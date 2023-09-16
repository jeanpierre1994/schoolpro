<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historiquepaiementecheanciers extends Model
{
    use HasFactory;
    protected $table = 'historiquepaiementecheanciers';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'echeancier_id',
        'montant_payer',
        'montant_restant',
        'date_paiement',
        'dossier_id',
        'paiement_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at', 
    ];
    public function getDossier()
    {
        return $this->belongsTo(Dossiers::class, 'dossier_id');
    }
    public function getEcheancier()
    {
        return $this->belongsTo(Echeanciers::class, 'echeancier_id');
    }
    public function getPaiement()
    {
        return $this->belongsTo(Paiements::class, 'paiement_id');
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
