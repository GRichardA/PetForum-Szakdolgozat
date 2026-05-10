@extends('layouts.app')

@section('title', 'Profil szerkesztése')

@section('content')
    <div class="max-w-2xl mx-auto">
        @if(Auth::user()->is_admin)
            <div class="mb-6 p-4 bg-indigo-50 border-l-4 border-indigo-400 rounded">
                <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    → Admin Panel
                </a>
            </div>
        @endif

        <div class="bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Profil szerkesztése</h1>

        <div class="mb-6 rounded-lg border border-indigo-100 bg-indigo-50 p-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Kisállatok</h2>
                    <p class="text-sm text-gray-600">A profilodhoz tartozó kisállatok kezelése.</p>
                </div>
                <a href="{{ route('profile.pets.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Kisállatok kezelése
                </a>
            </div>

            @if($user->pets->isNotEmpty())
                <div class="mt-4 grid gap-3 md:grid-cols-2">
                    @foreach($user->pets as $pet)
                        <div class="rounded-md bg-white p-3 shadow-sm">
                            <div class="font-medium text-gray-900">{{ $pet->name }}</div>
                            <div class="text-sm text-gray-600">{{ $pet->animal_type }} · {{ $pet->breed }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                <ul class="list-disc ml-5 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4">
                <div>
                    <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Feltöltés</label>
                    <input type="file" name="avatar" accept="image/*" class="mt-1" />
                    <p class="text-xs text-gray-500 mt-1">Max 2MB. JPG, PNG, GIF, SVG.</p>
                </div>
            </div>

            <div>
                <p class="mb-2 text-sm font-medium">Vagy válassz egy alap képet</p>
                <div class="flex gap-4">
                    <label class="flex flex-col items-center text-center">
                        <input type="radio" name="avatar_choice" value="default-1" {{ old('avatar_choice', $user->avatar_choice) === 'default-1' ? 'checked' : '' }} />
                        <img src="{{ asset('images/avatars/default-1.svg') }}" class="w-16 h-16 mt-2" />
                    </label>
                    <label class="flex flex-col items-center text-center">
                        <input type="radio" name="avatar_choice" value="default-2" {{ old('avatar_choice', $user->avatar_choice) === 'default-2' ? 'checked' : '' }} />
                        <img src="{{ asset('images/avatars/default-2.svg') }}" class="w-16 h-16 mt-2" />
                    </label>
                    <label class="flex flex-col items-center text-center">
                        <input type="radio" name="avatar_choice" value="default-avatar" {{ old('avatar_choice', $user->avatar_choice) === 'default-avatar' ? 'checked' : '' }} />
                        <img src="{{ asset('images/avatars/default-avatar.svg') }}" class="w-16 h-16 mt-2" />
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Név</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Új jelszó (opcionális)</label>
                <div class="password-input-wrap">
                    <input id="profile_password" type="password" name="password" class="mt-1 block w-full pr-10 border border-gray-300 rounded-md p-2" />
                    <button type="button" class="password-toggle-btn" data-target="profile_password" aria-pressed="false" title="Jelszó mutatása">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8c1.73 2.89 5 5 9 5s7.27-2.11 9-5c-1.73-2.89-5-5-9-5zM10 11a3 3 0 100-6 3 3 0 000 6z"/></svg>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jelszó megerősítése</label>
                <div class="password-input-wrap">
                    <input id="profile_password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full pr-10 border border-gray-300 rounded-md p-2" />
                    <button type="button" class="password-toggle-btn" data-target="profile_password_confirmation" aria-pressed="false" title="Jelszó mutatása">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8c1.73 2.89 5 5 9 5s7.27-2.11 9-5c-1.73-2.89-5-5-9-5zM10 11a3 3 0 100-6 3 3 0 000 6z"/></svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Mentés</button>
            </div>
        </form>
    </div>
@endsection
