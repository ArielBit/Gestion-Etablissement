<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Educateur;
use App\Models\Classeapprenant;
use App\Models\ParametresGlobaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class ApprenantEducController extends AdminController
{
    protected $title = 'Mes Classes et Apprenants';

    protected function grid()
    {
        $grid = new Grid(new Affectation());

        // 1. Récupérer l'année scolaire active et ses libellés depuis les paramètres globaux
        $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnneesId = $parametreGlobal?->anneescolaire_id;

        $etablissementAnnees = $parametreGlobal?->etablissementAnnees;
        $anneeScolaireNom = optional($etablissementAnnees?->anneeScolaire)->annee_scolaire ?? 'Année active';

        $currentUser = Auth::guard('admin')->user();
        $educateur = null;

        // 2. Filtrage initial par l'éducateur connecté
        if ($currentUser && $currentUser->isRole('educateur')) {
            $educateur = Educateur::where('matricule', $currentUser->username)->first();

            if ($educateur) {
                $grid->model()->where('educateurs_id', $educateur->id_educateurs);
            } else {
                $grid->model()->whereRaw('1 = 0');
            }
        }

        // 3. Traitement du filtre par clic sur un bouton de classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
        }

        // 4. Injecter la barre de boutons, l'année active et le sous-titre dynamique
        $grid->tools(function (Grid\Tools $tools) use ($currentUser, $educateur, $selectedClassId, $etablissementAnneesId, $anneeScolaireNom) {
            $query = Affectation::with('classes');
            if ($educateur) {
                $query->where('educateurs_id', $educateur->id_educateurs);
            }
            $affectations = $query->get();

            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 20px; background: #ffffff; padding: 15px; border-radius: 5px; border: 1px solid #e3e3e3; box-shadow: 0 1px 1px rgba(0,0,0,.05);">';
            
            // Affichage de l'année scolaire active tout en haut
            $html .= '<h4 style="margin-top: 0; color: #3c8dbc; font-weight: bold; border-bottom: 2px solid #3c8dbc; padding-bottom: 8px;">📅 Année Scolaire Active : ' . $anneeScolaireNom . '</h4>';

            $html .= '<div class="btn-group" style="margin-top: 10px; margin-bottom: 10px; display: flex; gap: 5px; flex-wrap: wrap;">';

            // Bouton "Toutes mes classes"
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>Toutes mes classes</a>";

            // Calcul global et badges individuels par classe (filtrés par l'année active des apprenants)
            $classCounts = [];
            $classesUniques = $affectations->unique('classes_id');

            foreach ($classesUniques as $aff) {
                $count = Classeapprenant::where('classes_id', $aff->classes_id)
                    ->where('etablissementannees_id', $etablissementAnneesId) // Comparaison stricte avec l'année active
                    ->count();

                $classCounts[$aff->classes_id] = $count;

                $nom = optional($aff->classes)->nom_classe;
                if (!$nom) continue;

                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom} <span class='badge bg-gray'>{$count}</span></a>";
            }

            $html .= '</div>';

            // Affichage du sous-titre du nombre d'élèves
            if ($selectedClassId && isset($classCounts[$selectedClassId])) {
                $selectedClassObj = $affectations->firstWhere('classes_id', $selectedClassId);
                $selectedClass = optional($selectedClassObj?->classes)->nom_classe ?? '';
                $totalEleves = $classCounts[$selectedClassId];
                $texteEffectif = "Nombre d'élèves de la classe <strong>{$selectedClass}</strong> pour l'année active : <strong>{$totalEleves}</strong>";
            } else {
                $totalEleves = Classeapprenant::whereIn('classes_id', array_keys($classCounts))
                    ->where('etablissementannees_id', $etablissementAnneesId)
                    ->count();
                $texteEffectif = "Nombre total d'élèves (toutes vos classes confondues pour l'année active) : <strong>{$totalEleves}</strong>";
            }

            $html .= "<div style='margin-top: 8px; font-size: 14px; color: #333;'>{$texteEffectif}</div>";
            $html .= '</div>';

            $tools->append($html);
        });

        // 5. Désactiver le filtre standard par formulaire
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 6. Colonne ID (filtrée strictement par l'année scolaire active de classeapprenant)
        $grid->column('apprenants_ids', __('ID'))->display(function () use ($etablissementAnneesId) {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '-';

            $html = '';
            foreach ($apprenants as $item) {
                $app = $item->apprenants;
                $id = optional($app)->id ?? optional($app)->id_apprenants ?? 'N/A';
                $html .= "<div><span class='label label-primary'>{$id}</span></div>";
            }

            return $html;
        });

        // 7. Colonne Matricule (filtrée strictement)
        $grid->column('apprenants_matricules', __('Matricule'))->display(function () use ($etablissementAnneesId) {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '-';

            $html = '';
            foreach ($apprenants as $item) {
                $matricule = optional($item->apprenants)->matricule ?? 'N/A';
                $html .= "<div><code>{$matricule}</code></div>";
            }

            return $html;
        });

        // 8. Colonne Nom (filtrée strictement)
        $grid->column('apprenants_noms', __('Nom'))->display(function () use ($etablissementAnneesId) {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '<span class="text-muted">Aucun apprenant pour cette année</span>';

            $html = '';
            foreach ($apprenants as $item) {
                $nom = optional($item->apprenants)->nom ?? '';
                $html .= "<div><strong>{$nom}</strong></div>";
            }

            return $html;
        });

        // 9. Colonne Prénom (filtrée strictement)
        $grid->column('apprenants_prenoms', __('Prénom'))->display(function () use ($etablissementAnneesId) {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->where('etablissementannees_id', $etablissementAnneesId)
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '-';

            $html = '';
            foreach ($apprenants as $item) {
                $prenom = optional($item->apprenants)->prenom ?? '';
                $html .= "<div>{$prenom}</div>";
            }

            return $html;
        });

        return $grid;
    }
}