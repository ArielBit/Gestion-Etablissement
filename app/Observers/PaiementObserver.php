<?php

namespace App\Observers;

use App\Models\Paiement;
use App\Models\Recu;
use App\Models\Classe;
use App\Models\Classeapprenant;
use App\Models\Apprenant;

class PaiementObserver
{
    public function created(Paiement $paiement)
    {
        $apprenant = $paiement->apprenants;

        // 1. Générer le matricule si c'est le premier paiement
        if ($apprenant && !$apprenant->matricule) {
            $apprenant->matricule = $this->generateMatricule($apprenant);
            $apprenant->save();
        }

        // 2. Créer le reçu
        $recu = Recu::create([
            'paiements_id' => $paiement->id_paiements,
            'reference'    => $this->generateReference($paiement),
            'statut'       => 'Soldé',
            'date_reçu'    => now(),
        ]);

        // 3. Affectation automatique de la classe selon la moyenne et le niveau
        $this->handleClasseAssignment($paiement);
    }

    private function generateMatricule($apprenant)
    {
        return 'APP-' . date('Y') . '-' . str_pad($apprenant->id_apprenants, 5, '0', STR_PAD_LEFT);
    }

    private function generateReference(Paiement $paiement)
    {
        return 'REF-' . date('Y') . '-' . str_pad($paiement->id_paiements, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Traitement de l'affectation automatique de la classe
     */
    private function handleClasseAssignment(Paiement $paiement)
{
    // Traiter uniquement les paiements d'inscription
    if ($paiement->type_frais !== 'inscription') {
        return;
    }

    $apprenant = $paiement->apprenants;

    if (!$apprenant) {
        return;
    }

    // 1. On récupère l'année scolaire directement depuis l'apprenant
    $etablissementAnneeIdApprenant = $apprenant->etablissementannees_id;

    if (!$etablissementAnneeIdApprenant) {
        return; 
    }

    // 2. Vérifier si l'apprenant est DÉJÀ affecté à une classe pour CETTE année précise dans la table pivot
    $alreadyAssigned = Classeapprenant::where('apprenants_id', $apprenant->id_apprenants)
        ->where('etablissementannees_id', $etablissementAnneeIdApprenant)
        ->exists();

    if ($alreadyAssigned) {
        return;
    }

    // 3. Récupération du niveau
    $niveauTarget = $apprenant->type_niveau2 ?? $apprenant->type_niveau;

    // 4. Récupération de la moyenne
    $moyenne = $apprenant->moyennean_moyenexam;

    if (is_null($moyenne) || empty($niveauTarget)) {
        return;
    }
        
    $moyenneClean = str_replace(',', '.', $apprenant->moyennean_moyenexam);
    
    // 5. Recherche de la classe en fonction du niveau et de la moyenne (sans filtre etablissementannees_id sur les classes)
    $classeId = $this->determinerClasseId($niveauTarget, (float) $moyenneClean);

    // 6. Insertion dans la table pivot classeapprenants
    if ($classeId) {
        Classeapprenant::create([
            'apprenants_id'          => $apprenant->id_apprenants,
            'classes_id'             => $classeId,
            'etablissementannees_id' => $etablissementAnneeIdApprenant,
            'created_by'             => auth()->id() ?? $paiement->created_by,
        ]);
    }
}

/**
 * Calcule l'indice (1, 2, 3) et retrouve le classes_id correspondant en BDD
 */
private function determinerClasseId(string $niveau, float $moyenne)
{
    // 1. Détermination du numéro selon le barème
    if ($moyenne >= 12.0) {
        $numero = 1;
    } elseif ($moyenne >= 10.0) {
        $numero = 2;
    } elseif ($moyenne >= 8.0) {
        $numero = 3;
    } else {
        return null; // Note insuffisante (< 8/20)
    }

    // 2. Extraire la valeur courte entre parenthèses s'il y en a une
    if (preg_match('/\(([^)]+)\)/', $niveau, $matches)) {
        $niveauCourt = $matches[1]; 
    } else {
        $niveauCourt = trim($niveau);
    }

    $nomPrincipal = trim(explode('(', $niveau)[0]);

    // 3. Construction des motifs de recherche
    $patternFormatFull = $nomPrincipal . ' ' . $numero . ' (' . $niveauCourt . ' ' . $numero . ')'; 

    // 4. Recherche de la classe en BDD par nom uniquement
    $classe = Classe::where('nom_classe', 'LIKE', '%' . $patternFormatFull . '%')
        ->orWhere(function ($query) use ($nomPrincipal, $niveauCourt, $numero) {
            $query->where('nom_classe', 'LIKE', '%' . $nomPrincipal . ' ' . $numero . '%')
                  ->where('nom_classe', 'LIKE', '%' . $niveauCourt . ' ' . $numero . '%');
        })
        ->first();

    return $classe ? $classe->id_classes : null;
}
}