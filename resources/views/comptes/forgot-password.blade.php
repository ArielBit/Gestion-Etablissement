@extends('layouts.app') 

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Mot de passe oublié</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Entrez l'adresse email associée à votre compte pour recevoir un lien de réinitialisation.</p>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="exemple@mail.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('connexion') }}" class="text-decoration-none">Retour à la connexion</a>
                            <button type="submit" class="btn btn-primary">Envoyer le lien</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection