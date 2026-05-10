<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pets = Auth::user()->pets()->orderBy('name')->get();

        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(StorePetRequest $request)
    {
        Auth::user()->pets()->create($request->validated());

        return redirect()->route('profile.pets.index')->with('success', 'A kisállat sikeresen mentve.');
    }

    public function edit(Pet $pet)
    {
        $this->ensureOwnership($pet);

        return view('pets.edit', compact('pet'));
    }

    public function update(StorePetRequest $request, Pet $pet)
    {
        $this->ensureOwnership($pet);

        $pet->update($request->validated());

        return redirect()->route('profile.pets.index')->with('success', 'A kisállat frissítve.');
    }

    public function destroy(Pet $pet)
    {
        $this->ensureOwnership($pet);

        $pet->delete();

        return redirect()->route('profile.pets.index')->with('success', 'A kisállat törölve.');
    }

    private function ensureOwnership(Pet $pet): void
    {
        $user = Auth::user();

        if ($pet->user_id !== $user->id && ! $user->is_admin) {
            abort(403);
        }
    }
}