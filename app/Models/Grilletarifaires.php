<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grilletarifaires extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->created_by = auth()->id();
            $model->statut_id = 1;
        });
    }
}
