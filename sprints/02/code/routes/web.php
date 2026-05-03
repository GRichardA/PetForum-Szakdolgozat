<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController; // ÚJ: AuthController importálása
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Kezdőoldal átirányítása az események listájára
Route::get('/', function () {
    return redirect()->route('events.index');
});

// Események CRUD útvonalai
// MEGLÉVŐ: Megtartjuk az Ön resource útvonalát
Route::resource('events', EventController::class);

// ÚJ ÚTVONAL: Saját események listázása (csak bejelentkezett felhasználóknak)
// Ez az útvonal köti össze a myEvents nézetet (my_events.blade.php) az EventController@myEvents metódussal.
Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.myEvents')->middleware('auth');


// HITELTESÍTÉS ÚTVONALAI (Sprint 3 Vertikális Szelet)
Route::controller(AuthController::class)->group(function () {
    // Bejelentkezés
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');

    // Regisztráció
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    
    // Kijelentkezés
    Route::post('/logout', 'logout')->name('logout');
});

// Profil szerkesztés (csak autentikált felhasználók)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Serve uploaded avatars through Laravel to avoid possible symlink/webserver issues
Route::get('/user-avatars/{filename}', function ($filename) {
    $path = storage_path('app/public/avatars/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('user.avatar');

// Comments
Route::post('/events/{event}/comments', [CommentController::class, 'store'])->name('events.comments.store')->middleware('auth');
Route::delete('/events/{event}/comments/{comment}', [CommentController::class, 'destroy'])->name('events.comments.destroy')->middleware('auth');

// Admin Routes (csak admin felhasználók számára)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('categories', AdminController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('categories', [AdminController::class, 'categoriesIndex'])->name('categories.index');
    Route::get('categories/create', [AdminController::class, 'categoriesCreate'])->name('categories.create');
    Route::post('categories', [AdminController::class, 'categoriesStore'])->name('categories.store');
    Route::get('categories/{category}/edit', [AdminController::class, 'categoriesEdit'])->name('categories.edit');
    Route::put('categories/{category}', [AdminController::class, 'categoriesUpdate'])->name('categories.update');
    Route::delete('categories/{category}', [AdminController::class, 'categoriesDestroy'])->name('categories.destroy');
    
    Route::get('events', [AdminController::class, 'eventsIndex'])->name('events.index');
    Route::delete('events/{event}', [AdminController::class, 'eventsDestroy'])->name('events.destroy');
});

// Health
use App\Http\Controllers\HealthController;
Route::get('/health', [HealthController::class, 'index'])->name('health');