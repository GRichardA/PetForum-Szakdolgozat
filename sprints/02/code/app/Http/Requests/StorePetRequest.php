<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'animal_type' => ['required', 'string', 'max:50'],
            'breed' => ['required', 'string', 'max:100'],
            'vaccination_date' => ['nullable', 'date'],
        ];
    }
}