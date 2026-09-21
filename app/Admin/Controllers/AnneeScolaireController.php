<?php

namespace App\Admin\Controllers;

use App\Models\AnneeScolaire;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class AnneeScolaireController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AnneeScolaire';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AnneeScolaire());

       //$grid->column('id_anneescolaires', __('Id anneescolaires'));
        $grid->column('annee_scolaire', __('Annee scolaire'));

        #DATE
        $grid->column('date_debut', __('Date debut'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('date_fin', __('Date fin'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
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
        $show = new Show(AnneeScolaire::findOrFail($id));

        $show->field('id_anneescolaires', __('Id anneescolaires'));
        $show->field('annee_scolaire', __('Annee scolaire'));
        $show->field('date_debut', __('Date debut'));
        $show->field('date_fin', __('Date fin'));
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
        $form = new Form(new AnneeScolaire());

        $form->select('annee_scolaire', __('Annee Scolaire'))
         ->options([
        '2023-2024' => '2023-2024',
        '2024-2025' => '2024-2025',
        '2025-2026' => '2025-2026',
        '2026-2027' => '2026-2027',
        '2027-2028' => '2027-2028',
        '2028-2029' => '2028-2029',
        '2029-2030' => '2029-2030',
        '2030-2031' => '2030-2031',
        ]);
        $form->date('date_debut', __('Date debut'));
        $form->date('date_fin', __('Date fin'));
        $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));

        return $form;
    }
}
