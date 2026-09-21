<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Header;
use App\Models\Footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ResetPasswordNotification;

class ForgotPasswordController extends Controller
{
    // 1. Afficher le formulaire "Mot de passe oublié"
    public function forgotPassword()
    {
        $headers = Header::all();
        $footers = Footer::all();

        return view('comptes.forgot-password', compact('headers', 'footers'));
    }

    // 2. Traiter la demande et envoyer l'email avec le lien
    public function sendResetLink(Request $request)
{
    // La validation doit vérifier l'existence de l'email dans la table 'users'
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ], [
        'email.exists' => 'Aucun compte n\'est associé à cette adresse email.',
    ]);

    $token = Str::random(64);

    // Insertion ou mise à jour du token dans password_reset_tokens
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => Hash::make($token),
            'created_at' => now(),
        ]
    );

    $user = User::where('email', $request->email)->first();
    $user->notify(new ResetPasswordNotification($token, $request->email));

    return back()->with('success', 'Un lien de réinitialisation vous a été envoyé par email.');
}

    // 3. Afficher le formulaire de saisie du nouveau mot de passe
    public function resetPassword($token)
    {
        $headers = Header::all();
        $footers = Footer::all();
        $email = request()->query('email');

        return view('comptes.reset-password', compact('token', 'email', 'headers', 'footers'));
    }

    // 4. Mettre à jour le mot de passe dans la base de données
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // Vérification de la validité du token
        if (!$resetData || !Hash::check($request->token, $resetData->token)) {
            return back()->with('error', 'Le jeton de réinitialisation est invalide ou a expiré.');
        }

        // Mise à jour du mot de passe de l'utilisateur
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Suppression du jeton utilisé
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('connexion')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
    }
        }