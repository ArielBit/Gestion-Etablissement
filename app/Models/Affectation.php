<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Affectation
 * 
 * @property int $professeurs_id
 * @property int $matieres_id
 * @property int $classes_id
 * @property int $educateurs_id	
 * @property int $etablissementannees_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Classe $classe
 * @property Matiere $matiere
 * @property Professeur $professeur
 * @property Educateur $educateur
 * @property Etablissementannee $etablissementannee
 *
 * @package App\Models
 */
class Affectation extends Model
{
	#use SoftDeletes;
	protected $table = 'affectations';
	protected $primaryKey = 'id_affectations';
	public $incrementing = true;
	protected $keyType = 'int';

	protected $casts = [
		'professeurs_id' => 'int',
		'matieres_id' => 'int',
		'classes_id' => 'int',
		'educateurs_id' => 'int',
		'etablissementannees_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'etablissementannees_id',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function classes()
	{
		return $this->belongsTo(Classe::class, 'classes_id'); 
	}

	public function matieres()
	{
		return $this->belongsTo(Matiere::class, 'matieres_id');
	}

	public function professeurs()
	{
		return $this->belongsTo(Professeur::class, 'professeurs_id');
	}

	public function educateurs()
	{
		return $this->belongsTo(Educateur::class, 'educateurs_id');
	}

	public function etablissementannee()
	{
		return $this->belongsTo(Etablissementannee::class, 'etablissementannees_id');
	}
}
