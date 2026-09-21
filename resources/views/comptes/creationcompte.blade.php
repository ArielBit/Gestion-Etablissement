<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création du Compte | {{ $etablissement->etablissement->nom }}</title>
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
            padding: 30px 20px;
        }
        .register-box {
            background: #11141b;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 550px;
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
        /* Style personnalisé pour les radios boutons en mode sombre */
        .form-check-input {
            background-color: #0b0d12;
            border-color: rgba(255,255,255,0.1);
        }
        .form-check-input:checked {
            background-color: #f2c75c;
            border-color: #f2c75c;
        }
        .form-check-input:focus {
            box-shadow: 0 0 8px rgba(242, 199, 92, 0.2);
            border-color: #f2c75c;
        }
    </style>
</head>
<body>

    <div class="register-box">
        
        <div class="text-center mb-4">
            <span class="sub-title mb-1">Rejoindre la plateforme</span>
            <h3 class="text-white m-0">Créer un compte</h3>
            <p class="text-white-50 small mt-2">Remplissez les informations ci-dessous pour vous inscrire</p>
        </div>

        <form method="POST" action="{{ route('createcompteusers') }}">
            @csrf

            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label for="nom" class="form-label text-white-50 small text-uppercase tracking-wider" style="font-size: 11px;">Nom</label>
                    <div class="position-relative">
                        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                            <i class="fas fa-user-tile"></i>
                        </span>
                        <input type="text" class="form-control custom-input" placeholder="Votre nom" name="nom" id="nom" value="{{ old('nom') }}" required>
                    </div>
                </div>

                <div class="col-sm-6 mb-3">
                    <label for="prenom" class="form-label text-white-50 small text-uppercase tracking-wider" style="font-size: 11px;">Prénom</label>
                    <div class="position-relative">
                        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                            <i class="fas fa-user-signature"></i>
                        </span>
                        <input type="text" class="form-control custom-input" placeholder="Votre prénom" name="prenom" id="prenom" value="{{ old('prenom') }}" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="Email" class="form-label text-white-50 small text-uppercase tracking-wider" style="font-size: 11px;">Adresse Email</label>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" class="form-control custom-input @error('email') is-invalid @enderror" placeholder="Ex: contact@domaine.com" name="email" id="Email" value="{{ old('email') }}" required>
                </div>
                @error('email')
    <div class="text-danger small mt-1">
        <i class="fas fa-exclamation-circle me-1"></i> 
        @if($message === 'validation.unique' || Str::contains($message, 'unique'))
            Cette adresse email est déjà associée à un compte existant.
        @else
            {{ $message }}
        @endif
    </div>
@enderror
            </div>

            <div class="mb-3 p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <label class="form-label text-white-50 small text-uppercase tracking-wider d-block mb-2" style="font-size: 11px;">Type de compte</label>
                <div class="d-flex flex-wrap gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="parent" name="role" value="parent" {{ old('role') === 'parent' ? 'checked' : '' }} required>
                        <label class="form-check-label text-white small" for="parent">Parent</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="eleve" name="role" value="eleve" {{ old('role') === 'eleve' ? 'checked' : '' }} required>
                        <label class="form-check-label text-white small" for="eleve">Élève</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="donateur" name="role" value="donateur" {{ old('role') === 'donateur' ? 'checked' : '' }} required>
                        <label class="form-check-label text-white small" for="donateur">Donateur</label>
                    </div>
                </div>
                @error('role')
                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label text-white-50 small text-uppercase tracking-wider" style="font-size: 11px;">Nom d'utilisateur</label>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                        <i class="fas fa-at"></i>
                    </span>
                    <input type="text" class="form-control custom-input" placeholder="Choisissez un pseudonyme" name="username" id="username" value="{{ old('username') }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label text-white-50 small text-uppercase tracking-wider" style="font-size: 11px;">Mot de passe</label>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" class="form-control custom-input" placeholder="Créez un mot de passe sécurisé" name="password" id="password" required>
                </div>
            </div>

            <div class="mb-4">
                <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center">
                    <i class="fas fa-user-plus me-2"></i> S'inscrire
                </button>
            </div>

            <div class="text-center pt-3 border-top border-secondary border-opacity-25">
                <p class="text-white-50 small mb-0">
                    Vous possédez déjà un compte ? 
                    <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-bold ms-1">Se connecter</a>
                </p>
                <a href="{{ route('accueil') }}" class="d-inline-block text-white-50 small text-decoration-none mt-2">
                    <i class="fas fa-arrow-left me-1" style="font-size: 10px;"></i> Retour à l'accueil
                </a>
            </div>

        </form>

    </div>

</body>
</html>