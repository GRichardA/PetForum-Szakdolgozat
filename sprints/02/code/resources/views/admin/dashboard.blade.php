@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-4xl font-bold mb-8 dark:text-white">Admin Panel</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Összes Esemény</h3>
            <p class="text-4xl font-bold text-indigo-600">{{ $totalEvents }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Kategóriák</h3>
            <p class="text-4xl font-bold text-indigo-600">{{ $totalCategories }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Felhasználók</h3>
            <p class="text-4xl font-bold text-indigo-600">{{ $totalUsers }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4 dark:text-white">Kezelési Lehetőségek</h2>
        <div class="space-y-3">
            <a href="{{ route('admin.categories.index') }}" class="block p-4 bg-indigo-50 dark:bg-indigo-900 hover:bg-indigo-100 dark:hover:bg-indigo-800 rounded-lg border border-indigo-200 dark:border-indigo-700 transition dark:text-white">
                <strong class="dark:text-white">Kategóriák kezelése</strong><br>
                <small class="dark:text-white">Új kategóriákat hozhat létre, szerkeszthet és törölhet</small>
            </a>
            <a href="{{ route('admin.events.index') }}" class="block p-4 bg-red-50 dark:bg-red-900 hover:bg-red-100 dark:hover:bg-red-800 rounded-lg border border-red-200 dark:border-red-700 transition dark:text-white">
                <strong class="dark:text-white">Események Moderálása</strong><br>
                <small class="dark:text-white">Megtekintheti és törölheti az eseményeket</small>
            </a>
        </div>
    </div>
</div>
@endsection
