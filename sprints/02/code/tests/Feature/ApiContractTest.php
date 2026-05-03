<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_show_returns_404_for_missing_event(): void
    {
        $response = $this->getJson('/api/v1/events/999999');

        $response->assertNotFound();
    }
}
