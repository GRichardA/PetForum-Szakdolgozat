@extends('layouts.app')

@section('title', 'Bejelentkezés')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">
            Bejelentkezés
        </h2>
        <p class="text-center text-gray-500 mb-8">
            Üdvözöljük újra! Lépjen be a fiókjába.
        </p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- E-mail cím -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail cím</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jelszó -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Jelszó</label>
                <div class="password-input-wrap">
                    <input id="password" type="password" name="password" required
                           class="w-full pr-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                    <button type="button" class="password-toggle-btn" data-target="password" aria-pressed="false" title="Jelszó mutatása">
                        <!-- eye icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8c1.73 2.89 5 5 9 5s7.27-2.11 9-5c-1.73-2.89-5-5-9-5zM10 11a3 3 0 100-6 3 3 0 000 6z"/></svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Emlékezzen rám -->
            <div class="mb-6 flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Emlékezzen rám
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <a class="text-sm text-indigo-600 hover:text-indigo-700 font-medium mr-4" href="{{ route('register') }}">
                    Nincs még fiókom
                </a>
                <button type="submit" class="w-full md:w-auto px-6 py-2 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Bejelentkezés
                </button>
            </div>
        </form>
    </div>
</div>
@endsection