<?php

namespace App\Admin\Controllers;

use App\Models\DonateursPage;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class DonateursPageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'DonateursPage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DonateursPage());

       // $grid->column('id_donateurspage', __('Id donateurspage'));
        $grid->column('explication', __('Explication'));
        $grid->column('types_donnateurs', __('Types donnateurs'));
        $grid->column('organisation', __('Organisation'));
        $grid->column('nom', __('Nom'));
        $grid->column('prenom', __('Prenom'));
        $grid->column('annee', __('Annee'));
        $grid->column('types_don', __('Types don'));
        $grid->column('don_vivres', __('Don vivres'));
        $grid->column('don_nonvivres', __('Don nonvivres'));
        $grid->column('quantite', __('Quantite'));
        $grid->column('contacts', __('Contacts'));
        $grid->column('email', __('Email'));
        $grid->column('modes_paye', __('Modes paye'));
        $grid->column('banque', __('Banque'));
        $grid->column('montant', __('Montant'));
        //AT
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
        $show = new Show(DonateursPage::findOrFail($id));

        $show->field('id_donateurspage', __('Id donateurspage'));
        $show->field('explication', __('Explication'));
        $show->field('types_donnateurs', __('Types donnateurs'));
        $show->field('organisation', __('Organisation'));
        $show->field('nom', __('Nom'));
        $show->field('prenom', __('Prenom'));
        $show->field('annee', __('Annee'));
        $show->field('types_don', __('Types don'));
        $show->field('don_vivres', __('Don vivres'));
        $show->field('don_nonvivres', __('Don nonvivres'));
        $show->field('quantite', __('Quantite'));
        $show->field('contacts', __('Contacts'));
        $show->field('email', __('Email'));
        $show->field('modes_paye', __('Modes paye'));
        $show->field('banque', __('Banque'));
        $show->field('montant', __('Montant'));
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
        $form = new Form(new DonateursPage());

        $form->text('explication', __('Explication'));
        $form->text('types_donnateurs', __('Types donnateurs'));
        $form->text('organisation', __('Organisation'));
        $form->text('nom', __('Nom'));
        $form->text('prenom', __('Prenom'));
        $form->text('annee', __('Annee'));
        $form->text('types_don', __('Types don'));
        $form->text('don_vivres', __('Don vivres'));
        $form->text('don_nonvivres', __('Don nonvivres'));
        $form->text('quantite', __('Quantite'));
        $form->text('contacts', __('Contacts'));
        $form->email('email', __('Email'));
        $form->text('modes_paye', __('Modes paye'));
        $form->text('banque', __('Banque'));
        $form->text('montant', __('Montant'));

        return $form;
    }
}
