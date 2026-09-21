<?php

namespace App\Observers;

use App\Models\Apprenant;

class ClassesApprenantsObserver
{
    /**
     * Handle the Apprenant "created" event.
     *
     * @param  \App\Models\Apprenant  $apprenant
     * @return void
     */
    public function created(Apprenant $apprenant)
    {
        //
    }

    /**
     * Handle the Apprenant "updated" event.
     *
     * @param  \App\Models\Apprenant  $apprenant
     * @return void
     */
    public function updated(Apprenant $apprenant)
    {
        //
    }

    /**
     * Handle the Apprenant "deleted" event.
     *
     * @param  \App\Models\Apprenant  $apprenant
     * @return void
     */
    public function deleted(Apprenant $apprenant)
    {
        //
    }

    /**
     * Handle the Apprenant "restored" event.
     *
     * @param  \App\Models\Apprenant  $apprenant
     * @return void
     */
    public function restored(Apprenant $apprenant)
    {
        //
    }

    /**
     * Handle the Apprenant "force deleted" event.
     *
     * @param  \App\Models\Apprenant  $apprenant
     * @return void
     */
    public function forceDeleted(Apprenant $apprenant)
    {
        //
    }
}
