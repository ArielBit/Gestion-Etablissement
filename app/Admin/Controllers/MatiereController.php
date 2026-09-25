<?php

namespace App\Admin\Controllers;

use App\Models\Matiere;
use App\Models\Classe;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class MatiereController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Matiere';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Matiere());

       // $grid->column('id_matieres', __('Id matieres'));
        $grid->column('nom_matiere', __('Nom matiere'));
        $grid->column('classe.nom_classe', __('Classe'));
        $grid->column('coeficient', __('Coeficient'));

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
        $grid->column('deleted_by', __('Deleted by'))*/

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
        $show = new Show(Matiere::findOrFail($id));

        $show->field('id_matieres', __('Id matieres'));
        $show->field('nom_matiere', __('Nom matiere'));
        $show->field('coeficient', __('Coeficient'));
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
        $form = new Form(new Matiere());

        $form->text('nom_matiere', __('Nom matiere'));
        $form->select('classes_id', __('Classe'))->options(Classe::pluck('nom_classe', 'id_classes'));
        $form->number('coeficient', __('Coeficient'));
        

        return $form;
    }
}
