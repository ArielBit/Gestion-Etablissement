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
 * Class Class
 * 
 * @property int $id_classes
 * @property string|null $nom_classe
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Collection|Affectation[] $affectations
 * @property Collection|Apprenant[] $apprenants
 *
 * @package App\Models
 */
class Classe extends Model
{
	#use SoftDeletes;
	protected $table = 'classes';
	protected $primaryKey = 'id_classes';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'nom_classe',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function affectations()
	{
		return $this->hasMany(Affectation::class, 'classes_id');
	}

	public function apprenants()
	{
		return $this->belongsToMany(Apprenant::class, 'classeapprenants', 'classes_id', 'apprenants_id')
					->withPivot('deleted_at', 'created_by', 'updated_by', 'deleted_by')
					->withTimestamps();
	}
}
