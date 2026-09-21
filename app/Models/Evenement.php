<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Evenement
 * 
 * @property int $id_evenements
 * @property string|null $premier
 * @property string|null $deuxieme
 * @property string|null $troisieme
 * @property string|null $quatre
 * @property string|null $cinq
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
 * @property string|null $sous_titre_premier
 * @property string|null $sous_titre_deux
 * @property string|null $temps_un
 * @property string|null $temps_deux
 * @property string|null $remise_titre
 * @property string|null $text_remise
 * @property string|null $periode
 * @property string|null $enseigne_un
 * @property string|null $enseigne_deux
 * @property string|null $enseigne_premier
 * @property string|null $enseigne_deuxieme
 *
 * @package App\Models
 */
class Evenement extends Model
{
	//use SoftDeletes;
	protected $table = 'evenements';
	protected $primaryKey = 'id_evenements';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'premier',
		'deuxieme',
		'troisieme',
		'quatre',
		'cinq',
		'created_by',
		'updated_by',
		'deleted_by',
		'titre_premier',
		'titre_deuxieme',
		'contenu_premier',
		'contenu_deuxieme',
		'sous_titre_premier',
		'sous_titre_deux',
		'temps_un',
		'temps_deux',
		'remise_titre',
		'text_remise',
		'periode',
		'enseigne_un',
		'enseigne_deux',
		'enseigne_premier',
		'enseigne_deuxieme'
	];
}
