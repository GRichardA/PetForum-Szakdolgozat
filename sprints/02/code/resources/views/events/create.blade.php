@extends('layouts.app')

@section('title', 'Új Esemény')

@section('content')
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Új Esemény Hozzáadása</h1>

    <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-100">
        <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-500 font-medium mb-6 inline-block">
            &larr; Vissza a listához
        </a>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                <p class="font-bold text-red-700">Hiba történt a mentés során:</p>
                <ul class="list-disc ml-5 text-sm text-red-600 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
            @csrf 
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Esemény címe:</label>
                <input type="text" name="title" id="title" required 
                       value="{{ old('title') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
            </div>

             <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategória:</label>
                <select name="category_id" id="category_id" required 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                    <option value="">Válassz kategóriát</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Dátum és Idő:</label>
                <input type="datetime-local" name="event_date" id="event_date" required 
                       value="{{ old('event_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Helyszín:</label>
                <input type="text" name="location" id="location" required 
                       value="{{ old('location') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Leírás (opcionális):</label>
                <textarea name="description" id="description" rows="4" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 resize-y">{{ old('description') }}</textarea>
            </div>

            <div>
                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Esemény Mentése
                </button>
            </div>
        </form>
    </div>
@endsection