<?php

namespace App\Admin\Controllers;

use App\Models\InscriptionsPage;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class InscriptionsPageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'InscriptionsPage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InscriptionsPage());

        //$grid->column('id_inscriptionspage', __('Id inscriptionspage'));
        $grid->column('photo', __('Photo'));
        $grid->column('nom', __('Nom'));
        $grid->column('prenom', __('Prenom'));
        $grid->column('numero', __('Numero'));
        $grid->column('sexe', __('Sexe'));
        $grid->column('nationalite', __('Nationalite'));
        $grid->column('date_naiss', __('Date naiss'));
        $grid->column('lieu_naiss', __('Lieu naiss'));
        $grid->column('age', __('Age'));
        $grid->column('lieu_reisd', __('Lieu reisd'));
        $grid->column('text_excelente', __('Text excelente'));
        $grid->column('annee', __('Annee'));
        $grid->column('type_enseig', __('Type enseig'));
        $grid->column('type_cycle', __('Type cycle'));
        $grid->column('lvl_etude_gen_un', __('Lvl etude gen un'));
        $grid->column('lvl_etude_gen_deux', __('Lvl etude gen deux'));
        $grid->column('lvl_etude_techn', __('Lvl etude techn'));
        $grid->column('type_etude', __('Type etude'));
        $grid->column('info_pmt', __('Info pmt'));
        $grid->column('nom_p', __('Nom p'));
        $grid->column('tel_p', __('Tel p'));
        $grid->column('email_p', __('Email p'));
        $grid->column('nom_m', __('Nom m'));
        $grid->column('tel_m', __('Tel m'));
        $grid->column('email_m', __('Email m'));
        $grid->column('nom_t', __('Nom t'));
        $grid->column('tel_t', __('Tel t'));
        $grid->column('email_t', __('Email t'));
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
        $show = new Show(InscriptionsPage::findOrFail($id));

        $show->field('id_inscriptionspage', __('Id inscriptionspage'));
        $show->field('photo', __('Photo'));
        $show->field('nom', __('Nom'));
        $show->field('prenom', __('Prenom'));
        $show->field('numero', __('Numero'));
        $show->field('sexe', __('Sexe'));
        $show->field('nationalite', __('Nationalite'));
        $show->field('date_naiss', __('Date naiss'));
        $show->field('lieu_naiss', __('Lieu naiss'));
        $show->field('age', __('Age'));
        $show->field('lieu_reisd', __('Lieu reisd'));
        $show->field('text_excelente', __('Text excelente'));
        $show->field('annee', __('Annee'));
        $show->field('type_enseig', __('Type enseig'));
        $show->field('type_cycle', __('Type cycle'));
        $show->field('lvl_etude_gen_un', __('Lvl etude gen un'));
        $show->field('lvl_etude_gen_deux', __('Lvl etude gen deux'));
        $show->field('lvl_etude_techn', __('Lvl etude techn'));
        $show->field('type_etude', __('Type etude'));
        $show->field('info_pmt', __('Info pmt'));
        $show->field('nom_p', __('Nom p'));
        $show->field('tel_p', __('Tel p'));
        $show->field('email_p', __('Email p'));
        $show->field('nom_m', __('Nom m'));
        $show->field('tel_m', __('Tel m'));
        $show->field('email_m', __('Email m'));
        $show->field('nom_t', __('Nom t'));
        $show->field('tel_t', __('Tel t'));
        $show->field('email_t', __('Email t'));
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
        $form = new Form(new InscriptionsPage());

        $form->text('photo', __('Photo'));
        $form->text('nom', __('Nom'));
        $form->text('prenom', __('Prenom'));
        $form->text('numero', __('Numero'));
        $form->text('sexe', __('Sexe'));
        $form->text('nationalite', __('Nationalite'));
        $form->text('date_naiss', __('Date naiss'));
        $form->text('lieu_naiss', __('Lieu naiss'));
        $form->text('age', __('Age'));
        $form->text('lieu_reisd', __('Lieu reisd'));
        $form->text('text_excelente', __('Text excelente'));
        $form->text('annee', __('Annee'));
        $form->text('type_enseig', __('Type enseig'));
        $form->text('type_cycle', __('Type cycle'));
        $form->text('lvl_etude_gen_un', __('Lvl etude gen un'));
        $form->text('lvl_etude_gen_deux', __('Lvl etude gen deux'));
        $form->text('lvl_etude_techn', __('Lvl etude techn'));
        $form->text('type_etude', __('Type etude'));
        $form->text('info_pmt', __('Info pmt'));
        $form->text('nom_p', __('Nom p'));
        $form->text('tel_p', __('Tel p'));
        $form->text('email_p', __('Email p'));
        $form->text('nom_m', __('Nom m'));
        $form->text('tel_m', __('Tel m'));
        $form->text('email_m', __('Email m'));
        $form->text('nom_t', __('Nom t'));
        $form->text('tel_t', __('Tel t'));
        $form->text('email_t', __('Email t'));
        
        return $form;
    }
}
