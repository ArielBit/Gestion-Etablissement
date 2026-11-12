<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Classe;
use App\Models\Professeur;
use App\Models\EducateursScolaritesniveaux;
use App\Models\Etablissementannee;
use App\Models\ParametresGlobaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class EducateurProfController extends AdminController
{
    protected $title = 'Éducateurs de mes Classes';

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
        $professeur = null;
        $classeIdsProfesseur = [];

        // 2. Identifier le professeur connecté et récupérer les IDs de ses classes pour l'année active
        if ($currentUser && $currentUser->isRole('professeur')) {
            $professeur = Professeur::where('matricule', $currentUser->username)->first();

            if ($professeur && $etablissementAnneesId) {
                $classeIdsProfesseur = Affectation::where('professeurs_id', $professeur->id_professeurs)
                    ->where('etablissementannees_id', $etablissementAnneesId)
                    ->whereNotNull('classes_id')
                    ->pluck('classes_id')
                    ->unique()
                    ->toArray();
            }
        }

        // 3. Initialiser la grille sur le modèle Classe
        $grid = new Grid(new Classe());

        if ($currentUser && $currentUser->isRole('professeur')) {
            if (!empty($classeIdsProfesseur)) {
                $grid->model()->whereIn('id_classes', $classeIdsProfesseur);
            } else {
                $grid->model()->whereRaw('1 = 0'); // Sécurité si aucune classe
            }
        } elseif (!$etablissementAnneesId) {
            $grid->model()->whereRaw('1 = 0');
        }

        // 4. Traitement du filtre par clic sur un bouton de classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('id_classes', $selectedClassId);
        }

        // 5. Injecter l'année active, les boutons dynamiques et le message d'avertissement si vide
        $grid->tools(function (Grid\Tools $tools) use ($professeur, $selectedClassId, $etablissementAnneesId, $anneeActiveLibelle, $classeIdsProfesseur) {
            $query = Affectation::with('classes')->whereNotNull('classes_id');
            if ($professeur) {
                $query->where('professeurs_id', $professeur->id_professeurs);
            }
            if ($etablissementAnneesId) {
                $query->where('etablissementannees_id', $etablissementAnneesId);
            }
            $affectations = $query->get();

            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">';
            
            // Zone d'affichage de l'Année Scolaire Active
            $html .= '<div>';
            $html .= '<span class="label label-success" style="font-size: 13px; padding: 7px 12px; display: inline-block;">';
            $html .= '<i class="fa fa-calendar"></i> Année Scolaire Active : <strong>' . htmlspecialchars($anneeActiveLibelle) . '</strong>';
            $html .= '</span>';
            $html .= '</div>';

            // Message d'alerte si aucune classe n'est attribuée au professeur pour cette année active
            if ($professeur && empty($classeIdsProfesseur)) {
                $html .= '</div>';
                $html .= '<div class="alert alert-warning" style="margin-top: 10px; margin-bottom: 10px;">';
                $html .= '<i class="fa fa-exclamation-triangle"></i> Aucune classe ne vous a été attribuée pour l\'année scolaire active (<strong>' . htmlspecialchars($anneeActiveLibelle) . '</strong>).';
                $html .= '</div>';
                $tools->append($html);
                return;
            }

            $html .= '<div class="btn-group" style="margin-right: 10px;">';

            // Bouton "Toutes mes classes"
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>Toutes mes classes</a>";

            // Boutons dynamiques uniques par classe
            $uniqueAffectations = $affectations->unique('classes_id');
            foreach ($uniqueAffectations as $aff) {
                if (!$aff->classes_id) continue;
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

        // 6. Désactiver les filtres et actions superflus
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 7. Colonne Classe
        $grid->column('nom_classe', __('Classe'));

        // 8. Colonne Nom de l'Éducateur (via le niveau de la classe et la table pivot pour l'année active)
        $grid->column('educateurs_noms', __('Nom de l\'Éducateur'))->display(function () use ($etablissementAnneesId) {
            $niveauId = $this->scolarites_niveaux_id;
            if (!$niveauId || !$etablissementAnneesId) {
                return '<span class="text-muted">N/A</span>';
            }

            $educateursPivots = EducateursScolaritesniveaux::with('educateurs.personnel')
                ->where('scolarites_niveaux_id', $niveauId)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->get();

            if ($educateursPivots->isEmpty()) {
                return '<span class="text-muted">Aucun éducateur attribué</span>';
            }

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($educateursPivots as $pivot) {
                $nom = optional($pivot->educateurs?->personnel)->nom ?? 'N/A';
                $html .= "<li style='padding: 2px 0;'><strong>{$nom}</strong></li>";
            }
            $html .= '</ul>';

            return $html;
        });

        // 9. Colonne Prénom de l'Éducateur
        $grid->column('educateurs_prenoms', __('Prénom de l\'Éducateur'))->display(function () use ($etablissementAnneesId) {
            $niveauId = $this->scolarites_niveaux_id;
            if (!$niveauId || !$etablissementAnneesId) {
                return '-';
            }

            $educateursPivots = EducateursScolaritesniveaux::with('educateurs.personnel')
                ->where('scolarites_niveaux_id', $niveauId)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->get();

            if ($educateursPivots->isEmpty()) {
                return '-';
            }

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($educateursPivots as $pivot) {
                $prenom = optional($pivot->educateurs?->personnel)->prenom ?? '';
                $html .= "<li style='padding: 2px 0;'>{$prenom}</li>";
            }
            $html .= '</ul>';

            return $html;
        });

        return $grid;
    }
}