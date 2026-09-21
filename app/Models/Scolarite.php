<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Scolarite
 * 
 * @property int $id_scolarites
 * @property string|null $classes
 * @property string|null $montant
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @package App\Models
 */
class Scolarite extends Model
{
	//use SoftDeletes;
	protected $table = 'scolarites';
	protected $primaryKey = 'id_scolarites';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'classes',
		'montant',
		'created_by',
		'updated_by',
		'deleted_by'
	];
}
