<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matieres extends Model
{
    use HasFactory;
    protected $table = 'matieres';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'sigle', 
        'groupepedagogique_id',// FK
        'categorie_id',
        'section_id',
        'note_max', 
        'moyenne', 
        'matiereconfig_id',
        'statut_id', 
        'created_by', // FK
        'updated_by', // FK
        'created_at',
        'updated_at', 
    ]; 
    
    public function getMatiereconfig()
    {
        return $this->belongsTo(Matiereconfig::class, 'matiereconfig_id');
    } 
    
    public function getStatut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    } 
    
    public function getCategorie()
    {
        return $this->belongsTo(Categories::class, 'categorie_id');
    } 
    
    public function getSection()
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }
    
    public function getGP()
    {
        return $this->belongsTo(Groupepedagogiques::class, 'groupepedagogique_id');
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
