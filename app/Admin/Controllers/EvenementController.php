<?php

namespace App\Admin\Controllers;

use App\Models\Evenement;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class EvenementController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Evenement';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Evenement());

        //$grid->column('id_evenements', __('Id evenements'));
        $grid->column('premier', __('Premier'));
        $grid->column('deuxieme', __('Deuxieme'));
        $grid->column('troisieme', __('Troisieme'));
        $grid->column('quatre', __('Quatre'));
         $grid->column('cinq', __('Cinq'));
       /*$grid->column('created_at', __('Created at'))->display(function ($value) {
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
        $grid->column('sous_titre_premier', __('Sous titre premier'));
        $grid->column('sous_titre_deux', __('Sous titre deux'));
        $grid->column('temps_un', __('Temps un'));
        $grid->column('temps_deux', __('Temps deux'));
        $grid->column('remise_titre', __('Remise titre'));
        $grid->column('text_remise', __('Text remise'));
        $grid->column('periode', __('Periode'));
        $grid->column('enseigne_un', __('Enseigne un'));
        $grid->column('enseigne_deux', __('Enseigne deux'));
        $grid->column('enseigne_premier', __('Enseigne premier'));
        $grid->column('enseigne_deuxieme', __('Enseigne deuxieme'));

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
        $show = new Show(Evenement::findOrFail($id));

        $show->field('id_evenements', __('Id evenements'));
        $show->field('premier', __('Premier'));
        $show->field('deuxieme', __('Deuxieme'));
        $show->field('troisieme', __('Troisieme'));
        $show->field('quatre', __('Quatre'));
        $show->field('cinq', __('Cinq'));
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
        $show->field('sous_titre_premier', __('Sous titre premier'));
        $show->field('sous_titre_deux', __('Sous titre deux'));
        $show->field('temps_un', __('Temps un'));
        $show->field('temps_deux', __('Temps deux'));
        $show->field('remise_titre', __('Remise titre'));
        $show->field('text_remise', __('Text remise'));
        $show->field('periode', __('Periode'));
        $show->field('enseigne_un', __('Enseigne un'));
        $show->field('enseigne_deux', __('Enseigne deux'));
        $show->field('enseigne_premier', __('Enseigne premier'));
        $show->field('enseigne_deuxieme', __('Enseigne deuxieme'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Evenement());

        $form->text('premier', __('Premier'));
        $form->text('deuxieme', __('Deuxieme'));
        $form->text('troisieme', __('Troisieme'));
        $form->text('quatre', __('Quatre'));
         $form->text('cinq', __('Cinq'));
        $form->text('titre_premier', __('Titre premier'));
        $form->text('titre_deuxieme', __('Titre deuxieme'));
        $form->textarea('contenu_premier', __('Contenu premier'));
        $form->textarea('contenu_deuxieme', __('Contenu deuxieme'));
        $form->text('sous_titre_premier', __('Sous titre premier'));
        $form->text('sous_titre_deux', __('Sous titre deux'));
        $form->text('temps_un', __('Temps un'));
        $form->text('temps_deux', __('Temps deux'));
        $form->text('remise_titre', __('Remise titre'));
        $form->textarea('text_remise', __('Text remise'));
        $form->text('periode', __('Periode'));
        $form->text('enseigne_un', __('Enseigne un'));
        $form->text('enseigne_deux', __('Enseigne deux'));
        $form->text('enseigne_premier', __('Enseigne premier'));
        $form->text('enseigne_deuxieme', __('Enseigne deuxieme'));

        return $form;
    }
}
