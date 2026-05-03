@extends('layouts.app')

@section('title', 'Hozzáférés Megtagadva')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">403</h1>
        <p class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-2">Hozzáférés Megtagadva</p>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Sajnos nincs jogosultságod az oldal megtekintésére.</p>
        <a href="{{ route('events.index') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Vissza az Eseményekhez
        </a>
    </div>
</div>
@endsection
