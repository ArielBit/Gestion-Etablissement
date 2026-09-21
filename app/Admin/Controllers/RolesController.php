<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use Encore\Admin\Show;
use Encore\Admin\Table;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    protected $title = 'Gestion des Rôles';

    public function index(Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Liste')
            ->body($this->table());
    }

    protected function table()
    {
        $table = new Table(new Role());

        $table->column('id', __('ID'))->sortable();
        $table->column('name', __('Nom du Rôle'))->sortable();
        $table->column('guard_name', __('Guard'));

        // Badges pour les permissions Spatie
        $table->column('permissions', __('Permissions'))->display(function ($permissions) {
            $permissions = collect($permissions)->pluck('name')->toArray();
            if (empty($permissions)) {
                return "<span class='label label-default'>Aucune</span>";
            }
            return array_map(function ($name) {
                return "<span class='label label-info'>{$name}</span>";
            }, $permissions);
        });

        $table->column('created_at', __('Créé le'))->display(function ($value) {
            return $value ? date('d/m/Y H:i', strtotime($value)) : '-';
        });

        return $table;
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

    protected function detail($id)
    {
        $show = new Show(Role::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Nom du Rôle'));
        $show->field('guard_name', __('Guard'));

        $show->field('permissions', __('Permissions'))->as(function ($permissions) {
            return $permissions->pluck('name')->implode(', ');
        });

        $show->field('created_at', __('Créé le'));
        $show->field('updated_at', __('Mis à jour le'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Role());

        $form->text('name', __('Nom du Rôle'))->rules('required');

        // On aligne le guard sur "admin" partout
        $form->text('guard_name', __('Guard Name'))
            ->default('admin')
            ->rules('required');

        // Charge les permissions associées au même guard
        $form->multipleSelect('permissions', __('Permissions'))
            ->options(function () {
                return Permission::where('guard_name', 'admin')->pluck('name', 'id');
            })
            ->customFormat(function ($v) {
                if (empty($v)) {
                    return [];
                }
                // Extrait les IDs si $v est une collection/tableau d'objets
                return array_column($v, 'id');
            });

        // Ignorer le champ 'permissions' lors du Form::save direct
        $form->saving(function (Form $form) {
            $form->ignore(['permissions']);
        });

        // Synchronisation manuelle explicite via le modèle Spatie
        $form->saved(function (Form $form) {
            $permissionIds = request()->input('permissions');
            
            // Nettoyage des valeurs
            if (is_array($permissionIds)) {
                $permissionIds = array_filter($permissionIds);
            } else {
                $permissionIds = [];
            }

            // Synchronisation de la relation Spatie
            $role = $form->model();
            $role->permissions()->sync($permissionIds);
        });

        return $form;
    }
}