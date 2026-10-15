<?php

namespace App\Admin\Controllers;

use App\Models\AnneeScolaire;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class AnneeScolaireController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AnneeScolaire';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AnneeScolaire());

       $grid->column('id_anneescolaires', __('ID'));
        $grid->column('annee_scolaire', __('Annee scolaire'));

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
        $show = new Show(AnneeScolaire::findOrFail($id));

        $show->field('id_anneescolaires', __('ID'));
        $show->field('annee_scolaire', __('Annee scolaire'));
      
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AnneeScolaire());

        $form->select('annee_scolaire', __('Annee Scolaire'))
         ->options([
        '2023-2024' => '2023-2024',
        '2024-2025' => '2024-2025',
        '2025-2026' => '2025-2026',
        '2026-2027' => '2026-2027',
        '2027-2028' => '2027-2028',
        '2028-2029' => '2028-2029',
        '2029-2030' => '2029-2030',
        '2030-2031' => '2030-2031',
        '2031-2032' => '2031-2032',
        '2032-2033' => '2032-2033',
        '2033-2034' => '2033-2034',
        '2034-2035' => '2034-2035',
        '2035-2036' => '2035-2036',
        '2036-2037' => '2036-2037',
        '2037-2038' => '2037-2038',
        '2038-2039' => '2038-2039',
        '2039-2040' => '2039-2040',

        ]);

        

        return $form;
    }
}
