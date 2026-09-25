<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Educateur;
use App\Models\Classeapprenant;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class ApprenantEducController extends AdminController
{
    protected $title = 'Mes Classes et Apprenants';

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

        // 3. Injecter la barre de boutons et le sous-titre dynamique de l'effectif
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

            // Calcul global et badges individuels par classe
            $classCounts = [];
            foreach ($affectations as $aff) {
                $count = Classeapprenant::where('classes_id', $aff->classes_id)->count();
                $classCounts[$aff->classes_id] = $count;

                $nom = optional($aff->classes)->nom_classe;
                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom} <span class='badge bg-gray'>{$count}</span></a>";
            }

            $html .= '</div>';

            // Affichage du sous-titre du nombre d'élèves
            if ($selectedClassId && isset($classCounts[$selectedClassId])) {
                $selectedClass = optional($affectations->firstWhere('classes_id', $selectedClassId)->classes)->nom_classe;
                $totalEleves = $classCounts[$selectedClassId];
                $texteEffectif = "Nombre d'élèves de la classe <strong>{$selectedClass}</strong> : <strong>{$totalEleves}</strong>";
            } else {
                $totalEleves = Classeapprenant::whereIn('classes_id', array_keys($classCounts))->count();
                $texteEffectif = "Nombre total d'élèves (toutes classes confondues) : <strong>{$totalEleves}</strong>";
            }

            $html .= "<div style='margin-top: 8px; font-size: 14px; color: #333;'>{$texteEffectif}</div>";
            $html .= '</div>';

            $tools->append($html);
        });

        // 4. Désactiver le filtre standard par formulaire
        $grid->disableFilter();

        // 5. Colonne Classe
        //$grid->column('classes.nom_classe', __('Classe'));

        // 6. Colonne ID
        $grid->column('apprenants_ids', __('ID'))->display(function () {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($apprenants as $item) {
                $app = $item->apprenants;
                $id = optional($app)->id ?? optional($app)->id_apprenants ?? 'N/A';
                $html .= "<span class='label label-primary'> {$id}</span>";
            }
            //$html .= '</ul>';

            return $html;
        });

        // 7. Colonne Matricule
        $grid->column('apprenants_matricules', __('Matricule'))->display(function () {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($apprenants as $item) {
                $matricule = optional($item->apprenants)->matricule ?? 'N/A';
                $html .= "<code>{$matricule}</code>";
            }
            //$html .= '</ul>';

            return $html;
        });

        // 8. Colonne Nom
        $grid->column('apprenants_noms', __('Nom'))->display(function () {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '<span class="text-muted">Aucun apprenant</span>';

            $html = '<ol style="padding-left: 15px; margin-bottom: 0;">';
            foreach ($apprenants as $item) {
                $nom = optional($item->apprenants)->nom;
                $html .= "<strong>{$nom}</strong>";
            }
            //$html .= '</ol>';

            return $html;
        });

        // 9. Colonne Prénom
        $grid->column('apprenants_prenoms', __('Prénom'))->display(function () {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($apprenants as $item) {
                $prenom = optional($item->apprenants)->prenom;
                $html .= "{$prenom}";
            }
            //$html .= '</ul>';

            return $html;
        });

        return $grid;
    }
}