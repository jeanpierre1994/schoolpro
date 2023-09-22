<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historiqueportefeuilles extends Model
{
    use HasFactory;
    protected $table = 'historiqueportefeuilles';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'old_montant',
        'new_montant',
        'type',
        'portefeuille_id', 
        'created_by', 
    ];
    
    public function getPortefeuille()
    {
        return $this->belongsTo(Portefeuilles::class, 'portefeuille_id');
    }

    public function getUserCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    } 
}
