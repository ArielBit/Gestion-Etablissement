<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use Encore\Admin\Show;
use Encore\Admin\Table;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    protected $title = 'Gestion des Permissions';

    public function index(Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Liste')
            ->body($this->table());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Détails')
            ->body($this->detail($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Création')
            ->body($this->form());
    }

    public function store()
    {
        return $this->form()->store();
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Édition')
            ->body($this->form()->edit($id));
    }

    public function update($id)
    {
        return $this->form()->update($id);
    }

    public function destroy($id)
    {
        return $this->form()->destroy($id);
    }

    protected function table()
{
    $table = new Table(new Permission());

    $table->column('id', __('ID'))->sortable();
    $table->column('name', __('Nom de la Permission'))->sortable();
    $table->column('http_path', __('Chemin / Route URL'))->display(function ($path) {
        return "<code>{$path}</code>";
    });

    return $table;
}

    protected function detail($id)
    {
        $show = new Show(Permission::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Nom de la Permission'));
        $show->field('guard_name', __('Guard'));
        $show->field('created_at', __('Créé le'));
        $show->field('updated_at', __('Mis à jour le'));

        return $show;
    }

   protected function form()
{
    $form = new Form(new Permission());

    $form->text('name', __('Nom de la Permission'))->rules('required');
    
    // Champ pour définir la route/URL bloquée depuis l'interface
    $form->text('http_path', __('Chemin HTTP / Route'))
        ->help('Exemple: /products* ou /orders/*')
        ->default('*');

    $form->text('guard_name', __('Guard'))->default('admin');

    return $form;
}
}