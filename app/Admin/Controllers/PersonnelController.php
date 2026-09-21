<?php

namespace App\Admin\Controllers;

use App\Models\Personnel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon; 

class PersonnelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Personnel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Personnel());

       // $grid->column('id_personnel', __('Id personnel'));
        $grid->column('photo', 'Photo')->display(function ($photo) {
    if (!$photo) {
        return 'Aucune photo';
    }

    return "<img src='" . asset('storage/' . $photo) . "' style='width:50px;height:50px;border-radius:6px;' />";
});
        $grid->column('nom', __('Nom'));
        $grid->column('prenom', __('Prenom'));
        $grid->column('sexe', __('Sexe'));
        $grid->column('date_naissance', __('Date naissance'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('telephone', __('Telephone'));
        $grid->column('email', __('Email'));
        $grid->column('adresse', __('Adresse'));
        $grid->column('categorie', __('Categorie'));
        $grid->column('fonction', __('Fonction'));
        
        $grid->column('date_embauche', __('Date embauche'))->display(function ($value) {
        return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        
       
        $grid->column('date_fin_embauche', __('Date fin embauche'))->display(function ($value) {
        return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });

        $grid->column('statut', __('Statut'));
        
        /* $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
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
        $show = new Show(Personnel::findOrFail($id));

      // $show->field('id_personnel', __('Id personnel'));
        $show->field('photo', __('Photo'));
        $show->field('nom', __('Nom'));
        $show->field('prenom', __('Prenom'));
        $show->field('sexe', __('Sexe'));
        $show->field('date_naissance', __('Date naissance'));
        $show->field('telephone', __('Telephone'));
        $show->field('email', __('Email'));
        $show->field('adresse', __('Adresse'));
        $show->field('categorie', __('Categorie'));
        $show->field('fonction', __('Fonction'));
        $show->field('date_embauche', __('Date embauche'));
         $show->field('date_fin_embauche', __('Date fin embauche'));
        $show->field('statut', __('Statut'));
       /* $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_by', __('Created by'));
        $show->field('updated_by', __('Updated by'));
        $show->field('deleted_by', __('Deleted by'));*/
       

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Personnel());

         $form->image('photo', __('Photo'));
        $form->text('nom', __('Nom'));
        $form->text('prenom', __('Prenom'));
        $form->select('sexe', __('Sexe'))->options([

        'M' => 'Masculin',
        'F' => 'Feminin',
        ]);

        $form->date('date_naissance', __('Date naissance'))->default(date('Y-m-d'));
        $form->text('telephone', __('Telephone'));
        $form->email('email', __('Email'));
        $form->text('adresse', __('Adresse'));
       
        // 1. Le select Catégorie
    $form->select('categorie', __('Catégorie'))->options([
        'Administration' => 'Administration',
        'Pédagogie' => 'Pédagogie',
        'Sécurité' => 'Sécurité',
        'Entretien' => 'Entretien',
    ])->load('fonction', '/admin/api/fonctions'); // Appelle l'API quand la catégorie change

    // 2. Le select Fonction (qui se remplira tout seul)
    $form->select('fonction', __('Fonction'))->options(function ($value) {
        // Pour gérer l'affichage en mode édition (Edit)
        if (!$value) {
            return [];
        }
        return [$value => $value];
    });


    $form->date('date_embauche', __('Date embauche'))->default(date('Y-m-d'));
    $form->date('date_fin_embauche', __('Date fin embauche'))->default(date('Y-m-d'));
        $form->text('statut', __('Statut'))->default('Actif');
       /* $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));*/
        

        return $form;
    }
    
}
