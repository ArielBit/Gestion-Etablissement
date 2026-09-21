<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models; 

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Apprenant
 * 
 * @property int $id_apprenants
 * @property string|null $photo
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $sexe
 * @property string|null $nationalite
 * @property Carbon|null $date_naissance
 * @property string|null $lieu_naissance
 * @property string|null $age
 * @property int $etablissementannees_id
 * @property string|null $type_enseignement
 * @property string|null $cycle
 * @property string|null $niveau_etude
 * @property string|null $type_niveau
 * @property string|null $type_niveau2
 * @property string|null $matricule
 * @property string|null $pere
 * @property string|null $tel_pere
 * @property string|null $mere
 * @property string|null $tel_mere
 * @property string|null $tuteur
 * @property string|null $tel_tuteur
 * @property string|null $lieu_residence
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $users_id
 * @property string|null $premier
 * @property string|null $titre_un
 * @property string|null $titre_deux
 * @property string|null $texte_circule
 * @property text|null $texte
 * @property string|null $titre_trois
 * @property string|null $texte_deux
 * @property string|null $diplome_bulletin
 * @property string|null $moyennean_moyenexam
 * 
 * @property Etablissementannee $etablissementannee
 * @property Collection|Classe[] $classes
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class Apprenant extends Model
{
	#use SoftDeletes;
	protected $table = 'apprenants';
	protected $primaryKey = 'id_apprenants';

	protected $casts = [
		'date_naissance' => 'datetime',
		'etablissementannees_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int',
		'users_id' => 'int'
	];

	protected $fillable = [ 
		'photo',
		'nom',
		'prenom',
		'sexe',
		'nationalite',
		'date_naissance',
		'lieu_naissance',
		'age',
		'etablissementannees_id',
		'type_enseignement',
		'cycle',
		'niveau_etude',
		'type_niveau',
		'type_niveau2',
		'matricule',
		'pere',
		'tel_pere',
		'email_pere',
		'mere',
		'tel_mere',
		'email_mere',
		'tuteur',
		'tel_tuteur',
		'email_tuteur',
		'lieu_residence',
		'created_by',
		'updated_by',
		'deleted_by' ,
		'users_id',
		'premier',
		'titre_un',
		'titre_deux',
		'texte_circule',
		'texte',
		'titre_trois',
		'texte_deux',
		'diplome_bulletin',
		'moyennean_moyenexam'
	];

	public function etablissementannee()
{
    return $this->belongsTo(
        Etablissementannee::class,
        'etablissementannees_id',
        'id_etablissementannees'
    );
}

	public function classes()
	{
		return $this->belongsToMany(Classe::class, 'classeapprenants', 'apprenants_id', 'classes_id')
					->withPivot('deleted_at', 'created_by', 'updated_by', 'deleted_by')
					->withTimestamps();
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class, 'apprenants_id');
	}

	public function etablissement()
{
    return $this->belongsTo(Etablissement::class, 'etablissements_id');
}

public function anneeScolaire()
{
    return $this->belongsTo(AnneeScolaire::class, 'annee_scolaires_id');
}

public function user()
	{
		return $this->belongsTo(User::class, 'users_id', 'id_users');
	}
}
