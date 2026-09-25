<?php

namespace App\Observers;

use App\Models\Professeur;
use Encore\Admin\Auth\Database\Administrator as AdminUser;
use Encore\Admin\Auth\Database\Role as AdminRole;

class ProfesseurObserver
{
    
    public function creating(Professeur $professeur)
    {
        // 1. Récupère le dernier ID en BDD pour calculer le suivant
        $nextId = (Professeur::max('id_professeurs') ?? 0) + 1;

        // 2. Assigne le numéro de badge sur l'instance en cours de création
        $professeur->matricule = 'PROF-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Création du Compte du Professeur
     */
    public function created(Professeur $professeur)
    {
        $personnel = $professeur->personnel;

        if (!$personnel || !$professeur->matricule) {
            return;
        }

        // Vérification d'existence
        if (!AdminUser::where('username', $professeur->matricule)->exists()) {
            $user = AdminUser::create([
                'username' => $professeur->matricule,
                'name'     => $personnel->nom . ' ' . $personnel->prenom,
                'password' => \Hash::make('00000000'),
            ]);

            $role = AdminRole::where('slug', 'professeur')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        }
    }
}