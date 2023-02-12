<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    use HasFactory;
    protected $table = 'sites';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sigle',  
        'telephone',
        'manager',
        'adresse',
        'email',
        'ets',
        'statut_id',
        'created_by',
        'updated_by',
    ];
    
    public function getStatut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    }
    public function getEtablissement()
    {
        return $this->belongsTo(Etablissements::class, 'ets');
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
