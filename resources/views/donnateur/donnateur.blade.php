@extends('layouts.app')

@section('title', 'Donnateurs | '. $etablissement->etablissement->nom)

@section('content')

<div class="breadcumb-wrapper position-relative " data-bg-src="assets/img/shape/breadcrumb-shep.png" style="margin-top: 50px;">
        
        <div class="container th-container4">
            <div class="row">
                <div class="col-xxl-5">
                    <div class="breadcumb-content">
                        <h1  class="breadcumb-title ">{{ $donateurs->premier }}</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{route('accueil')}}">Accueil</a></li>
                            <li>{{ $donateurs->premier }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--==============================
    program Area
==============================-->
    <section class="th-program-wrapper program-details space-top space-extra2-bottom overflow-hidden">
        <div class="container th-container4">
            <div class="row gy-4 gx-60">
                <div class="col-xl-8">
                    <div class="peogram-area">
                        <div class="title-area">
                            <h2 class="sec-title text-anim2">{{ $donateurs->titre_un }}<span class="d-block">{{ $donateurs->premier }}</span></h2>
                            <p class="sec-text2 mt-25 mb-0 wow fadeInUp" data-wow-delay=".2s">{{ $donateurs->titre_deux }}</p>
                            <p class="sec-text4 mt-25 mb-0 wow fadeInUp" data-wow-delay=".3s">{{ $donateurs->texte }}</p>
                        </div>
                        <div class="program-wrapp">
    <div class="discount-wrapp">
        <div class="logo" style="display: inline-block;"> <img src="{{ asset('asset/assets/img/ari.jpg') }}" alt="img" 
                 style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; display: block; animation: spinImage 12s linear infinite;">
                 
        </div>
        <div class="discount-tag">
            <span class="discount-anime">{{ $donateurs->texte_circule }}</span>
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
        <div class="shape-mockup jump d-none d-xxl-block" data-bottom="0%" data-right="0%"><img src="assets/img/shape/faq-2-1.png" alt="Stadum">
        </div>
    </section>
<div class="addmission-area overflow-hidden space overflow-hidden">
        <div class="addmission-bg-thumb overflow-hidden gsap-parallax">
            <img src="{{ asset('asset/assets/img/aaaa.png') }}" alt="Stadum">
        </div>
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title text-anim">{{ $donateurs->titre_trois }}</span>
                <div class="box-text-wrap mt-25">
                    <p class="box-text text-white wow fadeInUp" data-wow>
                        {{ $donateurs->texte_deux }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="admission-forum-wrap overflow-hidden">
        <div class="container">
            <div class="admission-forum-inner">
                <div class="addmission-forum-thumb overflow-hidden">
                    <img src="{{ asset('asset/assets/img/a4.jpg') }}" alt="Stadum">
                </div>
                <div class="addmisson-forum">
                    <div class="row justify-content-end">
                        


                        <!--==============================
FORMULAIRE DE PAIEMENT
==============================-->
                       <div class="contact-form-v1 col-lg-7 col-md-12">
    <form method="POST" action="{{ route('donnateur-submit') }}" class="contact-form">
        @csrf 
        <div class="row">
            
            <div class="form-group style-border col-12 mb-3">
                <label for="type_donnateurs" class="text-white mb-2">Types de Donateurs</label>
                <select id="type_donnateurs" name="type_donnateurs" class="form-select" required>
                    <option value="">Sélectionner</option>
                    <option value="Personne">Personne</option>
                    <option value="Organisation">Organisation</option>
                </select> 
            </div>

            <div class="form-group style-border col-12 mb-3" id="nom-prenom" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="text-white mb-2">Nom</label>
                        <input type="text" class="form-control" placeholder="Nom" name="nom" id="nom">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="text-white mb-2">Prénom</label>
                        <input type="text" class="form-control" placeholder="Prénom" name="prenom" id="prenom">
                    </div>
                </div>
            </div>

            <div class="form-group style-border col-12 mb-3" id="organisation" style="display: none;">
                <label for="type_organisations" class="text-white mb-2">Nom de l'organisation</label>
                <input type="text" class="form-control" placeholder="Nom Organisation" name="type_organisations" id="type_organisations">
            </div>

            <div class="form-group style-border col-md-6 mb-3">
                <label for="etablissementannees_id" class="text-white mb-2">Année Scolaire</label>  
                <select id="etablissementannees_id" name="etablissementannees_id" class="form-select" required>
                    <option value="">Sélectionner</option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee->id_etablissementannees }}">{{ $annee->anneeScolaire->annee_scolaire }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group style-border col-md-6 mb-3">
                <label for="type_dons" class="text-white mb-2">Types de Dons</label>
                <select id="type_dons" name="type_dons" class="form-select" required>
                    <option value="">Sélectionner</option>
                    <option value="Vivres">Vivres</option>
                    <option value="Non-Vivres">Non-Vivres</option> 
                </select>
            </div>

            <div class="form-group style-border col-12 mb-3" id="vivres" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="don_vivres" class="text-white mb-2">Nom du Don Vivres</label>
                        <input type="text" class="form-control" placeholder="Nom du Don Vivres" name="don_vivres" id="don_vivres">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="quantite_donvivres" class="text-white mb-2">Quantité</label>
                        <input type="text" class="form-control" placeholder="Quantité" name="quantite_donvivres" id="quantite_donvivres">
                    </div>
                </div>
            </div>

            <div id="non-vivres" style="display: none;" class="col-12 p-0">
                <div class="form-group style-border col-12 mb-3" id="modes-paiement-container">
                    <label for="modes-paiement" class="text-white mb-2">Modes de Paiement</label>
                    <select id="modes-paiement" name="modes_paiement" class="form-select">
                        <option value="">Sélectionner</option>
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
            </div>

            <div class="form-group style-border col-md-6 mb-3">
                <label for="contacts" class="text-white mb-2">Contacts</label>
                <input type="text" class="form-control" placeholder="Contacts" name="contacts" id="contacts" required>
            </div>

            <div class="form-group style-border col-md-6 mb-3">
                <label for="email" class="text-white mb-2">Email</label>
                <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
            </div>

            <div class="form-group style-border col-12 mb-3" id="montant-container" style="display: none;">
                <label for="montant_attendu" class="text-white mb-2">Montant à payer</label>
                <input type="number" class="form-control" id="montant_attendu" name="montant_attendu" placeholder="Montant Global">

                <input type="hidden" id="modalite_final" name="modalite_final">
                <input type="hidden" id="tranche_final" name="tranche_final">
                <input type="hidden" id="choix_mois_final" name="choix_mois_final">
                <input type="hidden" id="choix_premier_mois_final" name="choix_premier_mois_final">
                <input type="hidden" id="mode_paiement_final" name="mode_paiement_final">
                <input type="hidden" id="banque_final" name="banque_final">
            </div>

            <div class="form-btn col-12 mt-15">
                <button type="submit" class="th-btn th-btn white-hover">Valider le Don</button>
            </div>
        </div>
        <p class="form-messages mb-0 mt-3"></p>
    </form>
</div>

<script>
    const typeDonnateursSelect = document.getElementById('type_donnateurs');
    const nomPrenomBlock = document.getElementById('nom-prenom');
    const organisationBlock = document.getElementById('organisation');

    const typeDonsSelect = document.getElementById('type_dons');
    const vivresBlock = document.getElementById('vivres');
    const nonVivresBlock = document.getElementById('non-vivres');
    
    // Sélection du nouveau conteneur de montant
    const montantContainer = document.getElementById('montant-container');

    const modesPaiementSelect = document.getElementById('modes-paiement');
    const banqueContainer = document.getElementById('banque-container');
    const banqueSelect = document.getElementById('banque');
    const nomsBanques = document.getElementById('noms-banques');

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

    function setBlockVisibility(container, isVisible, isRequired = false) {
        if (!container) return;
        container.style.display = isVisible ? 'block' : 'none';
        
        const formElements = container.querySelectorAll('input, select');
        formElements.forEach(element => {
            element.required = (isVisible && isRequired);
        });
    }

    function resetFormDisplay() {
        setBlockVisibility(nomPrenomBlock, false);
        setBlockVisibility(organisationBlock, false);
        setBlockVisibility(vivresBlock, false);
        setBlockVisibility(nonVivresBlock, false);
        setBlockVisibility(montantContainer, false); // Cache le montant par défaut

        if(banqueContainer) banqueContainer.style.display = 'none';
        if(nomsBanques) nomsBanques.style.display = 'none';
        
        Object.values(banquesDives).forEach(div => {
            if(div) div.style.display = 'none';
        });
    }

    function toggle() {
        const typeDonnateur = typeDonnateursSelect.value;
        const typeDon = typeDonsSelect.value;
        const modePaiement = modesPaiementSelect.value;
        const banqueSelectionnee = banqueSelect.value;

        resetFormDisplay();

        // 1. TYPE DONNATEUR
        if (typeDonnateur === 'Personne') {
            setBlockVisibility(nomPrenomBlock, true, true);
        } else if (typeDonnateur === 'Organisation') {
            setBlockVisibility(organisationBlock, true, true);
        }

        // 2. TYPE DE DONS
        if (typeDon === 'Vivres') {
            setBlockVisibility(vivresBlock, true, true);
            // On s'assure explicitement ici que le montant n'est pas requis ni affiché
            setBlockVisibility(montantContainer, false, false);
        } else if (typeDon === 'Non-Vivres') {
            setBlockVisibility(nonVivresBlock, true, false); 
            modesPaiementSelect.required = true;

            // Ici, le don est financier, donc le montant devient obligatoire ET visible !
            setBlockVisibility(montantContainer, true, true);

            // Logique Banques
            if (modePaiement === 'Virement bancaire' || modePaiement === 'Carte Bancaire') {
                banqueContainer.style.display = 'block';
                banqueSelect.required = true;

                if (modePaiement === 'Virement bancaire') {
                    nomsBanques.style.display = 'block';
                    if (banquesDives[banqueSelectionnee]) {
                        banquesDives[banqueSelectionnee].style.display = 'block';
                    }
                }
            } else {
                banqueContainer.style.display = 'none';
                banqueSelect.required = false;
            }
        }
    }

    typeDonnateursSelect.addEventListener('change', toggle);
    typeDonsSelect.addEventListener('change', toggle);
    modesPaiementSelect.addEventListener('change', toggle);
    banqueSelect.addEventListener('change', toggle);

    toggle();
</script>
@endsection