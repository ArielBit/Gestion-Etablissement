<?php

namespace App\Admin\Controllers;

use App\Models\Educateur;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;

class EducateurController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Educateur';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Educateur());

        //$grid->column('id_educateurs', __('Id educateurs'));
        $grid->column('personnel.nom', __('Nom'));
        $grid->column('personnel.prenom', __('Prenom'));
        $grid->column('matricule', __('Matricule'));
        /*$grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
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
        $show = new Show(Educateur::findOrFail($id));

        $show->field('id_educateurs', __('Id educateurs'));
        $show->field('matricule', __('Matricule'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_by', __('Created by'));
        $show->field('updated_by', __('Updated by'));
        $show->field('deleted_by', __('Deleted by'));
        $show->field('personnels_id', __('Personnels id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Educateur());

         $personnels = \App\Models\Personnel::where('fonction', 'Educateur')
        ->get()
        ->mapWithKeys(function ($item) {
            
            return [$item->id_personnel => $item->nom . ' ' . $item->prenom]; 
        });

    
    $form->select('personnels_id', __('Personnel (Educateur)'))
        ->options($personnels)
        ->rules('required');


       /* $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));*/
        

        return $form;
    }
}
