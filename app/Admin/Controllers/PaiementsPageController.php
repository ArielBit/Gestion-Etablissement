<?php

namespace App\Admin\Controllers;

use App\Models\PaiementsPage;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class PaiementsPageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'PaiementsPage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PaiementsPage());

       // $grid->column('id_paiementspage', __('Id paiementspage'));
        $grid->column('explication', __('Explication'));
        $grid->column('select_nom', __('Select nom'));
        $grid->column('finance_un', __('Finance un'));
        $grid->column('finance_deux', __('Finance deux'));
        $grid->column('finance_trois', __('Finance trois'));
        $grid->column('finance_quatre', __('Finance quatre'));
        $grid->column('unite', __('Unite'));
        $grid->column('lieu_naiss', __('Lieu naiss'));
        $grid->column('modalite_paye', __('Modalite paye'));
        $grid->column('tranche_paye', __('Tranche paye'));
        $grid->column('un_mois', __('Un mois'));
        $grid->column('deux_mois', __('Deux mois'));
        $grid->column('trois_mois', __('Trois mois'));
        $grid->column('quatre_mois', __('Quatre mois'));
        $grid->column('choix_premier', __('Choix premier'));
        $grid->column('modes_paye', __('Modes paye'));
        $grid->column('banque', __('Banque'));
        $grid->column('montant', __('Montant'));
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
        $show = new Show(PaiementsPage::findOrFail($id));

        $show->field('id_paiementspage', __('Id paiementspage'));
        $show->field('explication', __('Explication'));
        $show->field('select_nom', __('Select nom'));
        $show->field('finance_un', __('Finance un'));
        $show->field('finance_deux', __('Finance deux'));
        $show->field('finance_trois', __('Finance trois'));
        $show->field('finance_quatre', __('Finance quatre'));
        $show->field('unite', __('Unite'));
        $show->field('lieu_naiss', __('Lieu naiss'));
        $show->field('modalite_paye', __('Modalite paye'));
        $show->field('tranche_paye', __('Tranche paye'));
        $show->field('un_mois', __('Un mois'));
        $show->field('deux_mois', __('Deux mois'));
        $show->field('trois_mois', __('Trois mois'));
        $show->field('quatre_mois', __('Quatre mois'));
        $show->field('choix_premier', __('Choix premier'));
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
        $form = new Form(new PaiementsPage());

        $form->text('explication', __('Explication'));
        $form->text('select_nom', __('Select nom'));
        $form->text('finance_un', __('Finance un'));
        $form->text('finance_deux', __('Finance deux'));
        $form->text('finance_trois', __('Finance trois'));
        $form->text('finance_quatre', __('Finance quatre'));
        $form->text('unite', __('Unite'));
        $form->text('lieu_naiss', __('Lieu naiss'));
        $form->text('modalite_paye', __('Modalite paye'));
        $form->text('tranche_paye', __('Tranche paye'));
        $form->text('un_mois', __('Un mois'));
        $form->text('deux_mois', __('Deux mois'));
        $form->text('trois_mois', __('Trois mois'));
        $form->text('quatre_mois', __('Quatre mois'));
        $form->text('choix_premier', __('Choix premier'));
        $form->text('modes_paye', __('Modes paye'));
        $form->text('banque', __('Banque'));
        $form->text('montant', __('Montant'));
       

        return $form;
    }
}
