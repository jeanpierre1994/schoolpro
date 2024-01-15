<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synthesenotes extends Model
{
    use HasFactory;

    
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
    
    
}
