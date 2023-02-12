<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissements extends Model
{
    use HasFactory;
    protected $table = 'etablissements';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sigle',
        'description',
        'ifu',
        'telephone',
        'dirigeant',
        'adresse',
        'statutjuridique_id',
        'statut_id',
        'created_by',
        'updated_by',
    ];
    
    public function getStatut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    }
    public function getStatutjuridique()
    {
        return $this->belongsTo(Statutjuridiques::class, 'statutjuridique_id');
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
