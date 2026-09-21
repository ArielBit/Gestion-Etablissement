<?php

namespace App\Admin\Controllers;

use App\Models\BulletinsMatiere;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class BulletinsMatiereController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'BulletinsMatiere';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid() 
    {
        $grid = new Grid(new BulletinsMatiere());

       // $grid->column('id_bulletinsmatieres', __('Id bulletinsmatieres'));

        $grid->column('annee_scolaire', 'Année scolaire')
        ->display(function () {
        return optional(
            optional($this->etablissementannees)->anneeScolaire
        )->annee_scolaire;
    });

    $grid->column('etablissementannees.annee_periodique', __('Année Périodique'));
        $grid->column('etablissementannees.type_anperiode', __('Type Année Périodique'));

        $grid->column('evaluations.notes', __('Notes'));

        $grid->column('evaluations.type_evaluation', __('Type Evaluation'));

        $grid->column('matieres.nom_matiere', __('Matieres'));

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
        
        $grid->column('moyenne', __('Moyenne'));
        $grid->column('rang', __('Rang'));
        $grid->column('appreciation', __('Appreciation'));
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
        $show = new Show(BulletinsMatiere::findOrFail($id));

        $show->field('id_bulletinsmatieres', __('Id bulletinsmatieres'));
        $show->field('evaluations_id', __('Evaluations id'));
        $show->field('matieres_id', __('Matieres id'));
        $show->field('classeapprenants_id', __('Classeapprenants id'));
        $show->field('etablissementannees_id', __('Etablissementannees id'));
        $show->field('periode_numero', __('Periode numero'));
        $show->field('apprenants_id', __('Apprenants id'));
        $show->field('moyenne', __('Moyenne'));
        $show->field('rang', __('Rang'));
        $show->field('appreciation', __('Appreciation'));
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
        $form = new Form(new BulletinsMatiere());

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

        $form->select('evaluations_id', __('Notes'))
        ->options(\App\Models\Evaluation::pluck('notes', 'id_evaluations'));

         $form->select('evaluations_id', __('Type Evaluation'))
        ->options(\App\Models\Evaluation::pluck('type_evaluation', 'id_evaluations'));

        $form->select('matieres_id', 'Matières')
    ->options(\App\Models\Matiere::pluck('nom_matiere', 'id_matieres'));

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
        
        $form->text('moyenne', __('Moyenne'));
        $form->text('rang', __('Rang'));
        $form->text('appreciation', __('Appreciation'));
        $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));

        return $form;
    }
}
