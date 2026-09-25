<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Professeur;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class EducateurProfController extends AdminController
{
    protected $title = 'Éducateurs de mes Classes';

    protected function grid()
    {
        $grid = new Grid(new Affectation());

        $currentUser = Auth::guard('admin')->user();
        $professeur = null;

        // 1. Filtrage initial par le professeur connecté
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

        // 2. Traitement du filtre par clic sur un bouton de classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
        }

        // 3. Injecter la barre de boutons et le sous-titre
        $grid->tools(function (Grid\Tools $tools) use ($currentUser, $professeur, $selectedClassId) {
            $query = Affectation::with('classes');
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

            // Boutons de filtres par classe
            foreach ($affectations as $aff) {
                $nom = optional($aff->classes)->nom_classe;
                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom}</a>";
            }

            $html .= '</div>';
            $html .= '</div>';

            $tools->append($html);
        });

        // 4. Désactiver le filtre standard par formulaire
        $grid->disableFilter();

        // 5. Colonne Classe
       /* $grid->column('classes.nom_classe', __('Classe'))->display(function ($nomClasse) {
            return "<span class='label label-info'>{$nomClasse}</span>";
        });

        // 6. Colonne Matières enseignées par le prof dans cette classe
        $grid->column('matieres_enseignees', __('Matière Enseignée'))->display(function () {
            $nomMatiere = optional($this->matieres)->nom_matiere 
                ?? optional($this->matieres)->libelle 
                ?? optional($this->matieres)->nom;

            if ($nomMatiere) {
                return "<span class='label label-success'>{$nomMatiere}</span>";
            }

            return '<span class="text-muted">Non définie</span>';
        });

        // 7. Colonne ID de(s) l'éducateur(s) affilié(s) à la classe
        $grid->column('educateurs_ids', __('ID Éducateur'))->display(function () {
            $affectationsEduc = Affectation::with('educateurs')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('educateurs_id')
                ->get()
                ->unique('educateurs_id');

            if ($affectationsEduc->isEmpty()) return '-';

            $html = '';
            foreach ($affectationsEduc as $aff) {
                $educ = $aff->educateurs;
                $id = optional($educ)->id ?? optional($educ)->id_educateurs ?? 'N/A';
                $html .= "<span class='label label-primary'>{$id}</span> ";
            }

            return $html;
        });

        // 8. Colonne Matricule de(s) l'éducateur(s)
        $grid->column('educateurs_matricules', __('Matricule Éducateur'))->display(function () {
            $affectationsEduc = Affectation::with('educateurs')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('educateurs_id')
                ->get()
                ->unique('educateurs_id');

            if ($affectationsEduc->isEmpty()) return '-';

            $html = '';
            foreach ($affectationsEduc as $aff) {
                $matricule = optional($aff->educateurs)->matricule ?? 'N/A';
                $html .= "<code>{$matricule}</code> ";
            }

            return $html;
        });*/

        // 9. Colonne Nom de(s) l'éducateur(s)
        $grid->column('educateurs_noms', __('Nom'))->display(function () {
            $affectationsEduc = Affectation::with('educateurs')
                ->where('classes_id', $this->classes_id)
                ->whereNotNull('educateurs_id')
                ->get()
                ->unique('educateurs_id');

            if ($affectationsEduc->isEmpty()) return '<span class="text-muted">Aucun éducateur attribué</span>';

            $html = '';
            foreach ($affectationsEduc as $aff) {
                $nom = optional($aff->educateurs->personnel )->nom 
                    ?? optional($aff->educateurs)->nom_educateur 
                    ?? 'N/A';
                $html .= "<strong>{$nom}</strong> ";
            }

            return $html;
        });

        // 10. Colonne Prénom de(s) l'éducateur(s)
        $grid->column('educateurs_prenoms', __('Prénom '))->display(function () {
            $affectationsEduc = Affectation::with('educateurs')
                ->where('classes_id', $this->classes_id)
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