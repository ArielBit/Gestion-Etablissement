<?php

namespace App\Admin\Controllers;

use App\Models\Professeur;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;

class ProfesseurController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Professeur';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Professeur());

        //$grid->column('id_professeurs', __('Id professeurs'));
         $grid->column('personnel.nom', __('Nom'));
         $grid->column('personnel.prenom', __('Prenom'));
        $grid->column('matiere.nom_matiere', __('Specialite'));
        $grid->column('diplome', __('Diplome'))->display(function ($diplome) {
    if (!$diplome) {
        return 'Aucun Diplôme renseigné.';
    }

    return "<img src='" . asset('storage/' . $diplome) . "' style='width:50px;height:50px;border-radius:6px;' />";
});
        $grid->column('matricule', __('Matricule'));
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
        $show = new Show(Professeur::findOrFail($id));

        //$show->field('id_professeurs', __('Id professeurs'));
        $show->field('personnels_id', __('Personnels id'));
         $show->field('matieres_id', __('Specialite'));
        $show->field('diplome', __('Diplome'));
        $show->field('matricule', __('Matricule'));
        /*$show->field('created_at', __('Created at'));
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
        $form = new Form(new Professeur());
         $personnels = \App\Models\Personnel::where('fonction', 'Professeur')
        ->get()
        ->mapWithKeys(function ($item) {
            
            return [$item->id_personnel => $item->nom . ' ' . $item->prenom]; 
        });

    
    $form->select('personnels_id', __('Personnel (Professeur)'))
        ->options($personnels)
        ->rules('required');
        
        $form->select('matieres_id', __('Specialité'))->options(\App\Models\Matiere::pluck('nom_matiere', 'id_matieres'));
        $form->image('diplome', __('Diplome'));
        $form->text('matricule', __('Matricule'));
       /* $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));*/
        

        return $form;
    }
}
