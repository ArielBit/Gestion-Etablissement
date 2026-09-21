<?php

namespace App\Observers;

use App\Models\Vigile;
use Encore\Admin\Auth\Database\Administrator as AdminUser;
use Encore\Admin\Auth\Database\Role as AdminRole;

class VigileObserver
{
    /**
     * Génération du numero_badge
     */
    public function creating(Vigile $vigile)
    {
        // 1. Récupère le dernier ID en BDD pour calculer le suivant
        $nextId = (Vigile::max('id_vigile') ?? 0) + 1;

        // 2. Assigne le numéro de badge sur l'instance en cours de création
        $vigile->numero_badge = 'VIG-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }



    /**
     * Création du Compte du Vigile
     */
    public function created(Vigile $vigile)
    {
        $personnel = $vigile->personnel;

        if (!$personnel || !$vigile->numero_badge) {
            return;
        }

        // Vérification d'existence
        if (!AdminUser::where('username', $vigile->numero_badge)->exists()) {
            $user = AdminUser::create([
                'username' => $vigile->numero_badge,
                'name'     => $personnel->nom . ' ' . $personnel->prenom,
                'password' => \Hash::make('00000000'),
            ]);

            $role = AdminRole::where('slug', 'vigile')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        }
    }
}