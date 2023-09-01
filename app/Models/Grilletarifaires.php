<?php

namespace App\Models;

use App\Actions\GenereCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
            $model->code = (new GenereCode)->handle(Grilletarifaires::class, "GT");
        });
    }
}
