@extends('layouts.app')

@section('title', 'Succès de la Création du Compte - CPNTIC')

@section('content')

<!--==============================
    SUCCESS CONFIRMATION AREA
==============================-->
<section class="space-top space-bottom d-flex align-items-center" style="background-color: #0b0d12; min-height: 75vh; margin-top: 50px;">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-xl-6 col-lg-8">
                
                <!-- Boîtier de Succès -->
                <div class="p-4 p-sm-5" style="background: #11141b; border-radius: 12px; border: 1px solid rgba(49, 216, 7, 0.15); box-shadow: 0 15px 40px rgba(0,0,0,0.3);">
                    
                    <!-- Icône Animée de Succès (Vert CPNTIC) -->
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle border border-success border-opacity-25 p-3" style="background: rgba(49, 216, 7, 0.05); width: 100px; height: 100px; box-shadow: 0 0 30px rgba(49, 216, 7, 0.1);">
                            <i class="fas fa-check-circle display-3" style="color: #31d807;"></i>
                        </div>
                    </div>

                    <!-- Messages -->
                    <span class="sub-title d-block mb-2" style="color: #31d807; letter-spacing: 2px; text-transform: uppercase; font-size: 12px; font-weight: 700;">Inscription Réussie</span>
                    <h2 class="text-white fw-bold mb-3" style="line-height: 1.3;">Félicitations ! <br>Votre compte a été créé avec succès</h2>
                    <p class="text-white-50 small mb-40 mx-auto" style="max-width: 420px;">
                        Bienvenue au CPNTIC. Votre espace utilisateur est désormais actif. Vous pouvez dès à présent vous connecter pour compléter votre profil ou accéder à nos services en ligne.
                    </p>

                    <!-- Groupe de Boutons d'Action -->
                    <div class="d-flex flex-column gap-3 justify-content-center">
                        <!-- Action principale : Connexion -->
                        <a href="{{ route('connexion') }}" class="th-btn style-radius w-100 justify-content-center" style="background-color: #f2c75c; color: #0b0d12; font-weight: 700;">
                            <i class="fas fa-sign-in-alt me-2"></i> Se Connecter à mon compte
                        </a>
                        
                        <!-- Action secondaire : Accueil -->
                        <a href="{{ route('accueil') }}" class="th-btn btn-border style-radius w-100 justify-content-center" style="background: transparent; border: 2px solid rgba(255,255,255,0.15); color: #fff;">
                            <i class="fas fa-home me-2"></i> Retourner à la page d'accueil
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

<!-- Complément CSS requis pour le comportement Hover du bouton transparent -->
<style>
    .btn-border:hover {
        background: #fff !important;
        color: #0b0d12 !important;
        border-color: #fff !important;
        transition: all 0.3s ease;
    }
</style>

@endsection