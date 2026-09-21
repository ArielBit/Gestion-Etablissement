<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vigile
 * 
 * @property int $id_vigile
 * @property string|null $numero_badge
 * @property string|null $societe_securite
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
class Vigile extends Model
{
	//use SoftDeletes;
	protected $table = 'vigiles';
	protected $primaryKey = 'id_vigile';
	public $incrementing = false;

	protected $casts = [
		'id_vigile' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'personnels_id' => 'int'
	];

	protected $fillable = [
		'numero_badge',
		'societe_securite',
		'created_by',
		'updated_by',
		'deleted_by',
		'personnels_id'
	];

	public function personnel()
	{
		return $this->belongsTo(Personnel::class, 'personnels_id');
	}
}


