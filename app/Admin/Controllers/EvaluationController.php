<?php

namespace App\Admin\Controllers;

use App\Models\Evaluation;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid; 
use Carbon\Carbon;
use App\Models\Classeapprenant;

class EvaluationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Evaluation';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Evaluation());

         //$grid->column('id_evaluations', __('Id evaluations'));
        $grid->column('annee_scolaire', 'Année scolaire')
    ->display(function () {
        return optional(
            optional($this->etablissementannees)->anneeScolaire
        )->annee_scolaire;
    }); 
        $grid->column('etablissementannees.annee_periodique', __('Année Périodique'));
        $grid->column('etablissementannees.type_anperiode', __('Type Année Périodique'));
        $grid->column('matieres.nom_matiere', __('Matieres'));
        $grid->column('type_evaluation', __('Type evaluation'));
        $grid->column('notes', __('Notes')); 
        $grid->column('duree', __('Duree'));
        $grid->column('date_evaluation', __('Date evaluation'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });

        $grid->column('observations', __('Observations')); 

        $grid->model()->with('classeapprenant.apprenants');
        $grid->column('apprenants', 'Apprenant')
    ->display(function () {
        return optional(
            optional($this->classeapprenant)->apprenants
        )->nom . ' ' .
        optional(
            optional($this->classeapprenant)->apprenants
        )->prenom;
    });

        $grid->column('classes', 'Classe')
    ->display(function () {
        return optional(
            optional($this->classeapprenant)->classes
        )->nom_classe;
    });
        $grid->column('professeurs.nom', __('Nom Professeurs'));
        $grid->column('professeurs.prenom', __('Prénom Professeurs'));

         #AT
        /*$grid->column('created_at', __('Created at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('updated_at', __('Updated at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('deleted_at', __('Deleted at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        
        #BY
        $grid->column('created_by', __('Created by'));
        $grid->column('updated_by', __('Updated by'));
        $grid->column('deleted_by', __('Deleted by'));*/

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
        $show = new Show(Evaluation::findOrFail($id));

        $show->field('id_evaluations', __('Id evaluations'));
        $show->field('annee_periodiques.libelle', __('Annee periodiques id'));
        $show->field('matieres_id', __('Matieres id'));
        $show->field('type_evaluation', __('Type evaluation'));
        $show->field('notes', __('Notes'));
        $show->field('duree', __('Duree'));
        $show->field('date_evaluation', __('Date evaluation'));
        $show->field('observations', __('Observations'));
        $show->field('classeapprenants_apprenants_id', __('Classeapprenants apprenants id'));
        $show->field('classeapprenants_classes_id', __('Classeapprenants classes id'));
        $show->field('professeurs_id', __('Professeurs id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_by', __('Created by'));
        $show->field('updated_by', __('Updated by'));
        $show->field('deleted_by', __('Deleted by'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Evaluation());

         $form->select('etablissementannees_id', 'Année scolaire')
    ->options(
        \App\Models\EtablissementAnnee::with('anneeScolaire')
            ->get()
            ->mapWithKeys(function ($item) { 
                return [
                    $item->id_etablissementannees =>
                        optional($item->anneeScolaire)->annee_scolaire
                ];
            })
    );

    $form->select('etablissementannees_id', 'Année Périodique')
    ->options(\App\Models\EtablissementAnnee::pluck('annee_periodique', 'id_etablissementannees'));

    $form->select('etablissementannees_id', 'Type Année Périodique')
    ->options(\App\Models\EtablissementAnnee::pluck('type_anperiode', 'id_etablissementannees'));

        $form->select('matieres_id', 'Matières')
    ->options(\App\Models\Matiere::pluck('nom_matiere', 'id_matieres'));

        $form->text('type_evaluation', __('Type evaluation'));
        $form->decimal('notes', __('Notes'));
        $form->text('duree', __('Duree'));
        $form->datetime('date_evaluation', __('Date evaluation'))->default(date('Y-m-d H:i:s'));
        $form->text('observations', __('Observations'));

        $form->select('classeapprenants_id', 'Apprenant')
    ->options(
        \App\Models\Classeapprenant::with(['apprenants', 'classes'])
            ->get()
            ->mapWithKeys(function ($item) {

                $nom =
                    optional($item->apprenants)->nom . ' ' .
                    optional($item->apprenants)->prenom;

                $classe =
                    optional($item->classes)->nom_classe;

                return [
                    $item->id_classeapprenants =>
                    $nom . ' - ' . $classe
                ];
            })
    );

        $form->select('professeurs_id', 'Professeurs')
    ->options(
        \App\Models\Professeur::all()->mapWithKeys(function ($professeur) {
            return [
                $professeur->id_professeurs => $professeur->nom . ' ' . $professeur->prenom
            ];
        })
    );
       

        return $form;
    }
}
