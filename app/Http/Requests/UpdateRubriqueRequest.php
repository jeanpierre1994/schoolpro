<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRubriqueRequest extends FormRequest
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
            'libelle' => 'required|min:2',
            'libelle_secondaire' => 'min:2', 
            'echeance' => 'required',
            'montant' => 'required',
            'famille_rubrique_id' => 'required|exists:famille_rubriques,id'        ];
    }
}
