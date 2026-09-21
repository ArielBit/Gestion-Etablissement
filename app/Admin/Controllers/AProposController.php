<?php

namespace App\Admin\Controllers;

use App\Models\APropo;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid; 
use Carbon\Carbon;

class AProposController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Apropo';

    

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new APropo());

        //$grid->column('id_propos', __('Id propos'));
        $grid->column('premier', __('Premier'));
        $grid->column('deuxieme', __('Deuxieme'));
        $grid->column('troisieme', __('Troisieme'));
        $grid->column('numero', __('Numero'));
       /* $grid->column('created_at', __('Created at'))->display(function ($value) {
        return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('updated_at', __('Updated at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('deleted_at', __('Deleted at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('created_by', __('Created by'));
        $grid->column('updated_by', __('Updated by'));
        $grid->column('deleted_by', __('Deleted by'));*/
        $grid->column('titre_premier', __('Titre premier'));
        $grid->column('titre_deuxieme', __('Titre deuxieme'));
        $grid->column('contenu_premier', __('Contenu premier'));
        $grid->column('contenu_deuxieme', __('Contenu deuxieme'));
        $grid->column('exelence', __('Exelence'));
        $grid->column('digitalisation', __('Digitalisation'));
        $grid->column('text_excelente', __('Text excelente'));
        $grid->column('text_digitalisation', __('Text digitalisation'));
        $grid->column('mission', __('Mission'));
        $grid->column('taux_reussite', __('Taux reussite'));
        $grid->column('nombre_premier', __('Nombre premier'));
        $grid->column('partenaires', __('Partenaires'));
        $grid->column('nombre_troisieme', __('Nombre troisieme'));
        $grid->column('apprenants', __('Apprenants'));
        $grid->column('nombre_deuxime', __('Nombre deuxime'));

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
        $show = new Show(APropo::findOrFail($id));

        $show->field('id_propos', __('Id propos'));
        $show->field('premier', __('Premier'));
        $show->field('deuxieme', __('Deuxieme'));
        $show->field('troisieme', __('Troisieme'));
        $show->field('numero', __('Numero'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_by', __('Created by'));
        $show->field('updated_by', __('Updated by'));
        $show->field('deleted_by', __('Deleted by'));
        $show->field('titre_premier', __('Titre premier'));
        $show->field('titre_deuxieme', __('Titre deuxieme'));
        $show->field('contenu_premier', __('Contenu premier'));
        $show->field('contenu_deuxieme', __('Contenu deuxieme'));
        $show->field('exelence', __('Exelence'));
        $show->field('digitalisation', __('Digitalisation'));
        $show->field('text_excelente', __('Text excelente'));
        $show->field('text_digitalisation', __('Text digitalisation'));
        $show->field('mission', __('Mission'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new APropo());

        $form->text('premier', __('Premier'));
        $form->text('deuxieme', __('Deuxieme'));
        $form->text('troisieme', __('Troisieme'));
        $form->text('numero', __('Numero'));
        $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));
        $form->text('titre_premier', __('Titre premier'));
        $form->text('titre_deuxieme', __('Titre deuxieme'));
        $form->textarea('contenu_premier', __('Contenu premier'));
        $form->textarea('contenu_deuxieme', __('Contenu deuxieme'));
        $form->text('exelence', __('Exelence'));
        $form->text('digitalisation', __('Digitalisation'));
        $form->textarea('text_excelente', __('Text excelente'));
        $form->textarea('text_digitalisation', __('Text digitalisation'));
        $form->text('mission', __('Mission'));
        $form->text('taux_reussite', __('Taux reussite'));
        $form->text('nombre_premier', __('Nombre premier'));
        $form->text('partenaires', __('Partenaires'));
        $form->text('nombre_troisieme', __('Nombre troisieme'));
        $form->text('apprenants', __('Apprenants'));
        $form->text('nombre_deuxime', __('Nombre deuxime'));

        return $form;
    }
}
