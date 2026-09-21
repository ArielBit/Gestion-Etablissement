<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Accueil
 * 
 * @property int $id_accueil
 * @property string|null $premier
 * @property string|null $deuxieme
 * @property string|null $troisieme
 * @property string|null $cycle_un
 * @property string|null $cycle_deux
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
 * @property string|null $evaluation
 * @property string|null $text_evaluation
 * @property string|null $cycle_trois
 * @property string|null $cyle_quatre
 * @property string|null $service_un
 * @property string|null $service_deux
 * @property string|null $service_trois
 * @property string|null $titre_service_un
 * @property string|null $titre_service_deux
 * @property string|null $text_service_un
 * @property string|null $text_service_deux
 * @property string|null $nombre_un
 * @property string|null $un
 * @property string|null $nombre_deux
 * @property string|null $deux
 * @property string|null $nombre_trois
 * @property string|null $trois
 * @property string|null $nombre_quatre
 * @property string|null $quatre
 * @property string|null $agenda
 * @property string|null $sous_titre_agenda
 * @property string|null $div_un
 * @property string|null $div_sous_un
 * @property string|null $div_text
 * @property string|null $div_deux
 * @property string|null $div_sous_deux
 * @property string|null $div_text_deux
 * @property string|null $div_trois
 * @property string|null $div_sous_trois
 * @property string|null $div_text_trois
 *
 * @package App\Models
 */
class Accueil extends Model
{
	//use SoftDeletes;
	protected $table = 'accueil';
	protected $primaryKey = 'id_accueil';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'premier',
		'deuxieme',
		'troisieme',
		'cycle_un',
		'cycle_deux',
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
		'evaluation',
		'text_evaluation',
		'cycle_trois',
		'cycle_quatre',
		'service_un',
		'service_deux',
		'service_trois',
		'titre_service_un',
		'titre_service_deux',
		'text_service_un',
		'text_service_deux',
		'nombre_un',
		'un',
		'nombre_deux',
		'deux',
		'nombre_trois',
		'trois',
		'nombre_quatre',
		'quatre',
		'agenda',
		'sous_titre_agenda',
		'div_un',
		'div_sous_un',
		'div_text',
		'div_deux',
		'div_sous_deux',
		'div_text_deux',
		'div_trois',
		'div_sous_trois',
		'div_text_trois'
	];
}
