<?php

namespace App\Admin\Controllers;

use App\Models\Affectation;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class AffectationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Affectation';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Affectation());

        $grid->column('professeurs.nom', __('Nom Professeurs'));
        $grid->column('professeurs.prenom', __('Prénom Professeurs'));
        $grid->column('matieres.nom_matiere', __('Matieres'));
        $grid->column('classes.nom_classe', __('Classes '));
        $grid->column('annee_scolaire', 'Année scolaire')
    ->display(function () {
        return optional(
            optional($this->etablissementannee)->anneeScolaire
        )->annee_scolaire;
    });
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
        $show = new Show(Affectation::findOrFail($id));

        $show->field('professeurs_id', __('Professeurs id'));
        $show->field('matieres_id', __('Matieres id'));
        $show->field('classes_id', __('Classes id'));
        $show->field('etablissementannees_id', __('Etablissementannees id'));
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
        $form = new Form(new Affectation());

        $form->select('professeurs_id', 'Professeurs')
    ->options(
        \App\Models\Professeur::all()->mapWithKeys(function ($professeur) {
            return [
                $professeur->id_professeurs => $professeur->nom . ' ' . $professeur->prenom
            ];
        })
    );
        $form->select('matieres_id', 'Matières')
    ->options(\App\Models\Matiere::pluck('nom_matiere', 'id_matieres'));

        $form->select('classes_id', 'Classes')
    ->options(\App\Models\Classe::pluck('nom_classe', 'id_classes'));

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
        $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));

        return $form;
    }
}
