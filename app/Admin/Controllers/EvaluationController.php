<?php

namespace App\Admin\Controllers;

use Encore\Admin\Admin;
use App\Models\Evaluation;
use App\Models\Affectation;
use App\Models\Professeur;
use App\Models\Classeapprenant;
use App\Models\ParametresGlobaux;
use App\Models\Etablissementannee;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use App\Models\PeriodesScolaire;

class EvaluationController extends AdminController
{
    protected $title = 'Gestion des Notes par Élève';

    public function show($id, $content = null)
    {
        return redirect(admin_url('evaluations'));
    }

    public function detail($id, $content = null)
    {
        return redirect(admin_url('evaluations'));
    }

    protected function grid()
    {
        $grid = new Grid(new Affectation());

        // 1. Récupérer l'ID de l'année scolaire active globale et son libellé
         $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnneesId = $parametreGlobal?->anneescolaire_id;
        
        $anneeActiveLibelle = 'Non définie';
        if ($etablissementAnneesId) {
            $anneeActive = $parametreGlobal?->etablissementAnnees;
            $anneeActiveLibelle = optional($anneeActive?->anneeScolaire)->annee_scolaire ?? 'Année active';
        }

        // FILTRE STRICT : On ne sélectionne que les affectations liées à l'année active
        if ($etablissementAnneesId) {
            $grid->model()->where('etablissementannees_id', $etablissementAnneesId);
        } else {
            $grid->model()->whereRaw('1 = 0');
        }

        $currentUser = Auth::guard('admin')->user();
        $professeur = null;
        $isAdmin = $currentUser && ($currentUser->isRole('administrator') || $currentUser->isAdministrator());
        $classeIdsProfesseur = [];

        // 2. Filtrage selon le profil (Admin vs Professeur)
        if (!$isAdmin && $currentUser) {
            $professeur = Professeur::where('matricule', $currentUser->username)->first();

            if ($professeur && $etablissementAnneesId) {
                $classeIdsProfesseur = Affectation::where('professeurs_id', $professeur->id_professeurs)
                    ->where('etablissementannees_id', $etablissementAnneesId)
                    ->whereNotNull('classes_id')
                    ->pluck('classes_id')
                    ->unique()
                    ->toArray();

                $grid->model()->where('professeurs_id', $professeur->id_professeurs);
            } else {
                $grid->model()->whereRaw('1 = 0');
            }
        }

        // 3. Traitement du filtre par classe
        $selectedClassId = request('classes_id');
        if ($selectedClassId) {
            $grid->model()->where('classes_id', $selectedClassId);
        }

        // Détermination de la période active (Trimestre / Semestre)
        $selectedClasse = $selectedClassId ? \App\Models\Classe::find($selectedClassId) : null;
        $periodeActiveHtml = '';
        if ($selectedClasse) {
            $typeClasse = strtolower($selectedClasse->type_cl ?? $selectedClasse->systeme ?? 'trimestre');
            
            $periodeIdToFind = str_contains($typeClasse, 'semestre') 
                ? ($parametreGlobal?->semestres_id ?? $parametreGlobal?->periodes_scolaires_id)
                : ($parametreGlobal?->trimestres_id ?? $parametreGlobal?->periodes_scolaires_id);

            $nomPeriode = 'Non défini';
            if ($periodeIdToFind) {
                $periodeObj = PeriodesScolaire::find($periodeIdToFind);
                $nomPeriode = $periodeObj->nom_peri ?? $periodeObj->libelle ?? $periodeObj->titre ?? 'Période active';
            }

            if (str_contains($typeClasse, 'semestre')) {
                $periodeActiveHtml = "<span class='label label-warning' style='font-size: 13px; margin-left: 10px;'>Semestre Actif : {$nomPeriode}</span>";
            } else {
                $periodeActiveHtml = "<span class='label label-success' style='font-size: 13px; margin-left: 10px;'>Trimestre Actif : {$nomPeriode}</span>";
            }
        }

        // 4. Barre d'outils (Année active, Boutons de classes, Alerte si vide, Indicateur de période & Bouton Noter)
        $grid->tools(function (Grid\Tools $tools) use ($isAdmin, $professeur, $selectedClassId, $periodeActiveHtml, $etablissementAnneesId, $anneeActiveLibelle, $classeIdsProfesseur) {
            $query = Affectation::with('classes')->whereNotNull('classes_id');
            if (!$isAdmin && $professeur) {
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
            if (!$isAdmin && $professeur && empty($classeIdsProfesseur)) {
                $html .= '</div>';
                $html .= '<div class="alert alert-warning" style="margin-top: 10px; margin-bottom: 10px;">';
                $html .= '<i class="fa fa-exclamation-triangle"></i> Aucune classe ne vous a été attribuée pour l\'année scolaire active (<strong>' . htmlspecialchars($anneeActiveLibelle) . '</strong>).';
                $html .= '</div>';
                $tools->append($html);
                return;
            }

            $html .= '<div class="btn-group" style="display: flex; gap: 5px; flex-wrap: wrap; align-items: center;">';

            $labelTous = $isAdmin ? 'Toutes les classes' : 'Toutes mes classes';
            $activeAll = empty($selectedClassId) ? 'btn-primary' : 'btn-default';
            $html .= "<a href='{$baseUrl}' class='btn btn-sm {$activeAll}'>{$labelTous}</a>";

            $uniqueAffectations = $affectations->unique('classes_id');
            foreach ($uniqueAffectations as $aff) {
                if (!$aff->classes_id) continue;

                $count = Classeapprenant::where('classes_id', $aff->classes_id)
                    ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                        $q->where('etablissementannees_id', $etablissementAnneesId);
                    })->count();

                $nom = optional($aff->classes)->nom_classe;
                if (!$nom) continue;

                $active = ($selectedClassId == $aff->classes_id) ? 'btn-primary' : 'btn-default';
                $url = $baseUrl . '?classes_id=' . $aff->classes_id;

                $html .= "<a href='{$url}' class='btn btn-sm {$active}'>{$nom} <span class='badge bg-gray'>{$count}</span></a>";
            }

            $html .= $periodeActiveHtml;
            $html .= '</div>';

            $saisieUrl = admin_url('evaluations/saisie-globale' . ($selectedClassId ? '?classes_id=' . $selectedClassId : ''));
            $html .= "<div><a href='{$saisieUrl}' class='btn btn-sm btn-success' data-pjax='0'><i class='fa fa-pencil-square-o'></i> Noter / Saisie globale</a></div>";
            $html .= '</div>';
            
            $tools->append($html);
        });

        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableActions();

        // 4. Colonne Classe
        $grid->column('classes.nom_classe', __('Classe'))->display(function($value) {
            return "<span class='label label-info' style='font-size: 12px;'>{$value}</span>";
        });

        // 5. Colonne Élève (filtrée par l'année active)
        $grid->column('eleve_bloc', __('Élève'))->display(function () use ($etablissementAnneesId) {
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                    $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->get()
                ->sortBy(fn($item) => optional($item->apprenants)->nom);

            if ($apprenants->isEmpty()) return '<span class="text-muted">Aucun élève</span>';

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $app = $item->apprenants;
                $nomComplet = ($app?->nom ?? '') . ' ' . ($app?->prenom ?? '');
                $matricule = $app?->matricule ?? 'N/A';

                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px;'>";
                $html .= "<strong>{$nomComplet}</strong><br>";
                $html .= "<code style='font-size: 11px;'>Mat: {$matricule}</code>";
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        // 6. Colonne Intitulé & Type d'évaluation (liée à l'affectation et l'élève de l'année active)
        $grid->column('type_evaluation_bloc', __('Type & Intitulé'))->display(function () use ($etablissementAnneesId) {
            $affectationId = $this->id_affectations;
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                    $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->get()
                ->sortBy(fn($item) => optional($item->apprenants)->nom);

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $evaluations = Evaluation::where('affectations_id', $affectationId)
                    ->where('classeapprenants_id', $item->id_classeapprenants)
                    ->get();

                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px; min-height: 40px;'>";
                if ($evaluations->isNotEmpty()) {
                    foreach ($evaluations as $ev) {
                        $intitule = $ev->nom_evaluation ?? 'Évaluation';
                        $type = $ev->type_evaluation ?? '-';
                        $html .= "<div style='margin-bottom: 2px;'><strong>{$intitule}</strong> <span class='label label-default' style='font-size: 10px;'>{$type}</span></div>";
                    }
                } else {
                    $html .= "<span class='text-muted' style='font-style: italic;'>Aucune éval.</span>";
                }
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        // 7. Colonne Notes (liée à l'affectation et l'élève de l'année active)
        $grid->column('notes_bloc', __('Notes'))->display(function () use ($etablissementAnneesId) {
            $affectationId = $this->id_affectations;
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                    $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->get()
                ->sortBy(fn($item) => optional($item->apprenants)->nom);

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $evaluations = Evaluation::where('affectations_id', $affectationId)
                    ->where('classeapprenants_id', $item->id_classeapprenants)
                    ->get();

                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px; min-height: 40px;'>";
                if ($evaluations->isNotEmpty()) {
                    foreach ($evaluations as $ev) {
                        $note = $ev->notes ?? 0;
                        $badgeColor = $note < 10 ? 'danger' : 'success';
                        
                        $urlEdit = admin_url("evaluations/saisie-globale?classes_id=" . $this->classes_id);
                        
                        $html .= "<div style='display: flex; align-items: center; gap: 5px; margin-bottom: 2px;'>";
                        $html .= "<span class='badge bg-{$badgeColor}' style='font-size: 12px;'>{$note}/20</span>";
                        $html .= "<a href='{$urlEdit}' class='text-primary' title='Modifier'><i class='fa fa-edit'></i></a>";
                        $html .= "</div>";
                    }
                } else {
                    $saisieUrl = admin_url("evaluations/saisie-globale?classes_id=" . $this->classes_id);
                    $html .= "<a href='{$saisieUrl}' class='btn btn-xs btn-success' title='Noter'><i class='fa fa-plus'></i> Noter</a>";
                }
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        // 8. Colonne Durée & Date
        $grid->column('duree_date_bloc', __('Durée & Date'))->display(function () use ($etablissementAnneesId) {
            $affectationId = $this->id_affectations;
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                    $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->get()
                ->sortBy(fn($item) => optional($item->apprenants)->nom);

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $evaluations = Evaluation::where('affectations_id', $affectationId)
                    ->where('classeapprenants_id', $item->id_classeapprenants)
                    ->get();

                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px; min-height: 40px;'>";
                if ($evaluations->isNotEmpty()) {
                    foreach ($evaluations as $ev) {
                        $duree = $ev->duree ?? '-';
                        $date = $ev->date_evaluation ? Carbon::parse($ev->date_evaluation)->format('d/m/Y') : '-';
                        $html .= "<div style='font-size: 11px; margin-bottom: 2px;'>⏱ {$duree} | 📅 {$date}</div>";
                    }
                } else {
                    $html .= "<span class='text-muted'>-</span>";
                }
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        // 9. Colonne Observations & Description
        $grid->column('observations_bloc', __('Observations & Description'))->display(function () use ($etablissementAnneesId) {
            $affectationId = $this->id_affectations;
            $apprenants = Classeapprenant::with('apprenants')
                ->where('classes_id', $this->classes_id)
                ->when($etablissementAnneesId, function($q) use ($etablissementAnneesId) {
                    $q->where('etablissementannees_id', $etablissementAnneesId);
                })
                ->get()
                ->sortBy(fn($item) => optional($item->apprenants)->nom);

            $html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            foreach ($apprenants as $item) {
                $evaluations = Evaluation::where('affectations_id', $affectationId)
                    ->where('classeapprenants_id', $item->id_classeapprenants)
                    ->get();

                $html .= "<div style='border-bottom: 1px dashed #ddd; padding-bottom: 5px; min-height: 40px;'>";
                if ($evaluations->isNotEmpty()) {
                    foreach ($evaluations as $ev) {
                        $obs = $ev->observations ?: ($ev->description ?: '-');
                        $html .= "<div style='font-size: 11px; color: #666; margin-bottom: 2px;'>{$obs}</div>";
                    }
                } else {
                    $html .= "<span class='text-muted'>-</span>";
                }
                $html .= "</div>";
            }
            $html .= '</div>';
            return $html;
        });

        return $grid;
    }

    public function saisieGlobale(Request $request, Content $content)
    {
        $currentUser = Auth::guard('admin')->user();
        $professeur = null;
        $isAdmin = $currentUser && ($currentUser->isRole('administrator') || $currentUser->isAdministrator());

        $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnneeId = $parametreGlobal?->anneescolaire_id;

        if (!$isAdmin && $currentUser) {
            $professeur = Professeur::where('matricule', $currentUser->username)->first();
            if (!$professeur) {
                abort(403, 'Accès non autorisé : profil professeur introuvable.');
            }
        }

        $selectedClassId = $request->get('classes_id');

        if (!$isAdmin && $selectedClassId) {
            $appartientAuProf = Affectation::where('professeurs_id', $professeur->id_professeurs)
                ->where('classes_id', $selectedClassId)
                ->when($etablissementAnneeId, function($q) use ($etablissementAnneeId) {
                    $q->where('etablissementannees_id', $etablissementAnneeId);
                })
                ->exists();

            if (!$appartientAuProf) {
                abort(403, 'Vous n\'avez pas accès à cette classe pour l\'année active.');
            }
        }

        $affectationsQuery = Affectation::with(['classes', 'matieres']);
        if (!$isAdmin && $professeur) {
            $affectationsQuery->where('professeurs_id', $professeur->id_professeurs);
        }
        if ($etablissementAnneeId) {
            $affectationsQuery->where('etablissementannees_id', $etablissementAnneeId);
        }
        if ($selectedClassId) {
            $affectationsQuery->where('classes_id', $selectedClassId);
        }
        
        $affectations = $affectationsQuery->get();

        $periodeActiveId = $parametreGlobal?->periodes_scolaires_id ?? PeriodesScolaire::first()?->id_periodes_scolaires;

        $classesAvecEleves = [];
        foreach ($affectations as $aff) {
            $eleves = Classeapprenant::with('apprenants')
                ->where('classes_id', $aff->classes_id)
                ->when($etablissementAnneeId, function($q) use ($etablissementAnneeId) {
                    $q->where('etablissementannees_id', $etablissementAnneeId);
                })
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id_classeapprenants,
                        'nom' => optional($item->apprenants)->nom . ' ' . optional($item->apprenants)->prenom,
                        'matricule' => optional($item->apprenants)->matricule ?? ''
                    ];
                });

            $classesAvecEleves[$aff->id_affectations] = [
                'classe_nom' => optional($aff->classes)->nom_classe,
                'matiere_nom' => optional($aff->matieres)->nom_matiere ?? optional($aff->matieres)->libelle,
                'eleves' => $eleves
            ];
        }

        $content->header('Saisie Globale des Notes');
        $content->description('Attribution des notes par groupes d\'élèves');
        
        $content->body(view('admin.evaluations.saisie_globale', compact(
            'affectations', 
            'classesAvecEleves', 
            'etablissementAnneeId', 
            'periodeActiveId',
            'selectedClassId'
        )));
        
        return $content;
    }

    public function storeSaisieGlobale(Request $request)
    {
        $currentUser = Auth::guard('admin')->user();
        $isAdmin = $currentUser && ($currentUser->isRole('administrator') || $currentUser->isAdministrator());

        $parametreGlobal = ParametresGlobaux::first();
        $etablissementAnneeId = $parametreGlobal?->anneescolaire_id;

        if (!$isAdmin) {
            $professeur = Professeur::where('matricule', $currentUser->username)->first();
            $appartientAuProf = Affectation::where('id_affectations', $request->affectations_id)
                ->where('professeurs_id', $professeur?->id_professeurs)
                ->when($etablissementAnneeId, function($q) use ($etablissementAnneeId) {
                    $q->where('etablissementannees_id', $etablissementAnneeId);
                })
                ->exists();

            if (!$appartientAuProf) {
                abort(403, 'Action non autorisée sur cette affectation.');
            }
        }

        $request->validate([
            'affectations_id' => 'required|exists:affectations,id_affectations',
            'nom_evaluation' => 'required|string',
            'type_evaluation' => 'required|string',
            'notes_groupes' => 'required|array', 
        ]);
        
        $periodeScolaireId = $parametreGlobal?->trimestres_id 
            ?? $parametreGlobal?->semestres_id 
            ?? PeriodesScolaire::first()?->id_periodes_scolaires;

        if (!$periodeScolaireId) {
            admin_toastr('Erreur : Aucune période active (trimestre/semestre) n\'a été trouvée dans les paramètres globaux.', 'error');
            return back()->withInput();
        }

        foreach ($request->notes_groupes as $groupe) {
            $noteSpecifique = $groupe['note_specifique'] ?? null;
            $eleveIds = $groupe['eleve_ids'] ?? [];
            $observationGroupe = $groupe['observation'] ?? null;

            if ($noteSpecifique !== null && !empty($eleveIds)) {
                foreach ($eleveIds as $classeApprenantId) {
                    Evaluation::create([
                        'affectations_id' => $request->affectations_id,
                        'etablissementannees_id' => $etablissementAnneeId,
                        'periodes_scolaires_id' => $periodeScolaireId, 
                        'classeapprenants_id' => $classeApprenantId,
                        'nom_evaluation' => $request->nom_evaluation,
                        'type_evaluation' => $request->type_evaluation,
                        'notes' => $noteSpecifique,
                        'duree' => $request->duree,
                        'date_evaluation' => $request->date_evaluation ?? now(),
                        'observations' => $observationGroupe,
                        'description' => $request->description,
                        'created_by' => Auth::id(),
                    ]);
                }
            }
        }

        admin_toastr('Notes enregistrées avec succès !', 'success');
        return redirect(admin_url('evaluations'));
    }
}