<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    /**
     * index() — Kitchen sees all items, Student sees ALL items too
     * (available + out of stock — the view shows a "Sold Out" badge for unavailable ones)
     */
    public function index()
    {
        if (auth()->user()->role === 'kitchen') {
            $menuItems = MenuItem::latest()->paginate(10);
            return view('admin.menu-items.index', compact('menuItems'));
            // Kitchen uses same view as admin for menu management
        }

        // Student: show every item, available or not — view handles the "Sold Out" state
        $menuItems = MenuItem::latest()->get();
        return view('student.menu.index', compact('menuItems'));
    }

    /**
     * today() — Shared "Today's Menu" page for all roles
     * Shows every item; unavailable ones are marked "Sold Out" in the view.
     */
    public function today()
    {
        $menuItems = MenuItem::latest()->get();
        return view('menu.today', compact('menuItems'));
    }

    /**
     * create() — Show form to add a new menu item (kitchen only)
     */
    public function create()
    {
        return view('admin.menu-items.create');
    }

    /**
     * store() — Save a new menu item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:120',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $validated['is_available'] = (bool) $validated['is_available'];

        MenuItem::create($validated);

        // Redirect back to correct role's menu list
        $route = auth()->user()->role === 'kitchen'
            ? 'kitchen.menu-items.index'
            : 'admin.menu-items.index';

        return redirect()->route($route)
                         ->with('success', 'Menu item added successfully.');
    }

    /**
     * show() — Show a single menu item
     */
    public function show(MenuItem $menuItem)
    {
        return view('admin.menu-items.show', compact('menuItem'));
    }

    /**
     * edit() — Show form to edit a menu item
     */
    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu-items.edit', compact('menuItem'));
    }

    /**
     * update() — Save the updated menu item
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:120',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image from disk before storing the new one
            if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                Storage::disk('public')->delete($menuItem->image);
            }

            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        } else {
            unset($validated['image']);
        }

        $validated['is_available'] = (bool) $validated['is_available'];

        $menuItem->update($validated);

        $route = auth()->user()->role === 'kitchen'
            ? 'kitchen.menu-items.index'
            : 'admin.menu-items.index';

        return redirect()->route($route)
                         ->with('success', 'Menu item updated successfully.');
    }

    /**
     * destroy() — Delete a menu item
     */
    public function destroy(MenuItem $menuItem)
    {
        // Check if this item has ever been ordered
        if ($menuItem->orderItems()->exists()) {
            // Has order history — can't hard delete, so just deactivate it
            $menuItem->update(['is_available' => false]);

            $route = auth()->user()->role === 'kitchen'
                ? 'kitchen.menu-items.index'
                : 'admin.menu-items.index';

            return redirect()->route($route)
                             ->with('success', 'This item has order history, so it was marked unavailable instead of deleted.');
        }

        // No order history — safe to fully delete
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        $route = auth()->user()->role === 'kitchen'
            ? 'kitchen.menu-items.index'
            : 'admin.menu-items.index';

        return redirect()->route($route)
                         ->with('success', 'Menu item deleted successfully.');
    }

    /**
     * toggleStock() — Flip is_available on/off from the menu card button
     */
    public function toggleStock(MenuItem $menuItem)
    {
        $menuItem->update(['is_available' => ! $menuItem->is_available]);

        $route = auth()->user()->role === 'kitchen'
            ? 'kitchen.menu-items.index'
            : 'admin.menu-items.index';

        $status = $menuItem->is_available ? 'marked available' : 'marked out of stock';

        return redirect()->route($route)
                         ->with('success', "{$menuItem->name} {$status}.");
    }
}