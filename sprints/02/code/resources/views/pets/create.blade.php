@extends('layouts.app')

@section('title', 'Új kisállat')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Új kisállat felvétele</h1>

        <form action="{{ route('profile.pets.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Név</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-md border border-gray-300 p-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Állattípus</label>
                <input type="text" name="animal_type" value="{{ old('animal_type') }}" placeholder="kutya" class="w-full rounded-md border border-gray-300 p-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fajta</label>
                <input type="text" name="breed" value="{{ old('breed') }}" placeholder="német juhász" class="w-full rounded-md border border-gray-300 p-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Oltás dátuma</label>
                <input type="date" name="vaccination_date" value="{{ old('vaccination_date') }}" class="w-full rounded-md border border-gray-300 p-2.5">
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('profile.pets.index') }}" class="text-sm text-gray-600 hover:text-gray-800">Vissza</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Mentés</button>
            </div>
        </form>
    </div>
@endsection