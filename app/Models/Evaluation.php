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
 * Class Evaluation
 * 
 * @property int $id_evaluations
 * @property string|null $type_evaluation
 * @property float|null $notes
 * @property string|null $duree
 * @property Carbon|null $date_evaluation
 * @property string|null $observations
 * @property int $classeapprenants_id
 * @property string|null $nom_evaluation
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $affectations_id
 * @property int $etablissementannees_id
 * @property int $periodes_scolaires_id
 * 
 * @property Affectation $affectation
 * @property Classeapprenant $classeapprenant
 * @property Etablissementannee $etablissementannee
 * @property PeriodesScolaire $periodes_scolaire
 * @property Collection|BulletinsMatiere[] $bulletins_matieres
 *
 * @package App\Models
 */
class Evaluation extends Model
{
	//use SoftDeletes;
	protected $table = 'evaluations';
	protected $primaryKey = 'id_evaluations';

	protected $casts = [
		'notes' => 'float',
		'date_evaluation' => 'datetime',
		'classeapprenants_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'affectations_id' => 'int',
		'etablissementannees_id' => 'int',
		'periodes_scolaires_id' => 'int'
	];

	protected $fillable = [
		'type_evaluation',
		'notes',
		'duree',
		'date_evaluation',
		'observations',
		'classeapprenants_id',
		'nom_evaluation',
		'description',
		'created_by',
		'updated_by',
		'deleted_by',
		'affectations_id',
		'etablissementannees_id',
		'periodes_scolaires_id'
	];

	public function affectation()
	{
		return $this->belongsTo(Affectation::class, 'affectations_id');
	}

	public function classeapprenant()
	{
		return $this->belongsTo(Classeapprenant::class, 'classeapprenants_id');
	}

	public function etablissementannee()
	{
		return $this->belongsTo(Etablissementannee::class, 'etablissementannees_id');
	}

	public function periodes_scolaire()
	{
		return $this->belongsTo(PeriodesScolaire::class, 'periodes_scolaires_id');
	}

	public function bulletins_matieres()
	{
		return $this->hasMany(BulletinsMatiere::class, 'evaluations_id');
	}
}
