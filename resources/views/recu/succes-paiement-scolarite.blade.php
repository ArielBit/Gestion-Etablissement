@extends('layouts.app')

@section('title', 'Succès Paiement Scolarité | '. $etablissement->etablissement->nom)

@section('content')

<section class="space-top space-bottom" style="background-color: #0b0d12; min-height: 75vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                
                <div class="success-icon-wrap mb-40 wow fadeInUp" data-wow-delay=".1s">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: rgba(49, 216, 7, 0.15); border: 2px solid #31d807; border-radius: 50%; box-shadow: 0 0 25px rgba(49, 216, 7, 0.4);">
                        <i class="fas fa-check-circle" style="font-size: 50px; color: #31d807;"></i>
                    </div>
                </div>

                <div class="title-area mb-40 wow fadeInUp" data-wow-delay=".2s">
                    <span class="sub-title" style="color: #31d807; letter-spacing: 2px;">Règlement validé</span>
                    <h2 class="sec-title text-white mt-3 fs-3" style="line-height: 1.4;">
                        Le paiement a été effectué <br>
                        <span style="color: #f2c75c;">avec succès !</span>
                    </h2>
                    <p class="text-white-50 mt-3">Votre reçu est disponible pour le suivi de votre dossier scolaire.</p>
                </div>

                <div class="btn-group-wrap d-flex flex-column align-items-center gap-3 wow fadeInUp" data-wow-delay=".3s">
                    
                    <a href="{{ route('reçu-paiement', ['id' => $recuId]) }}" class="th-btn style-radius" style="min-width: 320px; background-color: #f2c75c; color: #fff;">
                        <i class="fas fa-file-pdf me-2"></i> Voir mon reçu de paiement
                    </a>

                    <div class="d-flex flex-column flex-sm-row gap-3 mt-2">
                        <a href="{{ route('paiement') }}" class="th-btn btn-border style-radius" style="min-width: 240px; background: transparent; border: 2px solid rgba(255,255,255,0.2); color: #fff;">
                            <i class="fas fa-credit-card me-2"></i> Effectuer un nouveau paiement
                        </a>

                        <a href="{{ route('accueil') }}" class="th-btn btn-border style-radius" style="min-width: 240px; background: transparent; border: 2px solid rgba(255,255,255,0.2); color: #fff;">
                            <i class="fas fa-home me-2"></i> Retour à l'accueil
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

<style>
    .btn-border:hover {
        background: #fff !important;
        color: #fff !important;
        border-color: #fff !important;
    }
</style>

@endsection