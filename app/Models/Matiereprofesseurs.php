<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiereprofesseurs extends Model
{
    use HasFactory;
    protected $table = 'matiereprofesseurs';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matiere_id',
        'professeur_id',  
        'statut_id', 
        'created_by', // FK
        'updated_by', // FK
        'created_at',
        'updated_at', 
    ]; 
    
    public function getStatut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    } 
    
    public function getMatiere()
    {
        return $this->belongsTo(Matieres::class, 'matiere_id');
    } 
    
    public function getProfesseur()
    {
        return $this->belongsTo(User::class, 'professeur_id');
    }

    
}
