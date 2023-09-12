<?php

namespace App\Models;

use App\Actions\GenereCode;
use App\Models\FamilleRubrique;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rubriques extends Model
{
    use HasFactory;
    protected $table = 'rubriques';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'libelle',
        'libelle_secondaire',
        'description',
        'statut_id',
        'famille_rubrique_id',
        'montant',
        'echeance',
        'created_by',
        'updated_by',
    ];

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
            $model->code = (new GenereCode)->handle(Rubriques::class, "RB");
        });
    }
}
