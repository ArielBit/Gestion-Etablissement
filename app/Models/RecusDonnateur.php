<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ReçusDonnateur
 * 
 * @property int $id_reçus
 * @property string|null $reference
 * @property string|null $statut
 * @property Carbon|null $date_reçu
 * @property int $donnateurs_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property Donnateur $donnateur
 *
 * @package App\Models
 */
class RecusDonnateur extends Model
{
	//use SoftDeletes;
	protected $table = 'reçus_donnateurs';
	protected $primaryKey = 'id_reçus';

	protected $casts = [
		'date_reçu' => 'datetime',
		'donnateurs_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'reference',
		'statut',
		'date_reçu',
		'donnateurs_id',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function donnateur()
	{
		return $this->belongsTo(Donnateur::class, 'donnateurs_id', 'id_donnateurs');
	}
}
