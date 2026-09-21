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
 * Class Classeapprenant
 * 
 * @property int $id_classeapprenants
 * @property int $apprenants_id
 * @property int $classes_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $etablissementannees_id
 * 
 * @property Apprenant $apprenant
 * @property Classe $class
 * @property Etablissementannee $etablissementannee
 * @property Collection|BulletinsMatiere[] $bulletins_matieres
 * @property Collection|Evaluation[] $evaluations
 *
 * @package App\Models
 */
class Classeapprenant extends Model
{
	#use SoftDeletes;
	protected $table = 'classeapprenants';
	protected $primaryKey = 'id_classeapprenants';

    public $incrementing = true;

    protected $keyType = 'int';


	protected $casts = [
		'apprenants_id' => 'int',
		'classes_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'etablissementannees_id' => 'int'
	];

	protected $fillable = [
		'created_by',
		'updated_by',
		'deleted_by',
		'etablissementannees_id',
		'apprenants_id',
    	'classes_id',
	];

	public function apprenants()
{
    return $this->belongsTo(
        Apprenant::class,
        'apprenants_id',
        'id_apprenants'
    );
}

public function classes()
{
    return $this->belongsTo(
        Classe::class,
        'classes_id',
        'id_classes'
    );
}

	public function evaluations()
	{
		return $this->hasMany(Evaluation::class, 'classeapprenants_apprenants_id');
	}

	public function etablissementannee()
	{
		return $this->belongsTo(Etablissementannee::class, 'etablissementannees_id');
	}

	public function bulletins_matieres()
	{
		return $this->hasMany(BulletinsMatiere::class, 'classeapprenants_id');
	}

}
