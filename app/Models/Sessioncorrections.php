<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessioncorrections extends Model
{
    use HasFactory;
    protected $table = 'sessioncorrections';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'examen_prog_id',
        'professeur_id',
        'statutvalidation_id',// FK 
        'created_by',
        'updated_by', 
    ]; 
    
    public function getExamenprog()
    {
        return $this->belongsTo(Examenprog::class, 'examen_prog_id');
    }
    
    public function getProfesseur()
    {
        return $this->belongsTo(User::class, 'professeur_id');
    }
    
    public function getStatut()
    {
        return $this->belongsTo(Statutvalidations::class, 'statutvalidation_id');
    }
}
