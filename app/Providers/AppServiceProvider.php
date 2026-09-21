<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Paiement;
use App\Models\Donnateur;
use App\Models\Educateur;
use App\Models\Professeur;
use App\Models\Vigile;
use App\Models\PersonnelsNettoyage;
use App\Observers\PaiementObserver;
use App\Observers\DonnateurObserver;
use App\Observers\EducateurObserver;
use App\Observers\ProfesseurObserver;
use App\Observers\VigileObserver;
use App\Observers\PersonnelsNettoyageObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
     Schema::defaultStringLength(191);
     Paiement::observe(PaiementObserver::class);
     Donnateur::observe(DonnateurObserver::class);
     Educateur::observe(EducateurObserver::class);
     Professeur::observe(ProfesseurObserver::class);
     Vigile::observe(VigileObserver::class);
     PersonnelsNettoyage::observe(PersonnelsNettoyageObserver::class);
     //Apprenant::observe(ClasseapprenantController::class);
    }
}

    

