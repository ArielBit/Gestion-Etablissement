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
 * Class Professeur
 * 
 * @property int $id_professeurs
 * @property string|null $specialite
 * @property string|null $diplome
 * @property string|null $matricule
 * @property int $personnels_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $matieres_id
 * 
 * @property Matiere $matiere
 * @property Personnel $personnel
 * @property Collection|Affectation[] $affectations
 * @property Collection|Evaluation[] $evaluations
 *
 * @package App\Models
 */
class Professeur extends Model
{
	//use SoftDeletes;
	protected $table = 'professeurs';
	protected $primaryKey = 'id_professeurs';

	protected $casts = [
		'personnels_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'matieres_id' => 'int'
	];

	protected $fillable = [
		'specialite',
		'diplome',
		'matricule',
		'personnels_id',
		'created_by',
		'updated_by',
		'deleted_by',
		'matieres_id'
	];

	public function matiere()
	{
		return $this->belongsTo(Matiere::class, 'matieres_id');
	}

	public function personnel()
	{
		return $this->belongsTo(Personnel::class, 'personnels_id','id_personnel');
	}

	public function affectations()
	{
		return $this->hasMany(Affectation::class, 'professeurs_id');
	}

	public function evaluations()
	{
		return $this->hasMany(Evaluation::class, 'professeurs_id');
	}
}
