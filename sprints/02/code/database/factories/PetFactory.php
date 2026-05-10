<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
	protected $model = Pet::class;

	public function definition(): array
	{
		// Kiterjesztett magyar kisállat nevek
		$petNames = [
			'Bodri', 'Buksi', 'Morzsi', 'Pufi', 'Kormi', 'Lili', 'Manci', 'Cirmos', 'Mici', 'Mancs',
			'Pötty', 'Tüsi', 'Luna', 'Pityu', 'Csipesz', 'Hópihe', 'Bogyó', 'Barka', 'Rex', 'Bella',
			'Max', 'Charlie', 'Daisy', 'Molly', 'Bailey', 'Lucy', 'Cooper', 'Sadie', 'Bruno', 'Oscar',
			'Simba', 'Nala', 'Tiger', 'Mittens', 'Whiskers', 'Zsa-Zsa', 'Fluffy', 'Bandit', 'Duke', 'Lady',
			'Snoopy', 'Scooby', 'Szajkó', 'Piki', 'Csina', 'Fejfű', 'Bundás', 'Füles', 'Farkas', 'Hangyász'
		];

		$animalType = $this->faker->randomElement(['kutya', 'macska', 'madár', 'nyúl']);

		$breeds = [
			'kutya' => [
				'német juhász', 'labrador', 'golden retriever', 'tacskó', 'uszkár', 'schnauzer', 
				'pudli', 'bulldog', 'boxer', 'beagle', 'border collie', 'springer spaniel', 
				'vizsla', 'szetter', 'papír'
			],
			'macska' => [
				'perzsa', 'sziámi', 'maine coon', 'brit rövidszőrű', 'angóra', 'bengáli', 'devon rex', 'sfinx'
			],
			'madár' => ['kanári', 'papagáj', 'pinty', 'papagájkakadu'],
			'nyúl' => ['törpenyúl', 'holland törpe', 'angóra nyúl'],
		];

		return [
			'user_id' => User::factory(),
			'name' => $this->faker->randomElement($petNames),
			'animal_type' => $animalType,
			'breed' => $this->faker->randomElement($breeds[$animalType]),
			'vaccination_date' => $this->faker->boolean(75) ? $this->faker->dateTimeBetween('-12 months', 'now') : null,
		];
	}
}
