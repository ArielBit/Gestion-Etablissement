<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PersonnelsNettoyage
 * 
 * @property int $id_nettoyage
 * @property string|null $numero_badge
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $personnels_id
 *
 * @package App\Models
 */
class PersonnelsNettoyage extends Model
{
	//use SoftDeletes;
	protected $table = 'personnels_nettoyage';
	protected $primaryKey = 'id_nettoyage';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'personnels_id' => 'int'
	];

	protected $fillable = [
		'created_by',
		'updated_by',
		'deleted_by',
		'personnels_id',
		'numero_badge'
	];

	public function personnel()
	{
		return $this->belongsTo(Personnel::class, 'personnels_id');
	}
}
