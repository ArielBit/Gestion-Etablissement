<?php

namespace App\Admin\Controllers;

use App\Models\EducateursScolaritesniveaux;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EducateursScolaritesniveauxController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'EducateursScolaritesniveaux';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EducateursScolaritesniveaux());

        $grid->column('id_educateurs_scolaritesniveaux', __('ID'));

        $grid->column('educateur', __('Educateur'))->display(function () {
    $personnel = optional($this->educateurs)->personnel;

    return $personnel
        ? $personnel->nom . ' ' . $personnel->prenom
        : '-';
});
        $grid->column('scolarites.classes', __('Niveau'));
        
        $grid->column('annee_scolaire', 'Année scolaire')
    ->display(function () {
        return optional(
            optional($this->etablissementannee)->anneeScolaire
        )->annee_scolaire;
    });

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
        $show = new Show(EducateursScolaritesniveaux::findOrFail($id));

        $show->field('id_educateurs_scolaritesniveaux', __('Id educateurs scolaritesniveaux'));
        $show->field('educateurs_id', __('Educateurs id'));
        $show->field('scolarites_niveaux_id', __('Scolarites niveaux id'));
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
        $form = new Form(new EducateursScolaritesniveaux());

        $form->select('educateurs_id', __('Educateur'))
            ->options(
                \App\Models\Educateur::with('personnel')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        $nom = optional($item->personnel)->nom ?? '';
                        $prenom = optional($item->personnel)->prenom ?? '';
                        return [
                            $item->id_educateurs => trim($nom . ' ' . $prenom)
                        ];
                    })
            )
            ->rules('required');

        $form->select('scolarites_niveaux_id', 'Niveaux D\'études')
            ->options(\App\Models\Scolarite::pluck('classes', 'id_scolarites'));
       
        // Récupérer l'ID de l'année active depuis les paramètres globaux et l'insérer automatiquement de façon masquée
        $parametreGlobal = \App\Models\ParametresGlobaux::first();
        $activeYearId = $parametreGlobal?->anneescolaire_id;

        $form->hidden('etablissementannees_id')->default($activeYearId);

        return $form;
    }
}
