<?php

namespace App\Models;

use App\Models\Groupepedagogiques;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poles extends Model
{
    use HasFactory;
    protected $table = 'poles';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'libelle_secondaire',
        'description',
        'statut_id',
        'created_by',
        'updated_by',
    ];
    
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

    public function groupePedagogiques()
    {
        return $this->hasMany(Groupepedagogiques::class, 'pole_id');
    }
}
