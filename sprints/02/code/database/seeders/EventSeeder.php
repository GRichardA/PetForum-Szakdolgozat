<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
       $users = \App\Models\User::all();
    $categories = \App\Models\Category::all();

    $cimek = [
        'Margit-szigeti vizsla találkozó', 'Kezdő Agility alapok', 'Ingyenes szűrővizsgálat', 
        'Vasárnapi Kölyökbuli', 'Otthoni kozmetika tippek', 'Menhelyi nyílt nap', 
        'Reggeli kutya-jóga', 'Engedelmességi tréning', 'Frizbi bajnokság', 'Túra a Rám-szakadékhoz'
    ];

    $helyszinek = ['Városliget', 'Népsziget', 'Gellért-hegy', 'Kopaszi-gát', 'Hajógyári-sziget'];

    foreach (range(1, 30) as $i) {
        Event::create([
            'user_id' => $users->random()->id, // Véletlen gazda a 10-ből
            'category_id' => $categories->random()->id, // Véletlen kategória a 20-ból
            'title' => $cimek[array_rand($cimek)] . " ($i.)",
            'event_date' => Carbon::now()->addDays(rand(1, 50)),
            'location' => $helyszinek[array_rand($helyszinek)],
            'description' => 'Gyere el te is a kedvenceddel! Ez egy közösségi esemény kutyásoknak, ahol tapasztalatot cserélhetünk és a kutyák is jól érezhetik magukat.',
        ]);
    }
    }
}
