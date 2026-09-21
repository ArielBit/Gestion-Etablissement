<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * 
 * @property int $id_users
 * @property string $nom
 * @property string $prenom
 * @property string $username
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Collection|Apprenant[] $apprenants
 * @property Collection|Donnateur[] $donnateurs
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use HasFactory, Notifiable;
	//use HasRoles;
	protected $table = 'users';
	protected $primaryKey = 'id_users';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'username',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'role',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function apprenants()
	{
		return $this->hasMany(Apprenant::class, 'users_id', 'id_users');
	}

	public function donnateurs()
	{
		return $this->hasMany(Donnateur::class, 'users_id', 'id_users');
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class, 'users_id', 'id_users');
	}
}
