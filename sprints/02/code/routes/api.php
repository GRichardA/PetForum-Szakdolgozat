<?php

use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/events', [EventApiController::class, 'index'])->name('api.v1.events.index');
    Route::get('/events/{event}', [EventApiController::class, 'show'])->name('api.v1.events.show');
    Route::get('/health', [HealthController::class, 'index'])->name('api.v1.health');
});
