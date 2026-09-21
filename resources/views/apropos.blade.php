@extends('layouts.app')

@section('title', 'À Propos | '. $etablissement->etablissement->nom)

@section('content')

<!--==============================
    BREADCUMB AREA (Fil d'Ariane)
==============================-->
<div class="breadcumb-wrapper position-relative" data-bg-src="assets/img/shape/breadcrumb-shep.png" style="margin-top: 50px;">
    @foreach($propos as $propo)
    <div class="container th-container4">
        <div class="row">
            <div class="col-xxl-5">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">{{ $propo->premier}}</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('accueil') }}">Accueil</a></li>
                        <li>{{ $propo->deuxieme}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--==============================
    ABOUT SECTION
==============================-->
<section class="space-top space-bottom" style="background-color: #0b0d12;">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Colonne Image / Identité Visuelle -->
            <div class="col-lg-6 mb-40 mb-lg-0 wow fadeInLeft" data-wow-delay=".2s">
                <div class="img-box position-relative ps-3" style="border-left: 4px solid #f2c75c;">
                    <div class="p-4" style="background: #11141b; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1);">
                        <h3 class="text-white mb-3">{{ $propo->titre_premier}}<span style="color: #f2c75c;">l'excellence</span>.</h3>
                        <p class="text-white-50 leading-relaxed">
                           {{ $propo->contenu_premier}}
                        </p>
                        
                    </div>
                </div>
            </div>

            <!-- Colonne Vision & Missions -->
            <div class="col-lg-6 wow fadeInRight" data-wow-delay=".2s">
                <div class="title-area mb-30">
                    <span class="sub-title" style="color: #f2c75c; letter-spacing: 2px;">Notre Mission</span>
                    <h2 class="sec-title text-white mt-2 fs-2">Façonner l'avenir par l'innovation éducative</h2>
                </div>
                
                <p class="text-white-50 mb-30">
                    Nous croyons que chaque apprenant possède un potentiel unique. Notre rôle est de lui fournir l'environnement, les outils technologiques et l'accompagnement humain nécessaires pour révéler ses talents.
                </p>

                <!-- Liste des valeurs clés -->
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3" style="background: rgba(255,255,255,0.02); border-radius: 6px; border: 1px solid rgba(255,255,255,0.05);">
                            <h6 class="text-white mb-2"><i class="fas fa-graduation-cap me-2 text-primary"></i> Excellence</h6>
                            <p class="text-white-50 small mb-0">Un corps enseignant qualifié et des programmes mis à jour.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3" style="background: rgba(255,255,255,0.02); border-radius: 6px; border: 1px solid rgba(255,255,255,0.05);">
                            <h6 class="text-white mb-2"><i class="fas fa-laptop-code me-2 text-primary"></i> Digitalisation</h6>
                            <p class="text-white-50 small mb-0">Des infrastructures modernes adaptées aux besoins de l'ère numérique.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <hr style="border-top: 1px solid rgba(255,255,255,0.1); margin: 60px 0;">

        <!--==============================
            STATISTIQUES / CHIFFRES CLÉS
        ==============================-->
        <div class="row g-4 justify-content-center text-center">
            
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".1s">
                <div class="p-4" style="background: #11141b; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                    <h2 class="fw-bold mb-1 fs-1" style="color: #f2c75c;">{{ $propo->nombre_premier}}</h2>
                    <span class="text-white-50 text-uppercase tracking-wider small">{{ $propo->taux_reussite}}</span>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="p-4" style="background: #11141b; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                    <h2 class="fw-bold mb-1 fs-1" style="color: #f2c75c;">{{ $propo->nombre_deuxime}}</h2>
                    <span class="text-white-50 text-uppercase tracking-wider small">{{ $propo->apprenants}}</span>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 wow fadeInUp" data-wow-delay=".3s">
                <div class="p-4" style="background: #11141b; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                    <h2 class="fw-bold mb-1 fs-1" style="color: #f2c75c;">{{ $propo->nombre_troisieme}}</h2>
                    <span class="text-white-50 text-uppercase tracking-wider small">{{ $propo->partenaires}}</span>
                </div>
            </div>
@endforeach
        </div>

        <!--==============================
            BOUTON ACTION
        ==============================-->
        <div class="row mt-50 text-center" >
            <div class="col-12">
                <a href="{{ route('inscription') }}" class="th-btn style-radius shadow">
                    Rejoindre notre établissement <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

    </div>
</section>

@endsection