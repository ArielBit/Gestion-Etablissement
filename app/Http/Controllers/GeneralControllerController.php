<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Etablissementannee;
use App\Models\Apprenant;
use App\Models\Paiement;
use App\Models\Donnateur;
use App\Models\Recu;
use App\Models\RecusDonnateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Footer;
use App\Models\Header;
use App\Models\APropo;
use App\Models\Evenement;
use App\Models\Scolarite;
use App\Models\Accueil;
use App\Mail\MailDonateur;
use App\Mail\MailInscriptions;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Log;



class GeneralControllerController extends Controller
{
    public function accueil (){
        $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);
        $headers = Header::all();
        $footers = Footer::all();
        $accueil =Accueil::findOrFail(1);

        return view('accueil', compact('headers','footers','accueil','etablissement'));

    }
    
    public function header (){
    $headers = Header::all();

        return view('layouts.app', compact('headers'));
    }


    public function footer (){
    $footers = Footer::all();

        return view('layouts.app', compact('footers'));
    }

    public function evenement (){
        $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);

        $headers = Header::all();
        $footers = Footer::all();
        $evenements = Evenement::findOrFail(1);

        return view('evenement', compact('footers','headers','evenements','etablissement'));
    }

    public function inscription (){
        $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);
        $annees = Etablissementannee::with('anneeScolaire')->get();
        $headers = Header::all();
         $footers = Footer::all();
         $inscriptions = Apprenant::findOrFail(57);
         $scolarites = Scolarite::all()->keyBy('classes');

        return view('inscriptions-apprenants.inscription', compact('annees','headers','footers','inscriptions','scolarites','etablissement'));
    }

    //Soumission et vérification des données soumis
    public function verificationInscription (Request $request){
        //dd($request->all());
         $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);
         $headers = Header::all();
        $footers = Footer::all();
        $scolarites = Scolarite::all();
        
        
        $request->validate([  

            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'nom'  => 'required|string',
            'prenom'  => 'required|string',
            'sexe' => 'required|string',
            'nationalite' => 'required|string',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'age' => 'required|string',
            #anneée scolaire
            'etablissementannees_id' => 'required',
            'type_enseignement' => 'required|string',
            'cycle' => 'nullable|string',
            'niveau_etude_final' => 'nullable|string',
            'type_niveau_final' => 'nullable|string',
            'type_niveau2' => 'nullable|string',
            #matricule
            'matricule' => 'nullable|string',
            'pere' => 'nullable|string',
            'tel_pere' => 'nullable|string',
            'email_pere' => 'nullable|email',
            'mere' => 'nullable|string',
            'tel_mere' => 'nullable|string',
            'email_mere' => 'nullable|email',
            'tuteur' => 'nullable|string',
            'tel_tuteur' => 'nullable|string',
            'email_tuteur' => 'nullable|email',
            'lieu_residence' => 'required|string',
            'photo_b' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'moyenne' => 'required|string'
        ]);
        

        //stockage temporaire de la photo
        $photopath = $request->file('photo')->store('temp', 'public');
        $photopaths = $request->file('photo_b')->store('temp', 'public');
        $data = $request->except(['photo', 'photo_b']);
        $data['photo']=$photopath;
        $data['photo_b']=$photopaths;
        $data['niveau_etude'] = $request->niveau_etude_final;
        $data['type_niveau'] = $request->type_niveau_final;
        //Affichage de l'année
        $annees = Etablissementannee::with('anneeScolaire')->findOrFail($data['etablissementannees_id']);

        //Stockage de la requête dans la session(cookies) de l'utilisateur
        session(['inscription_data'=> $data]);
        return view('inscriptions-apprenants.verification-inscription', compact('data','headers','footers','annees','scolarites','etablissement'));

    }

    //Réelle/Vraie Insertion des données de l'apprenant
    public function confirmationInscription() {
        
        if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour inscrire un élève.');
    }
         $headers = Header::all();
        $footers = Footer::all();
        $scolarites = Scolarite::all();

        $data= session('inscription_data');

         if (!$data) {
        return redirect()->back()
            ->with('error', 'Aucune donnée à confirmer.',compact('headers','footers','scolarites'));
    }

    $apprenant =Apprenant::create([
        'users_id' => Auth::id(),
        'photo' => $data['photo'],
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'sexe' => $data['sexe'],
        'nationalite' => $data['nationalite'],
        'date_naissance' => $data['date_naissance'],
        'lieu_naissance' => $data['lieu_naissance'],
        'age' => $data['age'],
        'etablissementannees_id' => $data['etablissementannees_id'],
        'type_enseignement' => $data['type_enseignement'],
        'cycle' => $data['cycle'],
        'niveau_etude' => $data['niveau_etude'],
        'type_niveau' => $data['type_niveau'],
        'type_niveau2' => $data['type_niveau2'] ?? null,
        'matricule' => $data['matricule']  ?? null,
        'pere' => $data['pere'] ?? null,
        'tel_pere' => $data['tel_pere'] ?? null,
        'email_pere' => $data['email_pere'] ?? null,
        'mere' => $data['mere'] ?? null,
        'tel_mere' => $data['tel_mere'] ?? null,
        'email_mere' => $data['email_mere'] ?? null,
        'tuteur' => $data['tuteur'] ?? null,
        'tel_tuteur' => $data['tel_tuteur'] ?? null,
        'email_tuteur' => $data['email_tuteur'] ?? null,
        'lieu_residence' => $data['lieu_residence'],
        'diplome_bulletin' =>$data['photo_b'],
        'moyennean_moyenexam' => $data['moyenne']
        
        ]);

        session()->forget('inscription_data');

        return redirect()->route('succes-inscription', ['id' => $apprenant->id_apprenants]);

        }

        //Page de Succès de l'insciption de l'Apprenant
        public function succesInscription ($id){
            $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);

        $succes= Apprenant::findOrFail($id);
        $headers = Header::all();
        $footers = Footer::all();
        $scolarites = Scolarite::all();

        return view('inscriptions-apprenants.succes-inscription', compact('succes','headers','footers','scolarites','etablissement'));
    }

    public function paiement (){

    // Somme des paiements valides pour chaque apprenants
    $apprenant = Apprenant::withSum(['paiements' => function($query) {
        $query->where('statut_paiement', 'VALIDE');
    }], 'montant_attendu')->get();

    $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);
    $headers = Header::all();
    $footers = Footer::all();
    $paiements = Paiement::findOrFail(68);
    $scolarites = Scolarite::all();
        return view('recu.paiement' ,compact('apprenant','footers','headers','paiements','scolarites','etablissement'));
    }

    public function paiementScolarite(Request $request){
    //dd($request->all());
    $request->validate([
        

    'apprenants_id' => 'required|exists:apprenants,id_apprenants',
    'modalite_final' => 'required|string',
    'tranche_final' => 'nullable|string',
    'choix_mois_final' => 'nullable|string',
    'choix_premier_mois_final' => 'nullable|string',
    'mode_paiement_final' => 'required|string',
    'banque_final' => 'required|string',
    'montant_attendu' => 'required',
    'reste_payer' => 'required|numeric|min:0',
    'type_frais' => 'required|string'
    ]);

    $annneescolaire= Apprenant::findOrFail($request->apprenants_id);

    $paiement=Paiement::create([

    'apprenants_id' => $request->apprenants_id,
    'modalite' => $request->modalite_final,
    'tranche_paiement' => $request->tranche_final,
    'choix_mois' => $request->choix_mois_final,
    'choix_premiermois' => $request->choix_premier_mois_final,
    'modes_paiement' => $request->mode_paiement_final,
    'banque' => $request->banque_final,
    'montant_attendu' => $request->montant_attendu,
    'date_paiement' => now(),
    'statut_paiement' => 'EN_ATTENTE',
    'etablissementannees_id' => $annneescolaire->etablissementannees_id,
    'users_id' => Auth::id(),
    'reste_payer' => $request->reste_payer,
    'type_frais' => $request->type_frais
    
    ]);

   
    return redirect()->route('paiement-attente', $paiement->id_paiements);

    }

    public function paiementAttente($id)
{
     $headers = Header::all();
        $footers = Footer::all();
    $paiement = Paiement::findOrFail($id);

    if ($paiement->statut_paiement === 'VALIDE') {

        $recu = Recu::where('paiements_id', $paiement->id_paiements)->first();

        return redirect()
            ->route('succes-paiement-scolarite')
            ->with('recu_id', $recu->id_reçus);
    }
    

    return view('recu.paiement-attente', compact('paiement','headers','footers'));
}

    public function succesPaiement()
{
    $headers = Header::all();
    $footers = Footer::all();
    $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);


    $recuId = session('recu_id');

    if (!$recuId) {
        return redirect()->back();
    }

    // 1. Correction du nom de relation (apprenant au singulier)
    $recu = Recu::with('paiement.apprenants')->find($recuId);

    if (!$recu || !$recu->paiement || !$recu->paiement->apprenants) {
        Log::error("Reçu ou apprenant introuvable pour le reçu ID: " . $recuId);
        return redirect()->back()->with('error', 'Reçu ou apprenant introuvable.');
    }

    $apprenant = $recu->paiement->apprenants;

    // 2. Extraction des emails valides enregistrés lors de l'inscription
    $emails = array_filter([
        $apprenant->email_pere,
        $apprenant->email_mere,
        $apprenant->email_tuteur,
    ]);

    // 3. Envoi du mail aux adresses trouvées
    if (!empty($emails)) {
        try {
            Mail::to($emails)->send(new MailInscriptions($recu));
        } catch (\Exception $e) {
            Log::error("Erreur d'envoi de mail : " . $e->getMessage());
        }
    } else {
        Log::warning("Aucun email renseigné à l'inscription pour l'apprenant ID: " . $apprenant->id_apprenants);
    }

    return view('recu.succes-paiement-scolarite', compact('recuId', 'footers', 'headers','etablissement'));
}

    public function apropos (){
            $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);

        $footers = Footer::all();
         $headers = Header::all();
         $propos = APropo::all();

        return view('apropos', compact('footers', 'headers','propos','etablissement'));
    }

    public function propos (){
        $propos = APropo::all();

        return view('apropos', compact('propos'));
    }

    
public function recu($id)
{
    $recu = Recu::with('paiement.apprenants',
     'paiement.etablissementannee.anneeScolaire',
     'paiement.etablissementannee.etablissement')
                ->findOrFail($id);

    $pdf = Pdf::loadView('recu.recu-paiement', compact('recu'));

    return $pdf->download('recu-'.$recu->reference.'.pdf');
}


    public function donnateur (){
        $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);
        $headers = Header::all();
        $footers = Footer::all();
        $donateurs =Donnateur::findOrFail(27);
    $annees =Etablissementannee::with('anneeScolaire')->get();

        return view('donnateur.donnateur', compact('annees','footers','headers','donateurs','etablissement'));
    }

    public function donnateurSubmit(Request $request){
        //dd($request->all());
    $request->validate([
        
    'nom' => 'nullable|string',
    'prenom' => 'nullable|string',
    'type_donnateurs' => 'required|string',
    'type_organisations' => 'nullable|string',
    'type_dons' => 'required|string',
    'don_vivres' => 'nullable|string',
    'quantite_donvivres' => 'nullable|string',
    'contacts' => 'required|string',
    'email' => 'required|email',
    'modes_paiement' => 'nullable|string',
    'banque' => 'nullable|string',
    'montant_attendu' => 'nullable',
    'etablissementannees_id' => 'required|exists:etablissementannees,id_etablissementannees',
    
    ]);


    $donnateur= Donnateur::create([

    'nom' => $request->nom,
    'prenom' => $request->prenom,
    'type_donnateurs' => $request->type_donnateurs,
    'type_organisations' => $request->type_organisations,
    'type_dons' => $request->type_dons,
    'don_vivres' => $request->don_vivres,
    'quantite_donvivres' => $request->quantite_donvivres,
    'modes_paiement' => $request->modes_paiement,
    'banque' => $request->banque,
    'contacts' => $request->contacts,
    'email' => $request->email,
    'montant_attendu' => $request->montant_attendu, 
    'date_paiement' => now(),
    'statut_paiement' => 'EN_ATTENTE',
    'etablissementannees_id' => $request->etablissementannees_id,
    'users_id' => Auth::id(),
    ]);

    
    
    return redirect()->route('donnateur-paiement-attente', $donnateur->id_donnateurs);
        
    } 

    public function donnateurAttente($id)
{
    $donnateur = Donnateur::findOrFail($id);
     $headers = Header::all();
        $footers = Footer::all();

    if ($donnateur->statut_paiement === 'VALIDE') {

        $recus = RecusDonnateur::where('donnateurs_id', $donnateur->id_donnateurs)->first();

        return redirect()
            ->route('succes-paiement-donnateur')
            ->with('recus_id', $recus->id_reçus);
    }
    
    

    return view('donnateur.paiement-donnateur-attente', compact('donnateur','headers','footers'));
}

public function donnateurSucces (){
    $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);
    $headers = Header::all();
        $footers = Footer::all();
        
        $recuId= session('recus_id');

         if (!$recuId) {
        return redirect()->back();

    }
    $recus = RecusDonnateur::with('donnateur')->find($recuId);

    if (!$recus || !$recus->donnateur) {
        return redirect()->back()->with('error', 'Reçu ou donateur introuvable.');
    }
    // --- ENVOI DU MAIL DE SIMULATION VIA MAILHOG APRES VALDATION DU PAIEMENT---
    try {
        Mail::to($recus->donnateur->email)->send(new MailDonateur($recus)); 
    } catch (\Exception $e) {
        // En local, on capture une éventuelle erreur pour ne pas bloquer l'application si Mailhog est éteint
        Log::error("Erreur d'envoi de mail : " . $e->getMessage());
    }

        return view('donnateur.succes-paiement-donnateur', compact('recuId','footers','headers','etablissement'));
    }

    public function donnateurRecu($id){
    $recus = RecusDonnateur::with(
     'donnateur.etablissementannee.anneeScolaire',
     'donnateur.etablissementannee.etablissement')
                ->findOrFail($id);

    $pdf = Pdf::loadView('donnateur.recu-paiement-donnateur', compact('recus'));

    return $pdf->download('recu-'.$recus->reference.'.pdf');
}


    public function creationcompte (){
        $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);

        return view('comptes.creationcompte', compact('etablissement'));
    }

    //Création des Comptes Utilisaturs
    public function createcompteusers(Request $request){

        $request-> validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'string|required|email|unique:users,email',
            'username' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:parent,eleve,donateur',
        ]);

        $user=User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        return redirect()->route('comptes');
    }

    public function succesCompte (){

        return view('comptes.succes-compte');
    }

    public function connexion (){
        $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);

        return view('comptes.connexion',compact('etablissement'));
    }

    //Connexion/Authentication des Utilisateurs
    public function login(Request $request){

        $request-> validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $field =filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(Auth::attempt([
            $field => $request-> login,
            'password' => $request-> password,
        ])){
            $request->session()->regenerate();

            return redirect()->route('comptes');
        }
        return back()
        ->withInput()
        ->with('error', 'Identifiants incorrects.');
    }

    //Déconnexion des Utilisateurs
    public function logout(Request $request){ 

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('accueil');
    }

    //Affichage du Compte Utilisateur
    public function compte()  {
     $etablissement = Etablissementannee::with('etablissement')->findOrFail(6);

        $headers = Header::all();
        $footers = Footer::all();
        $etablissements = Etablissementannee::with('etablissement')->findOrFail(6);
        $annees = Etablissementannee::with('anneeScolaire')->findOrFail($etablissements->id_etablissementannees);

    if(Auth::check()){
        $user = Auth::user()->load(['apprenants', 'paiements', 'donnateurs']);
    }

    return view('comptes.compteuser', compact('user','headers', 'footers','etablissements','annees','etablissement'));
}
//Affichage de la Rubrique Modifier
public function modifie(){

    $headers = Header::all();
    $footers = Footer::all();
    if(Auth::check()){
        $user = Auth::user();
    }

    return view('comptes.modifiercompte', compact('user','headers','footers'));
}


public function modifier(Request $request) {

  $user = User::find(Auth::id());

    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $user->id_users . ',id_users',
        'username' => 'required|string',
    ]);


        $user->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'username' => $request->username,
    ]);

     return redirect()->route('accueil');

}

public function modifi(Request $request)
{
    $user = User::find(Auth::id());

    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|confirmed', 
    ]);

    if (!Hash::check(
        $request->old_password,
        $user->password
    )) {
        return back()->with('error', 'Mot de passe actuel incorrect.');
    }

    $user->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('success', 'Mot de passe modifié.');
}

public function delete() 
{
    $user = User::find(Auth::id());
    Auth::logout();
    $user->delete();

    return redirect()->route('accueil');

}

}
