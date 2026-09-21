<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Matiere
 * 
 * @property int $id_matieres
 * @property string|null $nom_matiere
 * @property int|null $coeficient
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Collection|Affectation[] $affectations
 * @property Collection|BulletinsMatiere[] $bulletins_matieres
 * @property Collection|Evaluation[] $evaluations
 * @property Collection|Professeur[] $professeurs
 *
 * @package App\Models
 */
class Matiere extends Model
{
	//use SoftDeletes;
	protected $table = 'matieres';
	protected $primaryKey = 'id_matieres';

	protected $casts = [
		'coeficient' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'nom_matiere',
		'coeficient',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function affectations()
	{
		return $this->hasMany(Affectation::class, 'matieres_id');
	}

	public function bulletins_matieres()
	{
		return $this->hasMany(BulletinsMatiere::class, 'matieres_id');
	}

	public function evaluations()
	{
		return $this->hasMany(Evaluation::class, 'matieres_id');
	}

	public function professeurs()
	{
		return $this->hasMany(Professeur::class, 'matieres_id');
	}
}
