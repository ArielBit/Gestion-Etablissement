<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Header
 * 
 * @property int $id_header
 * @property string|null $logo
 * @property string|null $email
 * @property string|null $adress
 * @property string|null $numero
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @package App\Models
 */
class Header extends Model
{
	//use SoftDeletes;
	protected $table = 'headers';
	protected $primaryKey = 'id_header';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'logo',
		'email',
		'adress',
		'numero',
		'created_by',
		'updated_by',
		'deleted_by'
	];
}
