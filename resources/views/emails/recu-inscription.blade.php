<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement Scolarité - {{ $recu->reference }}</title>
    <!-- Bootstrap 5 pour la structure et la grille -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome pour les icônes de l'en-tête -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .receipt-container {
            max-width: 850px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
            position: relative;
        }
        .receipt-header {
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .receipt-title {
            letter-spacing: 2px;
            font-weight: 800;
            color: #111;
        }
        .info-label {
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .info-value {
            color: #111;
            font-size: 16px;
            font-weight: 500;
        }
        .table-receipt th {
            background-color: #f1f3f5 !important;
            color: #333;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
        }
        .status-valide {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .signature-space {
            margin-top: 50px;
            border-top: 1px dashed #ccc;
            padding-top: 15px;
            min-height: 100px;
        }
        .actions-bar {
            max-width: 850px;
            margin: 20px auto -20px auto;
            display: flex;
            justify-content: space-between;
        }
        
        /* Styles CSS appliqués lors de la génération PDF ou de l'impression papier */
        @media print {
            body {
                background-color: #fff;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
            }
            .actions-bar, .btn-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    

    <!-- Conteneur Principal du Reçu Scolarité -->
    <div class="container">
        <div class="receipt-container">
            
            <!-- En-tête : Établissement & Coordonnées -->
            <div class="receipt-header">
                <div class="row align-items-center">
                    <div class="col-sm-7">
                        <h4 class="text-uppercase fw-bold mb-1 text-primary">
                            {{ $recu->paiement->etablissementannee->etablissement->nom }}
                        </h4>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-map-marker-alt me-1"></i> Adresse : CPNTIC<br>
                            <i class="fas fa-phone me-1"></i> Contact : CPNTIC
                        </p>
                    </div>
                    <div class="col-sm-5 text-sm-end mt-3 mt-sm-0">
                        <div class="p-2 d-inline-block border rounded bg-light text-center" style="min-width: 120px;">
                            <span class="fw-bold d-block small text-muted text-uppercase">Logo</span>
                            <span class="fs-5 fw-extrabold text-dark" style="letter-spacing: 1px;">CPNTIC</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Titre & Métadonnées de Facturation -->
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h2 class="receipt-title m-0">REÇU DE PAIEMENT</h2>
                    <p class="text-muted mt-1">Émis le : <strong>{{ $recu->date_reçu }}</strong></p>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <p class="mb-1"><span class="info-label">Référence :</span> <span class="fw-bold text-danger">{{ $recu->reference }}</span></p>
                    <p class="mb-0">
                        <span class="info-label">Statut :</span> 
                        <span class="status-badge status-valide">{{ $recu->statut ?? 'Validé' }}</span>
                    </p>
                </div>
            </div>

            <!-- Bloc Informations de l'Apprenant -->
            <div class="card bg-light border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase mb-3 fw-bold text-secondary" style="font-size: 13px; letter-spacing: 1px;">Détails de l'Apprenant</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-label">Nom & Prénom</div>
                            <div class="info-value">{{ $recu->paiement->apprenants->nom }} {{ $recu->paiement->apprenants->prenom }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Année Scolaire</div>
                            <div class="info-value">{{ $recu->paiement->etablissementannee->anneeScolaire->annee_scolaire }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Classe</div>
                            <div class="info-value text-muted"><em>Non spécifiée</em></div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Modalité choisie</div>
                            <div class="info-value">{{ $recu->paiement->modalite ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau Récapitulatif Financier (Scolarité) -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-receipt align-middle">
                    <thead>
                        <tr>
                            <th>Désignation Libellé</th>
                            <th class="text-center" style="width: 150px;">Tranche</th>
                            <th class="text-center" style="width: 150px;">Mois visé(s)</th>
                            <th class="text-center" style="width: 150px;">Mode / Opérateur</th>
                            <th class="text-end" style="width: 160px;">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class="fw-bold text-dark">Règlement des frais de Scolarité</span><br>
                                <small class="text-muted">Paiement partiel ou complet des droits académiques</small>
                            </td>
                            <td class="text-center info-value">{{ $recu->paiement->tranche_paiement ?? '-' }}</td>
                            <td class="text-center info-value">
                                @if(!empty($recu->paiement->choix_mois))
                                    <span class="badge bg-secondary px-2 py-1">{{ $recu->paiement->choix_mois }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center info-value">
                                {{ $recu->paiement->modes_paiement }} 
                                <small class="d-block text-muted">({{ $recu->paiement->banque ?? 'Direct' }})</small>
                            </td>
                            <td class="text-end fw-bold text-dark fs-5">{{ number_format((float)$recu->paiement->montant_attendu, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <!-- Lignes de synthèses comptables -->
                        <tr>
                            <td colspan="4" class="text-end fw-bold text-muted text-uppercase" style="font-size: 12px;">Montant encaissé :</td>
                            <td class="text-end fw-bold text-success fs-5">{{ number_format((float)$recu->paiement->montant_attendu, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end fw-bold text-muted text-uppercase" style="font-size: 12px;">Reste à Payer</td>
                            <td class="text-end fw-bold text-muted"><em>{{ number_format((float)$recu->paiement->reste_payer, 0, ',', ' ') }} FCFA</em></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Section Signature -->
            <div class="row mt-5 pt-3">
                <div class="col-sm-6">
                    <p class="small text-muted mb-0">Ce document fait office d'attestation de versement sous réserve d'encaissement définitif.</p>
                </div>
                <div class="col-sm-6 text-center text-sm-end">
                    <div class="d-inline-block text-center" style="min-width: 200px;">
                        <span class="info-label d-block mb-2">Signature & Cachet</span>
                        <div class="info-value fw-bold" style="font-family: 'Courier New', Courier, monospace; font-size: 20px; color: #555;">
                            {{ $recu->signature ?? 'CASH' }}
                        </div>
                        <div class="signature-space"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>