<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ParametresGlobaux
 * 
 * @property int $id_parametres
 * @property string|null $logo
 * @property string|null $nom_p
 * @property Carbon|null $date_creation
 * @property string|null $directeur
 * @property string|null $localisation
 * @property int $trimestres_id
 * @property int $semestres_id
 * @property Carbon|null $date_rentree
 * @property Carbon|null $date_cloture
 * @property int $etablissementannees_id
 * @property int $anneescolaire_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Etablissementannee $etablissementannee
 * @property PeriodesScolaire $periodes_scolaire
 *
 * @package App\Models
 */
class ParametresGlobaux extends Model
{
	//use SoftDeletes;
	protected $table = 'parametres_globaux';
	protected $primaryKey = 'id_parametres';

	protected $casts = [
		'date_creation' => 'datetime',
		'trimestres_id' => 'int',
		'semestres_id' => 'int',
		'etablissementannees_id' => 'int',
		'anneescolaire_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'logo',
		'nom_p',
		'date_creation',
		'directeur',
		'localisation',
		'trimestres_id',
		'semestres_id',
		'date_rentree',
		'date_cloture',
		'etablissementannees_id',
		'anneescolaire_id',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	
    public function etablissementAnnee()
    {
        return $this->belongsTo(Etablissementannee::class, 'etablissementannees_id', 'id_etablissementannees');
		
    }

	public function etablissementAnnees()
    {
        return $this->belongsTo(Etablissementannee::class, 'anneescolaire_id', 'id_etablissementannees');
    }

    
    public function anneeScolaire()
    { 
        return $this->belongsTo(AnneeScolaire::class, 'anneescolaire_id', 'id_anneescolaires');
    }

    
    public function trimestre()
    {
        return $this->belongsTo(PeriodesScolaire::class, 'trimestres_id', 'id_periodes');
    }

    public function semestre()
    {
        return $this->belongsTo(PeriodesScolaire::class, 'semestres_id', 'id_periodes');
    }
}
