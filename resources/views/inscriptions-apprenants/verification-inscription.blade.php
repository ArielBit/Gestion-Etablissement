@extends('layouts.app')

@section('title', 'Vérification de l\'Inscription | '. $etablissement->etablissement->nom)

@section('content')

<!--==============================
    BREADCUMB AREA
==============================-->
<div class="breadcumb-wrapper position-relative" data-bg-src="assets/img/shape/breadcrumb-shep.png" style="margin-top: 50px;">
    
    <div class="container th-container4">
        <div class="row">
            <div class="col-xxl-5">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Vérification</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('accueil') }}">Accueil</a></li>
                        <li>Vérification des données</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

  <!--==============================
         RECAPITULATIF AREA
  ==============================-->
<div class="admission-forum-wrap overflow-hidden space">
    <div class="container">
        <div class="admission-forum-inner" style="background: #11141b; padding: 40px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15);">
            
            <div class="title-area text-center mb-40">
                <h2 class="sec-title text-white">Vérification des données envoyées</h2>
                <p class="text-white-50 mt-2">Veuillez relire attentivement vos informations avant de confirmer votre inscription.</p>
            </div>

            <div class="contact-form-v1" style="margin-top: 50px;"> 
                <div class="row" style="margin-top: 50px;">
                    
                    <!--==============================
                        AFFICHE DE LA PHOTO
                    ==============================-->
                    <div class="col-12 text-center mb-5" style="margin-top: 150px;">
                        <label class="text-white d-block mb-3">Photo de l'élève</label>
                        <div class="d-inline-block p-2" style="border: 2px dashed rgba(255,255,255,0.3); border-radius: 8px;">
                            <img src="{{ asset('storage/'.$data['photo']) }}" alt="Photo Élève" class="img-fluid" style="max-height: 180px; border-radius: 6px; object-fit: cover;">
                        </div>
                    </div>

                    <!--==============================
                        SECTION : IDENTITY 
                    ==============================-->
                    <div class="col-12 mb-3">
                        <h5 class="text-white text-uppercase" style="letter-spacing: 1px; color: #f2c75c !important;">1. Identité de l'apprenant</h5>
                        <hr style="border-top: 1px solid rgba(255,255,255,0.15); margin-top: 5px;">
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-white-50 d-block text-sm">Nom :</span>
                        <strong class="text-white fs-5">{{ $data['nom'] }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-white-50 d-block text-sm">Prénom :</span>
                        <strong class="text-white fs-5">{{ $data['prenom'] }}</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Sexe :</span>
                        <strong class="text-white">{{ ucfirst($data['sexe']) }}</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Nationalité :</span>
                        <strong class="text-white">{{ $data['nationalite'] }}</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Âge :</span>
                        <strong class="text-white">{{ $data['age'] }} ans</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Date de Naissance :</span>
                        <strong class="text-white">{{ $data['date_naissance'] }}</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Lieu de Naissance :</span>
                        <strong class="text-white">{{ $data['lieu_naissance'] }}</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Lieu de Résidence :</span>
                        <strong class="text-white">{{ $data['lieu_residence'] }}</strong>
                    </div>


                    <!--==============================
                        SECTION : CURSUS
                    ==============================-->
                    <div class="col-12 mt-4 mb-3">
                        <h5 class="text-white text-uppercase" style="letter-spacing: 1px; color: #f2c75c !important;">2. Informations Académiques</h5>
                        <hr style="border-top: 1px solid rgba(255,255,255,0.15); margin-top: 5px;">
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-white-50 d-block text-sm">Année Scolaire:</span>
                        <strong class="text-white">{{ $annees->anneeScolaire->annee_scolaire }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-white-50 d-block text-sm">Type d'enseignement :</span>
                        <strong class="text-white">{{ ucfirst($data['type_enseignement']) }}</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Type de Cycle :</span>
                        <strong class="text-white">{{ $data['cycle'] ?? 'N/A' }}</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Niveau d'Étude :</span>
                        <strong class="text-white">{{ $data['niveau_etude'] ?? 'N/A' }}</strong>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Type Niveau:</span>
                        <strong class="text-white">{{ $data['type_niveau'] ?? 'N/A' }}</strong>
                    </div>

                     <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Type Niveau:</span>
                        <strong class="text-white">{{ $data['type_niveau2'] ?? 'N/A' }}</strong>
                    </div>

                     <div class="col-12 text-center mb-5" style="margin-top: 150px;">
                        <label class="text-white d-block mb-3">Photo Bulletin/Diplôme</label>
                        <div class="d-inline-block p-2" style="border: 2px dashed rgba(255,255,255,0.3); border-radius: 8px;">
                            <img src="{{ asset('storage/'.$data['photo_b']) }}" alt="Photo Bulletin" class="img-fluid" style="max-height: 180px; border-radius: 6px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <span class="text-white-50 d-block text-sm">Moyenne annuelle/examen :</span>
                        <strong class="text-white">{{ $data['moyenne'] ?? 'N/A' }}</strong>
                    </div>

                     

                    <!--==============================
                        SECTION : PARENTS
                    ==============================-->

                    <div class="col-12 mt-4 mb-3">
                        <h5 class="text-white text-uppercase" style="letter-spacing: 1px; color: #f2c75c !important;">3. Responsables Légaux</h5>
                        <hr style="border-top: 1px solid rgba(255,255,255,0.15); margin-top: 5px;">
                    </div>

                    <!-- Père -->
                    <div class="col-md-4 mb-4" style="border-right: 1px solid rgba(255,255,255,0.05);">
                        <h4 class="text-white">PÈRE</h4>
                        <span class="badge bg-secondary mb-2">PÈRE</span>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Nom:</span> {{ $data['pere'] ?? 'Non renseigné' }}</p>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Tél:</span> {{ $data['tel_pere'] ?? 'Non renseigné' }}</p>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Email:</span> {{ $data['email_pere'] ?? 'Non renseigné' }}</p>
                    </div>

                    <!-- Mère -->
                    <div class="col-md-4 mb-4" style="border-right: 1px solid rgba(255,255,255,0.05);">
                        <h4 class="text-white">MÈRE</h4>
                        <span class="badge bg-secondary mb-2">MÈRE</span>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Nom:</span> {{ $data['mere'] ?? 'Non renseigné' }}</p>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Tél:</span> {{ $data['tel_mere'] ?? 'Non renseigné' }}</p>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Email:</span> {{ $data['email_mere'] ?? 'Non renseigné' }}</p>
                    </div>

                    <!-- Tuteur -->
                    <div class="col-md-4 mb-4">
                        <h4 class="text-white">TUTEUR</h4>
                        <span class="badge bg-secondary mb-2">TUTEUR</span>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Nom:</span> {{ $data['tuteur'] ?? 'Non renseigné' }}</p>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Tél:</span> {{ $data['tel_tuteur'] ?? 'Non renseigné' }}</p>
                        <p class="text-white mb-1 text-sm"><span class="text-white-50">Email:</span> {{ $data['email_tuteur'] ?? 'Non renseigné' }}</p>
                    </div>


                    <!--==============================
                        BOUTONS D'ACTION
                    ==============================-->
                    <div class="col-12 mt-40">
                        <div class="row g-3">
                            <div class="col-md-6 order-md-2">
                                <form action="{{ route('confirmation-inscription') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="th-btn w-100">
                                        Confirmer l'inscription <i class="fas fa-check ms-2"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 order-md-1">
                                <button onclick="history.back()" class="th-btn btn-border w-100" style="background: transparent; border: 2px solid #fff; color: #fff;">
                                    <i class="fas fa-arrow-left me-2"></i> Modifier les informations
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection