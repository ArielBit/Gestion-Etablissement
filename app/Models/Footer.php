<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Footer
 * 
 * @property int $id_footers
 * @property string|null $description
 * @property string|null $copyright_un
 * @property string|null $copyright_lien
 * @property string|null $copyright_deux
 * @property string|null $photo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $titre
 *
 * @package App\Models
 */
class Footer extends Model
{
	//use SoftDeletes;
	protected $table = 'footers';
	protected $primaryKey = 'id_footers';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'description',
		'copyright_un',
		'copyright_lien',
		'copyright_deux',
		'photo',
		'created_by',
		'updated_by',
		'deleted_by',
		'titre'
	];
}
