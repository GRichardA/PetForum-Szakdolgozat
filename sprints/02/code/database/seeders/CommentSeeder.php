<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::all();
        $users = User::all();

        if ($events->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($events->take(10) as $event) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                Comment::create([
                    'event_id' => $event->id,
                    'user_id' => $users->random()->id,
                    'parent_id' => null,
                    'body' => 'Teszt hozzászólás az eseményhez.',
                ]);
            }
        }
    }
}