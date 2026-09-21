<?php

namespace App\Admin\Controllers;

use App\Models\PersonnelsNettoyage;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;

class PersonnelsNettoyageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'PersonnelsNettoyage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PersonnelsNettoyage());

        //$grid->column('id_nettoyage', __('Id nettoyage'));
         $grid->column('personnel.nom', __('Nom'));
         $grid->column('personnel.prenom', __('Prenom'));
          $grid->column('numero_badge', __('Numero Badge'));
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
        $show = new Show(PersonnelsNettoyage::findOrFail($id));

        //$show->field('id_nettoyage', __('Id nettoyage'));
         $show->field('personnels_id', __('Personnels id'));
       /* $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_by', __('Created by'));
        $show->field('updated_by', __('Updated by'));
        $show->field('deleted_by', __('Deleted by'));*/
       

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PersonnelsNettoyage());

         
         $personnels = \App\Models\Personnel::where('fonction', 'Agent de Nettoyage')
        ->get()
        ->mapWithKeys(function ($item) {
            
            return [$item->id_personnel => $item->nom . ' ' . $item->prenom]; 
        });

    
    $form->select('personnels_id', __('Personnel (Agent de Nettoyage)'))
        ->options($personnels)
        ->rules('required');

       /* $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));*/
        

        return $form;
    }
}
