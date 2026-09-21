<?php

namespace App\Admin\Controllers;

use App\Models\Note;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class NoteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Note';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Note());

      //  $grid->column('id_notes', __('Id notes'));
        $grid->column('note', __('Note'));
        $grid->column('evaluation_id', __('Evaluation id'));
        $grid->column('apprenants_id', __('Apprenants id'));
        $grid->column('classes_id', __('Classes id'));

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
        $show = new Show(Note::findOrFail($id));

        $show->field('id_notes', __('Id notes'));
        $show->field('note', __('Note'));
        $show->field('evaluation_id', __('Evaluation id'));
        $show->field('apprenants_id', __('Apprenants id'));
        $show->field('classes_id', __('Classes id'));
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
        $form = new Form(new Note());

        $form->decimal('note', __('Note'));
        $form->number('evaluation_id', __('Evaluation id'));
        $form->number('apprenants_id', __('Apprenants id'));
        $form->number('classes_id', __('Classes id'));
        

        return $form;
    }
}
