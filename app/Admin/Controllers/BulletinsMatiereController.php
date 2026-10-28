<?php

namespace App\Admin\Controllers;

use App\Models\BulletinsMatiere;
use App\Models\Affectation;
use App\Models\Professeur;
use App\Models\Classeapprenant;
use App\Models\ParametresGlobaux;
use App\Models\Evaluation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BulletinsMatiereController extends AdminController
{
    protected $title = 'Gestion des Bulletins par Matière';

    protected function grid()
    {
        $grid = new Grid(new Affectation());

        $currentUser = Auth::guard('admin')->user();
        $professeur = null;
        $isAdmin = $currentUser && ($currentUser->isRole('administrator') || $currentUser->isAdministrator());

        // 1. Filtrage selon le profil (Admin vs Professeur)
        if (!$isAdmin && $currentUser) {
            $professeur = Professeur::where('matricule', $currentUser->username)->first();
            if ($professeur) {
                $grid->model()->where('professeurs_id', $professeur->id_professeurs);
            } else {
                $grid->model()->whereRaw('1 = 0');
            }
        }

        // 2. Traitement du filtre par classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
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

        // 4. Barre d'outils avec les grands titres et sélecteurs de classes
        $grid->tools(function (Grid\Tools $tools) use ($isAdmin, $professeur, $selectedClassId, $nomEtablissement, $anneeScolaire, $selectedClasse, $nomPeriode) {
            $query = Affectation::with('classes', 'matieres');
            if (!$isAdmin && $professeur) {
                $query->where('professeurs_id', $professeur->id_professeurs);
            }
            $affectations = $query->get();
            $baseUrl = request()->url();

            $html = '<div style="margin-bottom: 20px; background: #ffffff; padding: 15px; border-radius: 5px; border: 1px solid #e3e3e3; box-shadow: 0 1px 1px rgba(0,0,0,.05);">';
            // BOUTON CALCULER LES MOYENNES
            if ($selectedClassId) {
                $calculUrl = admin_url('bulletins-matieres/calculer?classes_id=' . $selectedClassId);
                $html .= "<div><a href='{$calculUrl}' class='btn btn-sm btn-info' data-pjax='0'><i class='fa fa-calculator'></i> Calculer les moyennes</a></div>";
            }
            // Grands Titres
            $classeNom = $selectedClasse ? $selectedClasse->nom_classe : 'Toutes les classes';
            $html .= '<h3 style="margin-top: 0; color: #3c8dbc; font-weight: bold; border-bottom: 2px solid #3c8dbc; padding-bottom: 8px;">🏫 ' . $nomEtablissement . '</h3>';
            $html .= '<div style="display: flex; gap: 25px; font-size: 14px; margin-bottom: 15px; flex-wrap: wrap; color: #444;">';
            $html .= '<span><strong>📅 Année :</strong> ' . $anneeScolaire . '</span>';
            $html .= '<span><strong>📚 Classe :</strong> ' . $classeNom . '</span>';
            $html .= '<span><strong>⏱ Période :</strong> ' . $nomPeriode . '</span>';
            $html .= '</div>';

            // Boutons de sélection de classes
            $html .= '<div class="btn-group" style="display: flex; gap: 5px; flex-wrap: wrap; align-items: center;">';
            $labelTous = $isAdmin ? 'Toutes les classes' : 'Toutes mes classes';
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>{$labelTous}</a>";

            $classProcessed = [];
            foreach ($affectations as $aff) {
                if (in_array($aff->classes_id, $classProcessed)) continue;
                $classProcessed[] = $aff->classes_id;

                $count = Classeapprenant::where('classes_id', $aff->classes_id)->count();
                $nom = optional($aff->classes)->nom_classe;
                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom} <span class='badge bg-gray'>{$count}</span></a>";
            }
            $html .= '</div>';
            $html .= '</div>';

            $tools->append($html);
        });

        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 5. Colonne Classe
        $grid->column('classes.nom_classe', __('Classe'))->display(function($value) {
            return "<span class='label label-info' style='font-size: 12px;'>{$value}</span>";
        });

        // 6. Colonne Matière
        $grid->column('matieres.nom_matiere', __('Matière'))->display(function($value) {
            return "<span class='label label-success' style='font-size: 12px;'>{$value}</span>";
        });

        // 7. Colonne Élève (Nom, Prénom, Matricule regroupés ligne par ligne)
        $grid->column('eleve_bloc', __('Élève'))->display(function () {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->get()
                ->sortBy(fn($item) => optional($item->apprenants)->nom);

            if ($apprenants->isEmpty()) return '-';

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $app = $item->apprenants;
                $nomComplet = trim(($app?->nom ?? '') . ' ' . ($app?->prenom ?? ''));
                $matricule = $app?->matricule ?? 'N/A';

                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px; min-height: 40px;'>";
                $html .= "<strong>{$nomComplet}</strong><br>";
                $html .= "<code style='font-size: 11px;'>Mat: {$matricule}</code>";
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        // 8. Colonne Moyenne (liée aux bulletins de la matière et de l'élève)
        $grid->column('moyenne_bloc', __('Moyenne'))->display(function () {
            $apprenants = Classeapprenant::where('classes_id', $this->classes_id)->get();
            $matiereId = $this->matieres_id;

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $bulletin = BulletinsMatiere::where('matieres_id', $matiereId)
                    ->where('classeapprenants_id', $item->id_classeapprenants)
                    ->first();

                $moy = $bulletin?->moyenne ?? '-';
                $badgeColor = is_numeric($moy) && $moy < 10 ? 'danger' : 'success';
                $displayMoy = is_numeric($moy) ? "{$moy} / 20" : '-';

                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px; min-height: 40px; display: flex; align-items: center;'>";
                if (is_numeric($moy)) {
                    $html .= "<span class='badge bg-{$badgeColor}' style='font-size: 12px;'>{$displayMoy}</span>";
                } else {
                    $html .= "<span class='text-muted'>-</span>";
                }
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        // 9. Colonne Rang
        $grid->column('rang_bloc', __('Rang'))->display(function () {
            $apprenants = Classeapprenant::where('classes_id', $this->classes_id)->get();
            $matiereId = $this->matieres_id;

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $bulletin = BulletinsMatiere::where('matieres_id', $matiereId)
                    ->where('classeapprenants_id', $item->id_classeapprenants)
                    ->first();

                $rang = $bulletin?->rang ? "<strong>{$bulletin->rang}</strong>" : '-';
                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px; min-height: 40px; display: flex; align-items: center;'>";
                $html .= "<span>{$rang}</span>";
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        // 10. Colonne Appréciation
        $grid->column('appreciation_bloc', __('Appréciation'))->display(function () {
            $apprenants = Classeapprenant::where('classes_id', $this->classes_id)->get();
            $matiereId = $this->matieres_id;

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $bulletin = BulletinsMatiere::where('matieres_id', $matiereId)
                    ->where('classeapprenants_id', $item->id_classeapprenants)
                    ->first();

                $app = $bulletin?->appreciation ?: '<span class="text-muted" style="font-style: italic;">-</span>';
                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px; min-height: 40px; display: flex; align-items: center; font-size: 11px;'>";
                $html .= "<span>{$app}</span>";
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        return $grid;
    }

    //Calcule de la moyenne

    public function calculerMoyennes(Request $request)
    {
        $classesId = $request->get('classes_id');
        if (!$classesId) {
            admin_toastr('Veuillez d\'abord sélectionner une classe.', 'error');
            return redirect(admin_url('bulletins-matieres'));
        }

        $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnneeId = $parametreGlobal?->etablissementannees_id;

        // Récupérer toutes les affectations (matières) et tous les élèves de la classe
        $affectations = Affectation::where('classes_id', $classesId)->get();
        $apprenants = Classeapprenant::where('classes_id', $classesId)->get();

        foreach ($affectations as $aff) {
            $moyennesEleves = [];

            // 1. Calcul de la moyenne de chaque élève pour cette matière
            foreach ($apprenants as $app) {
                $evaluations = Evaluation::where('affectations_id', $aff->id_affectations)
                    ->where('classeapprenants_id', $app->id_classeapprenants)
                    ->get();

                if ($evaluations->isNotEmpty()) {
                    $moyenne = round($evaluations->avg('notes'), 2);
                } else {
                    $moyenne = null;
                }

                $moyennesEleves[$app->id_classeapprenants] = $moyenne;
            }

            /// 2. Calcul des rangs basés sur les moyennes décroissantes
            $valides = array_filter($moyennesEleves, fn($m) => $m !== null);
            arsort($valides);

            $ranks = [];
            $currentRank = 1;
            $previousScore = null;
            $index = 0;

            foreach ($valides as $eleveId => $score) {
                $index++;
                if ($score !== $previousScore) {
                    $currentRank = $index;
                }
                
                // Formatage : "1er" pour le premier, sinon "2e", "3e", etc.
                $suffixe = ($currentRank == 1) ? 'er' : 'e';
                $ranks[$eleveId] = $currentRank . $suffixe;
                
                $previousScore = $score;
            }

            // 3. Attribution des appréciations et enregistrement en base
            foreach ($apprenants as $app) {
                $moy = $moyennesEleves[$app->id_classeapprenants] ?? null;
                $rang = $ranks[$app->id_classeapprenants] ?? null;

                $appreciation = null;
                if ($moy !== null) {
                    if ($moy < 10) {
                        $appreciation = 'Insuffisant';
                    } elseif ($moy == 10) {
                        $appreciation = 'Passable';
                    } elseif ($moy > 10 && $moy <= 14) {
                        $appreciation = 'Assez bien';
                    } elseif ($moy > 14 && $moy <= 16) {
                        $appreciation = 'Bien';
                    } else {
                        $appreciation = 'Très bien';
                    }
                }

                BulletinsMatiere::updateOrCreate(
                    [
                        'matieres_id' => $aff->matieres_id,
                        'classeapprenants_id' => $app->id_classeapprenants,
                        'etablissementannees_id' => $etablissementAnneeId,
                    ],
                    [
                        'evaluations_id' => Evaluation::where('affectations_id', $aff->id_affectations)->first()?->id_evaluations,
                        'moyenne' => $moy,
                        'rang' => $rang,
                        'appreciation' => $appreciation,
                        'updated_by' => Auth::id(),
                    ]
                );
            }
        }

        admin_toastr('Calcul des moyennes, appréciations et rangs effectué avec succès !', 'success');
        return redirect(admin_url('bulletins-matieres?classes_id=' . $classesId));
    }
}