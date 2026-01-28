<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Eldönti, hogy a felhasználó jogosult-e erre a kérésre.
     */
    public function authorize(): bool
    {
        // Ha van Laravel Auth (pl. Breeze/Jetstream), itt ellenőrizhető a jogosultság.
        // Most bemutató céljából mindenki számára engedélyezzük, aki be van jelentkezve.
        return auth()->check(); 
    }

    /**
     * A kérésre vonatkozó validációs szabályok.
     */
    public function rules(): array
    {
        return [
            // Cím: kötelező, szöveges, maximum 255 karakter (szabványos string hossza)
            'title' => ['required', 'string', 'max:255'], 
            
            // Kategória ID: kötelező, léteznie kell a 'categories' táblában
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            
            // Dátum: kötelező, dátum formátum
            'event_date' => ['required', 'date'],
            
            // Helyszín: kötelező, szöveges, maximum 255 karakter
            'location' => ['required', 'string', 'max:255'],
            
            // Leírás: opcionális, szöveges
            'description' => ['nullable', 'string'],
        ];
    }
    
    /**
     * Egyedi hibaüzenetek.
     */
    public function messages(): array
    {
        return [
            'title.max' => 'Az esemény címe legfeljebb 255 karakter lehet.',
            'category_id.exists' => 'A kiválasztott kategória érvénytelen.',
            'event_date.required' => 'Az esemény dátuma és ideje kötelező.',
        ];
    }
}