<?php

namespace App\Admin\Controllers;

use App\Models\Educateur;
use App\Models\Professeur;
use App\Models\Vigile;
use App\Models\PersonnelsNettoyage;
use App\Models\Personnel;
use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseAuthController
{
    /**
     * Récupère le modèle Personnel selon le rôle/fonction connecté
     */
    protected function getPersonnelConnecte()
    {
        $currentUser = Auth::guard('admin')->user();
        if (!$currentUser) return null;

        $username = $currentUser->username;

        if ($currentUser->isRole('educateur')) {
            $record = Educateur::with('personnel')->where('matricule', $username)->first();
            return $record ? $record->personnel : null;
        }

        if ($currentUser->isRole('professeur')) {
            $record = Professeur::with('personnel')->where('matricule', $username)->first();
            return $record ? $record->personnel : null;
        }

        if ($currentUser->isRole('vigile')) {
            $record = Vigile::with('personnel')->where('numero_badge', $username)->first();
            return $record ? $record->personnel : null;
        }

        if ($currentUser->isRole('personnel_nettoyage')) {
            $record = PersonnelsNettoyage::with('personnel')->where('numero_badge', $username)->first();
            return $record ? $record->personnel : null;
        }

        return Personnel::where('email', $currentUser->email)->first();
    }

    /**
     * Page principale
     */
    public function getSetting(Content $content)
    {
        $isEditingAccount = request()->has('edit_account');

        return $content
            ->title('Mon Profil')
            ->description($isEditingAccount ? 'Modification des paramètres du compte' : 'Consultation des informations du profil')
            ->body($this->settingForm()->edit(Admin::user()->id));
    }

    /**
     * Formulaire avec Fiche fixe + Paramètres du compte modifiables
     */
    protected function settingForm()
    {
        $class = config('admin.database.users_model');
        $form = new Form(new $class());

        $form->setAction(admin_url('auth/setting'));

        // Désactivation des outils par défaut
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableList();
            $tools->disableView();
        });

        $user = Admin::user();
        $personnel = $this->getPersonnelConnecte();
        $isEditingAccount = request()->has('edit_account');

        // -------------------------------------------------------------
        // 1. FICHE PERSONNELLE (Consultation Uniquement / Toujours fixe)
        // -------------------------------------------------------------
        if ($personnel) {
            $photoUrl = $personnel->photo 
                ? asset('uploads/' . $personnel->photo) 
                : asset('vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg');

            $htmlInfo = '
            <div class="box box-solid box-default" style="margin-bottom: 25px; border-radius: 5px;">
                <div class="box-header with-border">
                    <h3 class="box-title" style="font-weight: 600;"><i class="fa fa-id-card-o"></i> Fiche Personnelle (Consultation)</h3>
                </div>
                <div class="box-body" style="padding: 20px;">
                    <div class="row">
                        <div class="col-md-3 text-center" style="border-right: 1px solid #f4f4f4;">
                            <img src="' . $photoUrl . '" class="img-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #3c8dbc; margin-bottom: 10px;" alt="Photo">
                            <div><span class="label label-primary" style="font-size: 13px;">' . strtoupper($personnel->fonction) . '</span></div>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-borderless" style="margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <td style="width: 20%; font-weight: bold; color: #555;"><i class="fa fa-user"></i> Nom & Prénom :</td>
                                        <td style="font-size: 15px;">' . htmlspecialchars($personnel->nom . ' ' . $personnel->prenom) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; color: #555;"><i class="fa fa-phone"></i> Téléphone :</td>
                                        <td>' . htmlspecialchars($personnel->telephone ?? 'Non renseigné') . '</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; color: #555;"><i class="fa fa-envelope"></i> Email :</td>
                                        <td>' . htmlspecialchars($personnel->email ?? 'Non renseigné') . '</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; color: #555;"><i class="fa fa-map-marker"></i> Adresse :</td>
                                        <td>' . htmlspecialchars($personnel->adresse ?? 'Non renseignée') . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>';

            $form->html($htmlInfo);
        }

        // -------------------------------------------------------------
        // 2. PARAMÈTRES DU COMPTE (Show ou Édition de l'Avatar / Password)
        // -------------------------------------------------------------
        if (!$isEditingAccount) {
            // MODE LECTURE SEULE DES PARAMÈTRES DU COMPTE
            $avatarUrl = $user->avatar 
                ? asset('uploads/' . $user->avatar) 
                : asset('vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg');

            $htmlAccount = '
            <div class="box box-solid box-primary" style="border-radius: 5px;">
                <div class="box-header with-border">
                    <h3 class="box-title" style="font-weight: 600;"><i class="fa fa-cogs"></i> Paramètres du Compte</h3>
                    <div class="box-tools pull-right">
                        <a href="' . admin_url('auth/setting?edit_account=1') . '" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil"></i> Modifier le compte
                        </a>
                    </div>
                </div>
                <div class="box-body" style="padding: 20px;">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td style="width: 20%; font-weight: bold; color: #555;"><i class="fa fa-picture-o"></i> Avatar :</td>
                                <td><img src="' . $avatarUrl . '" class="img-circle" style="width: 50px; height: 50px; object-fit: cover;" /></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; color: #555;"><i class="fa fa-user-circle"></i> Nom d\'utilisateur :</td>
                                <td>' . htmlspecialchars($user->username) . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; color: #555;"><i class="fa fa-tag"></i> Nom d\'affichage :</td>
                                <td>' . htmlspecialchars($user->name) . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; color: #555;"><i class="fa fa-lock"></i> Mot de passe :</td>
                                <td><code>********</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>';

            $form->html($htmlAccount);

            // Masquer le bouton de sauvegarde par défaut lorsqu'on est uniquement en consultation
            $form->footer(function ($footer) {
                $footer->disableSubmit();
                $footer->disableReset();
            });

        } else {
            // MODE ÉDITION DU COMPTE (Avatar & Mot de passe uniquement)
            $form->divider('Modification des Paramètres du Compte');

            // Bouton Annuler pour repasser en mode consultation
            $form->tools(function (Form\Tools $tools) {
                $tools->append(
                    '<a href="' . admin_url('auth/setting') . '" class="btn btn-sm btn-default pull-right" style="margin-right: 5px;">' .
                        '<i class="fa fa-times"></i> Annuler' .
                    '</a>'
                );
            });

            $form->display('username', trans('admin.username'));
            $form->text('name', trans('admin.name'))->rules('required');
            
            // Modification Avatar
            $form->image('avatar', trans('admin.avatar'))
                ->move('admin/avatars')
                ->uniqueName()
                ->removable();

            // Modification Mot de passe
            $form->password('password', trans('admin.password'))
                ->rules('nullable|min:6|confirmed', [
                    'confirmed' => 'Les mots de passe ne correspondent pas.',
                    'min'       => 'Le mot de passe doit contenir au moins 6 caractères.'
                ]);
                
            $form->password('password_confirmation', trans('admin.password_confirmation'));

            $form->ignore(['password_confirmation']);
        }

        // -------------------------------------------------------------
        // TRAITEMENT DU FORMULAIRE EN SAUVEGARDE
        // -------------------------------------------------------------
        $form->saving(function (Form $form) {
            if ($form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->ignore(['password']);
            }
        });

        $form->saved(function (Form $form) {
            admin_toastr(trans('admin.update_succeeded'));
            return redirect(admin_url('auth/setting'));
        });

        return $form;
    }
}