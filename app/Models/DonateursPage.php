<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DonateursPage
 * 
 * @property int $id_donateurspage
 * @property string|null $explication
 * @property string|null $types_donnateurs
 * @property string|null $organisation
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $annee
 * @property string|null $types_don
 * @property string|null $don_vivres
 * @property string|null $don_nonvivres
 * @property string|null $quantite
 * @property string|null $contacts
 * @property string|null $email
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
class DonateursPage extends Model
{
	#use SoftDeletes;
	protected $table = 'donateurs_page';
	protected $primaryKey = 'id_donateurspage';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'explication',
		'types_donnateurs',
		'organisation',
		'nom',
		'prenom',
		'annee',
		'types_don',
		'don_vivres',
		'don_nonvivres',
		'quantite',
		'contacts',
		'email',
		'modes_paye',
		'banque',
		'montant',
		'created_by',
		'updated_by',
		'deleted_by'
	];
}
