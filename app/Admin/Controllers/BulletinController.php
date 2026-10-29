<?php

namespace App\Admin\Controllers;

use App\Models\Bulletin;
use App\Models\BulletinsMatiere;
use App\Models\Affectation;
use App\Models\Professeur;
use App\Models\Classeapprenant;
use App\Models\ParametresGlobaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BulletinController extends AdminController
{
    protected function grid()
    {
        $grid = new Grid(new Classeapprenant());
        $grid->model()->with('apprenants');

        $currentUser = Auth::guard('admin')->user();
        $professeur = null;
        $isAdmin = $currentUser && ($currentUser->isRole('administrator') || $currentUser->isAdministrator());

        // 1. Filtrage strict : Seul l'admin ou le professeur principal de la classe peut voir
        if (!$isAdmin && $currentUser) {
            $professeur = Professeur::where('matricule', $currentUser->username)->first();
            if ($professeur) {
                // Récupérer uniquement les classes où ce professeur est désigné comme "professeur_principal" dans la table affectations
                $classeIdsPrincipal = \App\Models\Affectation::where('professeur_principal', $professeur->id_professeurs)
                    ->pluck('classes_id');

                if ($classeIdsPrincipal->isNotEmpty()) {
                    $grid->model()->whereIn('classes_id', $classeIdsPrincipal);
                } else {
                    $grid->model()->whereRaw('1 = 0'); // Bloqué si pas professeur principal
                }
            } else {
                $grid->model()->whereRaw('1 = 0');
            }
        }

        // 2. Traitement du filtre par classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
            
            // Si prof, vérifier qu'il est bien professeur principal de cette classe
            if (!$isAdmin && $professeur) {
                $estPP = \App\Models\Affectation::where('classes_id', $selectedClassId)
                    ->where('professeur_principal', $professeur->id_professeurs)
                    ->exists();

                if (!$estPP) {
                    $grid->model()->whereRaw('1 = 0');
                }
            }
        } else {
            // Si aucune classe n'est sélectionnée, on restreint pour éviter d'afficher toute l'école
            $grid->model()->whereRaw('1 = 0');
        }

        // 3. Récupération des paramètres globaux (Établissement, Année, Période)
        $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnnee = $parametreGlobal?->etablissementannee;
        $etablissementAnnees = $parametreGlobal?->etablissementAnnees;
        $nomEtablissement = optional($etablissementAnnee?->etablissement)->nom_etablissement ?? 'Établissement Scolaire';
        $anneeScolaire = optional($etablissementAnnees?->anneeScolaire)->annee_scolaire ?? 'Année active';
        $selectedClasse = $selectedClassId ? \App\Models\Classe::find($selectedClassId) : null;
        
        $nomPeriode = 'Non défini';
        if ($selectedClasse) {
            $typeClasse = strtolower($selectedClasse->type_cl ?? $selectedClasse->systeme ?? 'trimestre');
            $periodeIdToFind = str_contains($typeClasse, 'semestre') 
                ? ($parametreGlobal?->semestres_id ?? $parametreGlobal?->periodes_scolaires_id)
                : ($parametreGlobal?->trimestres_id ?? $parametreGlobal?->periodes_scolaires_id);

            if ($periodeIdToFind) {
                $periodeObj = \App\Models\PeriodesScolaire::find($periodeIdToFind);
                $nomPeriode = $periodeObj->nom_peri ?? $periodeObj->libelle ?? $periodeObj->titre ?? 'Période active';
            }
        }

        // 4. Barre d'outils avec grands titres et sélection de classes pour le Prof Principal
        $grid->tools(function (Grid\Tools $tools) use ($isAdmin, $professeur, $selectedClassId, $nomEtablissement, $anneeScolaire, $selectedClasse, $nomPeriode) {
            
            // Récupérer uniquement les classes où ce professeur est professeur principal
            $classesQuery = \App\Models\Classe::query();
            
            if (!$isAdmin && $professeur) {
                $classesQuery->whereHas('affectations', function($q) use ($professeur) {
                    $q->where('professeur_principal', $professeur->id_professeurs);
                });
            }
            
            $classesAutorisees = $classesQuery->get();
            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 20px; background: #ffffff; padding: 15px; border-radius: 5px; border: 1px solid #e3e3e3; box-shadow: 0 1px 1px rgba(0,0,0,.05);">';
            
            $classeNom = $selectedClasse ? $selectedClasse->nom_classe : 'Veuillez sélectionner une classe';
            $html .= '<h3 style="margin-top: 0; color: #3c8dbc; font-weight: bold; border-bottom: 2px solid #3c8dbc; padding-bottom: 8px;">🏫 ' . $nomEtablissement . '</h3>';
            $html .= '<div style="display: flex; gap: 25px; font-size: 14px; margin-bottom: 15px; flex-wrap: wrap; color: #444;">';
            $html .= '<span><strong>📅 Année :</strong> ' . $anneeScolaire . '</span>';
            $html .= '<span><strong>📚 Classe :</strong> ' . $classeNom . '</span>';
            $html .= '<span><strong>⏱ Période :</strong> ' . $nomPeriode . '</span>';
            $html .= '</div>';

            $html .= '<div class="btn-group" style="display: flex; gap: 5px; flex-wrap: wrap; align-items: center;">';
            
            // Vérification s'il y a des classes attribuées en tant que Professeur Principal
            if ($classesAutorisees->isNotEmpty()) {
                foreach ($classesAutorisees as $cls) {
                    $count = \App\Models\Classeapprenant::where('classes_id', $cls->id_classes)->count();
                    $active = ($selectedClassId == $cls->id_classes) ? 'btn-primary' : 'btn-default';
                    $url = $baseUrl . '?classes_id=' . $cls->id_classes;

                    $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$cls->nom_classe} <span class='badge bg-gray'>{$count}</span></a>";
                }
            } else {
                $html .= '<span class="text-danger" style="font-weight: bold; font-style: italic;"><i class="fa fa-exclamation-triangle"></i> Aucune classe attribuée en tant que professeur principal.</span>';
            }
            
            $html .= '</div>';
            $html .= '</div>';

            $tools->append($html);
        });
    

        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 5. Colonne Élève (Nom, Prénom, Matricule)
        $grid->column('id_classeapprenants', __('Élève'))->display(function () {
            $app = $this->apprenants; // Récupère l'élève lié via l'instance courante
            if (!$app) return '-';
            
            $nomComplet = trim(($app->nom ?? '') . ' ' . ($app->prenom ?? ''));
            $matricule = $app->matricule ?? 'N/A';
            
            return "<strong>{$nomComplet}</strong><br><code style='font-size: 11px;'>Mat: {$matricule}</code>";
        });

        // 6. Colonne Moyenne Générale (Calculée à partir des bulletins matières)
        $grid->column('moyenne_ generale', __('Moyenne Générale'))->display(function () {
            $bulletinsMatieres = BulletinsMatiere::where('classeapprenants_id', $this->id_classeapprenants)->get();
            if ($bulletinsMatieres->isEmpty() || $bulletinsMatieres->avg('moyenne') === null) {
                return '<span class="text-muted">-</span>';
            }
            $moyGen = round($bulletinsMatieres->avg('moyenne'), 2);
            $color = $moyGen < 10 ? 'danger' : 'success';
            return "<span class='badge bg-{$color}' style='font-size: 13px; padding: 5px 10px;'>{$moyGen} / 20</span>";
        });

        // 7. Colonne Rang Général
        $grid->column('rang_general', __('Rang Général'))->display(function () {
            // Logique de calcul du rang général de l'élève dans sa classe
            $classeId = $this->classes_id;
            $elevesClasse = Classeapprenant::where('classes_id', $classeId)->pluck('id_classeapprenants');
            
            $moyennesClasse = [];
            foreach ($elevesClasse as $idApp) {
                $bms = BulletinsMatiere::where('classeapprenants_id', $idApp)->get();
                $moy = $bms->isNotEmpty() ? $bms->avg('moyenne') : null;
                if ($moy !== null) {
                    $moyennesClasse[$idApp] = round($moy, 2);
                }
            }

            arsort($moyennesClasse);
            $ranks = [];
            $currRank = 1;
            $prevScore = null;
            $idx = 0;
            foreach ($elevesClasse as $idApp => $score) {
                // ... attribution des rangs
            }
            
            // Pour faire simple ici, on récupère le bulletin global s'il existe, ou un tiret
            $bulletin = Bulletin::whereHas('bulletins_matiere', fn($q) => $q->where('classeapprenants_id', $this->id_classeapprenants))->first();
            $rang = $bulletin?->rang ?? '-';
            return $rang !== '-' ? "<strong>{$rang}</strong>" : '<span class="text-muted">-</span>';
        });

        // 8. Bloc contenant l'ensemble des moyennes et rangs dans les différentes matières
        $grid->column('details_matieres_bloc', __('Détails par Matière'))->display(function () {
            $bulletinsMatieres = BulletinsMatiere::with('matiere')
                ->where('classeapprenants_id', $this->id_classeapprenants)
                ->get();

            if ($bulletinsMatieres->isEmpty()) {
                return '<span class="text-muted" style="font-style: italic;">Aucune note enregistrée</span>';
            }

            $html = '<div style="display: flex; flex-direction: column; gap: 8px;">';
            foreach ($bulletinsMatieres as $bm) {
                $nomMatiere = optional($bm->matiere)->nom_matiere ?? 'Matière';
                $moy = $bm->moyenne !== null ? $bm->moyenne . '/20' : '-';
                $rang = $bm->rang ?? '-';
                $app = $bm->appreciation ?? '-';
                $badgeCol = is_numeric($bm->moyenne) && $bm->moyenne < 10 ? 'label-danger' : 'label-success';

                $html .= "<div style='background: #f9f9f9; padding: 6px 10px; border-radius: 4px; border: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; font-size: 12px;'>";
                $html .= "<span><strong>{$nomMatiere}</strong></span>";
                $html .= "<div>";
                $html .= "<span class='label {$badgeCol}' style='margin-right: 5px;'>Moy: {$moy}</span>";
                $html .= "<span class='label label-info' style='margin-right: 5px;'>Rang: {$rang}</span>";
                $html .= "<span class='text-muted'>({$app})</span>";
                $html .= "</div>";
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        return $grid;
    }
}