<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portefeuilles extends Model
{
    use HasFactory;
    protected $table = 'portefeuilles';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'personne_id',
        'montant',
        'statut_id',
        'created_by',
        'updated_by',
    ];
    
    public function getPersonne()
    {
        return $this->belongsTo(Personnes::class, 'personne_id');
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
