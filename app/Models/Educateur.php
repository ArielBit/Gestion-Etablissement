<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Educateur
 * 
 * @property int $id_educateurs
 * @property string $matricule
 * @property string|null $niveau_responsable
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
class Educateur extends Model
{
	//use SoftDeletes;
	protected $table = 'educateurs';
	protected $primaryKey = 'id_educateurs';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'personnels_id' => 'int'
	];

	protected $fillable = [
		'matricule',
		'niveau_responsable',
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
