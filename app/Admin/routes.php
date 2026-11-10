<?php

use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use App\Admin\Controllers\PersonnelController;
use App\Admin\ControllersProfEducController;
use App\Admin\Controllers\PaiementButtonController;
use App\Admin\Controllers\DonnateurButtonController;
use App\Admin\Controllers\BulletinsMatiereController;
use App\Admin\Controllers\Evaluation;

Admin::routes();
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    //Notes evaluations
    $router->get('evaluations/saisie-globale', 'EvaluationController@saisieGlobale');
    $router->get('bulletins/calculer', 'BulletinController@calculerMoyennesGenerales');
    $router->post('evaluations/saisie-globale', 'EvaluationController@storeSaisieGlobale');
    $router->get('bulletins-matieres/calculer', [BulletinsMatiereController::class, 'calculerMoyennes']);
    $router->resource('bulletins-matieres', BulletinsMatiereController::class);
    $router->resource('evaluations', EvaluationController::class);

    $router->get('/', 'HomeController@index')->name('home');
     //$router->resource('administrations', AdministrationController::class);
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
       $router->resource('parametres-globaux', ParametresGlobauxController::class);
       $router->resource('periodes-scolaires', PeriodesScolaireController::class);
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
      $router->resource('educateurs-scolaritesniveaux', EducateursScolaritesniveauxController::class);
         
          
        /*
        **EDUCATEUR
        */
         $router->resource('apprenant-educ', ApprenantEducController::class);
          $router->resource('professeur-educ', ProfesseurEducController::class);
          $router->resource('matiere-classe', MatiereClasseController::class);

           /*
        **PROFESSEUR
        */
         $router->resource('apprenant-prof', ApprenantProfController::class);
          $router->resource('educ-prof', EducateurProfController::class);


          //Global
          $router->resource('matiere-classes', MatiereClasseController2::class);

     
     Route::get('paiements/valider/{id}', [PaiementButtonController::class, 'valider']);
     Route::get('paiements/rejeter/{id}', [PaiementButtonController::class, 'rejeter']);

     Route::get('donnateurs/valider/{id}', [DonnateurButtonController::class, 'valider']);
     Route::get('donnateurs/rejeter/{id}', [DonnateurButtonController::class, 'rejeter']);

     $router->get('api/trimestres-par-annee', 'ParametresGlobauxController@getTrimestresByAnnee');
    $router->get('api/semestres-par-annee', 'ParametresGlobauxController@getSemestresByAnnee');

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

//Filtrage des classes

$router->get('api/classes', function (\Illuminate\Http\Request $request) {

    $niveau = \App\Models\Scolarite::find($request->get('q'));

    if (!$niveau) {
        return [];
    }

    // Correspondance entre les niveaux et les classes
    $correspondances = [

        'Sixième (6ème)' => [
            'Sixième 1 (6ème 1)',
            'Sixième 2 (6ème 2)',
            'Sixième 3 (6ème 3)',
        ],

        'Cinquième (5ème)' => [
            'Cinquième 1 (5ème 1)',
            'Cinquième 2 (5ème 2)',
            'Cinquième 3 (5ème 3)',
        ],

        'Quatrième (4ème)' => [
            'Quatrième 1 (4ème 1)',
            'Quatrième 2 (4ème 2)',
            'Quatrième 3 (4ème 3)',
        ],

        'Troisième (3ème)' => [
            'Troisième 1 (3ème 1)',
            'Troisième 2 (3ème 2)',
            'Troisième 3 (3ème 3)',
        ],

        'Seconde A1 (2nde A1)' => [
            'Seconde A1-1 (2nde A1-1)',
            'Seconde A1-2 (2nde A1-2)',
            'Seconde A1-3 (2nde A1-3)',
        ],

        'Seconde A2 (2nde A2)' => [
            'Seconde A2-1 (2nde A2-1)',
            'Seconde A2-2 (2nde A2-2)',
            'Seconde A2-3 (2nde A2-3)',
        ],

        'Seconde B (2nde B)' => [
            'Seconde B-1 (2nde B-1)',
            'Seconde B-2 (2nde B-2)',
            'Seconde B-3 (2nde B-3)',
        ],

        'Seconde C (2nde C)' => [
            'Seconde C-1 (2nde C-1)',
            'Seconde C-2 (2nde C-2)',
            'Seconde C-3 (2nde C-3)',
        ],

        'Seconde D (2nde D)' => [
            'Seconde D-1 (2nde D-1)',
            'Seconde D-2 (2nde D-2)',
            'Seconde D-3 (2nde D-3)',
        ],

        'Seconde E (2nde E)' => [
            'Seconde E-1 (2nde E-1)',
            'Seconde E-2 (2nde E-2)',
            'Seconde E-3 (2nde E-3)',
        ],

        'Seconde F1 (2nde F1)' => [
            'Seconde F1-1 (2nde F1-1)',
            'Seconde F1-2 (2nde F1-2)',
            'Seconde F1-3 (2nde F1-3)',
        ],

        'Seconde F2 (2nde F2)' => [
            'Seconde F2-1 (2nde F2-1)',
            'Seconde F2-2 (2nde F2-2)',
            'Seconde F2-3 (2nde F2-3)',
        ],

        'Seconde G1 (2nde G1)' => [
            'Seconde G1-1 (2nde G1-1)',
            'Seconde G1-2 (2nde G1-2)',
            'Seconde G1-3 (2nde G1-3)',
        ],

        'Seconde G2 (2nde G2)' => [
            'Seconde G2-1 (2nde G2-1)',
            'Seconde G2-2 (2nde G2-2)',
            'Seconde G2-3 (2nde G2-3)',
        ],

    ];

    // Ajouter les niveaux Première et Terminale
    $series = ['A1', 'A2', 'B', 'C', 'D', 'E', 'F1', 'F2', 'G1', 'G2'];

    foreach ($series as $serie) {

        $correspondances["Première {$serie} (1ère {$serie})"] = [
            "Première {$serie}-1 (1ère {$serie}-1)",
            "Première {$serie}-2 (1ère {$serie}-2)",
            "Première {$serie}-3 (1ère {$serie}-3)",
        ];

        $correspondances["Terminale {$serie} (Tle {$serie})"] = [
            "Terminale {$serie}-1 (Tle {$serie}-1)",
            "Terminale {$serie}-2 (Tle {$serie}-2)",
            "Terminale {$serie}-3 (Tle {$serie}-3)",
        ];
    }

    // Récupérer les classes correspondant au niveau sélectionné
    $nomsClasses = $correspondances[$niveau->classes] ?? [];

    // Retourner les options au format attendu par Laravel-Admin
    return array_combine($nomsClasses, $nomsClasses) ?: [];

});

});
