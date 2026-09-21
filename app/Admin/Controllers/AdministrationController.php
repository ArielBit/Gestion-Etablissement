<?php

namespace App\Admin\Controllers;

use App\Models\Administration;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\grid;
use Carbon\Carbon;

class AdministrationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Administration';

    /**
     * Make a grid builder.
     *
     * @return grid
     */
    protected function grid()
    {
        $grid = new grid(new Administration());

       // $grid->column('id_administrations', __('Id administrations'));
        $grid->column('nom', __('Nom'));
        $grid->column('prenom', __('Prenom'));
        $grid->column('type_personne', __('Type personne'));
        
       $grid->column('annee_scolaire', 'Année scolaire')
    ->display(function () {
        return optional(
            optional($this->etablissementannee)->anneeScolaire
        )->annee_scolaire;
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
        $show = new Show(Administration::findOrFail($id));

        $show->field('id_administrations', __('Id administrations'));
        $show->field('nom', __('Nom'));
        $show->field('prenom', __('Prenom'));
        $show->field('type_personne', __('Type personne'));
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
        $form = new Form(new Administration());

        $form->text('nom', __('Nom'));
        $form->text('prenom', __('Prenom'));
        $form->select('type_personne', __('Type personne'))
         ->options([
        'directeur' => 'Directeur',
        'professeur' => 'Professeur',
        'educateur' => 'Éducateur',]);
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

        $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));

        return $form;
    }
}
