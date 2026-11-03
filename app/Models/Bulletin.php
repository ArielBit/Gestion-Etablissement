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
 * @property string|null $type_bulletin
 * @property string|null $moyenne_g
 * @property string|null $rang_g
 * @property string|null $appreciation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $classeapprenants_id
 * 
 * @property Classeapprenant $classeapprenant
 *
 * @package App\Models
 */
class Bulletin extends Model
{
	//use SoftDeletes;
	protected $table = 'bulletins';
	protected $primaryKey = 'id_bulletins';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'classeapprenants_id' => 'int',
	];

	protected $fillable = [
		'type_bulletin',
		'moyenne_g',
		'rang_g',
		'appreciation',
		'created_by',
		'updated_by',
		'deleted_by',
		'classeapprenants_id'
	];


	public function classeapprenant()
	{
		return $this->belongsTo(Classeapprenant::class, 'classeapprenants_id');
	}
}
