<?php

use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use App\Admin\Controllers\PersonnelController;
use App\Admin\Controllers\PaiementButtonController;
use App\Admin\Controllers\DonnateurButtonController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
     $router->resource('administrations', AdministrationController::class);
    $router->resource('affectations', AffectationController::class);
    $router->resource('annee-scolaires', AnneeScolaireController::class);
    $router->resource('apprenants', ApprenantController::class);
    $router->resource('bulletins', BulletinController::class);
    $router->resource('classes', ClasseController::class);
    $router->resource('decisions', DecisonController::class);
    $router->resource('etablissements', EtablissementController::class);
    $router->resource('etablissementannees', EtablissementanneeController::class);
    $router->resource('evaluations', EvaluationController::class);
    $router->resource('inscriptions', InscriptionController::class);
    $router->resource('matieres', MatiereController::class);
    $router->resource('modalites', ModaliteController::class);
     $router->resource('annee-periodiques', AnneePeriodiqueController::class);
    $router->resource('paiements', PaiementController::class);
    $router->resource('paiement-buttons', PaiementButtonController::class);
    #ParentEleves: c'est le model de la table parents, j'ai du le renommer pour eviter les conflits avec le model Parent qui existe deja dans Laravel et qui est utilisé pour la gestion des utilisateurs.
    $router->resource('recus', RecuController::class);
    $router->resource('classe-apprenant', ClasseapprenantController::class);
     $router->resource('bulletins-matieres', BulletinsMatiereController::class);
      $router->resource('users', UsersController::class);
      $router->resource('recus', RecuController::class);
     $router->resource('donnateurs', DonnateurController::class);
     $router->resource('donnateurs-buttons', DonnateurButtonController::class);
      $router->resource('footers', FooterController::class);
       $router->resource('headers', HeaderController::class);
       $router->resource('a-propos', AProposController::class);
    $router->resource('scolarites', ScolariteController::class);
        $router->resource('evenements', EvenementController::class);
        $router->resource('accueils', AccueilController::class);
    $router->resource('inscriptions-pages', InscriptionsPageController::class);
     $router->resource('paiements-pages', PaiementsPageController::class);
      $router->resource('donateurs-pages', DonateursPageController::class);
      //$router->resource('roles', RolesController::class);
      $router->resource('permissions', PermissionsController::class);
      //$router->resource('admin-users', AdminUsersController::class);
      //$router->resource('auth/users', AdminUsersController::class);

      //Personnels-Administrations
      $router->resource('personnels', PersonnelController::class);
       $router->resource('educateurs', EducateurController::class);
      $router->resource('professeurs', ProfesseurController::class);
      $router->resource('vigiles', VigileController::class);
        $router->resource('personnels-nettoyages', PersonnelsNettoyageController::class);
     
     Route::get('paiements/valider/{id}', [PaiementButtonController::class, 'valider']);
     Route::get('paiements/rejeter/{id}', [PaiementButtonController::class, 'rejeter']);

     Route::get('donnateurs/valider/{id}', [DonnateurButtonController::class, 'valider']);
     Route::get('donnateurs/rejeter/{id}', [DonnateurButtonController::class, 'rejeter']);

     // Utilisez $router->get au lieu de Route::get dans ce fichier
$router->get('api/fonctions', function (Request $request) {
    $q = $request->get('q'); 

    $mapping = [
        'Administration' => [
            'Directeur' => 'Directeur', 
            'Secrétaire' => 'Secrétaire', 
            'Comptable' => 'Comptable'
        ],
        'Pédagogie' => [
            'Professeur' => 'Professeur', 
            'Educateur' => 'Educateur'
        ],
        'Sécurité' => [
            'Vigile' => 'Vigile'
        ],
        'Entretien' => [
            'Agent de Nettoyage' => 'Agent de Nettoyage'
        ],
    ];

    return $mapping[$q] ?? [];
});

});
