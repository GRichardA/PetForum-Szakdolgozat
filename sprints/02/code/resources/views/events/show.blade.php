@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-100">
        {{-- Vissza a listához --}}
        <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-500 font-medium mb-6 inline-block">
            &larr; Vissza az eseményekhez
        </a>
        
        {{-- Fő Cím és Kategória --}}
        <div class="flex justify-between items-start mb-6 border-b pb-4">
            <h1 class="text-4xl font-extrabold text-gray-900 leading-tight pr-4">{{ $event->title }}</h1>
            
            {{-- Kategória jelvény (a color_code alapján) --}}
            <span style="background-color: {{ $event->category->color_code ?? '#6b7280' }}" 
                  class="text-white text-sm font-semibold px-3 py-1.5 rounded-full shadow-md whitespace-nowrap">
                {{ $event->category->name }}
            </span>
        </div>

        {{-- Esemény Részletek --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10 mb-8">
            {{-- Dátum és Idő --}}
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Dátum és Idő</p>
                <p class="mt-1 text-lg font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($event->event_date)->isoFormat('YYYY. MMMM D. (dddd) HH:mm') }}
                </p>
            </div>
            
            {{-- Helyszín --}}
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Helyszín</p>
                <p class="mt-1 text-lg font-semibold text-gray-800">{{ $event->location }}</p>
            </div>
            
            {{-- Létrehozta --}}
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Létrehozta</p>
                <p class="mt-1 text-lg text-gray-800">{{ $event->user->name ?? 'Ismeretlen felhasználó' }}</p>
            </div>

            {{-- Kezelő Gombok (csak tulajdonosnak) --}}
            @auth
                @if ($event->user_id === Auth::id())
                    <div class="flex space-x-4 mt-6 md:mt-0 items-center justify-start md:justify-end">
                        <a href="{{ route('events.edit', $event->id) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 shadow-sm transition duration-150">
                            Szerkesztés
                        </a>
                        
                        {{-- Törlési Form --}}
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Biztosan törölni szeretné ezt az eseményt? A művelet visszavonhatatlan!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 shadow-sm transition duration-150">
                                Törlés
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <h2 class="text-lg font-bold text-gray-900 mb-3">Pet-feltételek</h2>
                <p class="text-sm text-gray-600 mb-2">Elfogadott állattípusok:</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    @forelse($event->allowed_animal_types ?? [] as $type)
                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-sm text-indigo-700">{{ $type }}</span>
                    @empty
                        <span class="text-sm text-gray-500">Nincs megadott korlátozás.</span>
                    @endforelse
                </div>

                <p class="text-sm text-gray-600 mb-2">Elfogadott fajták:</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    @forelse($event->allowed_breeds ?? [] as $breed)
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm text-emerald-700">{{ $breed }}</span>
                    @empty
                        <span class="text-sm text-gray-500">Nincs megadott korlátozás.</span>
                    @endforelse
                </div>

                <div class="text-sm text-gray-700 space-y-1">
                    <p>Oltás szükséges: <strong>{{ $event->vaccination_required ? 'igen' : 'nem' }}</strong></p>
                    <p>Kapacitás: <strong>{{ $event->capacity ?? 'nincs megadva' }}</strong></p>
                    <p>Jelentkezések száma: <strong>{{ $event->confirmedRegistrations->count() }}</strong></p>
                    @if($event->capacity !== null)
                        <p>Szabad hely: <strong>{{ $event->availableSpots() }}</strong></p>
                    @endif
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h2 class="text-lg font-bold text-gray-900 mb-3">Jelentkezés kisállattal</h2>

                @auth
                    @if($userPets->isEmpty())
                        <p class="text-sm text-gray-600 mb-3">Még nincs felvett kisállatod.</p>
                        <a href="{{ route('profile.pets.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Kisállat felvétele</a>
                    @else
                        @if($event->isFull())
                            <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700">Az esemény betelt.</div>
                        @endif

                        <form action="{{ route('events.registrations.store', $event) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="pet_id" class="block text-sm font-medium text-gray-700 mb-1">Válassz kisállatot</label>
                                <select name="pet_id" id="pet_id" class="block w-full rounded-md border border-gray-300 p-2.5">
                                    <option value="">Válassz...</option>
                                    @foreach($userPets as $pet)
                                        <option value="{{ $pet->id }}">{{ $pet->name }} ({{ $pet->animal_type }}, {{ $pet->breed }})</option>
                                    @endforeach
                                </select>
                                @error('pet_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:cursor-not-allowed disabled:bg-gray-400" {{ $event->isFull() ? 'disabled' : '' }}>
                                Jelentkezés
                            </button>
                        </form>
                    @endif

                    @if($myRegistrations->isNotEmpty())
                        <div class="mt-6 border-t pt-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">A te jelentkezéseid</h3>
                            <div class="space-y-3">
                                @foreach($myRegistrations as $registration)
                                    <div class="flex items-center justify-between rounded-md bg-gray-50 p-3">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $registration->pet->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $registration->pet->animal_type }} · {{ $registration->pet->breed }}</div>
                                        </div>
                                        <form action="{{ route('events.registrations.destroy', [$event, $registration]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Leiratkozás</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <p class="text-sm text-gray-600">Jelentkezéshez be kell jelentkezned.</p>
                @endauth
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-3">Résztvevő kisállatok</h2>
            <div class="grid gap-3 md:grid-cols-2">
                @forelse($event->registrations as $registration)
                    <div class="rounded-md bg-gray-50 p-3">
                        <div class="font-medium text-gray-900">{{ $registration->pet->name }}</div>
                        <div class="text-sm text-gray-600">{{ $registration->pet->animal_type }} · {{ $registration->pet->breed }}</div>
                        <div class="text-xs text-gray-500">Gazdi: {{ $registration->user->name }}</div>
                    </div>
                @empty
                    <p class="text-sm text-gray-600">Még nincs jelentkező.</p>
                @endforelse
            </div>
        </div>

        {{-- Leírás --}}
        <div class="pt-6 border-t mt-6">
            <h2 class="text-xl font-bold text-gray-900 mb-3">Részletes Leírás</h2>
            <div class="text-gray-700 leading-relaxed space-y-4">
                {{-- FONTOS JAVÍTÁS: A hosszú szöveget nl2br-rel formázzuk és kódoljuk a biztonságért --}}
                <p>{!! nl2br(e($event->description)) !!}</p>
            </div>
        </div>
        
        {{-- Hozzászólások szekció --}}
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow mt-6 border border-gray-100">
            <h3 class="text-lg font-bold mb-4">Hozzászólások</h3>

            @auth
                <form action="{{ route('events.comments.store', $event->id) }}" method="POST" class="mb-4">
                    @csrf
                    <textarea name="body" rows="3" class="w-full border rounded p-3" placeholder="Írj hozzászólást..."></textarea>
                    <div class="mt-2 text-right">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Hozzászólás</button>
                    </div>
                </form>
            @else
                <p class="text-sm text-gray-600 mb-4">Jelentkezz be a hozzászóláshoz.</p>
            @endauth

            <div>
                @forelse($event->comments as $comment)
                    @include('events._comment', ['comment' => $comment])
                @empty
                    <p class="text-sm text-gray-600">Még nincs hozzászólás.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection