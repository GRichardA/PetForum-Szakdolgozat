<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Http\Requests\StoreEventRequest; // 💡 ÚJ: A validációs kérés beimportálása

class EventController extends Controller
{
    /**
     * Konstruktor: Védjük a metódusokat az 'auth' middleware-rel.
     */
    public function __construct()
    {
        // Csak a 'index' (összes esemény) és 'show' (egy esemény) metódusok publikusak.
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Eager loadinghoz szükséges kapcsolatok definiálása, userrel és category-val.
     * FIGYELEM: EBBEN A VERZIÓBAN NINCS SZŰRÉS AZ IDŐRE!
     */
    private function getBaseEventQuery()
    {
        // 💡 AZ IDŐSZŰRŐ ELTÁVOLÍTVA: Most minden eseményt betölt (múltat és jövőt)
        return Event::with('category', 'user')
                    ->orderBy('event_date', 'asc');
    }
    
    /**
     * Események listázása, kategória szűrővel (publikus oldal) - MINDEN ESEMÉNY.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        // Lekérdezés indítása az Eager Loadinggal, de időszűrő nélkül.
        $query = $this->getBaseEventQuery(); 
        // Category filter
        if ($request->filled('category')) {
            $categorySlug = $request->get('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                   $q->where('slug', $categorySlug);
            });
        }

        // Search in title or description
        if ($request->filled('search')) {
            $term = $request->get('search');
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $events = $query->get(); 

        // 💡 Javaslat: Ezt a nézetet nevezze át 'events.all_events' névre, ha el akarja különíteni.
         // Pass current filters for the view
         return view('events.index', compact('events', 'categories'))
             ->with('search', $request->get('search'));
    }

    /**
     * ÚJ METÓDUS: Megjeleníti csak a JÖVŐBELI eseményeket (korábbi index logika).
     */
    public function upcoming(Request $request)
    {
        $categories = Category::all();
        $query = Event::with('category', 'user')
                      ->where('event_date', '>=', now()) // 💡 Időszűrő itt van!
                      ->orderBy('event_date', 'asc');

        if ($request->has('category')) {
            $categorySlug = $request->get('category');
            
            $query->whereHas('category', function ($q) use ($categorySlug) {
                   $q->where('slug', $categorySlug);
            });
        }
        
        $events = $query->get(); 

        // Ezt a nézetet használhatja az index.blade.php helyett, ha csak a jövőbelieket akarja látni.
        return view('events.index', compact('events', 'categories'));
    }
    
    /**
     * Megjeleníti a bejelentkezett felhasználó által létrehozott eseményeket.
     */
    public function myEvents(Request $request)
    {
        $categories = Category::all();

        // Alap lekérdezés: minden esemény, ami az aktuális felhasználóé
        $query = $this->getBaseEventQuery() // Már nem tartalmaz időszűrőt
                      ->where('user_id', Auth::id()); 

        // Kategória szűrés kezelése
        if ($request->has('category')) {
            $categorySlug = $request->get('category');
            
            $query->whereHas('category', function ($q) use ($categorySlug) {
                   $q->where('slug', $categorySlug);
            });
        }
        
        $events = $query->get(); 

        return view('events.my_events', compact('events', 'categories'));
    }

    /**
     * Megjeleníti az esemény létrehozására szolgáló űrlapot.
     */
    public function create()
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    /**
     * Eltárol egy újonnan létrehozott eseményt az adatbázisban.
     */
    public function store(StoreEventRequest $request) // 💡 FRISSÍTVE: StoreEventRequest használatával
    {
        $validatedData = $request->validated(); // A StoreEventRequest már validálta az adatokat
        
        // VÉDELMI FRISSÍTÉS: Hozzáadjuk a bejelentkezett felhasználó ID-jét.
        $validatedData['user_id'] = Auth::id(); 

        $event = Event::create($validatedData);

        // 💡 VISSZAÁLLÍTVA: Átirányítás a 'show' oldalra, ahogy Ön utalt rá.
        return redirect()->route('events.show', $event->id)->with('success', 'Az esemény sikeresen létrehozva!');
    }

    /**
     * Egy adott esemény megjelenítése.
     */
    public function show(Event $event)
    {
        // Az eseményt betöltjük a kategóriával és felhasználóval a nézet számára.
        $event->load('category', 'user', 'comments.user', 'comments.children.user');
        return view('events.show', compact('event'));
    }

    /**
     * Megjeleníti az esemény szerkesztésére szolgáló űrlapot.
     */
    public function edit(Event $event)
    {
        // JOGOSULTSÁG ELLENŐRZÉS: Csak a tulajdonos szerkesztheti
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('events.index')->with('error', 'Nincs jogosultsága ennek az eseménynek a szerkesztéséhez.');
        }

        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    /**
     * Frissíti az adott eseményt az adatbázisban.
     */
    public function update(StoreEventRequest $request, Event $event) // 💡 FRISSÍTVE: StoreEventRequest használatával
    {
        // JOGOSULTSÁG ELLENŐRZÉS: Csak a tulajdonos frissítheti
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('events.index')->with('error', 'Nincs jogosultsága ennek az eseménynek a frissítéséhez.');
        }

        $validatedData = $request->validated(); // A StoreEventRequest már validálta az adatokat

        $event->update($validatedData);

        return redirect()->route('events.show', $event)->with('success', 'Az esemény sikeresen frissítve!');
    }

    /**
     * Eltávolítja az adott eseményt az adatbázisból.
     */
    public function destroy(Event $event)
    {
        // JOGOSULTSÁG ELLENŐRZÉS: Csak a tulajdonos törölheti
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('events.index')->with('error', 'Nincs jogosultsága ennek az eseménynek a törléséhez.');
        }
        
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Az esemény sikeresen törölve!');
    }
}