<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Megjeleníti a regisztrációs űrlapot.
     */
    public function showRegisterForm()
    {
        // Ha a felhasználó már be van jelentkezve, átirányítjuk az események listájára.
        if (Auth::check()) {
            return redirect()->route('events.index');
        }

        return view('auth.register');
    }

    /**
     * Kezeli az új felhasználó regisztrációját.
     */
    public function register(Request $request)
    {
        // 1. Validáció
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'A név megadása kötelező.',
            'email.unique' => 'Ez az e-mail cím már regisztrálva van.',
            'password.min' => 'A jelszónak legalább 8 karakter hosszúnak kell lennie.',
            'password.confirmed' => 'A jelszavak nem egyeznek.',
        ]);

        // 2. Felhasználó létrehozása
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Automatikus bejelentkezés
        Auth::login($user);

        return redirect()->route('events.index')->with('success', 'Sikeres regisztráció! Üdvözlünk a PetShop Közösségben!');
    }

    /**
     * Megjeleníti a bejelentkezési űrlapot.
     */
    public function showLoginForm()
    {
        // Ha a felhasználó már be van jelentkezve, átirányítjuk az események listájára.
        if (Auth::check()) {
            return redirect()->route('events.index');
        }

        return view('auth.login');
    }

    /**
     * Kezeli a felhasználó bejelentkezését.
     */
    public function login(Request $request)
    {
        // 1. Validáció
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Az e-mail cím megadása kötelező.',
            'password.required' => 'A jelszó megadása kötelező.',
        ]);

        // 2. Hitelesítés
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('events.index'))->with('success', 'Sikeres bejelentkezés!');
        }

        return back()->withErrors([
            'email' => 'A megadott hitelesítő adatok nem egyeznek a nyilvántartásunkban lévőkkel.',
        ])->onlyInput('email');
    }

    /**
     * Kezeli a felhasználó kijelentkezését.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('events.index')->with('success', 'Sikeresen kijelentkeztél.');
    }
}