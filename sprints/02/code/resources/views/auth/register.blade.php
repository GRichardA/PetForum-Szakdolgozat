@extends('layouts.app')

@section('title', 'Regisztráció')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">
            Regisztráció
        </h2>
        <p class="text-center text-gray-500 mb-8">
            Hozzon létre fiókot, hogy jelentkezhessen eseményekre és hozhasson létre sajátot.
        </p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Név -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Név</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- E-mail cím -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail cím</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jelszó -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Jelszó (min. 8 karakter)</label>
                <div class="password-input-wrap">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full pr-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                    <button type="button" class="password-toggle-btn" data-target="password" aria-pressed="false" title="Jelszó mutatása">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8c1.73 2.89 5 5 9 5s7.27-2.11 9-5c-1.73-2.89-5-5-9-5zM10 11a3 3 0 100-6 3 3 0 000 6z"/></svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jelszó megerősítése -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Jelszó megerősítése</label>
                <div class="password-input-wrap">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full pr-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="button" class="password-toggle-btn" data-target="password_confirmation" aria-pressed="false" title="Jelszó mutatása">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8c1.73 2.89 5 5 9 5s7.27-2.11 9-5c-1.73-2.89-5-5-9-5zM10 11a3 3 0 100-6 3 3 0 000 6z"/></svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <a class="text-sm text-indigo-600 hover:text-indigo-700 font-medium mr-4" href="{{ route('login') }}">
                    Már van fiókom
                </a>
                <button type="submit" class="w-full md:w-auto px-6 py-2 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Regisztrálok
                </button>
            </div>
        </form>
    </div>
</div>
@endsection