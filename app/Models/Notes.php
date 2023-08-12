<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    protected $table = 'notes';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sessioncorrection_id',
        'examen_prog_id',
        'groupepedagogique_id',
        'etudiant_id',
        'professeur_id',
        'note_examen',
        'note',
        'commentaire',
        'statutvalidation_id',
        'created_by', 
    ];
    
    public function getSessioncorrection()
    {
        return $this->belongsTo(Sessioncorrections::class, 'sessioncorrection_id');
    }
    
    public function getExamenprog()
    {
        return $this->belongsTo(Examenprog::class, 'examen_prog_id');
    }
    
    public function getGp()
    {
        return $this->belongsTo(Groupepedagogiques::class, 'groupepedagogique_id');
    }
    
    public function getEtudiant()
    {
        return $this->belongsTo(Etudiants::class, 'etudiant_id');
    }
    
    public function getProfesseur()
    {
        return $this->belongsTo(User::class, 'professeur_id');
    }
    
    public function getStatut()
    {
        return $this->belongsTo(Statutvalidations::class, 'statutvalidation_id');
    }

    public function getUserCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    } 
}
