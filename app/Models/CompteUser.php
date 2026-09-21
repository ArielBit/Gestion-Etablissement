<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class CompteUser
 * 
 * @property int $id
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $email
 * @property string $username
 * @property string $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Etablissementannee $etablissementannee
 *
 * @package App\Models
 */
class CompteUser extends Authenticatable
{
	#use SoftDeletes;
	protected $table = 'compte_users';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',

	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'email',
		'username',
		'password',
		'created_by',
		'updated_by',
		'deleted_by',
		
	];

	
}
