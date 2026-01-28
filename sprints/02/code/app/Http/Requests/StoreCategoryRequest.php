<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Vagy a megfelelő jogosultsági logika
    }

    public function rules(): array
    {
        return [
            // <<< FONTOS MÓDOSÍTÁS ITT: max:16 hozzáadva >>>
            'name' => ['required', 'string', 'max:16', 'unique:categories,name'],
            'color_code' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            // További szabályok...
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.max' => 'A kategória neve legfeljebb 16 karakter hosszú lehet.',
            // További üzenetek...
        ];
    }
}