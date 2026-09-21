<?php

namespace App\Admin\Controllers;

use App\Models\Bulletin;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class BulletinController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Bulletin';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Bulletin());

        //$grid->column('id_bulletins', __('Id bulletins'));
        $grid->column('annee_periodiques', __('Annee periodiques'));
        $grid->column('type_bulletin', __('Type bulletin'));
        $grid->column('moyenne', __('Moyenne'));
        $grid->column('rang', __('Rang'));
        $grid->column('appreciation', __('Appreciation'));
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
        $grid->column('bulletins_matieres_id', __('Bulletins matieres id'));

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
        $show = new Show(Bulletin::findOrFail($id));

        $show->field('id_bulletins', __('Id bulletins'));
        $show->field('annee_periodiques', __('Annee periodiques'));
        $show->field('type_bulletin', __('Type bulletin'));
        $show->field('moyenne', __('Moyenne'));
        $show->field('rang', __('Rang'));
        $show->field('appreciation', __('Appreciation'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_by', __('Created by'));
        $show->field('updated_by', __('Updated by'));
        $show->field('deleted_by', __('Deleted by'));
        $show->field('bulletins_matieres_id', __('Bulletins matieres id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Bulletin());

        $form->text('annee_periodiques', __('Annee periodiques'));
        $form->text('type_bulletin', __('Type bulletin'));
        $form->text('moyenne', __('Moyenne'));
        $form->text('rang', __('Rang'));
        $form->text('appreciation', __('Appreciation'));
        $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));
        $form->number('bulletins_matieres_id', __('Bulletins matieres id'));

        return $form;
    }
}
