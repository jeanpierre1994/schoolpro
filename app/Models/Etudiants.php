<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiants extends Model
{
    use HasFactory;
    protected $table = 'etudiants';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dossier_id',
        'matricule', 
        'groupepedagogique_id', 
        'validateur_id', 
        'commentaitaire', 
        'statutvalidation_id'
    ];
    
    public function getDossier()
    {
        return $this->belongsTo(Dossiers::class, 'dossier_id');
    } 

    public function getGp()
    {
        return $this->belongsTo(Groupepedagogiques::class, 'groupepedagogique_id');
    } 
}
