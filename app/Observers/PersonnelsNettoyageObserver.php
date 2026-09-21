<?php

namespace App\Observers;

use App\Models\PersonnelsNettoyage;
use Encore\Admin\Auth\Database\Administrator as AdminUser;
use Encore\Admin\Auth\Database\Role as AdminRole;


class PersonnelsNettoyageObserver
{
    
    public function creating(PersonnelsNettoyage $personnelsNettoyage)
    {
        // 1. Récupère le dernier ID en BDD pour calculer le suivant
        $nextId = (PersonnelsNettoyage::max('id_nettoyage') ?? 0) + 1;

        // 2. Assigne le numéro de badge sur l'instance en cours de création
        $personnelsNettoyage->numero_badge = 'NTY-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Création du Compte du Personnel de Nettoyage
     */
    public function created(PersonnelsNettoyage $personnelsNettoyage)
    {
        $personnel = $personnelsNettoyage->personnel;

        if (!$personnel || !$personnelsNettoyage->numero_badge) {
            return;
        }

        // Vérification d'existence
        if (!AdminUser::where('username', $personnelsNettoyage->numero_badge)->exists()) {
            $user = AdminUser::create([
                'username' => $personnelsNettoyage->numero_badge,
                'name'     => $personnel->nom . ' ' . $personnel->prenom,
                'password' => \Hash::make('00000000'),
            ]);

            $role = AdminRole::where('slug', 'personnelsNettoyage')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        }
    }
}