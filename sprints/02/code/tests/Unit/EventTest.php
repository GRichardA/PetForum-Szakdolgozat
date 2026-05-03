<?php

namespace Tests\Unit;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_date_is_cast_to_datetime()
    {
        $date = '2026-05-15 14:30:00';
        
        $event = Event::factory()->create([
            'event_date' => $date,
        ]);

        $this->assertInstanceOf(Carbon::class, $event->event_date);
    }

    public function test_event_date_can_be_formatted()
    {
        $event = Event::factory()->create([
            'event_date' => '2026-05-15 14:30:00',
        ]);

        $formatted = $event->event_date->format('Y.m.d H:i');
        
        $this->assertEquals('2026.05.15 14:30', $formatted);
    }

    public function test_event_has_required_fields()
    {
        $event = Event::factory()->create([
            'title' => 'Dog Show',
            'description' => 'Annual dog show',
            'location' => 'City Park',
            'event_date' => now(),
        ]);

        $this->assertEquals('Dog Show', $event->title);
        $this->assertEquals('Annual dog show', $event->description);
        $this->assertEquals('City Park', $event->location);
        $this->assertNotNull($event->event_date);
    }

    public function test_event_belongs_to_user()
    {
        $event = Event::factory()->create();

        $this->assertNotNull($event->user);
    }

    public function test_event_belongs_to_category()
    {
        $event = Event::factory()->create();

        $this->assertNotNull($event->category);
    }
}
