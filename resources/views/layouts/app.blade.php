<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('asset/assets/img/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('asset/assets/img/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('asset/assets/img/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('asset/assets/img/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('asset/assets/img/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('asset/assets/img/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('asset/assets/img/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('asset/assets/img/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('asset/assets/img/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('asset/assets/img/favicons/ar.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('asset/assets/img/favicons/ar.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('asset/assets/img/favicons/ar.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('asset/assets/img/favicons/ar.png') }}">
    <link rel="manifest" href="{{ asset('asset/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('asset/assets/img/favicons/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('asset/assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{ asset('asset/assets/css/fontawesome.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('asset/assets/css/magnific-popup.min.css') }}">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="{{ asset('asset/assets/css/swiper-bundle.min.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('asset/assets/css/style.css') }}">
    <!-- COMPTE UTILISATEUR -->
    <link rel="stylesheet" href="{{ asset('css/compte.css') }}">
    <title>@yield('title')</title>
</head>
<body>
    <!--HEADER-->
  <header>
    <!--==============================
     Preloader
  ==============================-->
    <div class="preloader ">
        <button class="th-btn preloaderCls">Annuler le Préchargeur </button>
        <div class="preloader-inner">
            <img src="{{ asset('asset/assets/img/ari.jpg') }}" alt="img" style="width:200px; height:200px; border-radius:50%;">
            <span class="loader">
                ARIELBIT
                <span class="loading-text">ARIELBIT</span>
            </span>
        </div>
    </div><!--==============================
    Sidemenu
============================== -->

<!--==============================
	DEBUT PARTIE 1 HEADER
==============================-->
    <header class="th-header header-layout1">
        @foreach($headers as $header)
        <div class="header-top">
            <div class="container th-container4">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto d-none d-lg-block">
                        
                    </div>
                    <div class="col-auto">
                        <div class="header-links">
                            <ul class="header-right-wrap">
                                <li><i class="fa-solid fa-user"></i>
                                <!--Utilisateur Connecté-->
                                 @guest
                                <a href="{{route('connexion')}}">Se Connecter</a> / 
                                <a href="{{route('creationcompte')}}">S'inscrire</a>
                                @endguest

                                 <!--Utilisateur Connecté-->
                                @auth
                                <a href="{{route('comptes')}}">Mon Compte</a></li>
                                @endauth
                                <li><i class="fas fa-comments"></i><a href="{{route('apropos')}}">FAQ</a></li>
                                <li>
                                    <div class="dropdown-link">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false"> </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink2">
                                            <li>
                                                <a href="#">German</a>
                                                <a href="#">French</a>
                                                <a href="#">Italian</a>
                                                <a href="#">Latvian</a>
                                                <a href="#">Spanish</a>
                                                <a href="#">Greek</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-info d-none d-sm-block">
            <div class="container th-container2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="{{route('accueil')}}">
                                <img src="{{ asset('asset/assets/img/ari.jpg') }}" alt="img" style="width:200px; height:200px; border-radius:50%;">
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-info-right">
                            <div class="header-info-item">
                                <div class="header-info-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="header-info-content">
                                    <span class="header-info-text">Address</span>
                                    <h3 class="header-info-title">
                                        <a href="#">{{$header->adress}}</a>
                                    </h3>
                                </div>
                            </div>
                            <div class="header-info-item">
                                <div class="header-info-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="header-info-content">
                                    <span class="header-info-text">Email</span>
                                    <h3 class="header-info-title">
                                        <a href="mailto:arielbit007@gmail.com">{{$header->email}}</a>
                                    </h3>
                                </div>
                            </div>
                            <div class="header-info-item">
                                <div class="header-info-icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div class="header-info-content">
                                    <span class="header-info-text">Numéro de Téléphone</span>
                                    <h3 class="header-info-title">
                                        <a href="tel:+2250123456789">{{$header->numero}}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FIN PARTIE 1 HEADER -->

         <!-- DEBUT PARTIE 2 HEADER -->
            <div class="menu-area">
                <div class="container th-container2">
                    <div class="menu-wrapp">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <div class="header-left d-flex align-items-center">
                                    <div class="header-logo d-block d-sm-none">
                                        <a href="home-university.html">
                                            <img src="{{ asset('asset/assets/img/logo.svg') }}" alt="Stadum">
                                        </a>
                                    </div>
                                    <div class="header-button d-none d-sm-block">
                                        <a href="{{ route('apropos') }}" class="th-btn">
                                            Obtenir Plus d'Informations
                                            <img src="{{ asset('asset/assets/img/icon/right-icon.svg') }}" class="th-arrow" alt="icon">
                                        </a>
                                    </div>
                                    <nav class="main-menu d-none d-xl-block">
                                        <ul>
                                            <li>
                                                @auth
                                                <!--Utilisateur Connecté-->
                                                <a href="{{route('accueil')}}">Accueil</a>
                                                @endauth

                                                @guest
                                                <!--Utilisateur Non Connecté-->
                                                <a href="{{route('accueil')}}">Accueil</a>
                                                @endguest
                                            </li>
                                            <li>
                                                @auth
                                                <!--Utilisateur Connecté-->
                                                <a href="{{route('evenement')}}">Agenda & Évènements</a>
                                                @endauth

                                                @guest
                                                <!--Utilisateur Non Connecté-->
                                                <a href="{{route('evenement')}}">Agenda & Évènements</a>
                                                @endguest
                                            </li>
                                           
                                            <li>
                                                @auth
                                                <!--Utilisateur Connecté-->
                                                <a href="{{route('inscription')}}">Inscriptions</a>
                                                @endauth

                                                @guest
                                                <!--Utilisateur Non Connecté-->
                                                <a href="{{route('inscription')}}">Inscriptions</a>
                                                @endguest
                                            </li>
                                            <li>
                                                 @auth
                                                <!--Utilisateur Connecté-->
                                                <a href="{{route('paiement')}}">Paiements</a>
                                                @endauth

                                                @guest
                                                <!--Utilisateur Non Connecté-->
                                                <a href="{{route('paiement')}}">Paiements</a>
                                                @endguest
                                            </li>
                                            <li>
                                                @auth
                                                <!--Utilisateur Connecté-->
                                                <a href="{{route('donnateur')}}">Donateurs</a>
                                                @endauth
                                                 @guest
                                                <!--Utilisateur Non Connecté-->
                                                <a href="{{route('donnateur')}}">Donateurs</a>
                                                @endguest

                                                
                                            </li>
                                            <li>
                                                @auth
                                                 <!--Utilisateur Connecté-->
                                                 <a href="{{route('apropos')}}">A Propos</a>
                                                 @endauth

                                                 @guest
                                                 <!--Utilisateur Non Connecté-->
                                                 <a href="{{route('apropos')}}">A Propos</a>
                                                 @endguest
                                                
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-auto ms-lg-auto">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         @endforeach
    </header>

    <!-- FIN PARTIE 2 HEADER -->

  <!--MAIN-->
  <main>
  @yield('content')
  </main>

  <footer class="footer-wrapper footer-default footer-overlay" style="background-color: #0b111e !important; background-image: none !important;">
    @foreach($footers as $footer)
    <div class="container">
        <div class="widget-area">
            <div class="row justify-content-between">
                <div class="col-md-6 col-xl-auto">
                    <div class="widget footer-widget">
                        <div class="th-widget-about">
                            <h3 class="widget_title">{{$footer->titre}}</h3>
                            <p class="about-text">{{$footer->description}}

                             </p>
                            <div class="footer-info">
                                <a href="#">
                                    <span class="footer-info-icon"><i class="fa-solid fa-location-dot"></i></span>@foreach($headers as $header) {{$header->adress}}
                                </a>
                                <a href="mailto:arielbit007@gmail.com">
                                    <span class="footer-info-icon"><i class="fa-solid fa-envelope"></i></span> {{$header->email}}@endforeach
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-auto">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">Liens Utiles</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <li><a href="{{route('evenement')}}">Evènements</a></li>
                                <li><a href="{{route('paiement')}}">Paiement</a></li>
                                <li><a href="{{route('apropos')}}">A Propos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-auto">
                    <div class="widget th-widget-instagram footer-widget">
                        <h3 class="widget_title">Instagram</h3>
                        <div class="instagram-feeds">
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m0.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m0.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m2.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m2.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m3.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m2.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m4.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m4.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m5.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m5.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m6.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m6.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m7.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m7.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="insta-thumb">
                                <img src="{{ asset('asset/assets/img/widget/m8.jpg') }}" alt="Image">
                                <a href="{{ asset('asset/assets/img/widget/m8.jpg') }}" class="insta-btn popup-image"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap z-index-common">
        <div class="container">
            <div class="row justify-content-center gy-3 align-items-center">
                <div class="col-lg-6">
                    <p class="copyright-text">
                        <i class="fal fa-copyright"></i>{{$footer->copyright_un}}  <a href="{{route('accueil')}}">{{$footer->copyright_lien}}</a>{{$footer->copyright_deux}} @endforeach
                    </p>
                </div>
                <div class="col-lg-6 text-lg-end text-center">
                    <div class="footer-links">
                        <ul>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of services</a></li>
                            <li><a href="#">Disclaimer</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

  
<!--============================== -->
    <!-- Jquery -->
    <script src="{{ asset('asset/assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <!-- Swiper Js -->
    <script src="{{ asset('asset/assets/js/swiper-bundle.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('asset/assets/js/bootstrap.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('asset/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Counter Up -->
    <script src="{{ asset('asset/assets/js/jquery.counterup.min.js') }}"></script>
    <!-- Range Slider -->
    <script src="{{ asset('asset/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Isotope Filter -->
    <script src="{{ asset('asset/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('asset/assets/js/isotope.pkgd.min.js') }}"></script>
    <!-- Wow Js -->
    <script src="{{ asset('asset/assets/js/wow.min.js') }}"></script>

    <!-- Gsap Animation -->
    <script src="{{ asset('asset/assets/js/gsap.min.js') }}"></script>
    <!-- ScrollTrigger -->
    <script src="{{ asset('asset/assets/js/ScrollTrigger.min.js') }}"></script>
    <!-- SplitText -->
    <script src="{{ asset('asset/assets/js/SplitText.min.js') }}"></script>
    <!-- Lenis Js -->
    <script src="{{ asset('asset/assets/js/lenis.min.js') }}"></script>
    <!-- Main Js File -->
    <script src="{{ asset('asset/assets/js/main.js') }}"></script>
</body>
</html>