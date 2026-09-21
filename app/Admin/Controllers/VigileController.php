<?php

namespace App\Admin\Controllers;

use App\Models\Vigile;
use App\Models\Personnel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;

class VigileController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Vigile';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Vigile());

        //$grid->column('id_vigile', __('Id vigile'));
         $grid->column('personnel.nom', __('Nom'));
         $grid->column('personnel.prenom', __('Prenom'));
        $grid->column('numero_badge', __('Numero badge'));
        $grid->column('societe_securite', __('Societe securite'));
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
        $show = new Show(Vigile::findOrFail($id));

        //$show->field('id_vigile', __('Id vigile'));
        $show->field('personnel.nom', __('Nom'));
        $show->field('numero_badge', __('Numero badge'));
        $show->field('societe_securite', __('Societe securite'));
        /*$show->field('created_at', __('Created at'));
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
    $form = new Form(new Vigile());

    
    $personnels = \App\Models\Personnel::where('fonction', 'Vigile')
        ->get()
        ->mapWithKeys(function ($item) {
            
            return [$item->id_personnel => $item->nom . ' ' . $item->prenom]; 
        });

    
    $form->select('personnels_id', __('Personnel (Vigile)'))
        ->options($personnels)
        ->rules('required');

    $form->text('societe_securite', __('Societe securite'));

    return $form;
}
}
