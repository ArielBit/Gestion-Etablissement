<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Administration
 * 
 * @property int $id_administrations
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $type_personne
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $etablissementannees_id
 * 
 * @property Etablissementannee $etablissementannee
 *
 * @package App\Models
 */
class Administration extends Model
{
	#use SoftDeletes;
	protected $table = 'administrations';
	protected $primaryKey = 'id_administrations';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'etablissementannees_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'type_personne',
		'created_by',
		'updated_by',
		'deleted_by',
		'etablissementannees_id'
	];

	public function etablissementannee()
{
    return $this->belongsTo(
        Etablissementannee::class,
        'etablissementannees_id',
        'id_etablissementannees'
    );
}
}
