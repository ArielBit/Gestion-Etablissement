@extends('layouts.app')

@section('title', 'Attente de Paiement Donateur')

@section('content')

<section class="space-top space-bottom" style="background-color: #0b0d12; min-height: 70vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                
                <div class="success-icon-wrap mb-40 wow fadeInUp" data-wow-delay=".1s">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: rgba(242, 199, 92, 0.1); border: 2px solid #f2c75c; border-radius: 50%; box-shadow: 0 0 25px rgba(242, 199, 92, 0.3);">
                        <i class="fas fa-spinner fa-spin" style="font-size: 45px; color: #f2c75c;"></i>
                    </div>
                </div>

                <div class="title-area mb-40 wow fadeInUp" data-wow-delay=".2s">
                    <span class="sub-title" style="color: #f2c75c; letter-spacing: 2px;">Traitement en cours</span>
                    <h2 class="sec-title text-white mt-3 fs-3" style="line-height: 1.4;">
                        Paiement en cours de vérification
                    </h2>
                    <p class="text-white-50 mt-4" style="max-width: 550px; margin: 0 auto; font-size: 16px;">
                        Votre demande de paiement a été correctement enregistrée. <br>
                        Veuillez patienter quelques instants pendant la validation de la transaction...
                    </p>
                </div>

                <div class="btn-group-wrap d-flex justify-content-center wow fadeInUp" data-wow-delay=".3s">
                    <a href="{{ route('accueil') }}" class="th-btn btn-border style-radius" style="min-width: 250px; background: transparent; border: 2px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.7);">
                        <i class="fas fa-home me-2"></i> Retour à l'accueil
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    .btn-border:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.4) !important;
    }
</style>

@endsection