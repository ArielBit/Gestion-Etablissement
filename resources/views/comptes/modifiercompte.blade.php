@extends('layouts.app')

@section('title', 'Modifier mes Données - CPNTIC')

@section('content')

<div class="breadcumb-wrapper position-relative" data-bg-src="assets/img/shape/breadcrumb-shep.png" style="margin-top: 50px;">
    <div class="breadcumb-banner">
        <img src="assets/img/breadcrumb/breadcumb-banner.png" alt="bg-banner">
    </div>
    <div class="breadcumb-shape">
        <img src="assets/img/shape/triangle-light.png" alt="shape" class="jump">
    </div>
    <div class="container th-container4">
        <div class="row">
            <div class="col-xxl-6">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Paramètres du Compte</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('accueil') }}">Accueil</a></li>
                        <li><a href="{{ route('comptes') }}">Mon Compte</a></li>
                        <li>Modifier les données</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="space-top space-bottom" style="background-color: #0b0d12;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">

                <div class="mb-4 text-start">
                    <a href="{{ route('comptes') }}" class="text-white-50 small text-decoration-none hover-warning">
                        <i class="fas fa-arrow-left me-2" style="font-size: 11px;"></i> Revenir au Compte
                    </a>
                </div>

                <div class="p-4 p-md-5 mb-40" style="background: #11141b; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                    <div class="border-bottom border-secondary-subtle pb-3 mb-4">
                        <span class="sub-title" style="color: #f2c75c; letter-spacing: 1px; text-transform: uppercase; font-size: 12px;">Édition Générale</span>
                        <h3 class="text-white m-0 mt-1">Modifier les données</h3>
                    </div>

                    <form method="POST" action="{{ route('modifier') }}" class="m-0">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label text-white-50 small text-uppercase tracking-wider">Nom</label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted"><i class="fas fa-user-tile"></i></span>
                                    <input type="text" class="form-control custom-input" name="nom" value="{{ $user->nom }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label text-white-50 small text-uppercase tracking-wider">Prénom</label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted"><i class="fas fa-user-signature"></i></span>
                                    <input type="text" class="form-control custom-input" name="prenom" value="{{ $user->prenom }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label text-white-50 small text-uppercase tracking-wider">Nom d'utilisateur</label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted"><i class="fas fa-at"></i></span>
                                    <input type="text" class="form-control custom-input" name="username" value="{{ $user->username }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-4">
                                <label class="form-label text-white-50 small text-uppercase tracking-wider">Adresse Email</label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control custom-input" name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="th-btn style-radius" style="background-color: #f2c75c; color: #0b0d12; font-weight: 700;">
                            <i class="fas fa-check me-2"></i> Enregistrer les modifications
                        </button>
                    </form>
                </div>


                <div class="p-4 p-md-5" style="background: #11141b; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                    <div class="border-bottom border-secondary-subtle pb-3 mb-4">
                        <span class="sub-title" style="color: #3498db; letter-spacing: 1px; text-transform: uppercase; font-size: 12px;">Sécurité</span>
                        <h3 class="text-white m-0 mt-1">Changer le mot de passe</h3>
                    </div>

                    <form method="POST" action="{{ route('modifi') }}" class="m-0">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase tracking-wider">Mot de passe actuel</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted"><i class="fas fa-unlock-alt"></i></span>
                                <input type="password" class="form-control custom-input" name="old_password" placeholder="Saisissez votre mot de passe actuel" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label text-white-50 small text-uppercase tracking-wider">Nouveau mot de passe</label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control custom-input" name="new_password" placeholder="Nouveau mot de passe" required>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-4">
                                <label class="form-label text-white-50 small text-uppercase tracking-wider">Confirmer le mot de passe</label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted"><i class="fas fa-lock-open"></i></span>
                                    <input type="password" class="form-control custom-input" name="new_password_confirmation" placeholder="Répétez le nouveau mot de passe" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="th-btn style-radius" style="background-color: #3498db; color: #fff; font-weight: 700;">
                            <i class="fas fa-key me-2"></i> Mettre à jour le mot de passe
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    .custom-input {
        background-color: #0b0d12 !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        padding: 12px 12px 12px 42px !important;
        border-radius: 6px !important;
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        border-color: #f2c75c !important;
        box-shadow: 0 0 8px rgba(242, 199, 92, 0.2) !important;
        background-color: #0b0d12 !important;
    }
    .hover-warning:hover {
        color: #f2c75c !important;
        transition: color 0.2s ease;
    }
</style>

@endsection