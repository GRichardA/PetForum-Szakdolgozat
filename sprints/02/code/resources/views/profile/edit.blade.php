@extends('layouts.app')

@section('title', 'Profil szerkesztése')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Profil szerkesztése</h1>

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
                <input type="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jelszó megerősítése</label>
                <input type="password" name="password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Mentés</button>
            </div>
        </form>
    </div>
@endsection
