@extends('layouts.app')

@section('title', 'Saját Eseményeim')

@section('content')
    {{-- 1. Fejléc és Új Esemény Gomb --}}
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Saját Szervezésű Eseményeim</h1>
            <p class="mt-1 text-gray-500">Itt láthatod a te általad létrehozott közelgő eseményeket.</p>
        </div>
        <div class="flex-shrink-0">
             <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Új Esemény
            </a>
        </div>
    </div>
    
    {{-- Kategória Szűrősáv --}}
    {{-- Mivel a Controller a myEvents metódusban is megkapja a kategóriákat, a szűrő használható --}}
    <div class="mb-8 flex flex-wrap gap-2 p-3 bg-gray-50 rounded-lg border border-gray-100 shadow-inner">
        
        @php
            // A request()->query('category') lekérdezés ugyanaz, de a route neve eltér: events.myEvents
            $currentCategorySlug = request()->query('category');
            
            $baseBtnClass = 'px-4 py-2 text-sm font-medium rounded-full transition duration-200';
            $activeClasses = 'bg-indigo-600 text-white shadow-lg border-indigo-600';
            $inactiveClasses = 'bg-white text-gray-700 hover:bg-indigo-50 hover:text-white border border-gray-300';
            
            $isAllActive = $currentCategorySlug === null;
        @endphp
        
        {{-- "Összes Esemény" Gomb (saját eseményekre szűrve) --}}
        <a href="{{ route('events.myEvents') }}" 
           class="{{ $baseBtnClass }} {{ $isAllActive ? $activeClasses : $inactiveClasses }}">
            Összes Saját Esemény
        </a>

        {{-- Dinamikus Kategória Gombok (ugyanazt a myEvents route-ot használva) --}}
        @if (isset($categories))
            @foreach ($categories as $category)
                @php
                    $isActive = $currentCategorySlug === $category->slug;
                @endphp
                <a href="{{ route('events.myEvents', ['category' => $category->slug]) }}" 
                   class="{{ $baseBtnClass }} {{ $isActive ? '' : $inactiveClasses }}"
                   {{-- Aktív gomb stílusa a kategória színkódjával --}}
                   @if ($isActive && $category->color_code)
                        style="background-color: {{ $category->color_code }}; border-color: {{ $category->color_code }}; color: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);"
                   @elseif ($isActive)
                        class="{{ $activeClasses }}"
                   @endif
                   >
                    {{ $category->name }}
                </a>
            @endforeach
        @endif
    </div>
    
    {{-- Események listája vagy üres állapot --}}
    @if($events->isEmpty())
        @php
            $currentCategorySlug = request()->query('category');
            $message = $currentCategorySlug ? 'Ebben a kategóriában még nem hoztál létre eseményt.' : 'Még nem hoztál létre egy eseményt sem.';
            $subtext = $currentCategorySlug ? 'Próbálj más szűrőt, vagy hozz létre újat!' : 'Kezdd el a szervezést most!';
        @endphp
        <div class="text-center py-16 bg-white rounded-lg shadow-sm border border-gray-100">
            <div class="text-6xl mb-4">✍️</div>
            <h3 class="text-lg font-medium text-gray-900">{{ $message }}</h3>
            <p class="mt-1 text-gray-500">{{ $subtext }}</p>
            <div class="mt-6">
                @if($currentCategorySlug)
                    <a href="{{ route('events.myEvents') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                        Szűrők törlése &rarr;
                    </a>
                @else
                    <a href="{{ route('events.create') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                        Esemény létrehozása &rarr;
                    </a>
                @endif
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col h-full">
                    <div class="p-6 flex-grow">
                        <div class="flex items-center justify-between mb-4">
                            
                            {{-- Kategória Címke --}}
                            @if ($event->category)
                                @php
                                    $color = $event->category->color_code ?? '#4F46E5';
                                    // Áttetsző háttér (1A = kb. 10% alpha) a szebb megjelenésért
                                    $bgColor = $event->category->color_code ? $event->category->color_code . '1A' : 'rgb(238 242 255)'; // Indigo-50
                                    $textColor = $event->category->color_code ? $color : '#4F46E5';
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full"
                                      style="background-color: {{ $bgColor }}; color: {{ $textColor }}; border: 1px solid {{ $color }}4D;">
                                    {{ $event->category->name }}
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                    Nincs Kategória
                                </span>
                            @endif
                            
                            <!-- Dátum -->
                            <span class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('Y.m.d H:i') }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 flex items-center">
                            📍 {{ $event->location }}
                        </p>
                        <p class="text-gray-500 text-sm line-clamp-3">
                            {{ $event->description ?? 'Nincs leírás megadva.' }}
                        </p>
                    </div>
                    {{-- A Saját Események oldalon MINDIG megjelenítjük a szerkesztés/törlés gombokat --}}
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                        <a href="{{ route('events.edit', $event->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                            Szerkesztés
                        </a>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Biztosan törölni akarod?')" class="text-sm text-red-600 hover:text-red-900 font-medium">
                                Törlés
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection