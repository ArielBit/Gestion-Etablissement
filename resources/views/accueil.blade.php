@extends('layouts.app')

@section('title', 'Accueil | Portail Institutionnel | ' . $etablissement->etablissement->nom)

@section('content')

<!--============================== 
    1. HERO BANNER AREA (Section d'Introduction Majeure)
==============================-->
<section class="hero-wrapper position-relative" style="background: linear-gradient(180deg, #07090d 0%, #0b0d12 100%); min-height: 85vh; display: flex; align-items: center; padding-top: 80px;  margin-top: 50px;">
    <div class="hero-shape-elements">
        <!-- Remplacer les sources par tes formes géométriques d'agence si disponibles -->
        <div class="position-absolute top-0 start-0 opacity-10"></div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 text-center text-lg-start wow fadeInLeft" data-wow-delay=".2s">
                <div class="title-area mb-30">
                    <span class="sub-title" style="color: #f2c75c; letter-spacing: 3px; text-transform: uppercase; font-weight: 700;">{{ $accueil->premier }}</span>
                    <h1 class="hero-title text-white mt-3 display-4 fw-extrabold" style="line-height: 1.2;">
                        {{ $accueil->deuxieme }} <span style="color: #f2c75c;">{{ $accueil->troisieme }}</span>
                    </h1>
                </div>
                <p class="text-white-50 fs-5 mb-40" style="max-width: 620px;">
                    {{ $accueil->cinq }}
                </p>
                <div class="btn-group-wrap d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                    <a href="{{ route('inscription') }}" class="th-btn style-radius shadow-lg">
                        <i class="fas fa-user-plus me-2"></i> S'inscrire en ligne
                    </a>
                    <a href="#presentation" class="th-btn btn-border style-radius" style="background: transparent; border: 2px solid rgba(255,255,255,0.2); color: #fff;">
                        Découvrir l'école <i class="fas fa-arrow-down ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0 text-center wow fadeInRight" data-wow-delay=".3s">
                <!-- Wrapper visuel symbolisant la tech et l'excellence -->
                <div class="position-relative d-inline-block">
                    <div class="p-4 rounded-circle border border-warning border-opacity-25" style="box-shadow: 0 0 40px rgba(242,199,92,0.15);">
                        <div class="d-flex align-items-center justify-content-center bg-dark rounded-circle" style="width: 320px; height: 320px; background: #11141b !important; border: 2px solid rgba(255,255,255,0.05);">
                            <div class="text-center">
                                <i class="fas fa-laptop-code display-1 text-warning mb-3"></i>
                                <h3 class="text-white m-0 tracking-wider">{{ $etablissement->etablissement->nom }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--==============================
    2. MOT DU DIRECTEUR & PRÉSENTATION
==============================-->
<section id="presentation" class="space-top space-bottom" style="background-color: #11141b; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-40 mb-lg-0 wow fadeInUp" data-wow-delay=".2s">
                <div class="pe-lg-4">
                    <span class="sub-title" style="color: #31d807; letter-spacing: 2px; text-transform: uppercase;">{{ $accueil->titre_premier }}</span>
                    <h2 class="text-white mt-2 mb-4">{{ $accueil->titre_deuxieme }}</h2>
                    <p class="text-white-50 mb-3" style="text-align: justify;">
                        Le <strong>CPNTIC</strong> {{ $accueil->contenu_premier }}
                    </p>
                    <p class="text-white-50 mb-4" style="text-align: justify;">
                        {{ $accueil->contenu_deuxieme }}
                    </p>
                    <a href="{{ route('apropos') }}" class="th-btn btn-border style-radius" style="border: 2px solid #31d807; color: #31d807; background: transparent;">
                        En savoir plus sur nos valeurs
                    </a>
                </div>
            </div>
            
            <!-- Les Piliers d'Enseignement -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 h-100" style="background: #0b0d12; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                            <div class="text-primary fs-3 mb-3"><i class="fas fa-book-open"></i></div>
                            <h5 class="text-white mb-2">{{ $accueil->sous_titre_premier }}</h5>
                            <p class="text-white-50 small mb-0">{{ $accueil->temps_un }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 h-100" style="background: #0b0d12; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                            <div class="text-warning fs-3 mb-3"><i class="fas fa-microchip"></i></div>
                            <h5 class="text-white mb-2">{{ $accueil->sous_titre_deux }}</h5>
                            <p class="text-white-50 small mb-0">{{ $accueil->temps_deux }}</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-4" style="background: #0b0d12; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05); border-left: 4px solid #f2c75c;">
                            <h6 class="text-white mb-1"><i class="fas fa-calendar-alt text-warning me-2"></i> {{ $accueil->evaluation }}</h6>
                            <p class="text-white-50 small m-0">
                                <strong>{{ $accueil->cycle_un }}</strong> {{ $accueil->cycle_deux }} <strong>{{ $accueil->cycle_trois }}</strong> {{ $accueil->cycle_quatre }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--==============================
    3. CHIFFRES CLÉS / STATISTIQUES
==============================-->
<section class="space-top space-bottom" style="background-color: #0b0d12;">
    <div class="container">
        <div class="row g-4 justify-content-center text-center">
            <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay=".1s">
                <div class="p-4 rounded" style="background: #11141b; border: 1px solid rgba(255,255,255,0.02);">
                    <h2 class="fw-extrabold mb-1 display-5" style="color: #f2c75c;">{{ $accueil->nombre_un }}</h2>
                    <span class="text-white-50 small text-uppercase tracking-wider">{{ $accueil->un }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="p-4 rounded" style="background: #11141b; border: 1px solid rgba(255,255,255,0.02);">
                    <h2 class="fw-extrabold mb-1 display-5" style="color: #f2c75c;">{{ $accueil->nombre_deux }}</h2>
                    <span class="text-white-50 small text-uppercase tracking-wider">{{ $accueil->deux }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 stroke-text wow fadeInUp" data-wow-delay=".3s">
                <div class="p-4 rounded" style="background: #11141b; border: 1px solid rgba(255,255,255,0.02);">
                    <h2 class="fw-extrabold mb-1 display-5" style="color: #f2c75c;">{{ $accueil->nombre_trois }}</h2>
                    <span class="text-white-50 small text-uppercase tracking-wider">{{ $accueil->trois }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay=".4s">
                <div class="p-4 rounded" style="background: #11141b; border: 1px solid rgba(255,255,255,0.02);">
                    <h2 class="fw-extrabold mb-1 display-5" style="color: #f2c75c;">{{ $accueil->nombre_quatre }}</h2>
                    <span class="text-white-50 small text-uppercase tracking-wider">{{ $accueil->quatre }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!--==============================
    4. SERVICES FINANCIERS & RÈGLEMENTS (Portail Intégré)
==============================-->
<section class="space-top space-bottom" style="background-color: #11141b; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container">
        <div class="row justify-content-center text-center mb-50">
            <div class="col-lg-6">
                <div class="title-area">
                    <span class="sub-title" style="color: #f2c75c; letter-spacing: 2px;">{{ $accueil->service_un }}</span>
                    <h2 class="sec-title text-white mt-2">{{ $accueil->service_deux }}</h2>
                    <p class="text-white-50 mt-3">{{ $accueil->service_trois }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Service Scolarité -->
            <div class="col-md-5 wow fadeInUp" data-wow-delay=".2s">
                <div class="p-4 text-center h-100 d-flex flex-column justify-content-between" style="background: #0b0d12; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <div class="p-3 d-inline-flex bg-primary bg-opacity-10 rounded-circle mb-3 text-primary fs-3">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h4 class="text-white mb-3">{{ $accueil->titre_service_un }}</h4>
                        <p class="text-white-50 small mb-0">
                            {{ $accueil->text_service_un }}
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-top border-secondary-subtle">
                        <a href="{{ route('paiement') }}" class="th-btn style-radius w-100 justify-content-center">Accéder au paiement</a>
                    </div>
                </div>
            </div>

            <!-- Service Donateurs -->
            <div class="col-md-5 wow fadeInUp" data-wow-delay=".3s">
                <div class="p-4 text-center h-100 d-flex flex-column justify-content-between" style="background: #0b0d12; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <div class="p-3 d-inline-flex bg-warning bg-opacity-10 rounded-circle mb-3 text-warning fs-3">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="text-white mb-3">{{ $accueil->titre_service_deux }}</h4>
                        <p class="text-white-50 small mb-0">
                            {{ $accueil->text_service_deux }}
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-top border-secondary-subtle">
                        <a href="{{ route('donnateur') }}" class="th-btn style-radius w-100 justify-content-center" style="background-color: #f2c75c; color: #fff;">Faire une contribution</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--==============================
    5. APERÇU AGENDA & ÉVÈNEMENTS 
==============================-->
<section class="space-top space-bottom" style="background-color: #0b0d12; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container">
        <div class="row align-items-center mb-40">
            <div class="col-md-8 text-center text-md-start">
                <span class="sub-title" style="color: #31d807; letter-spacing: 2px;">{{ $accueil->agenda }}</span>
                <h3 class="text-white mt-1 mb-0">{{ $accueil->sous_titre_agenda }}</h3>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="/evenement" class="th-btn btn-border style-radius" style="border: 2px solid rgba(255,255,255,0.15); color:#fff; background:transparent;">Voir tout l'agenda</a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Mini-carte 1 -->
            <div class="col-lg-4 wow fadeInUp" data-wow-delay=".1s">
                <div class="p-4 rounded h-100" style="background: #11141b; border: 1px solid rgba(255,255,255,0.03);">
                    <span class="text-warning small d-block mb-2 fw-bold text-uppercase"><i class="fas fa-briefcase me-2"></i>Insertion</span>
                    <h5 class="text-white mb-2">{{ $accueil->div_sous_un }}</h5>
                    <p class="text-white-50 small mb-0">{{ $accueil->div_text }}</p>
                </div>
            </div>
            <!-- Mini-carte 2 -->
            <div class="col-lg-4 wow fadeInUp" data-wow-delay=".2s">
                <div class="p-4 rounded h-100" style="background: #11141b; border: 1px solid rgba(255,255,255,0.03);">
                    <span class="text-danger small d-block mb-2 fw-bold text-uppercase"><i class="fas fa-candy-cane me-2"></i>{{ $accueil->div_deux }}</span>
                    <h5 class="text-white mb-2">{{ $accueil->div_sous_deux }}</h5>
                    <p class="text-white-50 small mb-0">{{ $accueil->div_text_deux }}</p>
                </div>
            </div>
            <!-- Mini-carte 3 -->
            <div class="col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                <div class="p-4 rounded h-100" style="background: #11141b; border: 1px solid rgba(255,255,255,0.03);">
                    <span class="text-primary small d-block mb-2 fw-bold text-uppercase"><i class="fas fa-chart-line me-2"></i>{{ $accueil->div_trois }}</span>
                    <h5 class="text-white mb-2">{{ $accueil->div_sous_trois }}</h5>
                    <p class="text-white-50 small mb-0">{{ $accueil->div_text_trois }}</p>
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
    }
</style>

@endsection