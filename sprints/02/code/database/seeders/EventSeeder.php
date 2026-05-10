<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();

        // Valós magyar helyszínek az SQL-ből
        $locations = [
            'Margit-sziget, Budapest',
            'Városligeti Kutyapark, Budapest',
            'Népsziget, Budapest',
            'Vahúr Klinika, Budapest',
            'Zen Kert, Budapest',
            'Duna-part, Budapest',
            'Bókay-kert, Budapest',
            'Dömös, Börzsöny',
            'Hungexpo, Budapest',
            'Puskás Park, Budapest',
            'Kultúrház, Budapest',
            'Deák tér, Budapest',
            'Gödöllő, Állatklinika',
            'Rendelő, Budapest',
            'Tornaterem, Budapest',
            'Lupa Beach, Dinnyés',
            'Belváros, Budapest',
            'Városmajor, Budapest',
            'Menhely, Noé Alapítvány',
            'Béke Sziget, Budapest',
            'Blaha Lujza tér, Budapest',
            'Bikás park, Budapest',
            'Gellért-hegy, Budapest',
            'Szegedi Dugonics tér, Szeged',
            'Szegedi Városi Liget, Szeged',
            'Közösségi Állatsarok, Budapest',
            'Dunai Állatorvosi Rendelő, Budapest',
            'Zöld Völgy Park, Gödöllő',
            'Kopaszi-gát, Budapest',
        ];

        $eventTemplates = [
            [
                'title' => 'Margit-szigeti vizsla találkozó',
                'description' => 'Közös sétára várjuk a vizslás gazdákat és kutyákat. Rövid ismerkedési kör, majd szabad játék az egyik tisztáson.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['vizsla', 'magyar viszla', 'német viszla'],
                'vaccination_required' => true,
                'capacity' => 15,
            ],
            [
                'title' => 'Kezdő Agility kutyáknak',
                'description' => 'Ismerkedés az akadályokkal és az agility sporttal. Teljesen kezdőknek ajánlott, szórakoztató és egy kicsit gondolkodtató feladatok.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['német juhász', 'labrador', 'golden retriever', 'uszkár'],
                'vaccination_required' => true,
                'capacity' => 12,
            ],
            [
                'title' => 'Ingyenes szűrés kutyásoknak',
                'description' => 'Tanácsadás és alapszintű szűrés kutyásoknak. Szakértő közreműködésével, teljesen ingyen.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['német juhász', 'labrador', 'uszkár', 'tacskó'],
                'vaccination_required' => false,
                'capacity' => 25,
            ],
            [
                'title' => 'Kölyökbuli - fiatal kutyáknak',
                'description' => 'Játék 2-6 hónapos kutyáknak. Kiváló szocializációs lehetőség fiatal kedvenceinknek egy biztonságos, felügyelt környezetben.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['német juhász', 'labrador', 'golden retriever', 'uszkár', 'tacskó'],
                'vaccination_required' => false,
                'capacity' => 10,
            ],
            [
                'title' => 'Kozmetika otthon - szőrápolás',
                'description' => 'Hogyan ápoljuk a szőrt otthon? Praktikus tanácsok és technikák a kutyák szőrzete gondozásáról.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['uszkár', 'pudli', 'schnauzer', 'york', 'bikin'],
                'vaccination_required' => false,
                'capacity' => 20,
            ],
            [
                'title' => 'Nyílt nap a Menhely-ben',
                'description' => 'Gyere és sétáltass egy kisállatot! Jó lehetőség az örökbefogadásra vagy csak egy nyári nap egy jó baráttal a szabad ég alatt.',
                'allowed_animal_types' => ['kutya', 'macska', 'nyúl'],
                'allowed_breeds' => ['német juhász', 'labrador', 'uszkár', 'perzsa', 'sziámi', 'törpenyúl'],
                'vaccination_required' => false,
                'capacity' => 30,
            ],
            [
                'title' => 'Kutya-jóga - közös nyújtás',
                'description' => 'Közös nyújtás és relaxáció. Ideális a stressz csökkentésére és a közös munka erősítésére.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['labrador', 'golden retriever', 'tacskó', 'bulldog'],
                'vaccination_required' => false,
                'capacity' => 12,
            ],
            [
                'title' => 'Engedelmességi tréning',
                'description' => 'Vezényszavak gyakorlása és alapvető engedelmességi szint fejlesztése. Alapos felkészítés és sok játék.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['német juhász', 'labrador', 'border collie', 'uszkár'],
                'vaccination_required' => true,
                'capacity' => 14,
            ],
            [
                'title' => 'Frizbi bajnokság',
                'description' => 'Barátságos verseny frizbi-rajongó kutyáknak. Szórakoztató és mozgalmas program.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['border collie', 'labrador', 'vizsla'],
                'vaccination_required' => true,
                'capacity' => 18,
            ],
            [
                'title' => 'Rám-szakadék túra',
                'description' => 'Erdei túra kutyásoknak. Gyönyörű természeti körülmények és kellemes kirándulás.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['német juhász', 'labrador', 'vizsla', 'springer spaniel'],
                'vaccination_required' => true,
                'capacity' => 20,
            ],
            [
                'title' => 'Dog Show - Kutyakiállítás',
                'description' => 'Nagyobb kutyakiállítás, ahol minden fajta képviselteti magát. Eredményhirdetés, bemutató és szórakoztató program.',
                'allowed_animal_types' => ['kutya'],
                'allowed_breeds' => ['német juhász', 'labrador', 'golden retriever', 'uszkár', 'tacskó', 'bulldog', 'schnauzer'],
                'vaccination_required' => true,
                'capacity' => 100,
            ],
            [
                'title' => 'Macskás gazditalálkozó',
                'description' => 'Benti, nyugodt környezetben szervezett találkozó macskás gazdiknak. Tapasztalatcsere és jó társaság.',
                'allowed_animal_types' => ['macska'],
                'allowed_breeds' => ['perzsa', 'sziámi', 'maine coon', 'brit rövidszőrű', 'angóra'],
                'vaccination_required' => true,
                'capacity' => 10,
            ],
            [
                'title' => 'Kisállat egészségnap',
                'description' => 'Ingyenes tanácsadás, oltási ellenőrzés és alap szűrések kisállatoknak. Veterinár szakemberek segítségével.',
                'allowed_animal_types' => ['kutya', 'macska', 'nyúl', 'madár'],
                'allowed_breeds' => ['német juhász', 'labrador', 'perzsa', 'sziámi', 'törpenyúl', 'holland törpe', 'kanári'],
                'vaccination_required' => false,
                'capacity' => 40,
            ],
            [
                'title' => 'Madaras délután - papagájosok klubja',
                'description' => 'Papagájos, kanáris és pintyes gazdiknak szervezett tapasztalatcsere. Kitenyésztési tippek és gondozási tanácsok.',
                'allowed_animal_types' => ['madár'],
                'allowed_breeds' => ['kanári', 'papagáj', 'pinty', 'håda'],
                'vaccination_required' => false,
                'capacity' => 15,
            ],
            [
                'title' => 'Nyuszis piknik',
                'description' => 'Nyusziknak és gazdijaiknak szervezett rövid piknik, árnyékos, csendes helyszínen. Igazi pihenés a természetben.',
                'allowed_animal_types' => ['nyúl'],
                'allowed_breeds' => ['törpenyúl', 'holland törpe', 'angóranyúl'],
                'vaccination_required' => false,
                'capacity' => 12,
            ],
        ];

        foreach ($eventTemplates as $index => $template) {
            $user = $users[$index % $users->count()] ?? $users->first();
            $location = $locations[$index % count($locations)];
            $category = Category::inRandomOrder()->first();

            Event::create([
                'title' => $template['title'],
                'description' => $template['description'],
                'event_date' => now()->addDays(rand(2, 60)),
                'location' => $location,
                'user_id' => $user->id,
                'category_id' => $category->id,
                'allowed_animal_types' => $template['allowed_animal_types'],
                'allowed_breeds' => $template['allowed_breeds'],
                'vaccination_required' => $template['vaccination_required'],
                'capacity' => $template['capacity'],
            ]);
        }
            }
}
