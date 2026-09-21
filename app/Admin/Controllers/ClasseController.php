<?php

namespace App\Admin\Controllers;

use App\Models\Classe;
use Encore\Admin\Form;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Grid;
use Carbon\Carbon;

class ClasseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Classe';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Classe());

        //$grid->column('id_classes', __('Id classes'));
        $grid->column('nom_classe', __('Nom classe'));
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
        $show = new Show(Classe::findOrFail($id));

        $show->field('id_classes', __('Id classes'));
        $show->field('nom_classe', __('Nom classe'));
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
        $form = new Form(new Classe());

        $form->select('nom_classe', __('Nom classe'))
        ->options([
       'Sixième 1 (6ème 1)' => 'Sixième 1 (6ème 1)',
    'Sixième 2 (6ème 2)' => 'Sixième 2 (6ème 2)',
    'Sixième 3 (6ème 3)' => 'Sixième 3 (6ème 3)',

    'Cinquième 1 (5ème 1)' => 'Cinquième 1 (5ème 1)',
    'Cinquième 2 (5ème 2)' => 'Cinquième 2 (5ème 2)',
    'Cinquième 3 (5ème 3)' => 'Cinquième 3 (5ème 3)',

    'Quatrième 1 (4ème 1)' => 'Quatrième 1 (4ème 1)',
    'Quatrième 2 (4ème 2)' => 'Quatrième 2 (4ème 2)',
    'Quatrième 3 (4ème 3)' => 'Quatrième 3 (4ème 3)',

    'Troisième 1 (3ème 1)' => 'Troisième 1 (3ème 1)',
    'Troisième 2 (3ème 2)' => 'Troisième 2 (3ème 2)',
    'Troisième 3 (3ème 3)' => 'Troisième 3 (3ème 3)',

    'Seconde A1-1 (2nde A1-1)' => 'Seconde A1-1 (2nde A1-1)',
    'Seconde A1-2 (2nde A1-2)' => 'Seconde A1-2 (2nde A1-2)',
    'Seconde A1-3 (2nde A1-3)' => 'Seconde A1-3 (2nde A1-3)',
    'Seconde A2-1 (2nde A2-1)' => 'Seconde A2-1 (2nde A2-1)',
    'Seconde A2-2 (2nde A2-2)' => 'Seconde A2-2 (2nde A2-2)',
    'Seconde A2-3 (2nde A2-3)' => 'Seconde A2-3 (2nde A2-3)',
    'Seconde B-1 (2nde B-1)' => 'Seconde B-1 (2nde B-1)',
    'Seconde B-2 (2nde B-2)' => 'Seconde B-2 (2nde B-2)',
    'Seconde B-3 (2nde B-3)' => 'Seconde B-3 (2nde B-3)',
    'Seconde C-1 (2nde C-1)' => 'Seconde C-1 (2nde C-1)',
    'Seconde C-2 (2nde C-2)' => 'Seconde C-2 (2nde C-2)',
    'Seconde C-3 (2nde C-3)' => 'Seconde C-3 (2nde C-3)',
    'Seconde D-1 (2nde D-1)' => 'Seconde D-1 (2nde D-1)',
    'Seconde D-2 (2nde D-2)' => 'Seconde D-2 (2nde D-2)',
    'Seconde D-3 (2nde D-3)' => 'Seconde D-3 (2nde D-3)',
    'Seconde E-1 (2nde E-1)' => 'Seconde E-1 (2nde E-1)',
    'Seconde E-2 (2nde E-2)' => 'Seconde E-2 (2nde E-2)',
    'Seconde E-3 (2nde E-3)' => 'Seconde E-3 (2nde E-3)',
    'Seconde F1-1 (2nde F1-1)' => 'Seconde F1-1 (2nde F1-1)',
    'Seconde F1-2 (2nde F1-2)' => 'Seconde F1-2 (2nde F1-2)',
    'Seconde F1-3 (2nde F1-3)' => 'Seconde F1-3 (2nde F1-3)',
    'Seconde F2-1 (2nde F2-1)' => 'Seconde F2-1 (2nde F2-1)',
    'Seconde F2-2 (2nde F2-2)' => 'Seconde F2-2 (2nde F2-2)',
    'Seconde F2-3 (2nde F2-3)' => 'Seconde F2-3 (2nde F2-3)',
    'Seconde G1-1 (2nde G1-1)' => 'Seconde G1-1 (2nde G1-1)',
    'Seconde G1-2 (2nde G1-2)' => 'Seconde G1-2 (2nde G1-2)',
    'Seconde G1-3 (2nde G1-3)' => 'Seconde G1-3 (2nde G1-3)',
    'Seconde G2-1 (2nde G2-1)' => 'Seconde G2-1 (2nde G2-1)',
    'Seconde G2-2 (2nde G2-2)' => 'Seconde G2-2 (2nde G2-2)',
    'Seconde G2-3 (2nde G2-3)' => 'Seconde G2-3 (2nde G2-3)',

    'Première A1-1 (1ère A1-1)' => 'Première A1-1 (1ère A1-1)',
    'Première A1-2 (1ère A1-2)' => 'Première A1-2 (1ère A1-2)',
    'Première A1-3 (1ère A1-3)' => 'Première A1-3 (1ère A1-3)',
    'Première A2-1 (1ère A2-1)' => 'Première A2-1 (1ère A2-1)',
    'Première A2-2 (1ère A2-2)' => 'Première A2-2 (1ère A2-2)',
    'Première A2-3 (1ère A2-3)' => 'Première A2-3 (1ère A2-3)',
    'Première B-1 (1ère B-1)' => 'Première B-1 (1ère B-1)',
    'Première B-2 (1ère B-2)' => 'Première B-2 (1ère B-2)',
    'Première B-3 (1ère B-3)' => 'Première B-3 (1ère B-3)',
    'Première C-1 (1ère C-1)' => 'Première C-1 (1ère C-1)',
    'Première C-2 (1ère C-2)' => 'Première C-2 (1ère C-2)',
    'Première C-3 (1ère C-3)' => 'Première C-3 (1ère C-3)',
    'Première D-1 (1ère D-1)' => 'Première D-1 (1ère D-1)',
    'Première D-2 (1ère D-2)' => 'Première D-2 (1ère D-2)',
    'Première D-3 (1ère D-3)' => 'Première D-3 (1ère D-3)',
    'Première E-1 (1ère E-1)' => 'Première E-1 (1ère E-1)',
    'Première E-2 (1ère E-2)' => 'Première E-2 (1ère E-2)',
    'Première E-3 (1ère E-3)' => 'Première E-3 (1ère E-3)',
    'Première F1-1 (1ère F1-1)' => 'Première F1-1 (1ère F1-1)',
    'Première F1-2 (1ère F1-2)' => 'Première F1-2 (1ère F1-2)',
    'Première F1-3 (1ère F1-3)' => 'Première F1-3 (1ère F1-3)',
    'Première F2-1 (1ère F2-1)' => 'Première F2-1 (1ère F2-1)',
    'Première F2-2 (1ère F2-2)' => 'Première F2-2 (1ère F2-2)',
    'Première F2-3 (1ère F2-3)' => 'Première F2-3 (1ère F2-3)',
    'Première G1-1 (1ère G1-1)' => 'Première G1-1 (1ère G1-1)',
    'Première G1-2 (1ère G1-2)' => 'Première G1-2 (1ère G1-2)',
    'Première G1-3 (1ère G1-3)' => 'Première G1-3 (1ère G1-3)',
    'Première G2-1 (1ère G2-1)' => 'Première G2-1 (1ère G2-1)',
    'Première G2-2 (1ère G2-2)' => 'Première G2-2 (1ère G2-2)',
    'Première G2-3 (1ère G2-3)' => 'Première G2-3 (1ère G2-3)',

    'Terminale A1-1 (Tle A1-1)' => 'Terminale A1-1 (Tle A1-1)',
    'Terminale A1-2 (Tle A1-2)' => 'Terminale A1-2 (Tle A1-2)',
    'Terminale A1-3 (Tle A1-3)' => 'Terminale A1-3 (Tle A1-3)',
    'Terminale A2-1 (Tle A2-1)' => 'Terminale A2-1 (Tle A2-1)',
    'Terminale A2-2 (Tle A2-2)' => 'Terminale A2-2 (Tle A2-2)',
    'Terminale A2-3 (Tle A2-3)' => 'Terminale A2-3 (Tle A2-3)',
    'Terminale B-1 (Tle B-1)' => 'Terminale B-1 (Tle B-1)',
    'Terminale B-2 (Tle B-2)' => 'Terminale B-2 (Tle B-2)',
    'Terminale B-3 (Tle B-3)' => 'Terminale B-3 (Tle B-3)',
    'Terminale C-1 (Tle C-1)' => 'Terminale C-1 (Tle C-1)',
    'Terminale C-2 (Tle C-2)' => 'Terminale C-2 (Tle C-2)',
    'Terminale C-3 (Tle C-3)' => 'Terminale C-3 (Tle C-3)',
    'Terminale D-1 (Tle D-1)' => 'Terminale D-1 (Tle D-1)',
    'Terminale D-2 (Tle D-2)' => 'Terminale D-2 (Tle D-2)',
    'Terminale D-3 (Tle D-3)' => 'Terminale D-3 (Tle D-3)',
    'Terminale E-1 (Tle E-1)' => 'Terminale E-1 (Tle E-1)',
    'Terminale E-2 (Tle E-2)' => 'Terminale E-2 (Tle E-2)',
    'Terminale E-3 (Tle E-3)' => 'Terminale E-3 (Tle E-3)',
    'Terminale F1-1 (Tle F1-1)' => 'Terminale F1-1 (Tle F1-1)',
    'Terminale F1-2 (Tle F1-2)' => 'Terminale F1-2 (Tle F1-2)',
    'Terminale F1-3 (Tle F1-3)' => 'Terminale F1-3 (Tle F1-3)',
    'Terminale F2-1 (Tle F2-1)' => 'Terminale F2-1 (Tle F2-1)',
    'Terminale F2-2 (Tle F2-2)' => 'Terminale F2-2 (Tle F2-2)',
    'Terminale F2-3 (Tle F2-3)' => 'Terminale F2-3 (Tle F2-3)',
    'Terminale G1-1 (Tle G1-1)' => 'Terminale G1-1 (Tle G1-1)',
    'Terminale G1-2 (Tle G1-2)' => 'Terminale G1-2 (Tle G1-2)',
    'Terminale G1-3 (Tle G1-3)' => 'Terminale G1-3 (Tle G1-3)',
    'Terminale G2-1 (Tle G2-1)' => 'Terminale G2-1 (Tle G2-1)',
    'Terminale G2-2 (Tle G2-2)' => 'Terminale G2-2 (Tle G2-2)',
    'Terminale G2-3 (Tle G2-3)' => 'Terminale G2-3 (Tle G2-3)',
    ]);
        

        return $form;
    }
}
