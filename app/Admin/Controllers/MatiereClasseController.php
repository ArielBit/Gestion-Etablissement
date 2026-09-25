<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Educateur;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class MatiereClasseController extends AdminController
{
    protected $title = 'Matières par Classe';

    protected function grid()
    {
        $grid = new Grid(new Affectation());

        $currentUser = Auth::guard('admin')->user();
        $educateur = null;

        // 1. Filtrage initial par l'éducateur connecté
        if ($currentUser && $currentUser->isRole('educateur')) {
            $educateur = Educateur::where('matricule', $currentUser->username)->first();

            if ($educateur) {
                $grid->model()->where('educateurs_id', $educateur->id_educateurs);
            } else {
                $grid->model()->whereRaw('1 = 0');
            }
        }

        // 2. Traitement du filtre par clic sur un bouton de classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
        }

        // 3. Injecter la barre de boutons par classe
        $grid->tools(function (Grid\Tools $tools) use ($currentUser, $educateur, $selectedClassId) {
            $query = Affectation::with('classes');
            if ($educateur) {
                $query->where('educateurs_id', $educateur->id_educateurs);
            }
            $affectations = $query->get();

            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 10px;">';
            $html .= '<div class="btn-group" style="margin-right: 10px;">';

            // Bouton "Toutes mes classes"
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>Toutes mes classes</a>";

            // Boutons individuels par classe
            foreach ($affectations as $aff) {
                $nom = optional($aff->classes)->nom_classe;
                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom}</a>";
            }

            $html .= '</div>'; // Fin btn-group
            $html .= '</div>';

            $tools->append($html);
        });

        // 4. Désactiver le filtre standard par formulaire
        $grid->disableFilter();

        // 5. Colonne Classe
        //$grid->column('classes.nom_classe', __('Classe'));

        // 6. Colonnes Professeurs relatives à la table Affectation
        // 5. Colonne ID des Matières
        $grid->column('matieres_ids', __('ID Matière'))->display(function () {
            $affectations = Affectation::with('matieres')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('matieres_id')
                ->get();

            if ($affectations->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $mat = $aff->matieres;
                $id = optional($mat)->id ?? optional($mat)->id_matieres ?? $aff->matieres_id ?? 'N/A';
                $html .= "<li style='padding: 2px 0;'><span class='label label-primary'>{$id}</span></li>";
            }
            $html .= '</ul>';

            return $html;
        });

        // Matricule des Professeurs
       /* $grid->column('professeurs_matricules', __('Matricule'))->display(function () {
            $affectations = Affectation::with('professeurs')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('professeurs_id')
                ->get();

            if ($affectations->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $matricule = optional($aff->professeurs)->matricule ?? 'N/A';
                $html .= "<li style='padding: 2px 0;'><code>{$matricule}</code></li>";
            }
            $html .= '</ul>';

            return $html;
        });

        // Nom des Professeurs
        $grid->column('professeurs_noms', __('Nom '))->display(function () {
            $affectations = Affectation::with('professeurs')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('professeurs_id')
                ->get()
                ->sortBy(function ($aff) {
                    return optional($aff->professeurs)->nom;
                });

            if ($affectations->isEmpty()) return '<span class="text-muted">Aucun professeur affilié</span>';

            $html = '<ol style="padding-left: 15px; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $nom = optional($aff->professeurs->personnel)->nom;
                $html .= "<strong>{$nom}</strong>";
            }
            $html .= '</ol>';

            return $html;
        });

        // Prénom des Professeurs
        $grid->column('professeurs_prenoms', __('Prénom '))->display(function () {
            $affectations = Affectation::with('professeurs')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('professeurs_id')
                ->get();

            if ($affectations->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $prenom = optional($aff->professeurs->personnel)->prenom;
                $html .= "<li style='padding: 2px 0;'>{$prenom}</li>";
            }
            $html .= '</ul>';

            return $html;
        });*/

        // Matière enseignée (depuis la relation de la table Affectation)
        $grid->column('matieres', __('Matière enseignée'))->display(function () {
            $affectations = Affectation::with('matieres')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('professeurs_id')
                ->get();

            if ($affectations->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $matiere = optional($aff->matieres)->libelle ?? optional($aff->matieres)->nom_matiere ?? 'Non spécifiée';
                $html .= "<li style='padding: 2px 0;'><span class='label label-info'>{$matiere}</span></li>";
            }
            $html .= '</ul>';

            return $html;
        });

        return $grid;
    }
}