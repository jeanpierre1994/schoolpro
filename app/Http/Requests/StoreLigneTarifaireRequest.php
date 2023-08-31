<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLigneTarifaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'rubrique_id' => ['required', 'exists:rubriques,id'],
            'grille_tarifaire_id' => ['required', 'exists:grilletarifaires,id'],
            'montant' => ['required', 'numeric'],
        ];
    }
}
