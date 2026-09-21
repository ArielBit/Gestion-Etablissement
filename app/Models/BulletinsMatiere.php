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
 * Class BulletinsMatiere
 * 
 * @property int $id_bulletinsmatieres
 * @property int $evaluations_id
 * @property int $matieres_id
 * @property int $classeapprenants_id
 * @property int $etablissementannees_id
 * @property string|null $periode_numero
 * @property string|null $apprenants_id
 * @property string|null $moyenne
 * @property string|null $rang
 * @property string|null $appreciation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Classeapprenant $classeapprenant
 * @property Etablissementannee $etablissementannee
 * @property Evaluation $evaluation
 * @property Matiere $matiere
 * @property Collection|Bulletin[] $bulletins
 *
 * @package App\Models
 */
class BulletinsMatiere extends Model
{
	#use SoftDeletes;
	protected $table = 'bulletins_matieres';
	protected $primaryKey = 'id_bulletinsmatieres';

	protected $casts = [
		'evaluations_id' => 'int',
		'matieres_id' => 'int',
		'classeapprenants_id' => 'int',
		'etablissementannees_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'evaluations_id',
		'matieres_id',
		'classeapprenants_id',
		'etablissementannees_id',
		'periode_numero',
		'apprenants_id',
		'moyenne',
		'rang',
		'appreciation',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function classeapprenant()
	{
		return $this->belongsTo(Classeapprenant::class, 'classeapprenants_id');
	}

	public function etablissementannees()
	{
		return $this->belongsTo(Etablissementannee::class, 'etablissementannees_id');
	}

	public function evaluations()
	{
		return $this->belongsTo(Evaluation::class, 'evaluations_id');
	}

	public function matieres()
	{
		return $this->belongsTo(Matiere::class, 'matieres_id');
	}

	public function bulletins()
	{
		return $this->hasMany(Bulletin::class, 'bulletins_matieres_id');
	}
}
