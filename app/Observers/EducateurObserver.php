<?php

namespace App\Observers;

use App\Models\Educateur;
use Encore\Admin\Auth\Database\Administrator as AdminUser;
use Encore\Admin\Auth\Database\Role as AdminRole;

class EducateurObserver
{
   
    public function creating(Educateur $educateur)
    {
        // 1. Récupère le dernier ID en BDD pour calculer le suivant
        $nextId = (Educateur::max('id_educateurs') ?? 0) + 1;

        // 2. Assigne le numéro matricule sur l'instance en cours de création
        $educateur->matricule = 'EDUC-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Création du Compte du Educateur
     */
    public function created(Educateur $educateur)
    {
        $personnel = $educateur->personnel;

        if (!$personnel || !$educateur->matricule) {
            return;
        }

        // Vérification d'existence
        if (!AdminUser::where('username', $educateur->matricule)->exists()) {
            $user = AdminUser::create([
                'username' => $educateur->matricule,
                'name'     => $personnel->nom . ' ' . $personnel->prenom,
                'password' => \Hash::make('00000000'),
            ]);

            $role = AdminRole::where('slug', 'educateur')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        }
    }
}