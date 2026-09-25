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
 * Class Personnel
 * 
 * @property int $id_personnel
 * @property string $nom
 * @property string $prenom
 * @property string $sexe
 * @property Carbon|null $date_naissance
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $adresse
 * @property string|null $photo
 * @property Carbon|null $date_embauche
 * @property string $categorie
 * @property string $fonction
 * @property string $statut
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $date_fin_embauche
 * 
 * @property Collection|Professeur[] $professeurs
 *
 * @package App\Models
 */
class Personnel extends Model
{
	//use SoftDeletes;
	protected $table = 'personnels';
	protected $primaryKey = 'id_personnel';

	protected $casts = [
		'date_naissance' => 'datetime',
		'date_embauche' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'date_fin_embauche' => 'datetime'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'sexe',
		'nomdate_naissance',
		'telephone',
		'email',
		'adresse',
		'photo',
		'date_embauche',
		'categorie',
		'fonction',
		'statut',
		'created_by',
		'updated_by',
		'deleted_by',
		'date_fin_embauche'
	];

	public function professeurs()
	{
		return $this->hasMany(Professeur::class, 'personnels_id');
	}

	public function vigiles()
	{
		return $this->hasMany(Vigile::class, 'personnels_id');
	}

	public function educateurs()
	{
		return $this->hasMany(Educateur::class, 'personnels_id');
	}

	public function personnelsNettoyage()
	{
		return $this->hasMany(PersonnelsNettoyage::class, 'personnels_id');
	}
}
