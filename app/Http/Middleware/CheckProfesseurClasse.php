<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Professeur;
use App\Models\Affectation;

class CheckProfesseurClasse
{
    public function handle(Request $request, Closure $next)
    {
        $currentUser = Auth::guard('admin')->user();
        
        if (!$currentUser) {
            return redirect('admin/auth/login');
        }

        // Si c'est un administrateur, accès total
        if ($currentUser->isRole('administrator') || $currentUser->isAdministrator()) {
            return $next($request);
        }

        // Récupérer le profil professeur
        $professeur = Professeur::where('matricule', $currentUser->username)->first();
        if (!$professeur) {
            abort(403, 'Accès non autorisé.');
        }

        // 1. Si une affectation précise est soumise (ex: formulaire POST ou filtre)
        if ($request->filled('affectations_id')) {
            $affectationId = $request->input('affectations_id');
            $appartientAuProf = Affectation::where('id_affectations', $affectationId)
                ->where('professeurs_id', $professeur->id_professeurs)
                ->exists();

            if (!$appartientAuProf) {
                abort(403, 'Vous n\'êtes pas affecté à cette ressource.');
            }
        }

        // 2. Si une classe précise est filtrée dans l'URL
        if ($request->filled('classes_id')) {
            $classId = $request->input('classes_id');
            $appartientAuProf = Affectation::where('classes_id', $classId)
                ->where('professeurs_id', $professeur->id_professeurs)
                ->exists();

            if (!$appartientAuProf) {
                abort(403, 'Vous n\'avez aucune affectation dans cette classe.');
            }
        }

        return $next($request);
    }
}