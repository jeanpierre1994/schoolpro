<?php

namespace App\Models;

use App\Models\Rubriques;
use App\Actions\GenereCode;
use App\Models\Grilletarifaires;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lignetarifs extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->created_by = auth()->id();
            $model->statut_id = 1;
            $model->code = (new GenereCode)->handle(LigneTarifs::class, "LT");
        });
    }

    public function rubrique()
    {
        return $this->belongsTo(Rubriques::class);
    }

    public function grilleTarifaire()
    {
        return $this->belongsTo(Grilletarifaires::class, 'grille_tarifaire_id');
    }
}
