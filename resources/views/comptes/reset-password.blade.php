@extends('layouts.app') {{-- Remplacez par votre layout principal --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Réinitialisation du mot de passe</h4>
                </div>
                <div class="card-body">

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        {{-- Champs cachés nécessaires pour la validation --}}
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email) }}" required readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="8 caractères minimum">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Répétez le mot de passe">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Mettre à jour le mot de passe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection