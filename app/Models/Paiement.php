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
 * Class Paiement
 * 
 * @property int $id_paiements
 * @property int $apprenants_id
 * @property string|null $modalite
 * @property string|null $tranche_paiement
 * @property string|null $choix_mois
 * @property string|null $choix_premiermois
 * @property string|null $modes_paiement
 * @property string|null $banque
 * @property string|null $montant_attendu
 * @property Carbon|null $date_paiement
 * @property string|null $statut_paiement
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
 * @property string|null $reste_payer
 * @property string|null $type_frais
 * 
 * @property Apprenant $apprenants
 * @property Etablissementannee $etablissementannee
 * @property Collection|Recu[] $reçus
 *
 * @package App\Models
 */
class Paiement extends Model
{
	#use SoftDeletes;
	protected $table = 'paiements';
	protected $primaryKey = 'id_paiements';

	protected $casts = [
		'apprenants_id' => 'int',
		'date_paiement' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'etablissementannees_id' => 'int',
		'users_id' => 'int'
	];

	protected $fillable = [
		'apprenants_id',
		'modalite',
		'tranche_paiement',
		'choix_mois',
		'choix_premiermois',
		'modes_paiement',
		'banque',
		'montant_attendu',
		'date_paiement',
		'statut_paiement',
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
		'texte_deux',
		'reste_payer',
		'type_frais'
	];

	public function apprenants()
{
    return $this->belongsTo( Apprenant::class, 'apprenants_id','id_apprenants');
}

	public function reçus()
	{
		return $this->hasOne(Recu::class, 'paiements_id');
	}

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
}
