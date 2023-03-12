<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examens extends Model
{
    use HasFactory;
    protected $table = 'examens';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'note_max', 
        'min_moyenne',// FK
        'max_moyenne',
        'commentaire',
        'groupepedagogique_id', 
        'examentype_id',
        'statut_id',
        'created_by', // FK
        'updated_by', // FK
        'created_at',
        'updated_at', 
    ]; 
    
    public function getGP()
    {
        return $this->belongsTo(Groupepedagogiques::class, 'groupepedagogique_id');
    } 
    
    public function getExamentype()
    {
        return $this->belongsTo(Examentypes::class, 'examentype_id');
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
