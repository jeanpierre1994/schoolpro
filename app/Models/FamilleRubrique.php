<?php

namespace App\Models;

use App\Models\Rubriques;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilleRubrique extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rubriques() : HasMany
    {
        return $this->hasMany(Rubriques::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->code = "FM" . $model->code . "000";
        });
    }
}
