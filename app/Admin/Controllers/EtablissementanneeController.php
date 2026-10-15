<?php

namespace App\Admin\Controllers;

use App\Models\Etablissementannee;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class EtablissementanneeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Etablissementannee';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Etablissementannee());

        $grid->column('id_etablissementannees', __('ID'));
        $grid->column('etablissement.nom_etablissement', __('Etablissement'));
        $grid->column('anneeScolaire.annee_scolaire', __('Année scolaire'));
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
        $show = new Show(Etablissementannee::findOrFail($id));

        $show->field('id_etablissementannees', __('Id etablissementannees'));
        $show->field('etablissements_id', __('Etablissements id'));
        $show->field('annee_scolaires_id', __('Annee scolaires id'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Etablissementannee());

        
        $form->select('etablissements_id', 'Établissement')
    ->options(\App\Models\Etablissement::pluck('nom_etablissement', 'id_etablissements'));
        

       $form->select('annee_scolaires_id', 'Année scolaire')
    ->options(\App\Models\AnneeScolaire::pluck('annee_scolaire', 'id_anneescolaires'));   

        return $form;
    }
}
