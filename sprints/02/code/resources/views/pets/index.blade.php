@extends('layouts.app')

@section('title', 'Kisállatok')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kisállatok</h1>
                <p class="text-sm text-gray-600">A profilodhoz tartozó kisállatok kezelése.</p>
            </div>
            <a href="{{ route('profile.pets.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Új kisállat
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
        @endif

        <div class="grid gap-4 md:grid-cols-2">
            @forelse($pets as $pet)
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $pet->name }}</h2>
                            <p class="text-sm text-gray-600">{{ $pet->animal_type }} · {{ $pet->breed }}</p>
                            <p class="mt-2 text-sm text-gray-600">Oltás: {{ $pet->vaccination_date ? $pet->vaccination_date->format('Y-m-d') : 'nincs megadva' }}</p>
                        </div>

                        <div class="flex flex-col gap-2 text-sm">
                            <a href="{{ route('profile.pets.edit', $pet) }}" class="text-indigo-600 hover:text-indigo-800">Szerkesztés</a>
                            <form action="{{ route('profile.pets.destroy', $pet) }}" method="POST" onsubmit="return confirm('Biztosan törlöd ezt a kisállatot?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">Törlés</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-gray-600 md:col-span-2">
                    Még nincs felvett kisállatod.
                </div>
            @endforelse
        </div>
    </div>
@endsection