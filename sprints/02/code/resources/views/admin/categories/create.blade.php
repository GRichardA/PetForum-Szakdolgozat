@extends('layouts.app')

@section('title', 'Új Kategória')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 mb-2 inline-block">← Vissza</a>
    <h1 class="text-3xl font-bold mb-6 dark:text-white">Új Kategória</h1>

    <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategória Neve</label>
                <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror dark:bg-slate-700 dark:text-white"
                       value="{{ old('name') }}" maxlength="16">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="color_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Szín (pl. #FF5733)</label>
                <div class="flex gap-2">
                    <input type="text" id="color_code" name="color_code" placeholder="#FF5733" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('color_code') border-red-500 @enderror dark:bg-slate-700 dark:text-white"
                           value="{{ old('color_code') }}">
                    <div id="color_preview" class="w-12 h-12 border-2 border-gray-300 dark:border-gray-600 rounded-lg"></div>
                </div>
                @error('color_code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2 justify-end mt-6">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    Mégse
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Létrehozás
                </button>
            </div>
        </form>
    </div>

    <script>
        const colorInput = document.getElementById('color_code');
        const preview = document.getElementById('color_preview');
        
        function updatePreview() {
            if (colorInput.value && /^#[0-9A-F]{6}$/i.test(colorInput.value)) {
                preview.style.backgroundColor = colorInput.value;
            } else {
                preview.style.backgroundColor = 'transparent';
            }
        }
        
        colorInput.addEventListener('input', updatePreview);
        updatePreview();
    </script>
</div>
@endsection
