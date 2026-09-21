<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Donnateur
 * 
 * @property int $id_donnateurs
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $type_donnateurs
 * @property string|null $type_organisations
 * @property string|null $type_dons
 * @property string|null $don_vivres
 * @property string|null $quantite_donvivres
 * @property string|null $modes_paiement
 * @property string|null $banque
 * @property string|null $montant_attendu
 * @property string|null $contacts
 * @property string|null $email
 * @property string|null $statut_paiement
 * @property Carbon|null $date_paiement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $etablissementannees_id
 * @property int $users_id
 * @property string|null $premier
 * @property string|null $titre_un
 * @property string|null $titre_deux
 * @property string|null $texte_circule
 * @property text|null $texte
 * @property string|null $titre_trois
 * @property string|null $texte_deux
 * 
 * 
 * @property Etablissementannee $etablissementannee
 * @property User $user
 * @property Collection|ReçusDonnateur[] $reçus_donnateurs
 *
 * @package App\Models
 */
class Donnateur extends Model
{
	//use SoftDeletes;
	protected $table = 'donnateurs';
	protected $primaryKey = 'id_donnateurs';

	protected $casts = [
		'date_paiement' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'etablissementannees_id' => 'int',
		'users_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'type_donnateurs',
		'type_organisations',
		'type_dons',
		'don_vivres',
		'quantite_donvivres',
		'modes_paiement',
		'banque',
		'montant_attendu',
		'contacts',
		'email',
		'statut_paiement',
		'date_paiement',
		'created_by',
		'updated_by',
		'deleted_by',
		'etablissementannees_id',
		'users_id',
		'premier',
		'titre_un',
		'titre_deux',
		'texte_circule',
		'texte',
		'titre_trois',
		'texte_deux'
	];

	public function etablissementannee()
{
    return $this->belongsTo(
        Etablissementannee::class,
        'etablissementannees_id',
        'id_etablissementannees'
    );
}

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id','id_users');
	}

	public function recusDonnateurs()
	{
		return $this->hasMany(RecusDonnateur::class, 'donnateurs_id');
	}

}
