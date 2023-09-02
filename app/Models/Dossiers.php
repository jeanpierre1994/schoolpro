<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossiers extends Model
{
    use HasFactory;
    protected $table = 'dossiers';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'site_id',
        'personne_id',
        'pole_id',// FK
        'filiere_id',
        'cycle_id',
        'niveau_id',
        'typesponsor_id', // FK
        'annee',
        'commentaire',
        'parent_created',
        'statuttraitement_id',
        'date_traitement',
        'validateur_id', 
        'created_by', // FK
        'updated_by', // FK
        'created_at',
        'updated_at', 
        'groupepedagogique_id',
        'parent_id',
        'portefeuille_id'
    ]; 
    
    public function getPortefeuille()
    {
        return $this->belongsTo(Portefeuilles::class, 'portefeuille_id');
    }
    public function getParent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
    
    public function getGp()
    {
        return $this->belongsTo(Groupepedagogiques::class, 'groupepedagogique_id');
    }
    
    public function getSite()
    {
        return $this->belongsTo(Sites::class, 'site_id');
    }
    
    public function getPersonne()
    {
        return $this->belongsTo(Personnes::class, 'personne_id');
    }
    
    public function getPole()
    {
        return $this->belongsTo(Poles::class, 'pole_id');
    }
    
    public function getFiliere()
    {
        return $this->belongsTo(Filieres::class, 'filiere_id');
    }
    
    public function getCycle()
    {
        return $this->belongsTo(Cycles::class, 'cycle_id');
    }
    
    public function getNiveau()
    {
        return $this->belongsTo(Niveaux::class, 'niveau_id');
    }
    
    public function getTypesponsor()
    {
        return $this->belongsTo(Typesponsors::class, 'typesponsor_id');
    }
    
    public function getStatuttraitement()
    {
        return $this->belongsTo(Statuttraitements::class, 'statuttraitement_id');
    }

    public function getValidateur()
    {
        return $this->belongsTo(User::class, 'validateur_id');
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
