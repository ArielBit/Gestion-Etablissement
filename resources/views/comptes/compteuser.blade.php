@extends('layouts.app')

@section('title', 'Mon Compte | '. $etablissement->etablissement->nom)

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
                    <h1 class="breadcumb-title">Espace Utilisateur</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('accueil') }}">Accueil</a></li>
                        <li>Mon compte ({{ ucfirst($user->role) }})</li>
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
                                            <!--=============
                                            DONNEES DU COMPTE UTILISATEUR
                                            =========-->
                <div class="p-4 p-md-5 mb-4" style="background: #11141b; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center border-bottom border-secondary-subtle pb-3 mb-4">
                        <div>
                            <span class="sub-title" style="color: #f2c75c; letter-spacing: 1px; text-transform: uppercase; font-size: 13px;">Profil ({{ ucfirst($user->role) }})</span>
                            <h3 class="text-white m-0">Informations Personnelles</h3>
                        </div>
                        <a href="{{ route('modifie') }}" class="th-btn style-radius btn-sm mt-3 mt-sm-0" style="background-color: #f2c75c; color: #fff;">
                            <i class="fas fa-user-edit me-2"></i> Modifier mes données
                        </a>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                <small class="text-white-50 d-block text-uppercase tracking-wider" style="font-size: 11px;">Nom</small>
                                <strong class="text-white fs-5 d-block mt-1">{{ $user->nom }}</strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                <small class="text-white-50 d-block text-uppercase tracking-wider" style="font-size: 11px;">Prénom</small>
                                <strong class="text-white fs-5 d-block mt-1">{{ $user->prenom }}</strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                <small class="text-white-50 d-block text-uppercase tracking-wider" style="font-size: 11px;">Nom d'utilisateur</small>
                                <strong class="text-warning fs-5 d-block mt-1">&#64;{{ $user->username }}</strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                <small class="text-white-50 d-block text-uppercase tracking-wider" style="font-size: 11px;">Adresse Email</small>
                                <strong class="text-white fs-5 d-block mt-1">{{ $user->email }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!--===========================================================
                                           AFFICHAGE DES DONNEES DU PARENT
                                            =============================================-->

               <div class="container-fluid py-4">
    
    <!-- 1. LES BOUTONS DES RUBRIQUES (DYNAMIQUES SELON LE RÔLE) -->
    <ul class="nav nav-pills gap-2 mb-4 pb-3 border-bottom border-secondary-subtle" id="dashboardTabs" role="tablist">
        <!-- Accessible par TOUT LE MONDE -->
        <li class="nav-item" role="presentation">
            <button class="nav-link active rub-btn" id="eleve-tab" data-bs-toggle="tab" data-bs-target="#rubrique-eleve" type="button" role="tab" aria-controls="rubrique-eleve" aria-selected="true">
                <i class="fas fa-user-graduate me-2"></i> Espace Élèves
            </button>
        </li>
        
        <!-- Accessible par PARENT et DONATEUR uniquement -->
        @if($user->role === 'parent' || $user->role === 'donateur')
            <li class="nav-item" role="presentation">
                <button class="nav-link rub-btn" id="parent-tab" data-bs-toggle="tab" data-bs-target="#rubrique-parent" type="button" role="tab" aria-controls="rubrique-parent" aria-selected="false">
                    <i class="fas fa-user-friends me-2"></i> Espace Parents
                </button>
            </li>
        @endif
        
        <!-- Accessible par DONATEUR uniquement -->
        @if($user->role === 'donateur' && !$user->donnateurs->isEmpty())
        <li class="nav-item" role="presentation">
            <button class="nav-link rub-btn" id="donateur-tab" data-bs-toggle="tab" data-bs-target="#rubrique-donateur" type="button" role="tab" aria-controls="rubrique-donateur" aria-selected="false">
                <i class="fas fa-hand-holding-heart me-2"></i> Espace Donateurs
            </button>
        </li>
        @endif
    </ul>

    <!-- 2. LE CONTENU DES RUBRIQUES -->
    <div class="tab-content" id="dashboardTabsContent">
        
        <!-- ================= RUBRIQUE ÉLÈVE (PROFIL & CARTE SCOLAIRE UNIQUEMENT) ================= -->
        <div class="tab-pane fade show active" id="rubrique-eleve" role="tabpanel" aria-labelledby="eleve-tab">
            <div class="p-4 p-md-5" style="background: #11141b; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                <div class="mb-4">
                    <h4 class="text-white m-0"><i class="fas fa-graduation-cap text-warning me-2"></i> Suivi Scolaire</h4>
                </div>

                @if($user->apprenants->isEmpty())
                    <p class="text-white-50">Aucun élève ou enfant associé à ce compte.</p>
                @else
                    @foreach($user->apprenants as $apprenant)
                        <div class="mb-5 p-3 rounded" style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.03);">
                            
                            <div class="mb-3 pb-3 border-bottom border-secondary-subtle">
                                <h5 class="text-warning m-0">
                                    <i class="fas fa-child me-2"></i> {{ $apprenant->prenom }} {{ $apprenant->nom }}
                                </h5>
                                <div>
                                    <button type="button" class="btn btn-warning btn-sm fw-bold px-3" 
                                            onclick="toggleSchoolCard('{{ $apprenant->id_apprenants }}')" 
                                            id="btn-toggle-{{ $apprenant->id_apprenants }}">
                                        <i class="fas fa-id-card me-2"></i> Voir la Carte Scolaire
                                    </button>
                                </div>
                            </div>

                            <!-- Profil de l'Apprenant -->
                            <div class="row text-white mb-3 g-3 p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Nom :</strong> <span class="text-white-50">{{ $apprenant->nom }}</span></p>
                                    <p class="mb-2"><strong>Prénom(s) :</strong> <span class="text-white-50">{{ $apprenant->prenom }}</span></p>
                                    <p class="mb-2"><strong>Matricule :</strong> <span class="text-warning font-monospace fw-bold">{{ $apprenant->matricule ?? 'En cours...' }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Classe / Niveau :</strong> <span class="text-info fw-semibold">@php
                                         $val1 = $apprenant->type_niveau ?? '';
                                         $val2 = $apprenant->type_niveau2 ?? '';

                                         $val1Valide = !empty($val1) && !Stripos($val1, 'spécifié');
                                         $val2Valide = !empty($val2) && !Stripos($val2, 'spécifié');
                                          @endphp

                                          {{ $val1Valide ? $val1 : ($val2Valide ? $val2 : 'Non Spécifié') }}</span></p>
                                    <p class="mb-2"><strong>Date de Naissance :</strong> <span class="text-white-50">{{ $apprenant->date_naissance ? \Carbon\Carbon::parse($apprenant->date_naissance)->format('d/m/Y') : '—' }}</span></p>
                                    <p class="mb-0"><strong>Sexe :</strong> <span class="text-white-50">{{ $apprenant->sexe === 'masculin' ? 'Masculin' : 'Féminin' }}</span></p>
                                </div>
                            </div>

                            <!-- Carte Scolaire (Masquée par défaut) -->
                            <div id="school-card-wrapper-{{ $apprenant->id_apprenants }}" class="mb-4 d-none">
                                <div class="cni-scolaire-horizontal mx-auto mx-md-0">
                                    <div class="cni-h-orange d-flex justify-content-between align-items-center px-3 py-1">
                                        <div class="cni-h-flag text-center"><div class="flag-circle"></div></div>
                                        <div class="text-center text-dark header-central-text">
                                            <div class="fw-bold text-uppercase m-0 rci-title">RÉPUBLIQUE DE CÔTE D'IVOIRE</div>
                                            <div class="m-0 rci-motto">Union - Discipline - Travail</div>
                                            <div class="fw-semibold m-0 rci-ministry">Ministère de l'Éducation Nationale et de l'Alphabétisation</div>
                                        </div>
                                        <div class="cni-h-arms text-center"><i class="fas fa-shield-alt fa-lg text-dark-50"></i></div>
                                    </div>

                                    <div class="cni-h-card-title text-center text-uppercase fw-bold">CARTE D'IDENTITÉ SCOLAIRE</div>

                                    <div class="cni-h-body px-3 py-2">
                                        <div class="row g-0 align-items-stretch">
                                            <div class="col-3 pe-3 border-end border-light-subtle d-flex align-items-center justify-content-center">
                                                <div class="cni-h-photo-frame">
                                                    @if($apprenant->photo)
                                                        <img src="{{ asset('storage/' . $apprenant->photo) }}" alt="Photo Éléve">
                                                    @else
                                                        <div class="cni-h-photo-placeholder"><i class="fas fa-user text-secondary fa-2x"></i></div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-6 px-3 d-flex flex-column justify-content-between">
                                                <div class="d-flex justify-content-between align-items-center mb-2 line-meta">
                                                    <div><span class="meta-lbl">Année Scolaire :</span> <span class="meta-val fw-bold text-dark">{{ $annees->anneeScolaire->annee_scolaire }}</span></div>
                                                    <div><span class="meta-lbl">Matricule :</span> <span class="meta-val fw-bold text-dark">{{ $apprenant->matricule ?? 'En cours...' }}</span></div>
                                                </div>

                                                <div class="h-info-group">
                                                    <div class="info-val text-uppercase">{{ $apprenant->nom }}</div>
                                                    <div class="info-lbl">Nom</div>
                                                </div>
                                                <div class="h-info-group">
                                                    <div class="info-val text-uppercase">{{ $apprenant->prenom }}</div>
                                                    <div class="info-lbl">Prénom(s)</div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-7">
                                                        <div class="h-info-group">
                                                            <div class="info-val">{{ $apprenant->date_naissance ? \Carbon\Carbon::parse($apprenant->date_naissance)->format('d/m/Y') : '—' }}</div>
                                                            <div class="info-lbl">Date Naiss.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="h-info-group">
                                                            <div class="info-val">{{ $apprenant->sexe === 'masculin' ? 'M' : 'F' }}</div>
                                                            <div class="info-lbl">Sexe</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="h-info-group">
                                                    <div class="info-val text-uppercase">{{ $apprenant->lieu_naissance ?? '—' }}</div>
                                                    <div class="info-lbl">Lieu Naiss.</div>
                                                </div>
                                                <div class="h-info-group mb-0">
    <div class="info-val text-uppercase fw-bold text-primary">
        @php
            $val1 = $apprenant->type_niveau ?? '';
            $val2 = $apprenant->type_niveau2 ?? '';

            $val1Valide = !empty($val1) && !Stripos($val1, 'spécifié');
            $val2Valide = !empty($val2) && !Stripos($val2, 'spécifié');
        @endphp

        {{ $val1Valide ? $val1 : ($val2Valide ? $val2 : 'Non Spécifié') }}
    </div>
    <div class="info-lbl">Classe</div>
</div>
                                            </div>

                                            <div class="col-3 ps-3 border-start border-light-subtle d-flex flex-column justify-content-between text-end">
                                                <div class="h-urgency p-1 text-center text-dark">
                                                    <div class="u-lbl">En cas d'urgence</div>
                                                    <div class="u-val fw-bold font-monospace">{{ $apprenant->tel_pere ?? '0708741273' }}</div>
                                                </div>
                                                <div class="text-center my-1 text-dark opacity-75">
                                                    <i class="fas fa-chair fa-lg"></i> <i class="fas fa-book-reader fa-lg"></i>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                                    <div class="stamp-fictif"><i class="fas fa-stamp text-secondary opacity-25"></i></div>
                                                    <div class="h-qrcode"><i class="fas fa-qrcode fa-3x text-dark opacity-75"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cni-h-green px-3 py-2 text-center text-uppercase fw-bold">
                                        000{{ $apprenant->id_apprenants }} : {{ $etablissements->etablissement->nom }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- ================= RUBRIQUE PARENT (TRAÇABILITÉ FINANCIÈRE & REÇUS) ================= -->
        @if($user->role === 'parent' || $user->role === 'donateur')
        <div class="tab-pane fade" id="rubrique-parent" role="tabpanel" aria-labelledby="parent-tab">
            <div class="p-4 p-md-5" style="background: #11141b; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                <div class="mb-4">
                    <h4 class="text-white m-0"><i class="fas fa-wallet text-success me-2"></i> Suivi Financier des Éléves</h4>
                </div>

                @if($user->apprenants->isEmpty())
                    <p class="text-white-50">Aucune information financière disponible.</p>
                @else
                    @foreach($user->apprenants as $apprenant)
                        @php
                            $totalScolarite = $apprenant->total_scolarite ?? 250000; 
                            $totalPaye = $apprenant->paiements->sum('montant') ?? 0; 
                            $resteAPayer = $totalScolarite - $totalPaye;
                            $pourcentage = ($totalScolarite > 0) ? ($totalPaye / $totalScolarite) * 100 : 0;
                        @endphp

                        <div class="mb-5 p-4 rounded" style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.04);">
                            <h5 class="text-success mb-3">
                                <i class="fas fa-user-circle me-2"></i> {{ $apprenant->prenom }} {{ $apprenant->nom }} 
                                <span class="badge bg-secondary fs-6 ms-2 font-monospace" style="font-size: 11px !important;">{{ $apprenant->matricule ?? 'Sans Matricule' }}</span>
                            </h5>

                            <!-- Synthèse Financière de l'enfant -->
                            <div class="row text-center g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="p-3 rounded bg-black bg-opacity-30 border border-secondary-subtle">
                                        <small class="text-white-50 d-block text-uppercase" style="font-size: 11px;">Scolarité Fixée</small>
                                        <span class="text-white fw-bold fs-5">{{ number_format($totalScolarite, 0, ',', ' ') }} F CFA</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded bg-success bg-opacity-10 border border-success-subtle">
                                        <small class="text-success d-block text-uppercase" style="font-size: 11px;">Total Versé</small>
                                        <span class="text-success fw-bold fs-5">+ {{ number_format($totalPaye, 0, ',', ' ') }} F CFA</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded bg-danger bg-opacity-10 border border-danger-subtle">
                                        <small class="text-danger d-block text-uppercase" style="font-size: 11px;">Solde Restant</small>
                                        <span class="text-danger fw-bold fs-5">{{ number_format($resteAPayer, 0, ',', ' ') }} F CFA</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Progression Graphique -->
                            <div class="mb-4 px-2">
                                <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                    <span class="text-white-50">Couverture des frais de scolarité</span>
                                    <span class="text-success fw-bold">{{ round($pourcentage, 1) }}%</span>
                                </div>
                                <div class="progress" style="height: 6px; background: rgba(255,255,255,0.1);">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $pourcentage }}%"></div>
                                </div>
                            </div>

                            <!-- Historique des Transactions / Paiements -->
                            <h6 class="text-white mb-3"><i class="fas fa-history text-secondary me-2"></i> Historique des Versements</h6>
                            @if($apprenant->paiements->isEmpty())
                                <div class="alert alert-dark border-0 text-white-50 py-2 px-3" style="background: rgba(255,255,255,0.02);">
                                    Aucune transaction enregistrée pour le moment.
                                </div>
                            @else
                                <div class="table-responsive rounded border border-secondary-subtle">
                                    <table class="table table-dark table-striped align-middle m-0 text-nowrap" style="font-size: 13px;">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" class="text-white-50 py-3">Réf. Versement</th>
                                                <th scope="col" class="text-white-50 py-3">Date</th>
                                                <th scope="col" class="text-white-50 py-3">Mode de Paiement</th>
                                                <th scope="col" class="text-white-50 py-3 text-end">Montant</th>
                                                <th scope="col" class="text-white-50 py-3 text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($apprenant->paiements as $index => $paiement)
                                                <tr>
                                                    <td class="font-monospace fw-bold text-warning">
                                                        #PAY-{{ str_pad($index + 1, 4, '0', STR_PAD_LEFT) }}
                                                    </td>
                                                    <td class="text-white-50">
                                                        {{ \Carbon\Carbon::parse($paiement->created_at)->format('d/m/Y H:i') }}
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-opacity-20 text-uppercase text-info bg-info border border-info-subtle px-2 py-1" style="font-size: 11px;">
                                                            {{ $paiement->mode_paiement ?? 'Espèces' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-bold text-success">
                                                        {{ number_format($paiement->montant, 0, ',', ' ') }} F
                                                    </td>
                                                    <td class="text-center">
                                                        <!-- Lien vers ton contrôleur de génération de reçu PDF -->
                                                        <a href="" class="btn btn-outline-light btn-xs fw-semibold px-2 py-1" style="font-size: 11px;">
                                                            <i class="fas fa-file-download text-success me-1"></i> Reçu PDF
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif

        <!-- ================= RUBRIQUE DONATEUR ================= -->
         <!-- ================= RUBRIQUE DONATEUR (DONATEUR UNIQUEMENT) ================= -->
        @if($user->role === 'donateur')
            <div class="tab-pane fade" id="rubrique-donateur" role="tabpanel" aria-labelledby="donateur-tab">
                <div class="p-4 p-md-5" style="background: #11141b; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                    <h4 class="text-white mb-4"><i class="fas fa-heart text-warning me-2"></i> Espace Mécénat & Donateurs</h4>
                    <p class="text-white-50">Historique de vos dotations de kits, parrainage d'infrastructures et suivis de vos requêtes d'équipements.</p>
                    <!-- Vos données et listes de dons ici -->
                </div>
            </div>
        @endif

    </div>
</div>

       
  
<script>
function toggleSchoolCard(id) {
    // Cibler le wrapper et le bouton spécifiques à l'aide de l'ID reçu
    const cardWrapper = document.getElementById('school-card-wrapper-' + id);
    const btn = document.getElementById('btn-toggle-' + id);
    
    if (cardWrapper.classList.contains('d-none')) {
        cardWrapper.classList.remove('d-none');
        btn.innerHTML = '<i class="fas fa-eye-slash me-2"></i> Masquer la Carte';
        btn.classList.replace('btn-warning', 'btn-secondary');
    } else {
        cardWrapper.classList.add('d-none');
        btn.innerHTML = '<i class="fas fa-id-card me-2"></i> Voir la Carte Scolaire';
        btn.classList.replace('btn-secondary', 'btn-warning');
    }
}
</script>

                <div class="p-4 rounded border border-danger border-opacity-25" style="background: rgba(231, 76, 60, 0.02);">
                    <h5 class="text-white mb-3"><i class="fas fa-shield-alt text-danger me-2"></i> Zone de sécurité & Actions</h5>
                    <p class="text-white-50 small mb-4">Gérez la connexion à votre session ou procédez à la fermeture définitive de votre espace utilisateur.</p>
                    
                    <div class="d-flex flex-wrap gap-3">
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            <!--===========================================================
                                           DECONNEXION DU COMPTE
                                            =============================================-->
                            @csrf
                            <button type="submit" class="th-btn style-radius btn-sm border border-secondary" style="background: transparent; color: #fff;">
                                <i class="fas fa-sign-out-alt me-2 text-white-50"></i> Déconnexion
                            </button>
                        </form>

                        <!--===========================================================
                                           SUPPRESSION DU COMPTE
                                            =============================================-->
                        <form method="POST" action="{{ route('delete') }}" class="m-0" onsubmit="return confirm('Attention ! Cette action est irréversible. Êtes-vous sûr de vouloir supprimer définitivement votre compte ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="th-btn style-radius btn-sm" style="background-color: #e74c3c; color: #fff;">
                                <i class="fas fa-trash-alt me-2"></i> Supprimer le compte
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection