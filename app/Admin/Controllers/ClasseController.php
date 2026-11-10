<?php

namespace App\Admin\Controllers;

use App\Models\Classe;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class ClasseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Classe';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Classe());

        $grid->column('id_classes', __('ID'));
        $grid->column('scolarites.classes', __('Niveaux D\'études'));
        $grid->column('nom_classe', __('Nom classe'));
        $grid->column('type_cl', __('Type Période'));
        #AT
       /* $grid->column('created_at', __('Created at'))->display(function ($value) {
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
        $show = new Show(Classe::findOrFail($id));

        $show->field('id_classes', __('Id classes'));
        $show->field('nom_classe', __('Nom classe'));
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
        $form = new Form(new Classe());

    $form->select('scolarites_niveaux_id', 'Niveaux d\'études')
    ->options(\App\Models\Scolarite::pluck('classes', 'id_scolarites'))
    ->load('nom_classe', '/admin/api/classes');

$form->select('nom_classe', 'Nom classe')
    ->options([]);

    $form->select('type_cl', __('Type Période'))
    ->options([
        'trimestre' => 'trimestre',
        'semestre' => 'semestre'
    ]);
        

        return $form;
    }
}
