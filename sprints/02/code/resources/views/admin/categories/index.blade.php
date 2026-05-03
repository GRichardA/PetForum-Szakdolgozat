@extends('layouts.app')

@section('title', 'Kategóriák Kezelése')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 mb-2 inline-block">← Vissza az Admin Panelre</a>
            <h1 class="text-3xl font-bold dark:text-white">Kategóriák Kezelése</h1>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            + Új Kategória
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 dark:bg-green-900 dark:border-green-600 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-slate-700 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Név</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Slug</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Szín</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b hover:bg-gray-50 dark:hover:bg-slate-700">
                        <td class="px-6 py-3 text-sm dark:text-gray-300">{{ $category->name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $category->slug }}</td>
                        <td class="px-6 py-3 text-sm">
                            @if($category->color_code)
                                <span class="inline-block w-6 h-6 rounded" style="background-color: {{ $category->color_code }};" title="{{ $category->color_code }}"></span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right text-sm space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">Szerkesztés</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Törlés</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-center text-gray-500 dark:text-gray-400">Nincs kategória</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
