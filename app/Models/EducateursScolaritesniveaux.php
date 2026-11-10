<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EducateursScolaritesniveaux
 * 
 * @property int $id_educateurs_scolaritesniveaux
 * @property int $educateurs_id
 * @property int $scolarites_niveaux_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $etablissementannees_id
 *  @property int $educateurs_id
 *  @property int $scolarites_niveaux_id
 * 
 * @property Educateur $educateurs
 * @property Scolarite $scolarites
 *
 * @package App\Models
 */
class EducateursScolaritesniveaux extends Model
{
	//use SoftDeletes;
	protected $table = 'educateurs_scolaritesniveaux';
	protected $primaryKey = 'id_educateurs_scolaritesniveaux';

	protected $casts = [
		'educateurs_id' => 'int',
		'scolarites_niveaux_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'etablissementannees_id' => 'int',
		'educateurs_id' => 'int',
		'scolarites_niveaux_id' => 'int'
	];

	protected $fillable = [
		'educateurs_id',
		'scolarites_niveaux_id',
		'created_by',
		'updated_by',
		'deleted_by',
		'etablissementannees_id',
		'educateurs_id',
		'scolarites_niveaux_id'
	];

	public function educateurs()
{
    return $this->belongsTo(Educateur::class,'educateurs_id','id_educateurs');
}

public function scolarites()
{
    return $this->belongsTo(Scolarite::class,'scolarites_niveaux_id','id_scolarites');
}

public function etablissementannee()
    {
        return $this->belongsTo(Etablissementannee::class, 'etablissementannees_id');
    }
}
