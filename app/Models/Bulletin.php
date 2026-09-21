<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bulletin
 * 
 * @property int $id_bulletins
 * @property string|null $annee_periodiques
 * @property string|null $type_bulletin
 * @property string|null $moyenne
 * @property string|null $rang
 * @property string|null $appreciation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $bulletins_matieres_id
 * 
 * @property BulletinsMatiere $bulletins_matiere
 *
 * @package App\Models
 */
class Bulletin extends Model
{
	#use SoftDeletes;
	protected $table = 'bulletins';
	protected $primaryKey = 'id_bulletins';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'bulletins_matieres_id' => 'int'
	];

	protected $fillable = [
		'annee_periodiques',
		'type_bulletin',
		'moyenne',
		'rang',
		'appreciation',
		'created_by',
		'updated_by',
		'deleted_by',
		'bulletins_matieres_id'
	];

	public function bulletins_matiere()
	{
		return $this->belongsTo(BulletinsMatiere::class, 'bulletins_matieres_id');
	}
}
