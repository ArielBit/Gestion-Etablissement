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
 * @property int $matieres_id
 * @property string|null $type_evaluation
 * @property float|null $notes
 * @property string|null $duree
 * @property Carbon|null $date_evaluation
 * @property string|null $observations
 * @property int $classeapprenants_id
 * @property int $professeurs_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $etablissementannees_id
 * 
 * @property Classeapprenant $classeapprenant
 * @property Etablissementannee $etablissementannee
 * @property Matiere $matiere
 * @property Professeur $professeur
 * @property Collection|BulletinsMatiere[] $bulletins_matieres
 *
 * @package App\Models
 */
class Evaluation extends Model
{
	#use SoftDeletes;
	protected $table = 'evaluations';
	protected $primaryKey = 'id_evaluations';

	protected $casts = [
		'matieres_id' => 'int',
		'notes' => 'float',
		'date_evaluation' => 'datetime',
		'classeapprenants_id' => 'int',
		'professeurs_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'etablissementannees_id' => 'int'
	];

	protected $fillable = [
		'matieres_id',
		'type_evaluation',
		'notes',
		'duree',
		'date_evaluation',
		'observations',
		'classeapprenants_id',
		'professeurs_id',
		'created_by',
		'updated_by',
		'deleted_by',
		'etablissementannees_id'
	];

	public function classeapprenant()
{
    return $this->belongsTo(
        Classeapprenant::class,
        'classeapprenants_id',
        'id_classeapprenants'
    );
}

	public function etablissementannees()
	{
		return $this->belongsTo(Etablissementannee::class, 'etablissementannees_id');
	}

	public function matieres()
	{
		return $this->belongsTo(Matiere::class, 'matieres_id');
	}

	public function professeurs()
	{
		return $this->belongsTo(Professeur::class, 'professeurs_id');
	}

	public function bulletins_matieres()
	{
		return $this->hasMany(BulletinsMatiere::class, 'evaluations_id');
	}
}
