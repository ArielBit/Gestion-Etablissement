<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Apropo
 * 
 * @property int $id_propos
 * @property string|null $premier
 * @property string|null $deuxieme
 * @property string|null $troisieme
 * @property string|null $numero
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $titre_premier
 * @property string|null $titre_deuxieme
 * @property string|null $contenu_premier
 * @property string|null $contenu_deuxieme
 * @property string|null $exelence
 * @property string|null $digitalisation
 * @property string|null $text_excelente
 * @property string|null $text_digitalisation
 * @property string|null $mission
 * @property string|null $taux_reussite
 * @property string|null $nombre_premier
 * @property string|null $partenaires
 * @property string|null $nombre_troisieme
 * @property string|null $apprenants
 * @property string|null $nombre_deuxime
 *
 * @package App\Models
 */
class Apropo extends Model
{
	//use SoftDeletes;
	protected $table = 'apropos';
	protected $primaryKey = 'id_propos';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'premier',
		'deuxieme',
		'troisieme',
		'numero',
		'created_by',
		'updated_by',
		'deleted_by',
		'titre_premier',
		'titre_deuxieme',
		'contenu_premier',
		'contenu_deuxieme',
		'exelence',
		'digitalisation',
		'text_excelente',
		'text_digitalisation',
		'mission',
		'taux_reussite',
		'nombre_premier',
		'partenaires',
		'nombre_troisieme',
		'apprenants',
		'nombre_deuxime'
	];
}
