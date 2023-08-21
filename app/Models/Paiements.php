<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    use HasFactory;
    protected $table = 'paiements';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'telephone',
        'email',
        'montant_a_payer',
        'montant_payer',
        'etudiant_id',
        'num_transaction',
        'statut_transaction',
        'mod_paiement',
        'enregistrer_par',
    ];
    
    public function getEtudiant()
    {
        return $this->belongsTo(Etudiants::class, 'etudiant_id');
    }

    public function getEnregistrerPar()
    {
        return $this->belongsTo(User::class, 'enregistrer_par');
    }
 
}
