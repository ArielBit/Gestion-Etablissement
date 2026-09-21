@extends('layouts.app')

@section('title', 'Inscriptions | '. $etablissement->etablissement->nom)


@section('content')
<!--==============================
    BREADCUMB AREA
==============================-->
<div class="breadcumb-wrapper position-relative" data-bg-src="assets/img/shape/breadcrumb-shep.png" style="margin-top: 50px;">
    <div class="container th-container4">
        <div class="row">
            <div class="col-xxl-5">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">{{ $inscriptions->premier }}</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('accueil') }}">Accueil</a></li>
                        <li>{{ $inscriptions->premier }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--==============================
    PROGRAM AREA
==============================-->
<section class="th-program-wrapper program-details space-top space-extra2-bottom overflow-hidden">
    <div class="container th-container4">
        <div class="row gy-4 gx-60">
            <div class="col-xl-8">
                <div class="peogram-area">
                    <div class="title-area">
                        <h2 class="sec-title text-anim2">{{ $inscriptions->premier }}  <span class="d-block">{{ $inscriptions->titre_un }}</span></h2>
                        <p class="sec-text2 mt-25 mb-0 wow fadeInUp" data-wow-delay=".2s">{{ $inscriptions->titre_deux }}</p>
                        <p class="sec-text4 mt-25 mb-0 wow fadeInUp" data-wow-delay=".3s">
                           {{ $inscriptions->texte }}
                        </p>
                    </div>
                    <div class="program-wrapp">
    <div class="discount-wrapp">
        <div class="logo" style="display: inline-block;"> <img src="{{ asset('asset/assets/img/ari.jpg') }}" alt="img" 
                 style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; display: block; animation: spinImage 12s linear infinite;">
                 
        </div>
        <div class="discount-tag">
            <span class="discount-anime">{{ $inscriptions->texte_circule }}</span>
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
</section>

<!--==============================
    ADMISSION BANNER AREA
==============================-->
<div class="addmission-area overflow-hidden space">
    <div class="addmission-bg-thumb overflow-hidden gsap-parallax">
        <img src="{{ asset('asset/assets/img/aaaa.png') }}" alt="Stadum">
    </div>
    <div class="container">
        <div class="title-area text-center">
            <span class="sub-title text-anim">{{ $inscriptions->titre_trois }}</span>
            <div class="box-text-wrap mt-25">
                <p class="box-text text-white wow fadeInUp" data-wow>
                    {{ $inscriptions->texte_deux }}
                </p>
            </div>
        </div>
    </div>
</div>

<!--==============================
    FORM SECTION AREA
==============================-->
<div class="admission-forum-wrap overflow-hidden">
    <div class="container">
        <div class="admission-forum-inner">
            <div class="addmission-forum-thumb overflow-hidden">
                <img src="{{ asset('asset/assets/img/a2.jpg') }}" alt="Stadum" style="width:90%;">
            </div>
            <div class="addmisson-forum">
                <div class="row justify-content-end">
                    <div class="contact-form-v1 col-lg-8 col-md-12">
                        
                        <form method="POST" action="{{ route('verification-inscription') }}" enctype="multipart/form-data" class="contact-form">
                            @csrf
                            
                            <div class="row">
                                <!-- Photo -->
                                <div class="form-group style-border col-12 mb-4">
                                    <label for="photo" class="text-white mb-2">Photo de l'élève</label>
                                    <input type="file" name="photo" id="photo" class="form-control" required>
                                </div>

                                <!-- Identité -->
                                <div class="form-group style-border col-md-6 mb-3">
                                    <label for="nom" class="text-white mb-2">Nom</label>
                                    <input type="text" class="form-control" placeholder="Nom" name="nom" id="nom" required>
                                </div>

                                <div class="form-group style-border col-md-6 mb-3">
                                    <label for="prenom" class="text-white mb-2">Prénom</label>
                                    <input type="text" class="form-control" placeholder="Prénom" name="prenom" id="prenom" required>
                                </div>

                                <div class="form-group style-border col-md-6 mb-3">
                                    <label for="sexe" class="text-white mb-2">Sexe</label>
                                    <select id="sexe" name="sexe" class="form-select" required>
                                        <option value="">Sélectionner</option>
                                        <option value="masculin">Masculin</option>
                                        <option value="feminin">Féminin</option>
                                    </select>
                                </div>

                                @php
    $nationalites = [
        'Ivoirienne', 'Burkinabè', 'Malienne', 'Sénégalaise', 'Guinéenne', 'Togolaise', 'Béninoise', 'Nigérienne', 'Ghanéenne', // Afrique de l'Ouest
        'Camerounaise', 'Congolaise', 'Gabonaise', 'Centrafricaine', 'Tchadienne', // Afrique Centrale
        'Française', 'Belge', 'Suisse', 'Canadienne', 'Américaine', 'Marocaine', 'Algérienne', 'Tunisienne', // Autres fréquentes
        // Ajoute ici d'autres nationalités si nécessaire, ou classe-les par ordre alphabétique :
        'Afghane', 'Albanaise', 'Allemande', 'Angolaise', 'Antiguaise', 'Saoudienne', 'Argentine', 'Arménienne', 'Australienne', 'Autrichienne',
        'Azerbaïdjanaise', 'Bahamienne', 'Bahreïnienne', 'Bangladaise', 'Barbadienne', 'Bélizienne', 'Bhoutanaise', 'Biélorusse', 'Birmane',
        'Bolivienne', 'Bosnienne', 'Botswanaise', 'Brésilienne', 'Brunéienne', 'Bulgare', 'Burundaise', 'Cambodgienne', 'Cap-verdienne',
        'Chilienne', 'Chinoise', 'Chypriote', 'Colombienne', 'Comorienne', 'Nord-coréenne', 'Sud-coréenne', 'Costaricienne', 'Croate', 'Cubaine',
        'Danoise', 'Djiboutienne', 'Dominicaine', 'Égyptienne', 'Émirienne', 'Équatorienne', 'Érythréenne', 'Espagnole', 'Estonienne', 'Éthiopienne',
        'Fidjienne', 'Finlandaise', 'Géorgienne', 'Grecque', 'Grenadienne', 'Guatémaltèque', 'Guyanienne', 'Haïtienne', 'Hondurienne', 'Hongroise',
        'Indienne', 'Indonésienne', 'Irakienne', 'Iranienne', 'Irlandaise', 'Islandaise', 'Israélienne', 'Italienne', 'Jamaïcaine', 'Japonaise',
        'Jordanienne', 'Kazakhstanaise', 'Kenyane', 'Kirghize', 'Kiribatienne', 'Koweïtienne', 'Laotienne', 'Lestothane', 'Lettone', 'Libanaise',
        'Libérienne', 'Libyenne', 'Liechtensteinoise', 'Lituanienne', 'Luxembourgeoise', 'Macédonienne', 'Malgache', 'Malaisienne', 'Maldivienne',
        'Maltaise', 'Mauricienne', 'Mauritanienne', 'Mexicaine', 'Micronésienne', 'Moldave', 'Monégasque', 'Mongole', 'Monténégrine', 'Mozambicaine',
        'Namibienne', 'Nauruane', 'Népalaise', 'Nicaraguayenne', 'Nigériane', 'Norvégienne', 'Néo-zélandaise', 'Omanaise', 'Ougandaise', 'Ouzbèke',
        'Pakistanaise', 'Palaosienne', 'Palestinienne', 'Panaméenne', 'Papouasienne', 'Paraguayenne', 'Neerlandaise', 'Péruvienne', 'Philippine',
        'Polonaise', 'Portugaise', 'Quatarienne', 'Roumaine', 'Britannique', 'Russe', 'Rwandaise', 'Saint-christophienne', 'Sainte-lucienne',
        'Saint-vincentaise', 'Salomonaise', 'Samoane', 'Santoméenne', 'Salvadorienne', 'Seychelloise', 'Sierra-léonaise', 'Singapourienne',
        'Slovaque', 'Slovène', 'Somalienne', 'Soudanaise', 'Sri-lankaise', 'Suédoise', 'Surinamaise', 'Swazie', 'Syrienne', 'Tadjike', 'Taïwanaise',
        'Tanzanienne', 'Thaïlandaise', 'Timoraise', 'Tonguienne', 'Trinidadienne', 'Turkmène', 'Turque', 'Tuvaluane', 'Ukrainienne', 'Uruguayenne',
        'Vanuatuane', 'Vaticane', 'Vénézuélienne', 'Vietnamienne', 'Yéménite', 'Zambienne', 'Zimbabwéenne'
    ];
    sort($nationalites); // Trie automatiquement la liste par ordre alphabétique
@endphp

<div class="form-group style-border col-md-6 mb-3">
    <label for="nationalite" class="text-white mb-2">Nationalité</label>
    <div class="position-relative">
        <select class="form-select" name="nationalite" id="nationalite" required>
            <option value="" disabled {{ old('nationalite') ? '' : 'selected' }}>Choisir une nationalité...</option>
            @foreach($nationalites as $nationalite)
                <option value="{{ $nationalite }}" {{ old('nationalite') == $nationalite ? 'selected' : '' }} style="background-color: #11141b; color: #fff;">
                    {{ $nationalite }}
                </option>
            @endforeach
        </select>
    </div>
    @error('nationalite')
        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</div>
    @enderror
</div>

                                <div class="form-group style-border col-md-4 mb-3">
                                    <label for="date_naissance" class="text-white mb-2">Date de Naissance</label>
                                    <input type="date" class="form-control" name="date_naissance" id="date_naissance" required>
                                </div>

                                <div class="form-group style-border col-md-5 mb-3">
                                    <label for="lieu_naissance" class="text-white mb-2">Lieu de Naissance</label>
                                    <input type="text" class="form-control" placeholder="Lieu de Naissance" name="lieu_naissance" id="lieu_naissance" required>
                                </div>

                                <div class="form-group style-border col-md-3 mb-3">
                                    <label for="age" class="text-white mb-2">Âge</label>
                                    <input type="text" class="form-control" placeholder="Âge" name="age" id="age" required>
                                </div>

                                <div class="form-group style-border col-12 mb-3">
                                    <label for="lieu_residence" class="text-white mb-2">Lieu de Résidence</label>
                                    <input type="text" class="form-control" placeholder="Lieu de Résidence" name="lieu_residence" id="lieu_residence" required>
                                </div>

                                <!-- Cursus -->
                                <div class="form-group style-border col-md-6 mb-3">
                                    <label for="etablissementannees_id" class="text-white mb-2">Année Scolaire</label>
                                    <select id="etablissementannees_id" name="etablissementannees_id" class="form-select" required>
                                        <option value="">Sélectionner</option>
                                        @foreach($annees as $annee)
                                            <option value="{{ $annee->id_etablissementannees }}">{{ $annee->anneeScolaire->annee_scolaire }}</option>
                                        @endforeach
                                    </select>
                                </div>

<!--========================================================================================================================================
================================================= CHOIX DES CLASSES========================================================
====================================================================================================================================== -->

<div class="form-group style-border col-md-6 mb-3">
    <label for="type_enseignement" class="text-white mb-2">Type d'enseignement</label>
    <select id="type_enseignement" name="type_enseignement" class="form-select" required>
        <option value="">Sélectionner</option>
        <option value="general">Général</option>
        <option value="technique">Technique</option>
    </select>
</div>

<!-- Blocs Conditionnels (JS) -->
<div class="form-group style-border col-12 mb-3" id="cycle-container" style="display: none;">
    <label for="cycle" class="text-white mb-2">Type de Cycle</label>
    <select id="cycle" name="cycle" class="form-select">
        <option value="">Sélectionner</option>
        <option value="Premier Cycle">Premier Cycle</option>
        <option value="Second Cycle">Second Cycle</option>
    </select>
</div>

<!-- Premier Cycle Général -->
<div class="form-group style-border col-12 mb-3" id="niveau-etude-general1" style="display: none;">
    <label for="niveau-general-etude1" class="text-white mb-2">Niveau d'étude Général</label>
    <select id="niveau-general-etude1" class="form-select">
        <option value="">Sélectionner</option>
        @if(isset($scolarites['Sixième (6ème)']))
            <option value="{{ $scolarites['Sixième (6ème)']->id }}" data-montant="{{ $scolarites['Sixième (6ème)']->montant }}">Sixième (6ème)</option>
        @endif
        @if(isset($scolarites['Cinquième (5ème)']))
            <option value="{{ $scolarites['Cinquième (5ème)']->id }}" data-montant="{{ $scolarites['Cinquième (5ème)']->montant }}">Cinquième (5ème)</option>
        @endif
        @if(isset($scolarites['Quatrième (4ème)']))
            <option value="{{ $scolarites['Quatrième (4ème)']->id }}" data-montant="{{ $scolarites['Quatrième (4ème)']->montant }}">Quatrième (4ème)</option>
        @endif
        @if(isset($scolarites['Troisième (3ème)']))
            <option value="{{ $scolarites['Troisième (3ème)']->id }}" data-montant="{{ $scolarites['Troisième (3ème)']->montant }}">Troisième (3ème)</option>
        @endif
    </select>
</div>

<!-- Second Cycle Général - Sélection du Niveau -->
<div class="form-group style-border col-12 mb-3" id="niveau-etude-general2" style="display: none;">
    <label for="niveau-general-etude2" class="text-white mb-2">Niveau d'étude Général</label>
    <select id="niveau-general-etude2" class="form-select">
        <option value="">Sélectionner</option>
        <option value="Seconde (2nde)">Seconde (2nde)</option>
        <option value="Première (1ère)">Première (1ère)</option>
        <option value="Terminale (Tle)">Terminale (Tle)</option>
    </select>
</div>

<!-- Enseignement Technique - Sélection du Niveau -->
<div class="form-group style-border col-12 mb-3" id="niveau-etude-technique" style="display: none;">
    <label for="niveau-technique-etude" class="text-white mb-2">Niveau d'étude Technique</label>
    <select id="niveau-technique-etude" class="form-select">
        <option value="">Sélectionner</option>
        <option value="Seconde (2nde)">Seconde (2nde)</option>
        <option value="Première (1ère)">Première (1ère)</option>
        <option value="Terminale (Tle)">Terminale (Tle)</option>
    </select>
</div>

<!-- Séries / Options : Technique Seconde -->
<div class="form-group style-border col-12 mb-3" id="type-niveau-technique-seconde" style="display: none;">  
    <label for="type-niveau-seconde-technique" class="text-white mb-2">Type d'étude</label>
    <select id="type-niveau-seconde-technique" class="form-select">
        <option value="">Sélectionner</option>
        @foreach(['Seconde B (2nde B)', 'Seconde E (2nde E)', 'Seconde F1 (2nde F1)', 'Seconde F2 (2nde F2)', 'Seconde G1 (2nde G1)', 'Seconde G2 (2nde G2)'] as $classe)
            @if(isset($scolarites[$classe]))
                <option value="{{ $scolarites[$classe]->id }}" data-montant="{{ $scolarites[$classe]->montant }}">{{ $classe }}</option>
            @endif
        @endforeach
    </select>
</div>  

<!-- Séries / Options : Technique Première -->
<div class="form-group style-border col-12 mb-3" id="type-niveau-technique-premiere" style="display: none;">  
    <label for="type-niveau-premiere-technique" class="text-white mb-2">Type d'étude</label>
    <select id="type-niveau-premiere-technique" class="form-select">
        <option value="">Sélectionner</option>
        @foreach(['Première B (1ère B)', 'Première E (1ère E)', 'Première F1 (1ère F1)', 'Première F2 (1ère F2)', 'Première G1 (1ère G1)', 'Première G2 (1ère G2)'] as $classe)
            @if(isset($scolarites[$classe]))
                <option value="{{ $scolarites[$classe]->id }}" data-montant="{{ $scolarites[$classe]->montant }}">{{ $classe }}</option>
            @endif
        @endforeach
    </select>
</div>  

<!-- Séries / Options : Technique Terminale -->
<div class="form-group style-border col-12 mb-3" id="type-niveau-technique-terminale" style="display: none;">  
    <label for="type-niveau-terminale-technique" class="text-white mb-2">Type d'étude</label>
    <select id="type-niveau-terminale-technique" class="form-select">
        <option value="">Sélectionner</option>
        @foreach(['Terminale B (Tle B)', 'Terminale E (Tle E)', 'Terminale F1 (Tle F1)', 'Terminale F2 (Tle F2)', 'Terminale G1 (Tle G1)', 'Terminale G2 (Tle G2)'] as $classe)
            @if(isset($scolarites[$classe]))
                <option value="{{ $scolarites[$classe]->id }}" data-montant="{{ $scolarites[$classe]->montant }}">{{ $classe }}</option>
            @endif
        @endforeach
    </select>
</div>  

<!-- Séries / Options : Général Seconde -->
<div class="form-group style-border col-12 mb-3" id="type-niveau-general-seconde" style="display: none;">  
    <label for="type-niveau-seconde-general" class="text-white mb-2">Type d'étude</label>
    <select id="type-niveau-seconde-general" class="form-select">
        <option value="">Sélectionner</option>
        @foreach(['Seconde A1 (2nde A1)', 'Seconde A2 (2nde A2)', 'Seconde C (2nde C)', 'Seconde D (2nde D)'] as $classe)
            @if(isset($scolarites[$classe]))
                <option value="{{ $scolarites[$classe]->id }}" data-montant="{{ $scolarites[$classe]->montant }}">{{ $classe }}</option>
            @endif
        @endforeach
    </select>
</div>  

<!-- Séries / Options : Général Première -->
<div class="form-group style-border col-12 mb-3" id="type-niveau-general-premiere" style="display: none;">  
    <label for="type-niveau-premiere-general" class="text-white mb-2">Type d'étude</label>
    <select id="type-niveau-premiere-general" class="form-select">
        <option value="">Sélectionner</option>
        @foreach(['Première A1 (1ère A1)', 'Première A2 (1ère A2)', 'Première C (1ère C)', 'Première D (1ère D)'] as $classe)
            @if(isset($scolarites[$classe]))
                <option value="{{ $scolarites[$classe]->id }}" data-montant="{{ $scolarites[$classe]->montant }}">{{ $classe }}</option>
            @endif
        @endforeach
    </select>
</div>  

<!-- Séries / Options : Général Terminale -->
<div class="form-group style-border col-12 mb-3" id="type-niveau-general-terminale" style="display: none;">  
    <label for="type-niveau-terminale-general" class="text-white mb-2">Type d'étude</label>
    <select id="type-niveau-terminale-general" class="form-select">
        <option value="">Sélectionner</option>
        @foreach(['Terminale A1 (Tle A1)', 'Terminale A2 (Tle A2)', 'Terminale C (Tle C)', 'Terminale D (Tle D)'] as $classe)
            @if(isset($scolarites[$classe]))
                <option value="{{ $scolarites[$classe]->id }}" data-montant="{{ $scolarites[$classe]->montant }}">{{ $classe }}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Remplacer : -->
<!-- <div id="section-moyenne-photo" class="row col-12 p-0 m-0" style="display: none !important;"> -->

<!-- Par ceci : -->
<div id="section-moyenne-photo" class="row col-12 p-0 m-0 d-none">
    <div class="form-group style-border col-md-6 mb-3">
        <label class="text-white mb-2">Moyenne annuelle/examen</label>
        <input type="text" class="form-control" placeholder="Moyenne" name="moyenne" id="moyenne">
    </div>

    <div class="form-group style-border col-md-6 mb-3">
        <label class="text-white mb-2">Photo Bulletin/Diplôme</label>
        <input type="file" name="photo_b" id="photo_b" class="form-control">
    </div>
</div>

                                
                                <!-- Section Parents -->
                                <div class="col-12 my-3">
                                    <hr style="border-top: 1px solid rgba(255,255,255,0.15);">
                                    <h5 class="text-white">Informations des Parents / Tuteurs</h5>
                                </div>

                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Nom complet du Père</label>
                                    <input type="text" class="form-control" placeholder="Nom et Prénom " name="pere" id="pere">
                                </div>
                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Téléphone du Père</label>
                                    <input type="text" class="form-control" placeholder="Tél du Père" name="tel_pere" id="tel_pere">
                                </div>
                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Email du Père</label>
                                    <input type="email" class="form-control" placeholder="Email du Père" name="email_pere" id="email_pere">
                                </div>

                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Nom complet de la Mère</label>
                                    <input type="text" class="form-control" placeholder="Nom et Prénom " name="mere" id="mere">
                                </div>
                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Téléphone de la Mère</label>
                                    <input type="text" class="form-control" placeholder="Tél de la Mère" name="tel_mere" id="tel_mere">
                                </div>
                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Email de la Mère</label>
                                    <input type="email" class="form-control" placeholder="Email de la Mère" name="email_mere" id="email_mere">
                                </div>

                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Nom complet du Tuteur</label>
                                    <input type="text" class="form-control" placeholder="Nom et Prénom " name="tuteur" id="tuteur">
                                </div>
                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Téléphone du Tuteur</label>
                                    <input type="text" class="form-control" placeholder="Tél du Tuteur" name="tel_tuteur" id="tel_tuteur">
                                </div>
                                <div class="form-group style-border col-md-4 mb-3">
                                    <label class="text-white mb-2">Email du Tuteur</label>
                                    <input type="email" class="form-control" placeholder="Email du Tuteur" name="email_tuteur" id="email_tuteur">
                                </div>

                                <!-- Soumission -->
                                <div class="form-btn col-12 mt-4">
                                    <button type="submit" class="th-btn th-btn white-hover w-100">Soumettre l'Inscription</button>
                                </div>

                               <!-- CHAMPS MASQUÉS DE DESTINATION POUR LA SOUMISSION -->
<input type="hidden" name="niveau_etude_final" id="niveau_etude_final">
<input type="hidden" name="type_niveau_final" id="type_niveau_final">
<input type="hidden" id="type_niveau2" name="type_niveau2" value="">
<input type="hidden" name="scolarite_id" id="scolarite_id">

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // Fonction utilitaire pour récupérer un élément par son ID
    function getEl(id) {
        return document.getElementById(id) || null;
    }

    // Affiche ou masque un bloc HTML en gérant le 'display' et les réinitialisations
    function afficherBloc(id, afficher, modeDisplay = 'block') {
        const el = getEl(id);
        if (!el) return;

        if (afficher) {
            el.style.setProperty('display', modeDisplay, 'important');
        } else {
            el.style.setProperty('display', 'none', 'important');
            const select = el.querySelector('select');
            if (select) select.selectedIndex = 0;
        }
    }

    // Récupère la valeur sélectionnée dans un select par son ID
    function getVal(id) {
        const el = getEl(id);
        return el ? el.value : '';
    }

    // Vérifie si un select possède une option choisie
    function aUneSelection(id) {
        const el = getEl(id);
        return el && el.selectedIndex > 0;
    }

    // 1. ÉTAPE MOYENNE ET PHOTO : Vérifie si UNE classe est sélectionnée
    function verifierSectionMoyennePhoto() {
        const sectionMoyennePhoto = getEl('section-moyenne-photo');
        if (!sectionMoyennePhoto) return;

        const auMoinsUneClasseChoisie = (
            aUneSelection('niveau-general-etude1') || 
            aUneSelection('type-niveau-seconde-general') || 
            aUneSelection('type-niveau-premiere-general') || 
            aUneSelection('type-niveau-terminale-general') || 
            aUneSelection('type-niveau-seconde-technique') || 
            aUneSelection('type-niveau-premiere-technique') || 
            aUneSelection('type-niveau-terminale-technique')
        );

        const inputMoyenne = getEl('moyenne');
        const inputPhoto = getEl('photo_b');

        if (auMoinsUneClasseChoisie) {
            sectionMoyennePhoto.style.setProperty('display', 'flex', 'important');
            if (inputMoyenne) inputMoyenne.required = true;
            if (inputPhoto) inputPhoto.required = true;
        } else {
            sectionMoyennePhoto.style.setProperty('display', 'none', 'important');
            if (inputMoyenne) { inputMoyenne.required = false; inputMoyenne.value = ''; }
            if (inputPhoto) { inputPhoto.required = false; inputPhoto.value = ''; }
        }
    }

    // 2. ÉTAPE SÉLECTEURS EN CASCADE
    function gererAffichageCascade() {
        const typeEnseignement = getVal('type_enseignement');
        const cycle = getVal('cycle');

        if (typeEnseignement === 'technique') {
            afficherBloc('cycle-container', false);
            afficherBloc('niveau-etude-general1', false);
            afficherBloc('niveau-etude-general2', false);
            afficherBloc('type-niveau-general-seconde', false);
            afficherBloc('type-niveau-general-premiere', false);
            afficherBloc('type-niveau-general-terminale', false);

            afficherBloc('niveau-etude-technique', true);
            const nTech = getVal('niveau-technique-etude');

            afficherBloc('type-niveau-technique-seconde', nTech === 'Seconde (2nde)');
            afficherBloc('type-niveau-technique-premiere', nTech === 'Première (1ère)');
            afficherBloc('type-niveau-technique-terminale', nTech === 'Terminale (Tle)');

        } else if (typeEnseignement === 'general') {
            afficherBloc('niveau-etude-technique', false);
            afficherBloc('type-niveau-technique-seconde', false);
            afficherBloc('type-niveau-technique-premiere', false);
            afficherBloc('type-niveau-technique-terminale', false);

            afficherBloc('cycle-container', true);

            if (cycle === 'Premier Cycle') {
                afficherBloc('niveau-etude-general1', true);
                afficherBloc('niveau-etude-general2', false);
                afficherBloc('type-niveau-general-seconde', false);
                afficherBloc('type-niveau-general-premiere', false);
                afficherBloc('type-niveau-general-terminale', false);

            } else if (cycle === 'Second Cycle') {
                afficherBloc('niveau-etude-general1', false);
                afficherBloc('niveau-etude-general2', true);

                const nGen = getVal('niveau-general-etude2');

                afficherBloc('type-niveau-general-seconde', nGen === 'Seconde (2nde)');
                afficherBloc('type-niveau-general-premiere', nGen === 'Première (1ère)');
                afficherBloc('type-niveau-general-terminale', nGen === 'Terminale (Tle)');

            } else {
                afficherBloc('niveau-etude-general1', false);
                afficherBloc('niveau-etude-general2', false);
                afficherBloc('type-niveau-general-seconde', false);
                afficherBloc('type-niveau-general-premiere', false);
                afficherBloc('type-niveau-general-terminale', false);
            }
        } else {
            const idsToutMasquer = [
                'cycle-container', 'niveau-etude-general1', 'niveau-etude-general2', 
                'niveau-etude-technique', 'type-niveau-technique-seconde', 
                'type-niveau-technique-premiere', 'type-niveau-technique-terminale',
                'type-niveau-general-seconde', 'type-niveau-general-premiere', 
                'type-niveau-general-terminale'
            ];
            idsToutMasquer.forEach(id => afficherBloc(id, false));
        }

        verifierSectionMoyennePhoto();
    }

    // 3. SYNCHRONISATION DES CHAMPS MASQUÉS
    function mettreAJourChampsCaches() {
        const typeEnseignement = getVal('type_enseignement');
        const cycleSelect = getEl('cycle');

        let niveauFinal = '';
        let typeNiveauFinal = '';
        let typeNiveau2 = '';
        let scolariteId = '';

        if (typeEnseignement === 'general') {
            const cycleVal = getVal('cycle');
            if (cycleVal === 'Premier Cycle') {
                const sel = getEl('niveau-general-etude1');
                if (sel && sel.selectedIndex > 0) {
                    const opt = sel.options[sel.selectedIndex];
                    typeNiveau2 = opt.text.trim();
                    scolariteId = opt.value;
                } else {
                    typeNiveau2 = 'Non Spécifié';
                }
                niveauFinal = 'Non Spécifié';
                typeNiveauFinal = 'Pas Spécifié';

            } else if (cycleVal === 'Second Cycle') {
                typeNiveau2 = 'Non Spécifié';

                const selNiveau = getEl('niveau-general-etude2');
                if (selNiveau && selNiveau.selectedIndex > 0) {
                    niveauFinal = selNiveau.options[selNiveau.selectedIndex].text.trim();
                }

                const idsGen = ['type-niveau-seconde-general', 'type-niveau-premiere-general', 'type-niveau-terminale-general'];
                idsGen.forEach(id => {
                    const sel = getEl(id);
                    if (sel && sel.selectedIndex > 0) {
                        const opt = sel.options[sel.selectedIndex];
                        typeNiveauFinal = opt.text.trim();
                        scolariteId = opt.value;
                    }
                });

                if (!typeNiveauFinal) {
                    typeNiveauFinal = 'Pas Spécifié';
                }
            } else {
                typeNiveau2 = 'Non Spécifié';
            }

        } else if (typeEnseignement === 'technique') {
            typeNiveau2 = 'Non Spécifié';

            if (cycleSelect) {
                cycleSelect.value = 'Second Cycle';
            }

            const selNiveau = getEl('niveau-technique-etude');
            if (selNiveau && selNiveau.selectedIndex > 0) {
                niveauFinal = selNiveau.options[selNiveau.selectedIndex].text.trim();
            }

            const idsTech = [
                'type-niveau-technique-seconde', 
                'type-niveau-technique-premiere', 
                'type-niveau-technique-terminale',
                'type-niveau-seconde-technique',
                'type-niveau-premiere-technique',
                'type-niveau-terminale-technique'
            ];

            idsTech.forEach(id => {
                let sel = getEl(id);
                if (sel && sel.tagName !== 'SELECT') {
                    sel = sel.querySelector('select');
                }
                
                if (sel && sel.selectedIndex > 0) {
                    const opt = sel.options[sel.selectedIndex];
                    typeNiveauFinal = opt.text.trim();
                    scolariteId = opt.value;
                }
            });

            if (!typeNiveauFinal) {
                typeNiveauFinal = 'Pas Spécifié';
            }
        } else {
            typeNiveau2 = 'Non Spécifié';
        }

        // Assignation sécurisée des valeurs masquées
        function setInputValue(id, val, nameAttr) {
            let input = getEl(id);
            if (!input && nameAttr) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.id = id;
                input.name = nameAttr;
                const form = document.querySelector('form');
                if (form) form.appendChild(input);
            }
            if (input) input.value = val;
        }

        setInputValue('niveau_etude_final', niveauFinal, 'niveau_etude_final');
        setInputValue('type_niveau_final', typeNiveauFinal, 'type_niveau_final');
        setInputValue('type_niveau2', typeNiveau2, 'type_niveau2');
        setInputValue('scolarite_id', scolariteId, 'scolarite_id');
    }

    // Écouteur global sur tous les sélecteurs
    document.addEventListener('change', function (e) {
        if (e.target && e.target.tagName === 'SELECT') {
            gererAffichageCascade();
            mettreAJourChampsCaches();
        }
    });

    // Synchronisation avant soumission
    const formElement = document.querySelector('form');
    if (formElement) {
        formElement.addEventListener('submit', function () {
            mettreAJourChampsCaches();
        });
    }

    // Initialisation globale au chargement
    gererAffichageCascade();
    mettreAJourChampsCaches();
});
</script>
@endsection