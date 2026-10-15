<?php

namespace App\Admin\Controllers;

use App\Models\PeriodesScolaire;
use App\Models\AnneeScolaire;
use App\Models\Etablissement;
use App\Models\Etablissementannee;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PeriodesScolaireController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'PeriodesScolaire';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
{
    $grid = new Grid(new PeriodesScolaire());

    $userEtablissementId = \Illuminate\Support\Facades\Auth::user()->etablissement_id;

    $query = $grid->model()->with(['etablissementAnnee.anneeScolaire']);

    // Isolation SaaS
    if (!empty($userEtablissementId)) {
        $query->whereHas('etablissementAnnee', function ($q) use ($userEtablissementId) {
            $q->where('etablissements_id', $userEtablissementId);
        });
    }

    $grid->column('id_periodes', __('ID'));
    $grid->column('type', __('Type Période'));
    $grid->column('nom_peri', __('Nom Période'));

    // Affichage correct de l'année via la relation pivot
    $grid->column('annee_scolaire', __('Année Scolaire'))->display(function () {
        $annee = $this->etablissementAnnee?->anneeScolaire;
        return $annee?->annee_scolaire ?? $annee?->libelle ?? 'Non définie';
    });

    $grid->column('date_debut', __('Date Début'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
    $grid->column('date_fin', __('Date Fin'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
    $grid->column('ordre', __('Ordre'));

    return $grid;
}
    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PeriodesScolaire::findOrFail($id));

        $show->field('id_periodes', __('Id periodes'));
        $show->field('nom_peri', __('Nom'));
        $show->field('type', __('Type'));
        $show->field('date_debut', __('Date debut'));
        $show->field('date_fin', __('Date fin'));
        $show->field('ordre', __('Ordre'));
        $show->field('date_rentree', __('Date rentree'));
        $show->field('date_cloture_annee', __('Date cloture annee'));
       /* $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_by', __('Created by'));
        $show->field('updated_by', __('Updated by'));
        $show->field('deleted_by', __('Deleted by'));*/
        $show->field('anneescolaire_id', __('Anneescolaire id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
{
    $form = new Form(new PeriodesScolaire());

    // 1. Choix du type de période
    $form->select('type', __('Type Période'))
        ->options([
            'trimestre' => 'Trimestre',
            'semestre'  => 'Semestre',
        ])
        // Lorsque 'trimestre' est sélectionné
        ->when('trimestre', function (Form $form) {
            $form->select('nom_peri', __('Nom du Trimestre'))
                ->options([
                    '1er Trimestre'  => '1er Trimestre',
                    '2ème Trimestre' => '2ème Trimestre',
                    '3ème Trimestre' => '3ème Trimestre',
                ])
                ->placeholder('Sélectionnez un Trimestre') 
                ->config('allowClear', true)
                ->rules('required');
        })
        // Lorsque 'semestre' est sélectionné
        ->when('semestre', function (Form $form) {
            $form->select('nom_peri', __('Nom du Semestre'))
                ->options([
                    '1er Semestre'  => '1er Semestre',
                    '2ème Semestre' => '2ème Semestre',
                ])
                ->placeholder('Sélectionnez un Semestre') 
                ->config('allowClear', true)
                ->rules('required');
        })
        ->rules('required');

    // 2. Dates de la période
    $form->datetime('date_debut', __('Date de début'))->default(date('Y-m-d H:i:s'));
    $form->datetime('date_fin', __('Date de fin'))->default(date('Y-m-d H:i:s'));

    // 3. Ordre d'affichage
    $form->number('ordre', __('Ordre'))->default(1);
    
    // 4. Année Scolaire associée
   $user = \Illuminate\Support\Facades\Auth::user();
    $userEtablissementId = $user->etablissement_id;

    // 4. Année Scolaire associée (filtrée par l'établissement de l'utilisateur connecté)
    $form->select('anneescolaire_id', __('Année Scolaire'))
        ->options(function () use ($userEtablissementId) {
            return \App\Models\Etablissementannee::with('anneeScolaire')
                ->when($userEtablissementId, function ($query) use ($userEtablissementId) {
                    $query->where('etablissements_id', $userEtablissementId);
                })
                ->get()
                ->mapWithKeys(function ($pivot) {
                    // La clé envoyée et enregistrée est l'ID de la table pivot (id_etablissementannees)
                    // Le libellé affiché est celui de l'année scolaire associée
                    $libelleAnnee = $pivot->anneeScolaire?->annee_scolaire 
                                 ?? $pivot->anneeScolaire?->libelle 
                                 ?? 'Année #' . $pivot->id_etablissementannees;

                    return [$pivot->id_etablissementannees => $libelleAnnee];
                });
        })
        ->rules('required');

    return $form;
}
}
