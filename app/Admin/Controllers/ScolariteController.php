<?php

namespace App\Admin\Controllers;

use App\Models\Scolarite;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;

class ScolariteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Scolarite';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Scolarite());

        //$grid->column('id_scolarites', __('Id scolarites'));
        $grid->column('classes', __('Classes'));
        $grid->column('montant', __('Montant'));
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
        $show = new Show(Scolarite::findOrFail($id));

        $show->field('id_scolarites', __('Id scolarites'));
        $show->field('classes', __('Classe'));
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
        $form = new Form(new Scolarite());

       // Remplacement par un select classique
    $form->select('classes', __('Classe'))->options([
       'Sixième (6ème)' => 'Sixième (6ème)',
    'Cinquième (5ème)' => 'Cinquième (5ème)',
    'Quatrième (4ème)' => 'Quatrième (4ème)',
    'Troisième (3ème)' => 'Troisième (3ème)',

    'Seconde A1 (2nde A1)' => 'Seconde A1 (2nde A1)',
    'Seconde A2 (2nde A2)' => 'Seconde A2 (2nde A2)',
    'Seconde B (2nde B)' => 'Seconde B (2nde B)',
    'Seconde C (2nde C)' => 'Seconde C (2nde C)',
    'Seconde D (2nde D)' => 'Seconde D (2nde D)',
    'Seconde E (2nde E)' => 'Seconde E (2nde E)',
    'Seconde F1 (2nde F1)' => 'Seconde F1 (2nde F1)',
    'Seconde F2 (2nde F2)' => 'Seconde F2 (2nde F2)',
    'Seconde G1 (2nde G1)' => 'Seconde G1 (2nde G1)',
    'Seconde G2 (2nde G2)' => 'Seconde G2 (2nde G2)',

    'Première A1 (1ère A1)' => 'Première A1 (1ère A1)',
    'Première A2 (1ère A2)' => 'Première A2 (1ère A2)',
    'Première B (1ère B)' => 'Première B (1ère B)',
    'Première C (1ère C)' => 'Première C (1ère C)',
    'Première D (1ère D)' => 'Première D (1ère D)',
    'Première E (1ère E)' => 'Première E (1ère E)',
    'Première F1 (1ère F1)' => 'Première F1 (1ère F1)',
    'Première F2 (1ère F2)' => 'Première F2 (1ère F2)',
    'Première G1 (1ère G1)' => 'Première G1 (1ère G1)',
    'Première G2 (1ère G2)' => 'Première G2 (1ère G2)',

    'Terminale A1 (Tle A1)' => 'Terminale A1 (Tle A1)',
    'Terminale A2 (Tle A2)' => 'Terminale A2 (Tle A2)',
    'Terminale B (Tle B)' => 'Terminale B (Tle B)',
    'Terminale C (Tle C)' => 'Terminale C (Tle C)',
    'Terminale D (Tle D)' => 'Terminale D (Tle D)',
    'Terminale E (Tle E)' => 'Terminale E (Tle E)',
    'Terminale F1 (Tle F1)' => 'Terminale F1 (Tle F1)',
    'Terminale F2 (Tle F2)' => 'Terminale F2 (Tle F2)',
    'Terminale G1 (Tle G1)' => 'Terminale G1 (Tle G1)',
    'Terminale G2 (Tle G2)' => 'Terminale G2 (Tle G2)',
    ])->required();
    

$form->text('montant', __('Montant'));

/*$form->saving(function (Form $form) {

    // Récupérer les classes sélectionnées
    $classesSelectionnees = $form->input('classes');

    // Supprimer les valeurs vides
    $classesSelectionnees = array_filter($classesSelectionnees);

    if (!empty($classesSelectionnees)) {

        $montant = $form->input('montant');

        foreach ($classesSelectionnees as $classe) {

            \App\Models\Scolarite::create([
                'classes'  => $classe,
                'montant' => $montant,
            ]);
        }

        admin_toastr(
            'Les classes sélectionnées ont été enregistrées avec succès !',
            'success'
        );

        return redirect(admin_url('scolarites'));
    }
});*/
        /*$form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'))*/

        return $form;
    }
}
