<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin dashboard
    public function dashboard()
    {
        $totalEvents = Event::count();
        $totalCategories = Category::count();
        $totalUsers = \App\Models\User::count();

        return view('admin.dashboard', compact('totalEvents', 'totalCategories', 'totalUsers'));
    }

    // Kategóriák listázása
    public function categoriesIndex()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Kategória létrehozása (form)
    public function categoriesCreate()
    {
        return view('admin.categories.create');
    }

    // Kategória mentése
    public function categoriesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:16|unique:categories,name',
            'color_code' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $slug = \Illuminate\Support\Str::slug($validated['name']);
        $validated['slug'] = $slug;

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategória létrehozva.');
    }

    // Kategória szerkesztése (form)
    public function categoriesEdit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Kategória frissítése
    public function categoriesUpdate(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:16|unique:categories,name,' . $category->id,
            'color_code' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $slug = \Illuminate\Support\Str::slug($validated['name']);
        $validated['slug'] = $slug;

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategória frissítve.');
    }

    // Kategória törlése
    public function categoriesDestroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategória törölve.');
    }

    // Események listázása (moderálás)
    public function eventsIndex()
    {
        $events = Event::with('user', 'category')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    // Esemény törlése
    public function eventsDestroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Esemény törölve.');
    }
}
