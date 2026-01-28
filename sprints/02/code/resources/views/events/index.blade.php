@extends('layouts.app')

@section('title', 'Események')

@section('content')
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Közelgő Események</h1>
            <p class="mt-1 text-gray-500">Találkozz a helyi kutyás közösséggel!</p>
        </div>
    </div>

    {{-- Szűrő és kereső --}}
    <div class="mb-8 p-3 bg-gray-50 rounded-lg border border-gray-100 shadow-inner">
        <form method="GET" action="{{ route('events.index') }}" class="flex flex-col md:flex-row md:items-center gap-3">
            <div class="flex items-center gap-2 md:gap-4 w-full md:w-auto">
                <label class="text-sm text-gray-600 hidden md:block">Kategória:</label>
                <select name="category" onchange="this.form.submit()" class="border rounded px-3 py-2 text-sm">
                    <option value="" {{ request('category') ? '' : 'selected' }}>Összes kategória</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kulcsszó keresése címben vagy leírásban" class="flex-1 border rounded px-3 py-2 text-sm" />
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Keresés</button>
            </div>
        </form>
    </div>
    {{-- 💡 ÚJ RÉSZ 1 VÉGE 💡 --}}

    {{-- A sikerüzenet kezelését áttettük a layouts/app.blade.php-ba! --}}
    {{-- Itt a teljes lista/kártya logika jön --}}

    {{-- 💡 ÚJ RÉSZ 2: Üres Állapot Frissítése (Kicseréli az eredeti @if($events->isEmpty()) blokkot) 💡 --}}
    @if($events->isEmpty())
        @php
            // Dinamikus üzenet a szűrés állapotának megfelelően
            $currentCategorySlug = request()->query('category');
            $message = $currentCategorySlug ? 'Ebben a kategóriában még nincsenek események.' : 'Még nincsenek események';
            $subtext = $currentCategorySlug ? 'Próbálj más szűrőt, vagy hozz létre újat!' : 'Legyél te az első szervező!';
        @endphp
        <div class="text-center py-16 bg-white rounded-lg shadow-sm border border-gray-100">
            <div class="text-6xl mb-4">🐕</div>
            <h3 class="text-lg font-medium text-gray-900">{{ $message }}</h3>
            <p class="mt-1 text-gray-500">{{ $subtext }}</p>
            <div class="mt-6">
                @if($currentCategorySlug)
                    <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                        Szűrők törlése &rarr;
                    </a>
                @else
                    <a href="{{ route('events.create') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                        Esemény létrehozása &rarr;
                    </a>
                @endif
            </div>
        </div>
    {{-- 💡 ÚJ RÉSZ 2 VÉGE 💡 --}}
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col h-full">
                    <div class="p-6 flex-grow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex space-x-2">
                                {{-- Alap 'Esemény' címke --}}
                                <span class="px-2 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 rounded-full">
                                    Esemény
                                </span>
                                
                                {{-- ÚJ: Kategória címke (színes) --}}
                                @if ($event->category)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full text-white"
                                        style="background-color: {{ $event->category->color_code ?? '#6b7280' }};">
                                        {{ $event->category->name }}
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Dátum és időpont --}}
                            <span class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('Y.m.d H:i') }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <a href="{{ route('events.show', $event->id) }}" class="hover:underline">{{ $event->title }}</a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 flex items-center">
                            📍 {{ $event->location }}
                        </p>
                        <p class="text-gray-500 text-sm line-clamp-3">
                            {{ $event->description ?? 'Nincs leírás megadva.' }}
                        </p>
                    </div>
                    
                    {{-- MÓDOSÍTOTT RÉSZ: Csak saját eseményeknél jelennek meg a gombok --}}
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                        <a href="{{ route('events.show', $event->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Megnyitás</a>

                        @if (Auth::id() === $event->user_id)
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('events.edit', $event->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Szerkesztés</a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Biztosan törölni akarod?')" class="text-sm text-red-600 hover:text-red-900 font-medium">Törlés</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection