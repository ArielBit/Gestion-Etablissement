<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Professeur;
use App\Models\ParametresGlobaux; // <-- Import indispensable des paramètres globaux
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class EducateurProfController extends AdminController
{
    protected $title = 'Éducateurs de mes Classes';

    protected function grid()
    {
        $grid = new Grid(new Affectation());

        // 1. Récupérer l'année scolaire active depuis les paramètres globaux
        $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnneesId = $parametreGlobal?->etablissementannees_id;

        // FILTRE STRICT : On ne sélectionne que les lignes de la table affectations liées à l'année active
        if ($etablissementAnneesId) {
            $grid->model()->where('etablissementannees_id', $etablissementAnneesId);
        } else {
            $grid->model()->whereRaw('1 = 0'); // Sécurité si aucune année active n'est définie
        }

        $currentUser = Auth::guard('admin')->user();
        $professeur = null;

        // 2. Filtrage initial par le professeur connecté
        if ($currentUser && $currentUser->isRole('professeur')) {
            $professeur = Professeur::where('matricule', $currentUser->username)->first();

            if ($professeur) {
                $grid->model()->where('professeurs_id', $professeur->id_professeurs);
            } else {
                $grid->model()->whereRaw('1 = 0');
            }
        }

        // Charger les relations utiles pour éviter les requêtes N+1
        $grid->model()->with(['classes', 'matieres']);

        // 3. Traitement du filtre par clic sur un bouton de classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
        }

        // 4. Injecter la barre de boutons filtrée par l'année active
        $grid->tools(function (Grid\Tools $tools) use ($currentUser, $professeur, $selectedClassId, $etablissementAnneesId) {
            $query = Affectation::with('classes');
            
            // Restreindre la recherche des boutons à l'année active
            if ($etablissementAnneesId) {
                $query->where('etablissementannees_id', $etablissementAnneesId);
            }

            if ($professeur) {
                $query->where('professeurs_id', $professeur->id_professeurs);
            }
            $affectations = $query->get();

            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 10px;">';
            $html .= '<div class="btn-group" style="margin-right: 10px;">';

            // Bouton "Toutes mes classes"
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>Toutes mes classes</a>";

            // Boutons de filtres par classe (uniques pour éviter les doublons de matières)
            $classesUniques = $affectations->unique('classes_id');
            foreach ($classesUniques as $aff) {
                $nom = optional($aff->classes)->nom_classe;
                if (!$nom) continue;

                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom}</a>";
            }

            $html .= '</div>';
            $html .= '</div>';

            $tools->append($html);
        });

        // 5. Désactiver le filtre standard par formulaire
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 6. Colonne Nom de(s) l'éducateur(s) (filtré par l'année active et la classe)
        $grid->column('educateurs_noms', __('Nom'))->display(function () use ($etablissementAnneesId) {
            $affectationsEduc = Affectation::with('educateurs.personnel')
                ->where('classes_id', $this->classes_id)
                ->where('etablissementannees_id', $etablissementAnneesId) // Comparaison stricte avec l'année active
                ->whereNotNull('educateurs_id')
                ->get()
                ->unique('educateurs_id');

            if ($affectationsEduc->isEmpty()) return '<span class="text-muted">Aucun éducateur attribué pour cette année</span>';

            $html = '';
            foreach ($affectationsEduc as $aff) {
                $nom = optional($aff->educateurs->personnel)->nom 
                    ?? optional($aff->educateurs)->nom_educateur 
                    ?? 'N/A';
                $html .= "<strong>{$nom}</strong> ";
            }

            return $html;
        });

        // 7. Colonne Prénom de(s) l'éducateur(s) (filtré par l'année active et la classe)
        $grid->column('educateurs_prenoms', __('Prénom'))->display(function () use ($etablissementAnneesId) {
            $affectationsEduc = Affectation::with('educateurs.personnel')
                ->where('classes_id', $this->classes_id)
                ->where('etablissementannees_id', $etablissementAnneesId) // Comparaison stricte avec l'année active
                ->whereNotNull('educateurs_id')
                ->get()
                ->unique('educateurs_id');

            if ($affectationsEduc->isEmpty()) return '-';

            $html = '';
            foreach ($affectationsEduc as $aff) {
                $prenom = optional($aff->educateurs->personnel)->prenom 
                    ?? optional($aff->educateurs)->prenom_educateur 
                    ?? 'N/A';
                $html .= "{$prenom} ";
            }

            return $html;
        });

        return $grid;
    }
}