<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeanciers extends Model
{
    use HasFactory;
    protected $table = 'echeanciers';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'active',
        'dossier_id',
        'lignetarif_id',
        'montant_rubrique',
        'montant_payer',
        'montant_restant',
        'remise',
        'date_paiement',
        'statutpaiement_id',
        'created_by', // FK
        'updated_by', // FK
    ];
    
    public function getDossier()
    {
        return $this->belongsTo(Dossiers::class, 'dossier_id');
    }
    public function getLignetarif()
    {
        return $this->belongsTo(Lignetarifs::class, 'lignetarif_id');
    }
    public function getStatutpaiement()
    {
        return $this->belongsTo(Statutpaiements::class, 'statutpaiement_id');
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
