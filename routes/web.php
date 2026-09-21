<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralControllerController;
use App\Mail\TestScolariteMail;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/test-mail', function () {
    Mail::to('parent.test@example.com')->send(new TestScolariteMail());
    return "Le mail de simulation a été envoyé à Mailhog !";
});
Route::get('/', [GeneralControllerController::class,'accueil'])->name('accueil');
Route::get('/app', [GeneralControllerController::class,'footer'])->name('app');
Route::get('/appdeux', [GeneralControllerController::class,'header'])->name('appdeux');
Route::get('/evenement', [GeneralControllerController::class,'evenement'])->name('evenement');
//Inscription Apprenants
Route::get('/inscriptions-eleves', [GeneralControllerController::class,'inscription'])->name('inscription');
Route::get('/verification-inscription-eleves', [GeneralControllerController::class,'verificationInscription'])->name('verification-inscription')->middleware('auth');
Route::post('/verification-inscription-eleves', [GeneralControllerController::class,'verificationInscription'])->name('verification-inscription-eleves')->middleware('auth');
Route::post('/confirmation-inscription-eleves', [GeneralControllerController::class,'confirmationInscription'])->name('confirmation-inscription');
Route::get('/succes-inscription-eleves/{id}', [GeneralControllerController::class,'succesInscription'])->name('succes-inscription');
//Paiement de la Scolarité
Route::get('/paiement', [GeneralControllerController::class,'paiement'])->name('paiement');
Route::post('/paiement-scolarite', [GeneralControllerController::class,'paiementScolarite'])->name('paiement-scolarite')->middleware('auth');
Route::get('/paiement-attente/{id}', [GeneralControllerController::class,'paiementAttente'])->name('paiement-attente');
Route::get('/succes-paiement-scolarite', [GeneralControllerController::class,'succesPaiement'])->name('succes-paiement-scolarite');
Route::get('/reçu-paiement/{id}', [GeneralControllerController::class,'recu'])->name('reçu-paiement');
//A Propos de l'etablissement
Route::get('/a-propos', [GeneralControllerController::class,'apropos'])->name('apropos');
Route::get('/propos', [GeneralControllerController::class,'Propos'])->name('propos');
//Donnateur
Route::get('/donnateur', [GeneralControllerController::class,'donnateur'])->name('donnateur');
Route::post('/donnateur-submit', [GeneralControllerController::class,'donnateurSubmit'])->name('donnateur-submit')->middleware('auth');
Route::get('/paiement-attente-donnateur/{id}', [GeneralControllerController::class,'donnateurAttente'])->name('donnateur-paiement-attente');
Route::get('/succes-paiement-donnateur', [GeneralControllerController::class,'donnateurSucces'])->name('succes-paiement-donnateur');
Route::get('/reçu-paiement-donnateur/{id}', [GeneralControllerController::class,'donnateurRecu'])->name('recu-paiement-donnateur');
// Création des Comptes Utilisateurs
Route::get('/creation-du-compte', [GeneralControllerController::class,'creationcompte'])->name('creationcompte');
Route::post('/creation-du-compte', [GeneralControllerController::class,'createcompteusers'])->name('createcompteusers');
// Connexion des Utilisateurs
Route::get('/connexion', [GeneralControllerController::class,'connexion'])->name('connexion');
Route::post('/connexion', [GeneralControllerController::class,'login'])->name('login');
//Affichage du Compte
Route::get('/compte-utilisateur', [GeneralControllerController::class,'compte'])->name('comptes')->middleware('auth');
//Confirmation de la création du Compte
Route::get('/succes-compte', [GeneralControllerController::class,'succesCompte'])->name('succes-compte');
// Déconnexion des Utilisateurs
Route::post('/deconnexion-compte', [GeneralControllerController::class,'logout'])->name('logout')->middleware('auth');
Route::delete('/suppression-compte', [GeneralControllerController::class,'delete'])->name('delete')->middleware('auth');
//Modifier données utilisateurs
Route::get('/modifier-les-donnees', [GeneralControllerController::class,'modifie'])->name('modifie')->middleware('auth');
Route::patch('/modifier-les-donnees', [GeneralControllerController::class,'modifier'])->name('modifier')->middleware('auth');
Route::patch('/modifier-le-mot de passe', [GeneralControllerController::class,'modifi'])->name('modifi')->middleware('auth');

// Formulaire demande d'email et envoi du mail
Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

// Formulaire nouveau mot de passe et mise à jour
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');
    