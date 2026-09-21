<?php

namespace App\Admin\Controllers;

use App\Models\Paiement;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class PaiementButtonController extends AdminController
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
        $grid->column('operateur_paiement', __('Operateur paiement'));
        $grid->column('montant_attendu', __('Montant attendu'));
        $grid->column('date_paiement', __('Date paiement')) ->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });

        $grid->model()->where('statut_paiement', 'EN_ATTENTE');

        $grid->column('statut_paiement', 'Statut')->display(function ($status) {
    if ($status == 'VALIDE') {
        return "<span class='label label-success'>Validé</span>";
    }
    if ($status == 'REJETE') {
        return "<span class='label label-danger'>Rejeté</span>";
    }
    return "<span class='label label-warning'>En attente</span>";
     });

     $grid->column('actions', 'Actions')->display(function () {
    $id = $this->id_paiements;

    return '
        <a href="/admin/paiements/valider/'.$id.'" class="btn btn-success btn-sm">Valider</a>
        <a href="/admin/paiements/rejeter/'.$id.'" class="btn btn-danger btn-sm">Rejeter</a>
    ';
});

        #AT
        $grid->column('created_at', __('Created at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
       /* $grid->column('updated_at', __('Updated at'))->display(function ($value) {
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


    public function valider($id)
{
    $paiement = Paiement::findOrFail($id);

    $paiement->update([
        'statut_paiement' => 'VALIDE',
        'validated_by' => auth()->id(),
        'validated_at' => now(),
    ]);

      admin_success('Succès', 'Paiement validé avec succès');
    return redirect()->back();
}

public function rejeter($id)
{
    $paiement = Paiement::findOrFail($id);

    $paiement->update([
        'statut_paiement' => 'REJETE',
        'validated_by' => auth()->id(),
        'validated_at' => now(),
    ]);

     admin_toastr('Refus', 'Paiement rejeté'); 
    return redirect()->back();
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
        $show->field('operateur_paiement', __('Operateur paiement'));
        $show->field('montant_attendu', __('Montant attendu'));
        $show->field('date_paiement', __('Date paiement'));
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
        $form->select('operateur_paiement', __('Operateur paiement')) ->options([
            'Moov Money' => 'Moov Money',
            'Orange Money' => 'Orange Money',
            'Djamo' => 'Djamo',
            ]);

             $form->number('montant_attendu', __('Montant Attendu'));

        $form->datetime('date_paiement', __('Date paiement'))->default(date('Y-m-d H:i:s'));
       /* $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));*/

        return $form;
    }
}
