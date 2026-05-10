<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pet;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Event $event)
    {
        $data = $request->validate([
            'pet_id' => ['required', 'integer', 'exists:pets,id'],
        ]);

        $pet = Pet::where('user_id', Auth::id())->findOrFail($data['pet_id']);

        if (! $event->canRegisterPet($pet)) {
            return back()->withErrors(['pet_id' => 'Ez a kisállat nem felel meg az esemény feltételeinek.']);
        }

        if ($event->isFull()) {
            return back()->withErrors(['pet_id' => 'Az esemény betelt.']);
        }

        Registration::firstOrCreate([
            'event_id' => $event->id,
            'pet_id' => $pet->id,
        ], [
            'user_id' => Auth::id(),
            'status' => 'confirmed',
        ]);

        return redirect()->route('events.show', $event)->with('success', 'Sikeres jelentkezés.');
    }

    public function destroy(Event $event, Registration $registration)
    {
        if ($registration->event_id !== $event->id) {
            abort(404);
        }

        if (! $registration->canBeCancelledBy(Auth::id())) {
            abort(403);
        }

        $registration->delete();

        return redirect()->route('events.show', $event)->with('success', 'A jelentkezés törölve.');
    }
}