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
 * Class Etablissement
 * 
 * @property int $id_etablissements
 * @property string|null $nom_etablissement
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
class Etablissement extends Model
{
	//use SoftDeletes;
	protected $table = 'etablissements';
	protected $primaryKey = 'id_etablissements';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'nom_etablissement',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function etablissementannees()
	{
		return $this->hasMany(Etablissementannee::class, 'etablissements_id');
	}
}
