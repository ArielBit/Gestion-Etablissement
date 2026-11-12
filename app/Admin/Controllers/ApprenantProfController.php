<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use App\Models\Classe;
use App\Models\Professeur;
use App\Models\Classeapprenant;
use App\Models\Etablissementannee;
use App\Models\ParametresGlobaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;

class ApprenantProfController extends AdminController
{
    protected $title = 'Mes Classes, Matières et Apprenants';

    protected function grid()
    {
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
                $grid->model()->whereRaw('1 = 0'); // Bloque l'affichage si aucune classe
            }
        } elseif (!$etablissementAnneesId) {
            $grid->model()->whereRaw('1 = 0');
        }

        // 4. Traitement du filtre par clic sur un bouton de classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('id_classes', $selectedClassId);
        }

        // 5. Injecter l'année active, les boutons dynamiques, l'effectif et le message d'avertissement si vide
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
                $html .= '</div>'; // Fermeture du premier flex
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

            // Calcul global des effectifs par classe (pour l'année active)
            $classCounts = [];
            foreach ($classeIdsProfesseur as $cId) {
                $count = Classeapprenant::where('classes_id', $cId)
                    ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                        $q->where('etablissementannees_id', $etablissementAnneesId);
                    })->count();
                $classCounts[$cId] = $count;
            }

            // Boutons dynamiques uniques par classe
            $uniqueAffectations = $affectations->unique('classes_id');
            foreach ($uniqueAffectations as $aff) {
                if (!$aff->classes_id) continue;
                $nom = optional($aff->classes)->nom_classe;
                if (!$nom) continue;

                $count = $classCounts[$aff->classes_id] ?? 0;
                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom} <span class='badge bg-gray'>{$count}</span></a>";
            }

            $html .= '</div>';
            $html .= '</div>';

            // Affichage du sous-titre du nombre d'élèves
            if ($selectedClassId && isset($classCounts[$selectedClassId])) {
                $selectedClassObj = Classe::find($selectedClassId);
                $selectedClassName = $selectedClassObj?->nom_classe ?? '';
                $totalEleves = $classCounts[$selectedClassId];
                $texteEffectif = "Nombre d'élèves de la classe <strong>{$selectedClassName}</strong> : <strong>{$totalEleves}</strong>";
            } else {
                $totalEleves = !empty($classeIdsProfesseur) ? Classeapprenant::whereIn('classes_id', $classeIdsProfesseur)
                    ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                        $q->where('etablissementannees_id', $etablissementAnneesId);
                    })->count() : 0;
                $texteEffectif = "Nombre total d'élèves (toutes classes confondues) : <strong>{$totalEleves}</strong>";
            }

            $html .= "<div style='margin-top: 8px; font-size: 14px; color: #333;'>{$texteEffectif}</div>";

            $tools->append($html);
        });

        // 6. Désactiver le filtre standard par formulaire et les actions
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 7. Colonne Classe
        $grid->column('nom_classe', __('Classe'));

        // 8. Colonne Matière Enseignée par le professeur dans cette classe
        $grid->column('matieres_enseignees', __('Matière Enseignée'))->display(function () use ($professeur, $etablissementAnneesId) {
            $query = Affectation::with('matieres')
                ->where('classes_id', $this->id_classes)
                ->when($professeur, function($q) use ($professeur) {
                    $q->where('professeurs_id', $professeur->id_professeurs);
                })
                ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                    $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->get();

            if ($query->isEmpty()) return '<span class="text-muted">Non définie</span>';

            $html = '';
            foreach ($query as $aff) {
                $nomMatiere = optional($aff->matieres)->libelle 
                    ?? optional($aff->matieres)->nom_matiere 
                    ?? optional($aff->matieres)->nom;

                if ($nomMatiere) {
                    $html .= "<span class='label label-success' style='margin-right: 3px;'>{$nomMatiere}</span> ";
                }
            }

            return $html !== '' ? $html : '<span class="text-muted">Non définie</span>';
        });

        // 9. Colonne Nom (Apprenants de la classe pour l'année active)
        $grid->column('apprenants_noms', __('Nom'))->display(function () use ($etablissementAnneesId) {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->id_classes)
                ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                    $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '<span class="text-muted">Aucun apprenant</span>';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($apprenants as $item) {
                $nom = optional($item->apprenants)->nom ?? '';
                $html .= "<li style='padding: 2px 0;'><strong>{$nom}</strong></li>";
            }
            $html .= '</ul>';

            return $html;
        });

        // 10. Colonne Prénom (Apprenants de la classe pour l'année active)
        $grid->column('apprenants_prenoms', __('Prénom'))->display(function () use ($etablissementAnneesId) {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->id_classes)
                ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                    $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->get()
                ->sortBy(function ($item) {
                    return optional($item->apprenants)->nom;
                });

            if ($apprenants->isEmpty()) return '-';

            $html = '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
            foreach ($apprenants as $item) {
                $prenom = optional($item->apprenants)->prenom ?? '';
                $html .= "<li style='padding: 2px 0;'>{$prenom}</li>";
            }
            $html .= '</ul>';

            return $html;
        });

        return $grid;
    }
}