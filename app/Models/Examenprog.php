<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examenprog extends Model
{
    use HasFactory;
    protected $table = 'examenprogs';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'date_debut',
        'date_fin', 
        'commentaire', 
        'matiere_id', 
        'examen_id', 
        'created_by', // FK
        'updated_by', // FK
        'created_at',
        'updated_at', 
    ]; 
    
    public function getMatiere()
    {
        return $this->belongsTo(Matieres::class, 'matiere_id',"id");
    } 
    
    public function getExamen()
    {
        return $this->belongsTo(Examens::class, 'examen_id');
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
