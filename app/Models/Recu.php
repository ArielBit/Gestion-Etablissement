<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Recu
 * 
 * @property int $id_reçus
 * @property int $paiements_id
 * @property string|null $reference
 * @property string|null $statut
 * @property Carbon|null $date_reçu
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Paiement $paiement
 *
 * @package App\Models
 */
class Recu extends Model
{
	#use SoftDeletes;
	protected $table = 'reçus';
	protected $primaryKey = 'id_reçus';

	protected $casts = [
		'paiements_id' => 'int',
		'date_reçu' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'paiements_id',
		'reference',
		'statut',
		'date_reçu',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function paiement()
	{
		return $this->belongsTo(Paiement::class, 'paiements_id');
	}

	public function apprenant()
{
    return $this->hasOneThrough(
        Apprenant::class,
        Paiement::class,
        'id_paiements',     
        'id_apprenants',    
        'paiements_id',     
        'apprenants_id'     
    );
}
}
 