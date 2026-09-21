<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class InscriptionsPage
 * 
 * @property int $id_inscriptionspage
 * @property string|null $photo
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $numero
 * @property string|null $sexe
 * @property string|null $nationalite
 * @property string|null $date_naiss
 * @property string|null $lieu_naiss
 * @property string|null $age
 * @property string|null $lieu_reisd
 * @property string|null $text_excelente
 * @property string|null $annee
 * @property string|null $type_enseig
 * @property string|null $type_cycle
 * @property string|null $lvl_etude_gen_un
 * @property string|null $lvl_etude_gen_deux
 * @property string|null $lvl_etude_techn
 * @property string|null $type_etude
 * @property string|null $info_pmt
 * @property string|null $nom_p
 * @property string|null $tel_p
 * @property string|null $email_p
 * @property string|null $nom_m
 * @property string|null $tel_m
 * @property string|null $email_m
 * @property string|null $nom_t
 * @property string|null $tel_t
 * @property string|null $email_t
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @package App\Models
 */
class InscriptionsPage extends Model
{
	#use SoftDeletes;
	protected $table = 'inscriptions_page';
	protected $primaryKey = 'id_inscriptionspage';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'photo',
		'nom',
		'prenom',
		'numero',
		'sexe',
		'nationalite',
		'date_naiss',
		'lieu_naiss',
		'age',
		'lieu_reisd',
		'text_excelente',
		'annee',
		'type_enseig',
		'type_cycle',
		'lvl_etude_gen_un',
		'lvl_etude_gen_deux',
		'lvl_etude_techn',
		'type_etude',
		'info_pmt',
		'nom_p',
		'tel_p',
		'email_p',
		'nom_m',
		'tel_m',
		'email_m',
		'nom_t',
		'tel_t',
		'email_t',
		'created_by',
		'updated_by',
		'deleted_by'
	];
}
