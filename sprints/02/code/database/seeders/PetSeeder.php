<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
	public function run(): void
	{
		$users = User::where('is_admin', false)->get();

		foreach ($users as $user) {
			Pet::factory()
				->count(random_int(1, 3))
				->for($user)
				->create();
		}
	}
}
