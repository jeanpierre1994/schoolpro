<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnes extends Model
{
    use HasFactory;
    protected $table = 'personnes';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenoms',
        'compte_id',// FK
        'matricule',
        'surnom',
        'nomjeunefille',
        'genre', // FK
        'ddn',
        'lieunais',
        'nationalite',
        'tel',
        'email',
        'adresse',
        'photo',
        'famille',
        'statut_id', // FK
        'created_by', // FK
        'updated_by', // FK
        'lien_parental',
        'site_id',
        'etablissement_id',
    ]; 
    
    public function getSite()
    {
        return $this->belongsTo(Sites::class, 'site_id');
    }
    
    public function getEtablissement()
    {
        return $this->belongsTo(Etablissements::class, 'etablissement_id');
    }
    
    public function getLienparental()
    {
        return $this->belongsTo(Lienparentals::class, 'lien_parental');
    }
    
    public function getCompte()
    {
        return $this->belongsTo(User::class, 'compte_id');
    }
    
    public function getGenre()
    {
        return $this->belongsTo(Genres::class, 'genre');
    }
    
    public function getStatut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    }

    public function getUserCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getUserUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
