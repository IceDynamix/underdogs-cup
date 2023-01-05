<?php

namespace App\Http\Requests;

use App\Models\Tournament;
use Illuminate\Foundation\Http\FormRequest;

class TournamentCreateRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = (new TournamentEditRequest())->rules();
        $rules['id'] = 'required|string|unique:tournaments,id';

        return $rules;
    }

    public function authorize()
    {
        return $this->user()->can('create', Tournament::class);
    }
}
