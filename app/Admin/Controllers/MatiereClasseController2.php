<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;

class MatiereClasseController2 extends AdminController
{
    protected $title = 'Matières Enseignées par Classe';

    protected function grid()
    {
        $grid = new Grid(new Affectation());

        // 1. Récupérer l'ID de la classe sélectionnée dans l'URL
        $selectedClassId = request('classes_id');

        // On groupe ou filtre par classe si une classe est sélectionnée
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
        }

        // 2. Générer la barre de filtres par boutons de classe (sans filtre éducateur)
        $grid->tools(function (Grid\Tools $tools) use ($selectedClassId) {
            // Récupère toutes les classes distinctes présentes dans Affectation
            $affectations = Affectation::with('classes')
                ->select('classes_id')
                ->distinct()
                ->get();

            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 10px;">';
            $html .= '<div class="btn-group" style="margin-right: 10px;">';

            // Bouton "Toutes les classes"
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>Toutes les classes</a>";

            // Boutons individuels pour chaque classe
            foreach ($affectations as $aff) {
                if (!$aff->classes) continue;

                $nom = $aff->classes->nom_classe;
                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom}</a>";
            }

            $html .= '</div></div>';

            $tools->append($html);
        });

        // 3. Désactiver le filtre standard par formulaire
        $grid->disableFilter();

        // 4. Colonne Nom de la Classe
        //$grid->column('classes.nom_classe', __('Classe'));

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

        // 6. Colonne Libellé / Nom de la Matière
        $grid->column('matieres_noms', __('Matières enseignées'))->display(function () {
            $affectations = Affectation::with('matieres')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('matieres_id')
                ->get()
                ->sortBy(function ($aff) {
                    return optional($aff->matieres)->libelle ?? optional($aff->matieres)->nom_matiere;
                });

            if ($affectations->isEmpty()) return '<span class="text-muted">Aucune matière enregistrée</span>';

            $html = '<ol style="padding-left: 15px; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $libelle = optional($aff->matieres)->libelle ?? optional($aff->matieres)->nom_matiere ?? 'Non spécifiée';
                $html .= "<strong>{$libelle}</strong>";
            }
            $html .= '</ol>';

            return $html;
        });

        // 7. Colonne Professeur assigné à la matière dans cette classe
        /*$grid->column('professeurs_matieres', __('Professeur en charge'))->display(function () {
            $affectations = Affectation::with('professeurs')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('matieres_id')
                ->get();

            if ($affectations->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $prof = $aff->professeurs;
                if ($prof) {
                    $nom = $prof->nom;
                    $prenom = $prof->prenom;
                    $html .= "<li style='padding: 2px 0;'>{$nom} {$prenom}</li>";
                } else {
                    $html .= "<li style='padding: 2px 0;'><span class='text-muted'>Non assigné</span></li>";
                }
            }
            $html .= '</ul>';

            return $html;
        });*/

        return $grid;
    }
}