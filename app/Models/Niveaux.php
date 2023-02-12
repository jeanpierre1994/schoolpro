<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveaux extends Model
{
    use HasFactory;
    protected $table = 'niveaux';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'filiere_id',
        'cycle_id',
        'description',
        'statut_id',
        'created_by',
        'updated_by',
    ];
    
    public function getCycle()
    {
        return $this->belongsTo(Cycles::class, 'cycle_id');
    }
    
    public function getFiliere()
    {
        return $this->belongsTo(Filieres::class, 'filiere_id');
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
