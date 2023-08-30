<?php

namespace App\Models;

use App\Models\FamilleRubrique;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rubriques extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function familleRubrique() : BelongsTo
    {
        return $this->belongsTo(FamilleRubrique::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->created_by = auth()->id();
            $model->statut_id = 1;
        });
    }
}
