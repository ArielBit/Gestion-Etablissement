<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Classe;
use App\Models\Educateur;
use App\Models\ParametresGlobaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class ProfesseurEducController extends AdminController
{
    protected $title = 'Mes Classes et Professeurs';

    protected function grid()
    {
        $currentUser = Auth::guard('admin')->user();
        $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnneesId = $parametreGlobal?->etablissementannees_id;

        $educateur = null;
        $classeIdsEducateur = [];

        // 1. Identifier l'éducateur connecté
        if ($currentUser && $currentUser->isRole('educateur')) {
            $educateur = Educateur::where('matricule', $currentUser->username)
                ->orWhere('id_educateurs', $currentUser->id ?? 0)
                ->first();

            if ($educateur) {
                // On récupère toutes les classes de cet éducateur
                $queryClasses = Affectation::where('educateurs_id', $educateur->id_educateurs)
                    ->whereNotNull('classes_id');

                // DÉCOMMENTE la ligne ci-dessous si tu veux filtrer strictement par l'année active :
                // if ($etablissementAnneesId) {
                //     $queryClasses->where('etablissementannees_id', $etablissementAnneesId);
                // }

                $classeIdsEducateur = $queryClasses->pluck('classes_id')->unique()->toArray();
            }
        }

        // 2. Initialiser la grille sur le modèle Classe
        $grid = new Grid(new Classe());

        if ($currentUser && $currentUser->isRole('educateur')) {
            if (!empty($classeIdsEducateur)) {
                $grid->model()->whereIn('id_classes', $classeIdsEducateur);
            } else {
                $grid->model()->whereRaw('1 = 0');
            }
        }

        // 3. Gestion du filtre par clic sur un bouton de classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('id_classes', $selectedClassId);
        }

        // 4. Injecter la barre de boutons dynamiques par classe
        $grid->tools(function (Grid\Tools $tools) use ($educateur, $selectedClassId, $etablissementAnneesId, $classeIdsEducateur) {
            $query = Affectation::with('classes')->whereNotNull('classes_id');

            if ($educateur && !empty($classeIdsEducateur)) {
                $query->where('educateurs_id', $educateur->id_educateurs);
            }

            $affectations = $query->get();
            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 10px;">';
            $html .= '<div class="btn-group" style="margin-right: 10px;">';
            
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>Toutes mes classes</a>";

            foreach ($affectations->unique('classes_id') as $aff) {
                $nom = optional($aff->classes)->nom_classe;
                if (!$nom) continue;

                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;
                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom}</a>";
            }

            $html .= '</div></div>';
            $tools->append($html);
        });

        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 5. Colonnes à afficher
        $grid->column('nom_classe', __('Classe'));

        // Noms des Professeurs et leurs Matières pour la classe
        $grid->column('professeurs_details', __('Professeurs & Matières'))->display(function () use ($etablissementAnneesId) {
            $affectations = Affectation::with(['professeurs.personnel', 'matieres'])
                ->where('classes_id', $this->id_classes)
                ->when($etablissementAnneesId, function ($q) use ($etablissementAnneesId) {
                    // Optionnel : décommente si tu veux filtrer les profs de l'année active
                    // $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->whereNotNull('professeurs_id')
                ->get();

            if ($affectations->isEmpty()) return '<span class="text-muted">Aucun professeur affilié</span>';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($affectations as $aff) {
                $nom = optional($aff->professeurs?->personnel)->nom ?? '';
                $prenom = optional($aff->professeurs?->personnel)->prenom ?? '';
                $matiere = optional($aff->matieres)->libelle ?? optional($aff->matieres)->nom_matiere ?? 'Matière';
                
                $html .= "<li style='padding: 3px 0;'><strong>{$nom} {$prenom}</strong> — <span class='label label-info'>{$matiere}</span></li>";
            }
            $html .= '</ul>';

            return $html;
        });

        return $grid;
    }
}