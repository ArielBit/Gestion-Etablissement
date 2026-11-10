<?php

namespace App\Admin\Controllers;

use App\Models\Classeapprenant;
use App\Models\Classe;
use App\Models\Educateur;
use App\Models\EducateursScolaritesniveaux;
use App\Models\Etablissementannee;
use App\Models\ParametresGlobaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class ApprenanteducController extends AdminController
{
    protected $title = 'Apprenants de mes Niveaux et Classes';

    protected function grid()
    { // 1. Récupérer l'ID de l'année scolaire active globale et son libellé
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

        // 3. Initialiser la grille sur le modèle Classeapprenant
        $grid = new Grid(new Classeapprenant());

        // Filtrer strictement par l'année scolaire active
        if ($etablissementAnneesId) {
            $grid->model()->where('etablissementannees_id', $etablissementAnneesId);
        } else {
            $grid->model()->whereRaw('1 = 0');
        }

        if ($currentUser && $currentUser->isRole('educateur')) {
            if (!empty($classeIdsEducateur)) {
                $grid->model()->whereIn('classes_id', $classeIdsEducateur);
            } else {
                $grid->model()->whereRaw('1 = 0'); // Sécurité si aucune classe trouvée pour ce niveau
            }
        }

        // 4. Traitement du filtre par clic sur un bouton de classe spécifique
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
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
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>Tous mes apprenants</a>";

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

        // 7. Colonnes du tableau pour les apprenants
        $grid->column('id_classeapprenants', __('Id'));

        $grid->column('apprenants.matricule', __('Matricule'))->display(function ($matricule) {
            return $matricule ?? 'N/A';
        });

        $grid->column('apprenants.nom', __('Nom'))->display(function ($nom) {
            return $nom ?? 'N/A';
        });

        $grid->column('apprenants.prenom', __('Prénom'))->display(function ($prenom) {
            return $prenom ?? '';
        });

        $grid->column('apprenants.sexe', __('Sexe'))->display(function ($sexe) {
            return $sexe ?? '-';
        });

        $grid->column('classes.nom_classe', __('Classe'));

        return $grid;
    }
}