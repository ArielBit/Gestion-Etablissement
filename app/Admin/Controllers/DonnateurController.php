<?php

namespace App\Admin\Controllers;

use App\Models\Donnateur;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;
class DonnateurController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Donnateur';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Donnateur());

        $grid->column('annee_scolaire', 'Année scolaire')
    ->display(function () {
        return optional(
            optional($this->etablissementannee)->anneeScolaire
        )->annee_scolaire;
    });
        //$grid->column('id_donnateurs', __('Id donnateurs'));
        $grid->column('nom', __('Nom'));
        $grid->column('prenom', __('Prenom'));
        $grid->column('type_donnateurs', __('Type donnateurs'));
        $grid->column('type_organisations', __('Type organisations'));
        $grid->column('type_dons', __('Type dons'));
        $grid->column('don_vivres', __('Don vivres'));
        $grid->column('quantite_donvivres', __('Quantite donvivres'));
        $grid->column('modes_paiement', __('Modes paiement'));
        $grid->column('operateur_paiement', __('Operateur paiement'));
        $grid->column('montant_attendu', __('Montant attendu'));
        $grid->column('date_paiement', __('Date paiement'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
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

        $grid->column('premier', __('Premier'));
        $grid->column('titre_un', __('Titre Un'));
        $grid->column('titre_deux', __('Titre Deux'));
        $grid->column('texte_circule', __('Texte Circulaire'));
        $grid->column('texte', __('Texte'));
        $grid->column('titre_trois', __('Titre Trois'));
        $grid->column('texte_deux', __('Texte Deux'));
        

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
        $show = new Show(Donnateur::findOrFail($id));

        $show->field('id_donnateurs', __('Id donnateurs'));
        $show->field('nom', __('Nom'));
        $show->field('prenom', __('Prenom'));
        $show->field('type_donnateurs', __('Type donnateurs'));
        $show->field('type_organisations', __('Type organisations'));
        $show->field('type_dons', __('Type dons'));
        $show->field('don_vivres', __('Don vivres'));
        $show->field('quantite_donvivres', __('Quantite donvivres'));
        $show->field('modes_paiement', __('Modes paiement'));
        $show->field('operateur_paiement', __('Operateur paiement'));
        $show->field('montant_attendu', __('Montant attendu'));
        $show->field('date_paiement', __('Date paiement'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_by', __('Created by'));
        $show->field('updated_by', __('Updated by'));
        $show->field('deleted_by', __('Deleted by'));
        $show->field('etablissementannees_id', __('Etablissementannees id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Donnateur());


        $form->select('etablissementannees_id', 'Année scolaire')
    ->options(
        \App\Models\EtablissementAnnee::with('anneeScolaire')
            ->get()
            ->mapWithKeys(function ($item) { 
                return [
                    $item->id_etablissementannees =>
                        optional($item->anneeScolaire)->annee_scolaire
                ];
            })
    );
        $form->text('nom', __('Nom'));
        $form->text('prenom', __('Prenom'));
        $form->text('type_donnateurs', __('Type donnateurs'));
        $form->text('type_organisations', __('Type organisations'));
        $form->text('type_dons', __('Type dons'));
        $form->text('don_vivres', __('Don vivres'));
        $form->text('quantite_donvivres', __('Quantite donvivres'));
        $form->text('modes_paiement', __('Modes paiement'));
        $form->text('banque', __('Banque '));
        $form->number('montant_attendu', __('Montant attendu'));
        $form->datetime('date_paiement', __('Date paiement'))->default(date('Y-m-d H:i:s'));
        $form->text('premier', __('Premier'));
        $form->text('titre_un', __('Titre Un'));
        $form->text('titre_deux', __('Titre Deux'));
        $form->text('texte_circule', __('Texte Circulaire'));
        $form->text('texte', __('Texte'));
        $form->text('titre_trois', __('Titre Trois'));
        $form->text('texte_deux', __('Texte Deux'));
        $form->select('users_id', __('Utilisateurs'))
    ->options(\App\Models\User::pluck('username', 'id_users'));
        

        return $form;
    }
}
