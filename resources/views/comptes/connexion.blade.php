<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion au Compte | {{ $etablissement->etablissement->nom }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #0b0d12;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .login-box {
            background: #11141b;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }
        .sub-title {
            color: #f2c75c;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 700;
            display: block;
        }
        .custom-input {
            background-color: #0b0d12 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            padding: 12px 12px 12px 42px !important;
            border-radius: 6px !important;
            transition: all 0.3s ease;
        }
        .custom-input:focus {
            border-color: #f2c75c !important;
            box-shadow: 0 0 8px rgba(242, 199, 92, 0.2) !important;
            background-color: #0b0d12 !important;
        }
        .custom-input::placeholder {
            color: rgba(255, 255, 255, 0.3) !important;
        }
        /* Style du bouton d'action principal (Inspiré de th-btn) */
        .btn-submit {
            background-color: #f2c75c;
            color: #0b0d12;
            font-weight: 700;
            border: none;
            padding: 12px;
            border-radius: 50px;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-submit:hover {
            background-color: #e0b54a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(242, 199, 92, 0.2);
            color: #0b0d12;
        }
    </style>
</head>
<body>

    <div class="login-box">
        
        <div class="text-center mb-4">
            <span class="sub-title mb-1">Portail Sécurisé</span>
            <h3 class="text-white m-0">CPNTIC</h3>
            <p class="text-white-50 small mt-2">Accédez à votre espace d'apprentissage et de gestion</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="login" class="form-label text-white-50 small text-uppercase tracking-wider" style="font-size: 11px;">Identifiant</label>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" class="form-control custom-input" placeholder="Email ou Nom d'utilisateur" name="login" id="login" required autocomplete="username">
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label text-white-50 small text-uppercase tracking-wider" style="font-size: 11px;">Mot de passe</label>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" class="form-control custom-input" placeholder="Votre mot de passe" name="password" id="password" required autocomplete="current-password">
                </div>
            </div>

            <div class="mb-4">
                <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center">
                    <i class="fas fa-sign-in-alt me-2"></i> Se connecter
                </button>
            </div>

            <div class="mb-4" >
            <a href="{{ route('password.request') }}" class="text-warning text-decoration-none fw-bold ms-1">Mot de passe oublié ?</a>
            </div>

            <div class="text-center pt-3 border-top border-secondary border-opacity-25">
                <p class="text-white-50 small mb-0">
                    Nouveau sur la plateforme ? 
                    <a href="{{ route('inscription') }}" class="text-warning text-decoration-none fw-bold ms-1">Créer un compte</a>
                </p>
                <a href="{{ route('accueil') }}" class="d-inline-block text-white-50 small text-decoration-none mt-2">
                    <i class="fas fa-arrow-left me-1" style="font-size: 10px;"></i> Retour à l'accueil
                </a>
            </div>

        </form>

    </div>

</body>
</html>