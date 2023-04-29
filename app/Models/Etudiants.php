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
    ];
    
    public function getDossier()
    {
        return $this->belongsTo(Dossiers::class, 'dossier_id');
    } 
}
