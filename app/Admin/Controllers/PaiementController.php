<?php

namespace App\Admin\Controllers;

use App\Models\Paiement;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class PaiementController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */ 
    protected $title = 'Paiement';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Paiement());

        //$grid->column('id_paiements', __('Id paiements'));
        $grid->column('apprenants.nom', __('Nom Apprenants'));
         $grid->column('apprenants.prenom', __('Prénom Apprenants'));
        $grid->column('modalite', __('Modalite'));
        $grid->column('annee_scolaire', 'Année scolaire')
    ->display(function () {
        return optional(
            optional($this->etablissementannee)->anneeScolaire
        )->annee_scolaire;
    });
    $grid->column('type_frais',__('Type de Frais'));
        $grid->column('tranche_paiement', __('Tranche paiement'));
        $grid->column('choix_mois', __('Choix mois'));
        $grid->column('choix_premiermois', __('Choix premiermois'));
        $grid->column('modes_paiement', __('Modes paiement'));
        $grid->column('banque', __('Banque '));
        $grid->column('montant_attendu', __('Montant attendu'));
        $grid->column('statut_paiement', __('Statut paiement'));
        $grid->column('date_paiement', __('Date paiement')) ->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });

        #AT
        /*$grid->column('created_at', __('Created at'))->display(function ($value) {
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
        $show = new Show(Paiement::findOrFail($id));

        $show->field('id_paiements', __('Id paiements'));
        $show->field('apprenants_id', __('Apprenants id'));
        $show->field('modalite', __('Modalite'));
        $show->field('tranche_paiement', __('Tranche paiement'));
        $show->field('choix_mois', __('Choix mois'));
        $show->field('choix_premiermois', __('Choix premiermois'));
        $show->field('modes_paiement', __('Modes paiement'));
        $show->field('banque', __('Banque'));
        $show->field('montant_attendu', __('Montant attendu'));
        $show->field('date_paiement', __('Date paiement'));
         $show->field('type_frais', __('Type de Frais'));
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
        $form = new Form(new Paiement());

        $form->select('apprenants_id', 'Apprenant')
    ->options(
        \App\Models\Apprenant::all()->mapWithKeys(function ($apprenants) {
            return [
                $apprenants->id_apprenants => $apprenants->nom . ' ' . $apprenants->prenom
            ];
        })
    );

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
    $form->select('type_frais', __('Type de Frais'))
        ->options([
            '-- Sélectionner le type de frais --' => '-- Sélectionner le type de frais --',
            'Frais d\'inscription' => 'Frais d\'inscription',
            'Frais de scolarité' => 'Frais de scolarité',
            'Frais de réinscription' => 'Frais de réinscription'
        ]);

        $form->select('modalite', __('Modalite')) ->options([
        'Paiement Mensuel' => 'Paiement Mensuel',
        'Paiement en une seule fois' => 'Paiement en une seule fois',]);

        $form->select('tranche_paiement', __('Tranche paiement'))->options([
            'Payer une fois par mois' => 'Payer une fois par mois',
            'Payer pour deux mois' => 'Payer pour deux mois',
            'Payer pour trois mois' => 'Payer pour trois mois',
            'Payer pour quatre mois' => 'Payer pour quatre mois',
        ]);
        $form->select('choix_mois', __('Choix mois'))->options([
            'Septembre' => 'Septembre',
            'Octobre' => 'Octobre',
            'Novembre' => 'Novembre',
            'Décembre' => 'Décembre',
            'Janvier' => 'Janvier',
            'Février' => 'Février',
            'Mars' => 'Mars',
            'Avril' => 'Avril',
            'Mai' => 'Mai',
            
        ]);
        $form->select('choix_premiermois', __('Choix premiermois'))
        ->options([
            'Payer la somme demandé' => 'Payer la somme demandé',
            'Payer par tranche de 25.000F' => 'Payer par tranche de 25.000F',
            'Payer en fonction de ses moyens' => 'Payer en fonction de ses moyens',
        ]);

         $form->select('modes_paiement', __('Modes paiement')) ->options([
            'Carte Bancaire' => 'Carte Bancaire',
            'Mobile Money' => 'Mobile Money',
            ]);
        $form->select('banque', __('Banque')) ->options([
            'Moov Money' => 'Moov Money',
            'Orange Money' => 'Orange Money',
            'Djamo' => 'Djamo',
            ]);

             $form->number('montant_attendu', __('Montant Attendu'));

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
