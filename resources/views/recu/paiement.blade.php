@extends('layouts.app')

@section('title', 'Paiements | '. $etablissement->etablissement->nom)

@section('content')
<div class="breadcumb-wrapper position-relative " data-bg-src="assets/img/shape/breadcrumb-shep.png" style="margin-top: 50px;">
        
        <div class="container th-container4" style="background-color: #0b111e;"> 
            <div class="row">
                <div class="col-xxl-5">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title" style="color:white;">{{$paiements->premier}}</h1>
                        <ul class="breadcumb-menu" >
                            <li><a href="{{route('accueil')}}" style="color:white;">Accueil</a></li>
                            <li>{{$paiements->premier}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--==============================
    program Area
=============================-->
    <section class="th-program-wrapper program-details space-top space-extra2-bottom overflow-hidden">
        <div class="container th-container4">
            <div class="row gy-4 gx-60">
                <div class="col-xl-8">
                    <div class="peogram-area">
                        <div class="title-area">
                            <h2 class="sec-title text-anim2">{{$paiements->premier}}<span class="d-block">{{$paiements->titre_un}}</span></h2>
                            <p class="sec-text2 mt-25 mb-0 wow fadeInUp" data-wow-delay=".2s">{{$paiements->titre_deux}}</p>
                            <p class="sec-text4 mt-25 mb-0 wow fadeInUp" data-wow-delay=".3s">{{$paiements->texte}}</p>
                        </div>
                        <div class="program-wrapp">
    <div class="discount-wrapp">
        <div class="logo" style="display: inline-block;"> <img src="{{ asset('asset/assets/img/ari.jpg') }}" alt="img" 
                 style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; display: block; animation: spinImage 12s linear infinite;">
                 
        </div>
        <div class="discount-tag">
            <span class="discount-anime">{{$paiements->texte_circule}}</span>
        </div>
    </div>
</div>


<style>
@keyframes spinImage {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
                </div>
            </div>
        </div>
    </div>
    <div class="shape-mockup jump d-none d-xxl-block" data-bottom="0%" data-right="0%">
        <img src="assets/img/shape/faq-2-1.png" alt="Stadum">
    </div>
                        
                        
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
        <div class="shape-mockup jump d-none d-xxl-block" data-bottom="0%" data-right="0%">
        </div>
    </section>
<div class="addmission-area overflow-hidden space overflow-hidden">
        <div class="addmission-bg-thumb overflow-hidden gsap-parallax">
            <img src="{{ asset('asset/assets/img/aaaa.png') }}" alt="Stadum">
        </div>
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title text-anim">{{$paiements->titre_trois}}</span>
                <div class="box-text-wrap mt-25">
                    <p class="box-text text-white wow fadeInUp" data-wow>
                        {{$paiements->texte_deux}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="admission-forum-wrap overflow-hidden">
        <div class="container">
            <div class="admission-forum-inner">
                <div class="addmission-forum-thumb overflow-hidden">
                    <img src="{{ asset('asset/assets/img/a3.jpg') }}" alt="Stadum">
                </div>
                <div class="addmisson-forum">
                    <div class="row justify-content-end">

                    <!--==============================
    FORMULAIRE
==============================-->


                        <div class="contact-form-v1 col-lg-7 col-md-12">
    <form method="POST" action="{{ route('paiement-scolarite') }}" class="contact-form">
        @csrf 
        <div class="row">
            
            <!-- Injection du dictionnaire des scolarités en JSON pour le JS -->
<script>
    window.scolaritesBD = @json($scolarites->pluck('montant', 'classes'));
</script>

<div class="form-group style-border col-12 mb-3">
    <label for="apprenants_id" class="text-white mb-2">Choisissez le nom complet de l'apprenant</label>
    <select id="apprenants_id" name="apprenants_id" class="form-select" required>
        <option value="">--Sélectionner--</option>
        @foreach ($apprenant as $apprenants)
            <option value="{{ $apprenants->id_apprenants }}"
                    data-niveau="{{ $apprenants->type_niveau2 }}"
                    data-type-niveau="{{ $apprenants->type_niveau }}"
                    data-deja-paye="{{ $apprenants->paiements_sum_montant_attendu ?? 0 }}">
                {{ $apprenants->nom }} {{ $apprenants->prenom }}
            </option>
        @endforeach
    </select>
</div>

<div class="col-12 mb-3" id="bloc-infos-scolarite" style="display: none;">
    <div class="card bg-dark text-white p-3 border-secondary">
        <h5 class="text-info mb-3" id="titre-classe-eleve" style="font-weight: 600;"></h5>
        
        <ul class="list-group list-group-flush bg-transparent">
            <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center ps-0">
                Scolarité totale : <span class="fw-bold" id="valeur-scolarite">0</span> F CFA
            </li>
            <li class="list-group-item bg-transparent text-success d-flex justify-content-between align-items-center ps-0">
                Montant déjà payé : <span class="fw-bold" id="valeur-deja-paye">0</span> F CFA
            </li>
            <li class="list-group-item bg-transparent text-warning d-flex justify-content-between align-items-center ps-0" style="font-size: 1.1rem;">
                Reste à couvrir au total : <span class="fw-bold" id="valeur-reste-total">0</span> F CFA
            </li>
            <li class="list-group-item bg-transparent text-danger d-flex justify-content-between align-items-center ps-0" style="font-size: 1.2rem; border-top: 2px solid #444;">
                Nouveau reste après ce versement : <span class="fw-bold" id="valeur-reste-futur">0</span> F CFA
            </li>
        </ul>
    </div>
</div>

            <div class="form-group style-border col-12 mb-3" id="type-frais">
                <label for="type-frais" class="text-white mb-2">Type de Frais</label>
                <select id="type-frais" name="type_frais" class="form-select">
                    <option value="">-- Sélectionner le type de frais --</option>
                    <option value="inscription">Frais d'inscription</option>
                    <option value="scolarite">Frais de scolarité</option>
                    <option value="reinscription">Frais de réinscription</option>
                </select>
            </div>


            <div class="form-group style-border col-12 mb-3">
                <label class="text-white mb-2 d-block">Modalité de paiement</label>
                
                <div id="paiement-mensuel" class="form-check mb-2">
                    <input type="radio" name="modalite" id="mensuel-paiement" value="Paiement Mensuel" class="form-check-input" required> 
                    <label for="mensuel-paiement" class="form-check-label text-white">Paiement Mensuel</label>
                </div>
                
                <div id="paiement-seule" class="form-check">
                    <input type="radio" name="modalite" id="seule-paiement" value="Paiement en une seule fois" class="form-check-input" required> 
                    <label for="seule-paiement" class="form-check-label text-white">Paiement en une seule fois</label>
                </div>
            </div>

            <div class="form-group style-border col-12 mb-3" id="tranche-paiement" style="display: none;">
                <label for="paiement-tranche" class="text-white mb-2">Tranche de Paiement</label>
                <select id="paiement-tranche" name="tranche_paiement" class="form-select">
                    <option value="">Sélectionner</option>
                    <option value="Payer une fois par mois">Payer une fois par mois</option>
                    <option value="Payer pour deux mois">Payer pour deux mois</option>
                    <option value="Payer pour trois mois">Payer pour trois mois</option>
                    <option value="Payer pour quatre mois">Payer pour quatre mois</option>  
                </select>
            </div>

            <div class="form-group style-border col-12 mb-3" id="choix-un-mois" style="display: none;">
                <label for="un-mois-choix" class="text-white mb-2">Choix du mois</label>
                <select id="un-mois-choix" name="choix_mois" class="form-select">
                    <option value="">Sélectionner</option>
                    <option value="Septembre">Septembre</option>
                    <option value="Octobre">Octobre</option>
                    <option value="Novembre">Novembre</option>
                    <option value="Décembre">Décembre</option>
                    <option value="Janvier">Janvier</option>
                    <option value="Février">Février</option>
                    <option value="Mars">Mars</option>
                    <option value="Avril">Avril</option>
                    <option value="Mai">Mai</option>
                </select>
            </div>

            <div class="form-group style-border col-12 mb-3" id="choix-deux-mois" style="display: none;">
                <label for="deux-mois-choix" class="text-white mb-2">Choix de deux mois</label>
                <select id="deux-mois-choix" name="choix_mois" class="form-select">
                    <option value="">--Sélectionner--</option>
                    <option value="Septembre-Octobre">Septembre-Octobre</option>
                    <option value="Octobre-Novembre">Octobre-Novembre</option>
                    <option value="Novembre-Décembre">Novembre-Décembre</option>
                    <option value="Décembre-Janvier">Décembre-Janvier</option>
                    <option value="Janvier-Février">Janvier-Février</option>
                    <option value="Février-Mars">Février-Mars</option>
                    <option value="Mars-Avril">Mars-Avril</option>
                    <option value="Avril-Mai">Avril-Mai</option>
                </select>
            </div>

            <div class="form-group style-border col-12 mb-3" id="choix-trois-mois" style="display: none;">
                <label for="trois-mois-choix" class="text-white mb-2">Choix de trois mois</label>
                <select id="trois-mois-choix" name="choix_mois" class="form-select">
                    <option value="">--Sélectionner--</option>
                    <option value="Septembre-Octobre-Novembre">Septembre-Octobre-Novembre</option>
                    <option value="Octobre-Novembre-Décembre">Octobre-Novembre-Décembre</option>
                    <option value="Novembre-Décembre-Janvier">Novembre-Décembre-Janvier</option>
                    <option value="Décembre-Janvier-Février">Décembre-Janvier-Février</option>
                    <option value="Janvier-Février-Mars">Janvier-Février-Mars</option>
                    <option value="Février-Mars-Avril">Février-Mars-Avril</option>
                    <option value="Mars-Avril-Mai">Mars-Avril-Mai</option>
                </select>
            </div>

            <div class="form-group style-border col-12 mb-3" id="choix-quatre-mois" style="display: none;">
                <label for="quatre-mois-choix" class="text-white mb-2">Choix de quatre mois</label>
                <select id="quatre-mois-choix" name="choix_mois" class="form-select">
                    <option value="">--Sélectionner--</option>
                    <option value="Septembre-Octobre-Novembre-Décembre">Septembre-Octobre-Novembre-Décembre</option>
                    <option value="Octobre-Novembre-Décembre-Janvier">Octobre-Novembre-Décembre-Janvier</option>
                    <option value="Novembre-Décembre-Janvier-Février">Novembre-Décembre-Janvier-Février</option>
                    <option value="Décembre-Janvier-Février-Mars">Décembre-Janvier-Février-Mars</option>
                    <option value="Janvier-Février-Mars-Avril">Janvier-Février-Mars-Avril</option>
                    <option value="Février-Mars-Avril-Mai">Février-Mars-Avril-Mai</option>
                </select>
            </div>

            <div class="form-group style-border col-12 mb-3" id="choix-premier-mois" style="display: none;">
                <label for="choix-mois-premier" class="text-white mb-2">Choix Premier mois</label>
                <select id="choix-mois-premier" name="choix_premiermois" class="form-select">
                    <option value="">--Sélectionner--</option>
                    <option value="Payer la somme demandé">Payer la somme demandé</option>
                    <option value="Payer en fonction de ses moyens">Payer en fonction de ses moyens</option>
                </select>
            </div>

            <div class="form-group style-border col-12 mb-3" id="modes-paiement-container">
                <label for="modes-paiement" class="text-white mb-2">Modes de Paiement</label>
                <select id="modes-paiement" name="modes_paiement" class="form-select" required>
                    <option value="">--Sélectionner--</option>
                    <option value="Carte Bancaire">Carte Bancaire</option>
                    <option value="Virement bancaire">Virement bancaire</option>
                </select>
            </div>

            <div class="form-group style-border col-12 mb-3" id="banque-container" style="display: none;">
                <label for="banque" class="text-white mb-2">Banque</label>
                <select id="banque" name="banque" class="form-select">
                    <option value="">Sélectionner</option>
                    <option value="BANQUE ATLANTIQUE">BANQUE ATLANTIQUE</option>
                    <option value="BICICI">BICICI</option>
                    <option value="CORIS BANK">CORIS BANK</option>
                    <option value="ECOBANK">ECOBANK</option>
                    <option value="MANSA BANK">MANSA BANK</option>
                    <option value="NSIA BANQUE">NSIA BANQUE</option>
                    <option value="ORABANK">ORABANK</option>
                    <option value="SGCI">SGCI</option>
                    <option value="SIB">SIB</option>
                    <option value="UBA">UBA</option>
                    <option value="VERSUS BANK">VERSUS BANK</option>
                </select>

                <div id="noms-banques" class="mt-3 alert alert-custom" style="display: none; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
                    <div id="sgci" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> SGCI</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 01 234 567 890 12</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> SGCI CI AB</p>
                    </div>  
                    <div id="bicici" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> BICICI</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 10 234 567 890 01</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> BICICI CI AB</p>
                    </div>
                    <div id="sib" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> SIB</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 20 345 678 901 23</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> SIB CI AB</p>
                    </div>
                    <div id="nsia" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> NSIA Banque</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 30 456 789 012 34</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> NSIA CI AB</p>
                    </div>
                    <div id="ecobank" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> Ecobank</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 40 567 890 123 45</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> ECOCI CI AB</p>
                    </div>
                    <div id="uba" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> UBA</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 50 678 901 234 56</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> UNAFRICI</p>
                    </div>
                    <div id="atlantique" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> Banque Atlantique</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 60 789 012 345 67</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> ATCI CI AB</p>
                    </div>
                    <div id="orabank" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> Orabank</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 70 890 123 456 78</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> ORCI CI AB</p>
                    </div>
                    <div id="coris" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> Coris Bank</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 80 901 234 567 89</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> CORICI</p>
                    </div>
                    <div id="mansa" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> Mansa Bank</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 90 111 222 333 44</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> MANSA CI</p>
                    </div>
                    <div id="versus" style="display: none;">
                        <p class="mb-1"><strong>Bénéficiaire :</strong> Groupe Scolaire XYZ</p>
                        <p class="mb-1"><strong>Banque :</strong> Versus Bank</p>
                        <p class="mb-1"><strong>Numéro de compte :</strong> 11 111 111 111 11</p>
                        <p class="mb-1"><strong>Code SWIFT :</strong> VERSUS CI</p>
                    </div>
                </div>
            </div>

            <div class="form-group style-border col-12 mb-3">
                <label for="montant_attendu" class="text-white mb-2">Montant à régler</label>
                <input type="number" id="montant_attendu" name="montant_attendu" class="form-control" placeholder="Montant à régler" required>


                <input type="hidden" id="reste_payer" name="reste_payer" value="0">
                <input type="hidden" id="modalite_final" name="modalite_final">
                <input type="hidden" id="tranche_final" name="tranche_final">
                <input type="hidden" id="choix_mois_final" name="choix_mois_final">
                <input type="hidden" id="choix_premier_mois_final" name="choix_premier_mois_final">
                <input type="hidden" id="mode_paiement_final" name="mode_paiement_final">
                <input type="hidden" id="banque_final" name="banque_final">
            </div>

            <div class="form-btn col-12 mt-15">
                <button type="submit" class="th-btn th-btn white-hover">Payer</button>
            </div>
        </div>
        <p class="form-messages mb-0 mt-3"></p>
    </form>
</div>


    
<!--==============================
                                           SCRIPT D'AFFICHAGE
                                        ==============================--> 
<script>
window.addEventListener('DOMContentLoaded', function () {
    const modalitePaiementMensuelRadio = document.getElementById('mensuel-paiement');
    const modalitePaiementSeuleRadio = document.getElementById('seule-paiement');

    const tranchePaiement = document.getElementById('tranche-paiement');
    const tranchePaiementSelect = document.getElementById('paiement-tranche');

    const choixUnMois = document.getElementById('choix-un-mois');
    const choixDeuxMois = document.getElementById('choix-deux-mois');
    const choixTroisMois = document.getElementById('choix-trois-mois');
    const choixQuatreMois = document.getElementById('choix-quatre-mois');

    const choixUnMoisSelect = document.getElementById('un-mois-choix');
    const choixDeuxMoisSelect = document.getElementById('deux-mois-choix');
    const choixTroisMoisSelect = document.getElementById('trois-mois-choix');
    const choixQuatreMoisSelect = document.getElementById('quatre-mois-choix');

    const premierChoixMois = document.getElementById('choix-premier-mois');
    const premierChoixMoisSelect = document.getElementById('choix-mois-premier');

    const banqueContainer = document.getElementById('banque-container');
    const modesPaiementSelect = document.getElementById('modes-paiement');
    const banqueSelect = document.getElementById('banque');
    const nomsBanques = document.getElementById('noms-banques');

    const modaliteFinal = document.getElementById('modalite_final');
    const trancheFinal = document.getElementById('tranche_final');
    const choixMoisFinal = document.getElementById('choix_mois_final');
    const choixPremierMoisFinal = document.getElementById('choix_premier_mois_final');
    const modePaiementFinal = document.getElementById('mode_paiement_final');
    const banqueFinal = document.getElementById('banque_final');
    const form = document.querySelector('form[action*="paiement-scolarite"]') || document.querySelector('form');

    const apprenantSelect = document.getElementById('apprenants_id');
    const montantAttenduInput = document.getElementById('montant_attendu');
    const blocInfosScolarite = document.getElementById('bloc-infos-scolarite');
    const titreClasseEleve = document.getElementById('titre-classe-eleve');

    const valeurScolarite = document.getElementById('valeur-scolarite');
    const valeurDejaPaye = document.getElementById('valeur-deja-paye');
    const valeurResteTotal = document.getElementById('valeur-reste-total');
    const valeurResteFutur = document.getElementById('valeur-reste-futur');
    const restePayerInput = document.getElementById('reste_payer');

    const banquesDives = {
        'BICICI': document.getElementById('bicici'),
        'SGCI': document.getElementById('sgci'),
        'BANQUE ATLANTIQUE': document.getElementById('atlantique'),
        'ORABANK': document.getElementById('orabank'),
        'CORIS BANK': document.getElementById('coris'),
        'MANSA BANK': document.getElementById('mansa'),
        'VERSUS BANK': document.getElementById('versus'),
        'UBA': document.getElementById('uba'),
        'SIB': document.getElementById('sib'),
        'NSIA BANQUE': document.getElementById('nsia'),
        'ECOBANK': document.getElementById('ecobank')
    };

    function setDisplayAndRequired(element, displayStyle, selectElement = null, isRequired = false) {
        if (!element) return;
        element.style.display = displayStyle;
        if (selectElement) {
            selectElement.required = (displayStyle === 'block' && isRequired);
        }
    }

    function resetAll() {
        setDisplayAndRequired(tranchePaiement, 'none', tranchePaiementSelect);
        setDisplayAndRequired(choixUnMois, 'none', choixUnMoisSelect);
        setDisplayAndRequired(choixDeuxMois, 'none', choixDeuxMoisSelect);
        setDisplayAndRequired(choixTroisMois, 'none', choixTroisMoisSelect);
        setDisplayAndRequired(choixQuatreMois, 'none', choixQuatreMoisSelect);
        setDisplayAndRequired(premierChoixMois, 'none', premierChoixMoisSelect);

        if (nomsBanques) nomsBanques.style.display = 'none';

        Object.values(banquesDives).forEach(div => {
            if (div) div.style.display = 'none';
        });
    }

    function syncFinalValues() {
        if (modaliteFinal && modalitePaiementSeuleRadio && modalitePaiementMensuelRadio) {
            modaliteFinal.value = modalitePaiementSeuleRadio.checked ? modalitePaiementSeuleRadio.value : (modalitePaiementMensuelRadio.checked ? modalitePaiementMensuelRadio.value : '');
        }
        if (trancheFinal && tranchePaiementSelect) {
            trancheFinal.value = tranchePaiementSelect.value;
        }

        let choixMois = '';
        if (choixUnMois && choixUnMois.style.display === 'block') choixMois = choixUnMoisSelect.value;
        else if (choixDeuxMois && choixDeuxMois.style.display === 'block') choixMois = choixDeuxMoisSelect.value;
        else if (choixTroisMois && choixTroisMois.style.display === 'block') choixMois = choixTroisMoisSelect.value;
        else if (choixQuatreMois && choixQuatreMois.style.display === 'block') choixMois = choixQuatreMoisSelect.value;

        if (choixMoisFinal) choixMoisFinal.value = choixMois;
        if (choixPremierMoisFinal) choixPremierMoisFinal.value = (premierChoixMois && premierChoixMois.style.display === 'block') ? premierChoixMoisSelect.value : '';
        if (modePaiementFinal && modesPaiementSelect) modePaiementFinal.value = modesPaiementSelect.value;
        if (banqueFinal && banqueSelect) banqueFinal.value = banqueSelect.value;
    }

    function toggle() {
        resetAll();

        if (modalitePaiementMensuelRadio && modalitePaiementMensuelRadio.checked) {
            setDisplayAndRequired(tranchePaiement, 'block', tranchePaiementSelect, true);
            const tranche = tranchePaiementSelect.value;

            if (tranche === 'Payer une fois par mois') {
                setDisplayAndRequired(choixUnMois, 'block', choixUnMoisSelect, true);
                setDisplayAndRequired(premierChoixMois, 'block', premierChoixMoisSelect, true);
            } else if (tranche === 'Payer pour deux mois') {
                setDisplayAndRequired(choixDeuxMois, 'block', choixDeuxMoisSelect, true);
            } else if (tranche === 'Payer pour trois mois') {
                setDisplayAndRequired(choixTroisMois, 'block', choixTroisMoisSelect, true);
            } else if (tranche === 'Payer pour quatre mois') {
                setDisplayAndRequired(choixQuatreMois, 'block', choixQuatreMoisSelect, true);
            }
        }

        const mode = modesPaiementSelect ? modesPaiementSelect.value : '';
        if (mode === 'Virement bancaire' || mode === 'Carte Bancaire') {
            if (banqueContainer) banqueContainer.style.display = 'block';
            if (banqueSelect) banqueSelect.required = true;

            if (mode === 'Virement bancaire' && nomsBanques) {
                nomsBanques.style.display = 'block';
                const banqueSelectionnee = banqueSelect.value;
                if (banquesDives[banqueSelectionnee]) {
                    banquesDives[banqueSelectionnee].style.display = 'block';
                }
            }
        } else {
            if (banqueContainer) banqueContainer.style.display = 'none';
            if (banqueSelect) banqueSelect.required = false;
        }

        syncFinalValues();
    }

    // === LECTURE DYNAMIQUE DE LA BD ===
    function recupererScolarite(niveau, typeNiveau) {
        const scolaritesBD = window.scolaritesBD || {};

        // Recherche prioritaire par type_niveau puis par niveau_etude
        if (typeNiveau && scolaritesBD[typeNiveau] !== undefined) {
            return { montant: parseFloat(scolaritesBD[typeNiveau]), libelle: typeNiveau };
        }
        if (niveau && scolaritesBD[niveau] !== undefined) {
            return { montant: parseFloat(scolaritesBD[niveau]), libelle: niveau };
        }

        return { montant: 0, libelle: typeNiveau || niveau || "Classe inconnue" };
    }

    function recalculerSituationFinanciere() {
        if (!apprenantSelect || !blocInfosScolarite) return;

        const selectedOption = apprenantSelect.options[apprenantSelect.selectedIndex];
        
        if (!selectedOption || !apprenantSelect.value) {
            blocInfosScolarite.style.display = 'none';
            if (restePayerInput) restePayerInput.value = 0;
            return;
        }

        // 1. Extraction des données de l'apprenant
        const niveau = selectedOption.getAttribute('data-niveau');
        const typeNiveau = selectedOption.getAttribute('data-type-niveau');
        const dejaPaye = parseFloat(selectedOption.getAttribute('data-deja-paye')) || 0;

        // 2. Détermination de la scolarité via les données envoyées par la BD
        const infoScolarite = recupererScolarite(niveau, typeNiveau);
        const scolariteTotale = infoScolarite.montant;

        // 3. Calculs des restes
        const resteInitialAvantSaisie = scolariteTotale - dejaPaye;
        const montantSaisiActuel = montantAttenduInput ? (parseFloat(montantAttenduInput.value) || 0) : 0;
        
        let resteFutur = resteInitialAvantSaisie - montantSaisiActuel;
        if (resteFutur < 0) resteFutur = 0;

        // 4. Mises à jour du formulaire et de l'affichage
        if (restePayerInput) restePayerInput.value = resteFutur;

        titreClasseEleve.textContent = `Situation financière de l'apprenant en classe de (${infoScolarite.libelle})`;
        valeurScolarite.textContent = scolariteTotale.toLocaleString('fr-FR');
        valeurDejaPaye.textContent = dejaPaye.toLocaleString('fr-FR');
        valeurResteTotal.textContent = (resteInitialAvantSaisie < 0 ? 0 : resteInitialAvantSaisie).toLocaleString('fr-FR');
        valeurResteFutur.textContent = resteFutur.toLocaleString('fr-FR');
        
        blocInfosScolarite.style.display = 'block';
    }

    // Écouteurs d'événements
    if (apprenantSelect) apprenantSelect.addEventListener('change', recalculerSituationFinanciere);
    if (montantAttenduInput) montantAttenduInput.addEventListener('input', recalculerSituationFinanciere);

    if (modalitePaiementMensuelRadio) modalitePaiementMensuelRadio.addEventListener('change', toggle);
    if (modalitePaiementSeuleRadio) modalitePaiementSeuleRadio.addEventListener('change', toggle);
    if (tranchePaiementSelect) tranchePaiementSelect.addEventListener('change', toggle);
    if (modesPaiementSelect) modesPaiementSelect.addEventListener('change', toggle);
    if (banqueSelect) banqueSelect.addEventListener('change', toggle);

    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', syncFinalValues);
    });

    if (form) form.addEventListener('submit', syncFinalValues);

    toggle();
    recalculerSituationFinanciere();
});
</script>
@endsection