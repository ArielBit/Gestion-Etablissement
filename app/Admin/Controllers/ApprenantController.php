<?php

namespace App\Admin\Controllers;

use App\Models\Apprenant;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use App\Models\Etablissementannee;
use Carbon\Carbon;

class ApprenantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Apprenant';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Apprenant());

       // $grid->column('id_apprenants', __('Id apprenants'));
        $grid->column('photo', 'Photo')->display(function ($photo) {
    if (!$photo) {
        return 'Aucune photo';
    }

    return "<img src='" . asset('storage/' . $photo) . "' style='width:50px;height:50px;border-radius:6px;' />";
});
        $grid->column('nom', __('Nom'));
        $grid->column('prenom', __('Prenom'));
        $grid->column('sexe', __('Sexe'));
        $grid->column('nationalite', __('Nationalite'));
        $grid->column('date_naissance', __('Date naissance'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        
        $grid->column('age', __('Age'));

        $grid->column('matricule', __('Matricule'));
        
       $grid->column('annee_scolaire', 'Année scolaire')
    ->display(function () {
        return optional(
            optional($this->etablissementannee)->anneeScolaire
        )->annee_scolaire;
    });
        $grid->column('type_enseignement', _('Type Enseignement'));
         $grid->column('cycle', _('Type de Cycle'));
        $grid->column('niveau_etude', __('Niveau etude'));
        $grid->column('type_niveau', __('Type niveau'));
        $grid->column('type_niveau2', __('Type niveau 2'));
        $grid->column('pere', __('Nom et Prénom du Père'));
        $grid->column('tel_pere', __('Numéro de téléphone du père'));
        $grid->column('email_pere', __('Email du père'));
        $grid->column('mere', __('Nom et Prénom de la Mère'));
        $grid->column('tel_mere', __('Numéro de téléphone de la mère'));
        $grid->column('email_mere', __('Email du Mère'));
        $grid->column('tuteur', __('Nom et Prénom du Tuteur'));
        $grid->column('tel_tuteur', __('Numéro de téléphone du tuteur'));
        $grid->column('email_tuteur', __('Email du Tuteur'));
        $grid->column('lieu_residence', __('Lieu de Résidence'));
        $grid->column('premier', __('Premier'));
        $grid->column('titre_un', __('Titre Un'));
        $grid->column('titre_deux', __('Titre Deux'));
        $grid->column('texte_circule', __('Texte Circulaire'));
        $grid->column('texte', __('Texte'));
        $grid->column('titre_trois', __('Titre Trois'));
        $grid->column('texte_deux', __('Texte Deux'));
        $grid->column('user.username', __('Nom d/utilisateur'));
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
        $show = new Show(Apprenant::findOrFail($id));

        $show->field('id_apprenants', __('Id apprenants'));
        $show->field('photo', 'Photo')->image();
        $show->field('nom', __('Nom'));
        $show->field('prenom', __('Prenom'));
        $show->field('sexe', __('Sexe'));
        $show->field('nationalite', __('Nationalite'));
        $show->field('date_naissance', __('Date naissance'));
         $show->field('lieu_naissance', __('Lieu de naissance'));
        $show->field('age', __('Age'));
        $show->field('etablissementannees_id', __('Année Scolaire'));
        $show->field('cycle', __('Type de Cycle'));
        $show->field('type_enseignement', _('Type Enseignement'));
        $show->field('niveau_etude', __('Niveau etude'));
        $show->field('type_niveau', __('Type niveau'));
         $show->field('type_niveau2', __('Type niveau2'));
        $show->field('matricule', __('Matricule'));
       $show->field('pere', __('Nom et Prénom du Père'));
        $show->field('tel_pere', __('Numéro de téléphone du père'));
        $show->field('mere', __('Nom et Prénom de la Mère'));
        $show->field('tel_mere', __('Numéro de téléphone de la mère'));
        $show->field('tuteur', __('Nom et Prénom du Tuteur'));
        $show->field('tel_tuteur', __('Numéro de téléphone du tuteur'));
        $show->field('lieu_residence', __('Lieu Résidence'));
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
    $form = new Form(new Apprenant());
    

        $form->text('nom', __('Nom'));
        $form->text('prenom', __('Prenom'));
        $form->radio('sexe', __('Sexe'))->options(['Masculin' => 'Masculin', 'Féminin' => 'Féminin']);
        $form->text('nationalite', __('Nationalite'));
        $form->date('date_naissance', __('Date naissance'))->default(date('Y-m-d'));
         $form->text('lieu_naissance', __('Lieu de naissance'));
        $form->text('age', __('Age'));
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
    $form->select('type_enseignement', __('Type Enseignement'))
         ->options([
        'General' => 'General',
        'Technique' => 'Technique',]);

     $form->select('cycle', __('Type de Cycle'))
        ->options([
        'Premier Cycle' => 'Premier Cycle',
        'Second Cycle' => 'Second Cycle',]);
        

       $form->select('niveau_etude', __('Niveau etude'))
         ->options([
        'Seconde (2nde)' => 'Seconde (2nde)',
        'Première (1ère)' => 'Première (1ère)',
        'Terminale (Tle)' => 'Terminale (Tle)',]);

        $form->select('type_niveau', __('Type niveau'))
         ->options([
        '2nde A1' => '2nde A1',
        '2nde A2' => '2nde A2',
        '2nde C' => '2nde C',
        '2nde D' => '2nde D',
        '1ère A1' => '1ère A1',
        '1ère A2' => '1ère A2',
        '1ère C' => '1ère C',
        '1ère D' => '1ère D',
        'Tle A1' => 'Tle A1',
        'Tle A2' => 'Tle A2',
        'Tle C' => 'Tle C',
        'Tle D' => 'Tle D',]);

        $form->select('type_niveau2', __('Type niveau2'))
         ->options([
        '2nde A1' => '2nde A1',
        '2nde A2' => '2nde A2'
        ,]);

        $form->text('matricule', __('Matricule'));

        $form->text('pere', __('Nom et Prénom du Père'));
        #Numéro de téléphone du père

        $form->mobile('tel_pere', __('Numéro de téléphone du père'))
    ->options(['mask' => '9999999999'])
    ->help('Entrez le numéro à 10 chiffres');

    #Ajouter le préfixe +225 lors de l'enregistrement
    $form->saving(function (Form $form) {
    $form->tel_pere = '+225'.$form->tel_pere;
});
        $form->text('mere', __('Nom et Prénom de la Mère'));
        #Numéro de téléphone de la mère

        $form->mobile('tel_mere', __('Numéro de téléphone de la mère'))
    ->options(['mask' => '9999999999'])
    ->help('Entrez le numéro à 10 chiffres');

    #Ajouter le préfixe +225 lors de l'enregistrement
    $form->saving(function (Form $form) {
    $form->tel_mere = '+225'.$form->tel_mere;
});
        $form->text('tuteur', __('Nom et Prénom du Tuteur'));
        #Numéro de téléphone du tuteur

        $form->mobile('tel_tuteur', __('Numéro de téléphone du tuteur'))
    ->options(['mask' => '9999999999'])
    ->help('Entrez le numéro à 10 chiffres');

    #Ajouter le préfixe +225 lors de l'enregistrement
    $form->saving(function (Form $form) {
    $form->tel_tuteur = '+225'.$form->tel_tuteur;
});
        $form->text('lieu_residence', __('Lieu Résidence'));
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
