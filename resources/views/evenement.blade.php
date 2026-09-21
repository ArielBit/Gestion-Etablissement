@extends('layouts.app')

@section('title', 'Nos Évènements | '. $etablissement->etablissement->nom)


@section('content')

<!--==============================
    BREADCUMB AREA (Fil d'Ariane)
==============================-->
<div class="breadcumb-wrapper position-relative" data-bg-src="assets/img/shape/breadcrumb-shep.png" style="margin-top: 50px;">
    
    <div class="container th-container4">
        <div class="row">
            <div class="col-xxl-6">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">{{ $evenements->premier }}</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('accueil') }}">Accueil</a></li>
                        <li>{{ $evenements->premier }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--==============================
    MAIN EVENTS AREA
==============================-->
<section class="space-top space-bottom" style="background-color: #0b0d12;">
    <div class="container">
        
        <!-- En-tête de la page avec précision sur l'enseignement -->
        <div class="row mb-50 text-center text-md-start align-items-end">
            <div class="col-md-8">
                <div class="title-area mb-0">
                    <span class="sub-title" style="color: #f2c75c; letter-spacing: 2px;">{{ $evenements->deuxieme }}</span>
                    <h2 class="sec-title text-white mt-2">{{ $evenements->troisieme }}</h2>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="p-3 d-inline-block rounded border border-warning-subtle" style="background: rgba(242, 199, 92, 0.05);">
                    <span class="text-white-50 small d-block uppercase tracking-wider mb-1">{{ $evenements->quatre }}</span>
                    <strong class="text-warning">{{ $evenements->cinq }}</strong>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- 1. ÉVÈNEMENT : JOURNÉE CARRIÈRE -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay=".1s">
                <div class="p-4 h-100 d-flex flex-column justify-content-between" style="background: #11141b; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05); border-top: 4px solid #f2c75c;">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge" style="background-color: rgba(242, 199, 92, 0.15); color: #f2c75c;">Orientation & Insertion</span>
                            <small class="text-white-50"><i class="fas fa-graduation-cap me-1"></i> Tech & Pro</small>
                        </div>
                        <h4 class="text-white mb-3">{{ $evenements->titre_premier }}</h4>
                        <p class="text-white-50 mb-0">
                            {{ $evenements->contenu_premier }}
                        </p>
                    </div>
                    <div class="pt-4 border-top border-secondary-subtle mt-4 d-flex justify-content-between align-items-center">
                        <span class="text-white small"><i class="fas fa-map-marker-alt me-1 text-warning"></i> {{ $evenements->sous_titre_premier }}</span>
                        <a href="#" class="btn btn-sm btn-outline-warning style-radius">En savoir plus</a>
                    </div>
                </div>
            </div>

            <!-- 2. ÉVÈNEMENT : FÊTES DE DÉCEMBRE & FIN D'ANNÉE -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="p-4 h-100 d-flex flex-column justify-content-between" style="background: #11141b; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05); border-top: 4px solid #e74c3c;">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-danger bg-opacity-25 text-danger">Célébrations</span>
                            <small class="text-white-50"><i class="fas fa-users me-1"></i>{{ $evenements->sous_titre_deux }}</small>
                        </div>
                        <h4 class="text-white mb-3">{{ $evenements->titre_deuxieme }}</h4>
                        <p class="text-white-50 mb-0">
                            {{ $evenements->contenu_deuxieme }}
                        </p>
                    </div>
                    <div class="pt-4 border-top border-secondary-subtle mt-4 d-flex justify-content-between align-items-center">
                        <span class="text-white small"><i class="fas fa-calendar-check me-1 text-danger"></i> {{ $evenements->temps_deux }}</span>
                        <a href="#" class="btn btn-sm btn-outline-danger style-radius">Voir la galerie</a>
                    </div>
                </div>
            </div>

            <!-- 3. ÉVÈNEMENT : REMISE DES BULLETINS -->
            <div class="col-12 wow fadeInUp" data-wow-delay=".3s">
                <div class="p-4" style="background: #11141b; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05); border-left: 4px solid #3498db;">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-25 text-primary">Suivi Académique & Pédagogique</span>
                                <span class="badge bg-secondary text-white-50">Obligatoire</span>
                            </div>
                            <h4 class="text-white mb-3">{{ $evenements->remise_titre }}</h4>
                            <p class="text-white-50 mb-0">
                                {{ $evenements->text_remise }}
                            </p>
                        </div>
                        <div class="col-lg-4 mt-4 mt-lg-0 border-start border-secondary-subtle ps-lg-4">
                            <h6 class="text-white mb-3 text-uppercase small tracking-wider" style="color: #3498db !important;">{{ $evenements->periode }}</h6>
                            <ul class="list-unstyled text-white-50 small m-0 p-0">
                                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> <strong>{{ $evenements->enseigne_un }}</strong> {{ $evenements->enseigne_premier }}</li>
                                <li><i class="fas fa-check-circle text-primary me-2"></i> <strong>{{ $evenements->enseigne_deux }}</strong> {{ $evenements->enseigne_deuxieme }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection