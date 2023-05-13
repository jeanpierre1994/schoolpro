<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupepedagogiques extends Model
{
    use HasFactory;
    protected $table = 'groupepedagogiques';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle_classe',
        'libelle_secondaire',
        'description_classe', 
        'pole_id',// FK
        'filiere_id',
        'cycle_id',
        'niveau_id', 
        'created_by', // FK
        'updated_by', // FK
        'created_at',
        'updated_at', 
    ]; 
    
    public function getSite()
    {
        return $this->belongsTo(Sites::class, 'site_id');
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

    public function getUserCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getUserUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
