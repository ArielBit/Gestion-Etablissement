<?php

namespace App\Admin\Controllers;

use App\Models\Bulletin;
use App\Models\BulletinsMatiere;
use App\Models\Affectation;
use App\Models\Professeur;
use App\Models\Classeapprenant;
use App\Models\ParametresGlobaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BulletinController extends AdminController
{
    protected function grid()
    {
    $grid = new Grid(new Classeapprenant());
    $grid->model()->with('apprenants');

    // Récupération de l'année active
    $parametreGlobal = ParametresGlobaux::first();
    // TEST DE DIAGNOSTIC : Qu'est-ce qui est stocké dans les paramètres globaux ?

       /*dd([
            'ParametresGlobaux complet' => $parametreGlobal?->toArray(),
            'etablissementannees_id récupéré' => $parametreGlobal?->etablissementannees_id ?? 'AUCUN ID TROUVÉ',
            'Année scolaire liée' => optional($parametreGlobal?->etablissementAnnees)->toArray()
        ]);*/
        
    $etablissementAnneesId = $parametreGlobal?->anneescolaire_id;

    if ($etablissementAnneesId) {
        $grid->model()->where('etablissementannees_id', $etablissementAnneesId);
    }

    $currentUser = Auth::guard('admin')->user();
    $professeur = null;
    $isAdmin = $currentUser && ($currentUser->isRole('administrator') || $currentUser->isAdministrator());

    if (!$isAdmin && $currentUser) {
        $professeur = Professeur::where('matricule', $currentUser->username)->first();
        if ($professeur) {
            $classeIdsPrincipal = \App\Models\Affectation::where('professeur_principal', $professeur->id_professeurs)
                ->pluck('classes_id');

            if ($classeIdsPrincipal->isNotEmpty()) {
                $grid->model()->whereIn('classes_id', $classeIdsPrincipal);
            } else {
                $grid->model()->whereRaw('1 = 0'); 
            }
        } else {
            $grid->model()->whereRaw('1 = 0');
        }
    }

    $selectedClassId = request('classes_id');
    if ($selectedClassId) {
        $grid->model()->where('classes_id', $selectedClassId);
        
        if (!$isAdmin && $professeur) {
            $estPP = \App\Models\Affectation::where('classes_id', $selectedClassId)
                ->where('professeur_principal', $professeur->id_professeurs)
                ->exists();

            if (!$estPP) {
                $grid->model()->whereRaw('1 = 0');
            }
        }
    } else {
        $grid->model()->whereRaw('1 = 0');
    }

        // 4. Récupération des informations pour l'en-tête de la barre d'outils
        $etablissementAnnee = $parametreGlobal?->etablissementannee;
        $etablissementAnnees = $parametreGlobal?->etablissementAnnees;
        $nomEtablissement = optional($etablissementAnnee?->etablissement)->nom_etablissement ?? 'Établissement Scolaire';
        $anneeScolaire = optional($etablissementAnnees?->anneeScolaire)->annee_scolaire ?? 'Année active';
        $selectedClasse = $selectedClassId ? \App\Models\Classe::find($selectedClassId) : null;
        
        $nomPeriode = 'Non défini';
        if ($selectedClasse) {
            $typeClasse = strtolower($selectedClasse->type_cl ?? $selectedClasse->systeme ?? 'trimestre');
            $periodeIdToFind = str_contains($typeClasse, 'semestre') 
                ? ($parametreGlobal?->semestres_id ?? $parametreGlobal?->periodes_scolaires_id)
                : ($parametreGlobal?->trimestres_id ?? $parametreGlobal?->periodes_scolaires_id);

            if ($periodeIdToFind) {
                $periodeObj = \App\Models\PeriodesScolaire::find($periodeIdToFind);
                $nomPeriode = $periodeObj->nom_peri ?? $periodeObj->libelle ?? $periodeObj->titre ?? 'Période active';
            }
        }

        // 5. Barre d'outils avec affichage dynamique et comptage filtré par année active
        $grid->tools(function (Grid\Tools $tools) use ($isAdmin, $professeur, $selectedClassId, $nomEtablissement, $anneeScolaire, $selectedClasse, $nomPeriode, $etablissementAnneesId) {
            
            $classesQuery = \App\Models\Classe::query();
            
            if (!$isAdmin && $professeur) {
                $classesQuery->whereHas('affectations', function($q) use ($professeur) {
                    $q->where('professeur_principal', $professeur->id_professeurs);
                });
            }
            
            $classesAutorisees = $classesQuery->get();
            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 20px; background: #ffffff; padding: 15px; border-radius: 5px; border: 1px solid #e3e3e3; box-shadow: 0 1px 1px rgba(0,0,0,.05);">';
            
            $classeNom = $selectedClasse ? $selectedClasse->nom_classe : 'Veuillez sélectionner une classe';
            $html .= '<h3 style="margin-top: 0; color: #3c8dbc; font-weight: bold; border-bottom: 2px solid #3c8dbc; padding-bottom: 8px;">🏫 ' . $nomEtablissement . '</h3>';
            $html .= '<div style="display: flex; gap: 25px; font-size: 14px; margin-bottom: 15px; flex-wrap: wrap; color: #444;">';
            $html .= '<span><strong>📅 Année :</strong> ' . $anneeScolaire . '</span>';
            $html .= '<span><strong>📚 Classe :</strong> ' . $classeNom . '</span>';
            $html .= '<span><strong>⏱ Période :</strong> ' . $nomPeriode . '</span>';
            $html .= '</div>';

            $html .= '<div class="btn-group" style="display: flex; gap: 5px; flex-wrap: wrap; align-items: center;">';
            
            if ($classesAutorisees->isNotEmpty()) {
                foreach ($classesAutorisees as $cls) {
                    // COMPTEUR STRICT : On compte les élèves de la classe UNIQUEMENT pour l'année active
                    $count = \App\Models\Classeapprenant::where('classes_id', $cls->id_classes)
                        ->where('etablissementannees_id', $etablissementAnneesId)
                        ->count();

                    $active = ($selectedClassId == $cls->id_classes) ? 'btn-primary' : 'btn-default';
                    $url = $baseUrl . '?classes_id=' . $cls->id_classes;

                    $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$cls->nom_classe} <span class='badge bg-gray'>{$count}</span></a>";
                }
            } else {
                $html .= '<span class="text-danger" style="font-weight: bold; font-style: italic;"><i class="fa fa-exclamation-triangle"></i> Aucune classe attribuée en tant que professeur principal.</span>';
            }
            
            $html .= '</div>';
            
            // Bouton de calcul
            if ($selectedClassId) {
                $urlCalcul = admin_url('bulletins/calculer?classes_id=' . $selectedClassId);
                $html .= '<div style="margin-top: 15px;">';
                $html .= "<a href='{$urlCalcul}' class='btn btn-success btn-sm'><i class='fa fa-calculator'></i> Calculer les moyennes et rangs généraux</a>";
                $html .= '</div>';
            }
            
            $html .= '</div>';

            $tools->append($html);
        });

        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 6. Colonnes du tableau (Élève, Moyennes, etc.)
        $grid->column('id_classeapprenants', __('Élève'))->display(function () {
            $app = $this->apprenants;
            if (!$app) return '-';
            
            $nomComplet = trim(($app->nom ?? '') . ' ' . ($app->prenom ?? ''));
            $matricule = $app->matricule ?? 'N/A';
            
            return "<strong>{$nomComplet}</strong><br><code style='font-size: 11px;'>Mat: {$matricule}</code>";
        });

        $grid->column('moyenne_generale', __('Moyenne Générale'))->display(function () {
            $bulletin = \App\Models\Bulletin::where('classeapprenants_id', $this->id_classeapprenants)->first();
            $moy = $bulletin?->moyenne_g ?? null;

            if ($moy === null || $moy === '') {
                return '<span class="text-muted">- (Non calculé)</span>';
            }

            $badgeColor = is_numeric($moy) && (float)$moy < 10 ? 'danger' : 'success';
            return "<span class='badge bg-{$badgeColor}' style='font-size: 13px; padding: 5px 10px;'>{$moy} / 20</span>";
        });

        $grid->column('rang_general', __('Rang Général'))->display(function () {
            $bulletin = \App\Models\Bulletin::where('classeapprenants_id', $this->id_classeapprenants)->first();
            $rangVal = $bulletin?->rang_g;

            if (empty($rangVal) || $rangVal === '-') {
                return '<span class="text-muted">-</span>';
            }

            return "<span class='badge bg-info' style='font-size: 12px; padding: 5px 8px;'><strong>{$rangVal}</strong></span>";
        });
        
        // 8. Bloc contenant l'ensemble des moyennes et rangs dans les différentes matières
        $grid->column('details_matieres_bloc', __('Détails par Matière'))->display(function () {
            $bulletinsMatieres = BulletinsMatiere::with('matiere')
                ->where('classeapprenants_id', $this->id_classeapprenants)
                ->get();

            if ($bulletinsMatieres->isEmpty()) {
                return '<span class="text-muted" style="font-style: italic;">Aucune note enregistrée</span>';
            }

            $html = '<div style="display: flex; flex-direction: column; gap: 8px;">';
            foreach ($bulletinsMatieres as $bm) {
                $nomMatiere = optional($bm->matiere)->nom_matiere ?? 'Matière';
                $moy = $bm->moyenne !== null ? $bm->moyenne . '/20' : '-';
                $rang = $bm->rang ?? '-';
                $app = $bm->appreciation ?? '-';
                $badgeCol = is_numeric($bm->moyenne) && $bm->moyenne < 10 ? 'label-danger' : 'label-success';

                // Recherche du professeur associé à cette matière pour la classe courante
                $affectation = Affectation::with('professeurs')
                    ->where('classes_id', $this->classes_id)
                    ->where('matieres_id', $bm->matieres_id)
                    ->first();

                $profNom = 'Non assigné';
                if ($affectation && $affectation->professeurs) {
                    $profNom = trim(($affectation->professeurs->personnel->nom ?? '') . ' ' . ($affectation->professeurs->personnel->prenom ?? ''));
                }


                $html .= "<div style='background: #f9f9f9; padding: 6px 10px; border-radius: 4px; border: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; font-size: 12px;'>";
               $html .= "<span><strong>{$nomMatiere}</strong> <br><small class='text-muted'>Prof: {$profNom}</small></span>";
                $html .= "<div>";
                $html .= "<span class='label {$badgeCol}' style='margin-right: 5px;'>Moy: {$moy}</span>";
                $html .= "<span class='label label-info' style='margin-right: 5px;'>Rang: {$rang}</span>";
                $html .= "<span class='text-muted'>({$app})</span>";
                $html .= "</div>";
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        return $grid;
    }


public function calculerMoyennesGenerales(Request $request)
{
    $classesId = $request->get('classes_id');
    if (!$classesId) {
        admin_toastr('Veuillez d\'abord sélectionner une classe.', 'error');
        return redirect(admin_url('classeapprenants'));
    }

    // 1. Récupérer l'année active via les paramètres globaux
    $parametreGlobal = ParametresGlobaux::first();
    $etablissementAnneesId = $parametreGlobal?->anneescolaire_id ?? null;

    $selectedClasse = \App\Models\Classe::find($classesId);
    $typeClasse = strtolower($selectedClasse?->type_cl ?? $selectedClasse?->systeme ?? 'trimestre');
    $typeBulletin = str_contains($typeClasse, 'semestre') ? 'Semestrielle' : 'Trimestrielle';

    // 2. Récupérer tous les élèves de la classe pour cette année en une seule requête (Eager Loading)
    $queryApprenants = Classeapprenant::where('classes_id', $classesId);
    if ($etablissementAnneesId) {
        $queryApprenants->where('etablissementannees_id', $etablissementAnneesId);
    }
    
    $apprenants = $queryApprenants->with('bulletinsMatieres')->get();

    if ($apprenants->isEmpty()) {
        admin_toastr('Aucun élève trouvé pour cette classe.', 'warning');
        return redirect(admin_url('classeapprenants?classes_id=' . $classesId));
    }

    $moyennesGeneralesEleves = [];

    // 3. Calcul rapide en mémoire (sans requêtes SQL dans la boucle)
    foreach ($apprenants as $app) {
        $sommeNotes = 0.0;
        $nombreMatieresNotes = 0;

        foreach ($app->bulletinsMatieres as $bm) {
            $noteString = trim((string) ($bm->moyenne ?? ''));
            $noteString = str_replace(',', '.', $noteString);

            if ($noteString !== '' && is_numeric($noteString)) {
                $sommeNotes += (float) $noteString;
                $nombreMatieresNotes++;
            }
        }

        if ($nombreMatieresNotes > 0) {
            $moyennesGeneralesEleves[$app->id_classeapprenants] = round($sommeNotes / $nombreMatieresNotes, 2);
        } else {
            $moyennesGeneralesEleves[$app->id_classeapprenants] = null;
        }
    }

    // 4. Calcul des rangs généraux
    $valides = array_filter($moyennesGeneralesEleves, fn($m) => $m !== null);
    arsort($valides);

    $ranks = [];
    $currentRank = 1;
    $previousScore = null;
    $index = 0;

    foreach ($valides as $eleveId => $score) {
        $index++;
        if ($score !== $previousScore) {
            $currentRank = $index;
        }
        $suffixe = ($currentRank == 1) ? 'er' : 'ème';
        $ranks[$eleveId] = $currentRank . $suffixe;
        $previousScore = $score;
    }

    // 5. Enregistrement en base de données
    try {
        foreach ($apprenants as $app) {
            $moy = $moyennesGeneralesEleves[$app->id_classeapprenants] ?? null;
            $rang = $ranks[$app->id_classeapprenants] ?? '-';

            if ($moy === null) {
                continue;
            }

            $appreciation = 'Insuffisant';
            if ($moy >= 10 && $moy < 12) $appreciation = 'Passable';
            elseif ($moy >= 12 && $moy < 14) $appreciation = 'Assez bien';
            elseif ($moy >= 14 && $moy < 16) $appreciation = 'Bien';
            elseif ($moy >= 16) $appreciation = 'Très bien';

            Bulletin::updateOrCreate(
                ['classeapprenants_id' => $app->id_classeapprenants],
                [
                    'moyenne_g'     => (string) $moy,
                    'rang_g'        => $rang,
                    'appreciation'  => $appreciation,
                    'type_bulletin' => $typeBulletin,
                    'updated_by'    => Auth::guard('admin')->id() ?? Auth::id(),
                ]
            );
        }

        admin_toastr('Moyennes générales et rangs calculés avec succès !', 'success');
    } catch (\Exception $e) {
        admin_toastr('Erreur lors de l\'enregistrement : ' . $e->getMessage(), 'error');
    }

    return redirect(admin_url('bulletins?classes_id=' . $classesId));
}
}
    