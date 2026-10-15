<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PeriodesScolaire
 * 
 * @property int $id_periodes
 * @property string|null $nom_peri
 * @property string|null $type
 * @property Carbon|null $date_debut
 * @property Carbon|null $date_fin
 * @property int|null $ordre 
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int $anneescolaire_id
 * 
 * @property Etablissementannee $etablissementannee
 * @property Collection|ParametresGlobaux[] $parametres_globauxes
 *
 * @package App\Models
 */
class PeriodesScolaire extends Model
{
    protected $table = 'periodes_scolaires';
    protected $primaryKey = 'id_periodes';

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'ordre' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int',
        'anneescolaire_id' => 'int'
    ];

    protected $fillable = [
        'nom_peri',
        'type',
        'date_debut',
        'date_fin',
        'ordre',
        'created_by',
        'updated_by',
        'deleted_by',
        'anneescolaire_id'
    ];

    /**
     * Relation vers la table pivot etablissementannees
     */
    public function etablissementAnnee()
    {
        // belongsTo(ModeleCible, cle_etrangere_dans_periodes_scolaires, cle_primaire_dans_etablissementannees)
        return $this->belongsTo(
            Etablissementannee::class, 
            'anneescolaire_id', 
            'id_etablissementannees'
        );
    }


    /**
     * Relations vers ParametresGlobaux
     */
    public function parametres_globauxes()
    {
        return $this->hasMany(ParametresGlobaux::class, 'semestres_id');
    }
}