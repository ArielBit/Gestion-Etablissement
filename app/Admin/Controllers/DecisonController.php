<?php

namespace App\Admin\Controllers;

use App\Models\Decision;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class DecisonController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Decision';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Decision());

        //$grid->column('id_decisions', __('Id decisions'));
        $grid->column('type_decision', __('Type decision'));
        $grid->column('appreciation', __('Appreciation'));
        $grid->column('administrations_id', __('Administrations id'));
        $grid->column('bulletin_id', __('Bulletin id'));
        $grid->column('decisioncol', __('Decisioncol'));

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
        $show = new Show(Decision::findOrFail($id));

        $show->field('id_decisions', __('Id decisions'));
        $show->field('type_decision', __('Type decision'));
        $show->field('appreciation', __('Appreciation'));
        $show->field('administrations_id', __('Administrations id'));
        $show->field('bulletin_id', __('Bulletin id'));
        $show->field('decisioncol', __('Decisioncol'));
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
        $form = new Form(new Decision());

        $form->text('type_decision', __('Type decision'));
        $form->text('appreciation', __('Appreciation'));
        $form->number('administrations_id', __('Administrations id'));
        $form->number('bulletin_id', __('Bulletin id'));
        $form->text('decisioncol', __('Decisioncol'));
        $form->number('created_by', __('Created by'));
        $form->number('updated_by', __('Updated by'));
        $form->number('deleted_by', __('Deleted by'));

        return $form;
    }
}
