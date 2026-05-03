@extends('layouts.app')

@section('title', 'Események Moderálása')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 mb-2 inline-block">← Vissza az Admin Panelre</a>
        <h1 class="text-3xl font-bold dark:text-white">Események Moderálása</h1>
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
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Cím</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Szerző</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Kategória</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Dátum</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr class="border-b hover:bg-gray-50 dark:hover:bg-slate-700">
                        <td class="px-6 py-3 text-sm font-medium dark:text-gray-300">
                            <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:underline dark:text-indigo-400">
                                {{ Str::limit($event->title, 30) }}
                            </a>
                        </td>
                        <td class="px-6 py-3 text-sm dark:text-gray-300">{{ $event->user->name ?? 'Ismeretlen' }}</td>
                        <td class="px-6 py-3 text-sm">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded text-xs">{{ $event->category->name ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-500 dark:text-gray-400">
                            @if($event->event_date)
                                {{ $event->event_date->format('Y.m.d H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right text-sm">
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd az eseményt?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Törlés</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-center text-gray-500 dark:text-gray-400">Nincs esemény</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
@endsection
