<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PaiementsPage
 * 
 * @property int $id_paiementspage
 * @property string|null $explication
 * @property string|null $select_nom
 * @property string|null $finance_un
 * @property string|null $finance_deux
 * @property string|null $finance_trois
 * @property string|null $finance_quatre
 * @property string|null $unite
 * @property string|null $lieu_naiss
 * @property string|null $modalite_paye
 * @property string|null $tranche_paye
 * @property string|null $un_mois
 * @property string|null $deux_mois
 * @property string|null $trois_mois
 * @property string|null $quatre_mois
 * @property string|null $choix_premier
 * @property string|null $modes_paye
 * @property string|null $banque
 * @property string|null $montant
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @package App\Models
 */
class PaiementsPage extends Model
{
	#use SoftDeletes;
	protected $table = 'paiements_page';
	protected $primaryKey = 'id_paiementspage';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'explication',
		'select_nom',
		'finance_un',
		'finance_deux',
		'finance_trois',
		'finance_quatre',
		'unite',
		'lieu_naiss',
		'modalite_paye',
		'tranche_paye',
		'un_mois',
		'deux_mois',
		'trois_mois',
		'quatre_mois',
		'choix_premier',
		'modes_paye',
		'banque',
		'montant',
		'created_by',
		'updated_by',
		'deleted_by'
	];
}
