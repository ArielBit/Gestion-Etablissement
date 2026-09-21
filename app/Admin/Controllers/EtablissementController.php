<?php

namespace App\Admin\Controllers;

use App\Models\Etablissement;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class EtablissementController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Etablissement';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Etablissement());

        //$grid->column('id_etablissements', __('Id etablissements'));
        $grid->column('nom', __('Nom'));
        $grid->column('date_creation', __('Date creation'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        
        $grid->column('directeur', __('Directeur'));
        $grid->column('localisation', __('Localisation'));

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
        $show = new Show(Etablissement::findOrFail($id));

        $show->field('id_etablissements', __('Id etablissements'));
        $show->field('nom', __('Nom'));
        $show->field('date_creation', __('Date creation'));
        $show->field('directeur', __('Directeur'));
        $show->field('localisation', __('Localisation'));
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
        $form = new Form(new Etablissement());

        $form->text('nom', __('Nom'));
        $form->date('date_creation', __('Date creation'))->default(date('Y-m-d'));
        $form->text('directeur', __('Directeur'));
        $form->text('localisation', __('Localisation'));
       

        return $form;
    }
}
