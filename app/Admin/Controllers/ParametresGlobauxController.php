<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\ParametresGlobaux;
use App\Models\Etablissementannee;
use App\Models\AnneeScolaire;
use App\Models\PeriodesScolaire;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ParametresGlobauxController extends AdminController
{
    protected $title = 'Configuration de l\'Établissement';

    /**
     * Grille de consultation
     */
    protected function grid()
    {
        $grid = new Grid(new ParametresGlobaux());

        $user = Auth::user();
        $userEtablissementId = $user->etablissement_id;

        // Chargement des relations
        $query = $grid->model()->with([
            'etablissementAnnee.etablissement', 
            'anneeScolaire', 
            'trimestre', 
            'semestre'
        ]);

        // Isolation SaaS : Filtrage par établissement si l'utilisateur y est rattaché
        if (!empty($userEtablissementId)) {
            $query->whereHas('etablissementAnnee', function ($q) use ($userEtablissementId) {
                $q->where('etablissements_id', $userEtablissementId);
            });
        }

        $grid->column('id_parametres', __('ID'));

        // Extraction directe du nom de l'établissement
        $grid->column('etablissement', __('Établissement'))->display(function () {
            $etablissement = $this->etablissementAnnee?->etablissement;
            return is_array($etablissement) ? ($etablissement['nom_etablissement'] ?? 'Non défini') : ($etablissement?->nom_etablissement ?? 'Non défini');
        });

        $grid->column('logo', __('Logo'))->display(function ($photo) {
    if (!$photo) {
        return 'Aucune photo';
    }

    return "<img src='" . asset('uploads/' . $photo) . "' style='width:50px;height:50px;border-radius:6px;' />";
});
       
        $grid->column('directeur', __('Directeur / Proviseur'));

       $grid->column('anneescolaire_id', __('Année Scolaire Active'))->display(function () {
    // $this représente l'instance de ParametresGlobaux
    return $this->etablissementAnnees?->anneeScolaire?->annee_scolaire 
        ?? 'Non définie';
});

        // Affichage explicite du trimestre (libelle ou nom_periode)
        $grid->column('trimestre', __('Trimestre Actif'))->display(function () {
            return $this->trimestre?->libelle ?? $this->trimestre?->nom_peri ?? $this->trimestre?->type ?? 'Non défini';
        });

        // Affichage explicite du semestre (libelle ou nom_periode)
        $grid->column('semestre', __('Semestre Actif'))->display(function () {
            return $this->semestre?->libelle ?? $this->semestre?->nom_peri ?? $this->semestre?->type ?? 'Non défini';
        });

          $grid->column('date_rentree', __('Date rentree'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
            $grid->column('date_cloture', __('Date cloture'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });

        return $grid;
    }

    /**
     * Formulaire d'édition de la configuration
     */
    protected function form()
    {
        $form = new Form(new ParametresGlobaux());

        $user = Auth::user();
        $userEtablissementId = $user->etablissement_id ?? \App\Models\Etablissement::value('id_etablissements');

        // Création de secours de l'établissement si BDD vierge
        if (!$userEtablissementId) {
            $etablissement = \App\Models\Etablissement::create([
                'nom_etablissement' => 'Mon Établissement'
            ]);
            $userEtablissementId = $etablissement->id_etablissements;
            
            $user->etablissement_id = $userEtablissementId;
            $user->save();
        }

        // Récupération ou création automatique du pivot etablissementannees
        $etablissementAnnee = Etablissementannee::firstOrCreate([
            'etablissements_id' => $userEtablissementId,
        ]);

        // 1. ANCRAGE TECHNIQUE MASQUÉ
        $form->hidden('etablissementannees_id')
            ->default($etablissementAnnee->id_etablissementannees);

        // 2. NOM DE L'ÉTABLISSEMENT
        $form->text('nom_p', __('Nom de l\'Établissement'))
            ->rules('required')
            ->default(function ($form) {
                return $form->model()->etablissementAnnee?->etablissement?->nom 
                    ?? Auth::user()->etablissement?->nom 
                    ?? '';
            });

        $form->image('logo', __('Logo / Armoiries'))->uniqueName();
        $form->text('directeur', __('Directeur / Proviseur'));
        $form->text('localisation', __('Localisation'));

        $form->divider(__('Contextes d\'Exercice Actifs'));

       // 1. ANNÉE SCOLAIRE ACTIVE : Un seul ->load() natif pour les trimestres
    $form->select('anneescolaire_id', __('Année Scolaire Active'))
        ->options(function () use ($userEtablissementId) {
            return Etablissementannee::with('anneeScolaire')
                ->when($userEtablissementId, function ($query) use ($userEtablissementId) {
                    $query->where('etablissements_id', $userEtablissementId);
                })
                ->get()
                ->mapWithKeys(function ($pivot) {
                    $libelleAnnee = $pivot->anneeScolaire?->annee_scolaire 
                                 ?? $pivot->anneeScolaire?->libelle 
                                 ?? 'Année #' . $pivot->id_etablissementannees;
                    return [$pivot->id_etablissementannees => $libelleAnnee];
                });
        })
        ->load('trimestres_id', '/admin/api/trimestres-par-annee')
        ->rules('required');

    // 2. TRIMESTRE ACTIF
    $form->select('trimestres_id', __('Trimestre Actif'))
        ->options(function ($id) use ($form) {
            $anneescolaireId = request('anneescolaire_id') 
                ?? optional($form->model())->anneescolaire_id;

            if ($anneescolaireId) {
                return PeriodesScolaire::where('anneescolaire_id', $anneescolaireId)
                    ->where('type', 'trimestre')
                    ->pluck('nom_peri', 'id_periodes');
            }

            if (!$id) return [];
            $periode = PeriodesScolaire::find($id);
            return $periode ? [$periode->id_periodes => $periode->nom_peri] : [];
        });

    // 3. SEMESTRE ACTIF
    $form->select('semestres_id', __('Semestre Actif'))
        ->options(function ($id) use ($form) {
            $anneescolaireId = request('anneescolaire_id') 
                ?? optional($form->model())->anneescolaire_id;

            if ($anneescolaireId) {
                return PeriodesScolaire::where('anneescolaire_id', $anneescolaireId)
                    ->where('type', 'semestre')
                    ->pluck('nom_peri', 'id_periodes');
            }

            if (!$id) return [];
            $periode = PeriodesScolaire::find($id);
            return $periode ? [$periode->id_periodes => $periode->nom_peri] : [];
        });

    $form->date('date_rentree', __('Date rentrée'))->default(date('Y-m-d'));
    $form->date('date_cloture', __('Date cloture'))->default(date('Y-m-d'));

    // 4. INJECTION JS POUR DÉCLENCHER LE CHARGEMENT DES SEMESTRES
    Admin::script("
        $(document).off('change', 'select.anneescolaire_id').on('change', 'select.anneescolaire_id', function () {
            var target = $('select.semestres_id');
            var id = $(this).val();

            target.find('option').remove();

            if (!id) {
                target.val('').trigger('change');
                return;
            }

            $.ajax({
                url: '/admin/api/semestres-par-annee',
                data: { q: id },
                success: function (data) {
                    target.find('option').remove();
                    $.each(data, function (i, item) {
                        target.append(new Option(item.text, item.id, false, false));
                    });
                    target.val('').trigger('change');
                }
            });
        });
    ");

        // --------------------------------------------------------------------------
        // HOOKS
        // --------------------------------------------------------------------------
        
        $form->saving(function (Form $form) use ($etablissementAnnee) {
            if (!$form->etablissementannees_id) {
                $form->etablissementannees_id = $etablissementAnnee->id_etablissementannees;
            }
        });

        $form->saved(function (Form $form) {
            $nomSaisi = request('nom_p');
            $parametre = $form->model();

            if ($nomSaisi && $parametre->etablissementAnnee?->etablissement) {
                $etablissement = $parametre->etablissementAnnee->etablissement;
                $etablissement->nom_etablissement = $nomSaisi;
                $etablissement->save();
            }
        });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });

        return $form;
    }
/**
     * Endpoint API dédié aux Trimestres
     */
    public function getTrimestresByAnnee(Request $request)
    {
        $etablissementAnneeId = $request->get('q');

        if (!$etablissementAnneeId) {
            return [];
        }

        return PeriodesScolaire::where('anneescolaire_id', $etablissementAnneeId)
            ->where('type', 'trimestre')
            ->get()
            ->map(function ($periode) {
                return [
                    'id' => $periode->id_periodes,
                    'text' => $periode->nom_peri,
                ];
            });
    }

    /**
     * Endpoint API dédié aux Semestres
     */
    public function getSemestresByAnnee(Request $request)
    {
        $etablissementAnneeId = $request->get('q');

        if (!$etablissementAnneeId) {
            return [];
        }

        return PeriodesScolaire::where('anneescolaire_id', $etablissementAnneeId)
            ->where('type', 'semestre')
            ->get()
            ->map(function ($periode) {
                return [
                    'id' => $periode->id_periodes,
                    'text' => $periode->nom_peri,
                ];
            });
    }
}