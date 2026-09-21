<?php

namespace App\Admin\Controllers;

use App\Models\Accueil;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class AccueilController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Accueil';

    /**
     * Make a table builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Accueil());

       // $grid->column('id_accueil', __('Id accueil'));
        $grid->column('premier', __('Premier'));
        $grid->column('deuxieme', __('Deuxieme'));
        $grid->column('troisieme', __('Troisieme'));
        $grid->column('cycle_un', __('Cycle Un'));
        $grid->column('cycle_deux', __('Cycle Deux'));
        $grid->column('cycle_trois', __('Cycle Trois'));
        $grid->column('cycle_quatre', __('Cycle Quatre'));
        $grid->column('cinq', __('Cinq'));
       /* $table->column('created_at', __('Created at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $table->column('updated_at', __('Updated at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $table->column('deleted_at', __('Deleted at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $table->column('created_by', __('Created by'));
        $table->column('updated_by', __('Updated by'));
        $table->column('deleted_by', __('Deleted by'));*/
        $grid->column('titre_premier', __('Titre premier'));
        $grid->column('titre_deuxieme', __('Titre deuxieme'));
        $grid->column('contenu_premier', __('Contenu premier'));
        $grid->column('contenu_deuxieme', __('Contenu deuxieme'));
        $grid->column('sous_titre_premier', __('Sous titre premier'));
        $grid->column('sous_titre_deux', __('Sous titre deux'));
        $grid->column('temps_un', __('Temps un'));
        $grid->column('temps_deux', __('Temps deux'));
        $grid->column('evaluation', __('Evaluation'));
        $grid->column('text_evaluation', __('Text evaluation'));
        $grid->column('service_un', __('Service un'));
        $grid->column('service_deux', __('Service deux'));
        $grid->column('service_trois', __('Service trois'));
        $grid->column('titre_service_un', __('Titre service un'));
        $grid->column('titre_service_deux', __('Titre service deux'));
        $grid->column('text_service_un', __('Text service un'));
        $grid->column('text_service_deux', __('Text service deux'));
        $grid->column('nombre_un', __('Nombre un'));
        $grid->column('un', __('Un'));
        $grid->column('nombre_deux', __('Nombre deux'));
        $grid->column('deux', __('Deux'));
        $grid->column('nombre_trois', __('Nombre trois'));
        $grid->column('trois', __('Trois'));
        $grid->column('nombre_quatre', __('Nombre quatre'));
        $grid->column('quatre', __('Quatre'));
        $grid->column('agenda', __('Agenda'));
        $grid->column('sous_titre_agenda', __('Sous titre agenda'));
        $grid->column('div_un', __('Div un'));
        $grid->column('div_sous_un', __('Div sous un'));
        $grid->column('div_text', __('Div text'));
        $grid->column('div_deux', __('Div deux'));
        $grid->column('div_sous_deux', __('Div sous deux'));
        $grid->column('div_text_deux', __('Div text deux'));
        $grid->column('div_trois', __('Div trois'));
        $grid->column('div_sous_trois', __('Div sous trois'));
        $grid->column('div_text_trois', __('Div text trois'));

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
        $show = new Show(Accueil::findOrFail($id));

        $show->field('id_accueil', __('Id accueil'));
        $show->field('premier', __('Premier'));
        $show->field('deuxieme', __('Deuxieme'));
        $show->field('troisieme', __('Troisieme'));
        $show->field('cycle_un', __('Cycle Un'));
        $show->field('cycle_deux', __('Cycle Deux'));
        $show->field('cycle_trois', __('Cycle Trois'));
        $show->field('cycle_quatre', __('Cycle Quatre'));
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
        $show->field('evaluation', __('Evaluation'));
        $show->field('text_evaluation', __('Text evaluation'));
        $show->field('service_un', __('Service un'));
        $show->field('service_deux', __('Service deux'));
        $show->field('service_trois', __('Service trois'));
        $show->field('titre_service_un', __('Titre service un'));
        $show->field('titre_service_deux', __('Titre service deux'));
        $show->field('text_service_un', __('Text service un'));
        $show->field('text_service_deux', __('Text service deux'));
        $show->field('nombre_un', __('Nombre un'));
        $show->field('un', __('Un'));
        $show->field('nombre_deux', __('Nombre deux'));
        $show->field('deux', __('Deux'));
        $show->field('nombre_trois', __('Nombre trois'));
        $show->field('trois', __('Trois'));
        $show->field('nombre_quatre', __('Nombre quatre'));
        $show->field('quatre', __('Quatre'));
        $show->field('agenda', __('Agenda'));
        $show->field('sous_titre_agenda', __('Sous titre agenda'));
        $show->field('div_un', __('Div un'));
        $show->field('div_sous_un', __('Div sous un'));
        $show->field('div_text', __('Div text'));
        $show->field('div_deux', __('Div deux'));
        $show->field('div_sous_deux', __('Div sous deux'));
        $show->field('div_text_deux', __('Div text deux'));
        $show->field('div_trois', __('Div trois'));
        $show->field('div_sous_trois', __('Div sous trois'));
        $show->field('div_text_trois', __('Div text trois'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Accueil());

        $form->text('premier', __('Premier'));
        $form->text('deuxieme', __('Deuxieme'));
        $form->text('troisieme', __('Troisieme'));
        $form->text('cycle_un', __('Cycle Un'));
        $form->text('cycle_deux', __('Cycle Deux'));
        $form->text('cycle_trois', __('Cycle Trois'));
        $form->text('cycle_quatre', __('Cycle Quatre'));
        $form->textarea('cinq', __('Cinq'));
        $form->text('titre_premier', __('Titre premier'));
        $form->text('titre_deuxieme', __('Titre deuxieme'));
        $form->textarea('contenu_premier', __('Contenu premier'));
        $form->textarea('contenu_deuxieme', __('Contenu deuxieme'));
        $form->text('sous_titre_premier', __('Sous titre premier'));
        $form->text('sous_titre_deux', __('Sous titre deux'));
        $form->text('temps_un', __('Temps un'));
        $form->text('temps_deux', __('Temps deux'));
        $form->text('evaluation', __('Evaluation'));
        $form->text('text_evaluation', __('Text evaluation'));
        $form->text('service_un', __('Service un'));
        $form->text('service_deux', __('Service deux'));
        $form->text('service_trois', __('Service trois'));
        $form->text('titre_service_un', __('Titre service un'));
        $form->text('titre_service_deux', __('Titre service deux'));
        $form->textarea('text_service_un', __('Text service un'));
        $form->textarea('text_service_deux', __('Text service deux'));
        $form->text('nombre_un', __('Nombre un'));
        $form->text('un', __('Un'));
        $form->text('nombre_deux', __('Nombre deux'));
        $form->text('deux', __('Deux'));
        $form->text('nombre_trois', __('Nombre trois'));
        $form->text('trois', __('Trois'));
        $form->text('nombre_quatre', __('Nombre quatre'));
        $form->text('quatre', __('Quatre'));
        $form->text('agenda', __('Agenda'));
        $form->text('sous_titre_agenda', __('Sous titre agenda'));
        $form->text('div_un', __('Div un'));
        $form->text('div_sous_un', __('Div sous un'));
        $form->textarea('div_text', __('Div text'));
        $form->text('div_deux', __('Div deux'));
        $form->text('div_sous_deux', __('Div sous deux'));
        $form->textarea('div_text_deux', __('Div text deux'));
        $form->text('div_trois', __('Div trois'));
        $form->text('div_sous_trois', __('Div sous trois'));
        $form->textarea('div_text_trois', __('Div text trois'));

        return $form;
    }
}
