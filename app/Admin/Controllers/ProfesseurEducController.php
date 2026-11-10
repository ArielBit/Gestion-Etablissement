<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Classe;
use App\Models\Educateur;
use App\Models\EducateursScolaritesniveaux;
use App\Models\Etablissementannee;
use App\Models\ParametresGlobaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class ProfesseurEducController extends AdminController
{
    protected $title = 'Mes Classes et Professeurs';

    protected function grid()
    {
        // 1. Récupérer l'ID de l'année scolaire active globale et son libellé
        $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnneesId = $parametreGlobal?->anneescolaire_id;
        
        $anneeActiveLibelle = 'Non définie';
        if ($etablissementAnneesId) {
            $anneeActive = $parametreGlobal?->etablissementAnnees;
            $anneeActiveLibelle = optional($anneeActive?->anneeScolaire)->annee_scolaire ?? 'Année active';
        }

        $currentUser = Auth::guard('admin')->user();
        $educateur = null;
        $classeIdsEducateur = [];

        // 2. Si c'est un éducateur, récupérer ses niveaux via la table pivot pour l'année active, puis ses classes
        if ($currentUser && $currentUser->isRole('educateur')) {
            $educateur = Educateur::where('matricule', $currentUser->username)
                ->orWhere('id_educateurs', $currentUser->id ?? 0)
                ->first();

            if ($educateur && $etablissementAnneesId) {
                // Récupérer les IDs des niveaux (scolarites_niveaux_id) assignés à l'éducateur pour l'année active
                $niveauxIds = EducateursScolaritesniveaux::where('educateurs_id', $educateur->id_educateurs)
                    ->where('etablissementannees_id', $etablissementAnneesId)
                    ->pluck('scolarites_niveaux_id')
                    ->toArray();

                // Récupérer toutes les classes appartenant à ces niveaux
                if (!empty($niveauxIds)) {
                    $classeIdsEducateur = Classe::whereIn('scolarites_niveaux_id', $niveauxIds)
                        ->pluck('id_classes')
                        ->toArray();
                }
            }
        }

        // 3. Initialiser la grille sur le modèle Classe
        $grid = new Grid(new Classe());

        if ($currentUser && $currentUser->isRole('educateur')) {
            if (!empty($classeIdsEducateur)) {
                $grid->model()->whereIn('id_classes', $classeIdsEducateur);
            } else {
                $grid->model()->whereRaw('1 = 0'); // Sécurité si aucune classe trouvée pour ce niveau
            }
        }

        // 4. Traitement du filtre par clic sur un bouton de classe spécifique
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('id_classes', $selectedClassId);
        }

        // 5. Injecter la zone de l'année active et la barre de boutons dynamiques par classe
        $grid->tools(function (Grid\Tools $tools) use ($selectedClassId, $classeIdsEducateur, $anneeActiveLibelle) {
            $query = Classe::query();

            if (!empty($classeIdsEducateur)) {
                $query->whereIn('id_classes', $classeIdsEducateur);
            } else {
                $query->whereRaw('1 = 0');
            }

            $classes = $query->get();
            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">';
            
            // Zone d'affichage de l'Année Scolaire Active
            $html .= '<div>';
            $html .= '<span class="label label-success" style="font-size: 13px; padding: 7px 12px; display: inline-block;">';
            $html .= '<i class="fa fa-calendar"></i> Année Scolaire Active : <strong>' . htmlspecialchars($anneeActiveLibelle) . '</strong>';
            $html .= '</span>';
            $html .= '</div>';

            // Boutons de filtrage par classe
            $html .= '<div class="btn-group">';
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>Toutes mes classes</a>";

            foreach ($classes as $classe) {
                $active = ($selectedClassId == $classe->id_classes) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $classe->id_classes;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$classe->nom_classe}</a>";
            }
            $html .= '</div>';

            $html .= '</div>';

            $tools->append($html);
        });

        // 6. Désactiver les filtres et actions superflus
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 7. Colonne Nom de la Classe
        $grid->column('nom_classe', __('Classe'));

        // 8. Nom des Professeurs (filtré par la classe courante et l'année scolaire active)
        $grid->column('professeurs_noms', __('Nom du Professeur'))->display(function () use ($etablissementAnneesId) {
            $affectations = Affectation::with('professeurs.personnel')
                ->where('classes_id', $this->id_classes)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->whereNotNull('professeurs_id')
                ->get()
                ->sortBy(function ($aff) {
                    return optional($aff->professeurs?->personnel)->nom;
                });

            if ($affectations->isEmpty()) return '<span class="text-muted">Aucun professeur affilié</span>';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $nom = optional($aff->professeurs?->personnel)->nom ?? 'N/A';
                $html .= "<li style='padding: 2px 0;'><strong>{$nom}</strong></li>";
            }
            $html .= '</ul>';

            return $html;
        });

        // 9. Prénom des Professeurs
        $grid->column('professeurs_prenoms', __('Prénom du Professeur'))->display(function () use ($etablissementAnneesId) {
            $affectations = Affectation::with('professeurs.personnel')
                ->where('classes_id', $this->id_classes)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->whereNotNull('professeurs_id')
                ->get();

            if ($affectations->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $prenom = optional($aff->professeurs?->personnel)->prenom ?? '';
                $html .= "<li style='padding: 2px 0;'>{$prenom}</li>";
            }
            $html .= '</ul>';

            return $html;
        });

        // 10. Matière enseignée
        $grid->column('matieres', __('Matière enseignée'))->display(function () use ($etablissementAnneesId) {
            $affectations = Affectation::with('matieres')
                ->where('classes_id', $this->id_classes)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->whereNotNull('professeurs_id')
                ->get();

            if ($affectations->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $matiere = optional($aff->matieres)->libelle ?? optional($aff->matieres)->nom_matiere ?? 'Non spécifiée';
                $html .= "<li style='padding: 2px 0;'><span class='label label-info' style='font-size: 11px;'>{$matiere}</span></li>";
            }
            $html .= '</ul>';

            return $html;
        });

        return $grid;
    }
}