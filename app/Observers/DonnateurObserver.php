<?php

namespace App\Observers;

use App\Models\Donnateur;
use App\Models\RecusDonnateur;

class DonnateurObserver
{
    public function created(Donnateur $donnateur)
    {
        
        $recu = RecusDonnateur::create([
            'donnateurs_id' => $donnateur->id_donnateurs,
            'reference' => $this->generateReference($donnateur),
            'statut' => 'Soldé',
            'date_reçu' => now(),
        ]);
        
    }


    private function generateReference(Donnateur $donnateur)
    {
        return 'REF-' . date('Y') . '-' . str_pad($donnateur->id_donnateurs, 6, '0', STR_PAD_LEFT);
    }
}