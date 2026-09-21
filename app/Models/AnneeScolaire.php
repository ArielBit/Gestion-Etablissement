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
 * Class AnneeScolaire
 * 
 * @property int $id_anneescolaires
 * @property string|null $annee_scolaire
 * @property string|null $date_debut
 * @property string|null $date_fin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Collection|Etablissementannee[] $etablissementannees
 *
 * @package App\Models
 */
class AnneeScolaire extends Model
{
	#use SoftDeletes;
	protected $table = 'annee_scolaires';
	protected $primaryKey = 'id_anneescolaires';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'annee_scolaire',
		'date_debut',
		'date_fin',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function etablissementannees()
	{
		return $this->hasMany(Etablissementannee::class, 'annee_scolaires_id');
	}
}
