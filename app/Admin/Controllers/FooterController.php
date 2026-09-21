<?php

namespace App\Admin\Controllers;

use App\Models\Footer;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class FooterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Footer';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Footer());

        //$grid->column('id_footers', __('Id footers'));
        $grid->column('description', __('Description'));
        $grid->column('copyright_un', __('Copyright Un'));
        $grid->column('copyright_lien', __('Copyright Lien'));
        $grid->column('copyright_deux', __('Copyright Deux'));
        $grid->column('photo', __('Photo'));
        $grid->column('titre', __('Titre'));
       /* $grid->column('created_at', __('Created at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('updated_at', __('Updated at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
        $grid->column('deleted_at', __('Deleted at'))->display(function ($value) {
            return !empty($value)? Carbon::parse($value)->isoFormat('DD MMMM YYYY'):"Date inconnue";
        });
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
        $show = new Show(Footer::findOrFail($id));

        $show->field('id_footers', __('Id footers'));
        $show->field('description', __('Description'));
        $show->field('droit', __('Droit'));
        $show->field('photo', __('Photo'));
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
        $form = new Form(new Footer());
        $form->text('titre', __('Titre'));
        $form->text('description', __('Description'));
        $form->text('copyright_un', __('Copyright Un'));
        $form->text('copyright_lien', __('Copyright Lien'));
        $form->text('copyright_deux', __('Copyright Deux'));
        
            
       

        return $form;
    }
}
