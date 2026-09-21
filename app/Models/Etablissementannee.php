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
 * Class Etablissementannee
 * 
 * @property int $id_etablissementannees
 * @property int $etablissements_id
 * @property int $annee_scolaires_id
 * @property string|null $annee_periodique
 * @property string|null $type_anperiode
 * @property Carbon|null $date_debut
 * @property Carbon|null $date_fin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * 
 * @property AnneeScolaire $annee_scolaire
 * @property Etablissement $etablissement
 * @property Collection|Administration[] $administrations
 * @property Collection|Affectation[] $affectations
 * @property Collection|Apprenant[] $apprenants
 * @property Collection|BulletinsMatiere[] $bulletins_matieres
 * @property Collection|Classeapprenant[] $classeapprenants
 * @property Collection|CompteUser[] $compte_users
 * @property Collection|Donnateur[] $donnateurs
 * @property Collection|Evaluation[] $evaluations
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class Etablissementannee extends Model
{
	#use SoftDeletes;
	protected $table = 'etablissementannees';
	protected $primaryKey = 'id_etablissementannees';

    public $incrementing = true;

    protected $keyType = 'int';

	protected $casts = [
		'etablissements_id' => 'int',
		'annee_scolaires_id' => 'int',
		'date_debut' => 'datetime',
		'date_fin' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'annee_periodique',
		'type_anperiode',
		'date_debut',
		'date_fin',
		'created_by',
		'updated_by'
	];

	public function anneeScolaire()
{
    return $this->belongsTo(AnneeScolaire::class,'annee_scolaires_id','id_anneescolaires');
}

	public function etablissement()
	{
		return $this->belongsTo(Etablissement::class, 'etablissements_id','id_etablissements');
	}

	public function administrations()
	{
		return $this->hasMany(Administration::class, 'etablissementannees_id');
	}

	public function affectations()
	{
		return $this->hasMany(Affectation::class, 'etablissementannees_id');
	}

	public function apprenants()
	{
		return $this->hasMany(Apprenant::class, 'etablissementannees_id');
	}

	public function bulletins_matieres()
	{
		return $this->hasMany(BulletinsMatiere::class, 'etablissementannees_id');
	}

	public function classeapprenants()
	{
		return $this->hasMany(Classeapprenant::class, 'etablissementannees_id');
	}

	public function compte_users()
	{
		return $this->hasMany(CompteUser::class, 'etablissementannees_id');
	}

	public function donnateurs()
	{
		return $this->hasMany(Donnateur::class, 'etablissementannees_id');
	}

	public function evaluations()
	{
		return $this->hasMany(Evaluation::class, 'etablissementannees_id');
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class, 'etablissementannees_id');
	}
}
