<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Pet;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
	public function run(): void
	{
		$events = Event::all();
		$pets = Pet::all();

		foreach ($events as $event) {
			$eligiblePets = $pets->filter(function (Pet $pet) use ($event) {
				return $event->canRegisterPet($pet);
			})->shuffle();

			if ($eligiblePets->isEmpty()) {
				continue;
			}

			$count = min($eligiblePets->count(), random_int(1, min(3, $eligiblePets->count())));

			foreach ($eligiblePets->take($count) as $pet) {
				Registration::firstOrCreate([
					'event_id' => $event->id,
					'pet_id' => $pet->id,
				], [
					'user_id' => $pet->user_id,
					'status' => 'confirmed',
				]);
			}
		}
	}
}
