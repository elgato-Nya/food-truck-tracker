<?php

namespace App\Http\Controllers;

use App\Models\FoodTruck;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index(): View
    {
        $foodTrucks = FoodTruck::orderBy('last_reported_at', 'desc')->paginate(10);
        $totalTrucks = FoodTruck::count();
        $activeTrucks = FoodTruck::active()->count();
        
        return view('admin.dashboard', compact('foodTrucks', 'totalTrucks', 'activeTrucks'));
    }

    /**
     * Show the form for creating a new food truck
     */
    public function create(): View
    {
        return view('admin.food-trucks.create');
    }

    /**
     * Store a newly created food truck
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'food_type' => 'required|string|max:255',
            'location_description' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'menu_info' => 'nullable|string',
            'news' => 'nullable|string',
            'reported_by' => 'required|string|max:100',
            'is_active' => 'boolean'
        ]);

        FoodTruck::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Food truck created successfully!');
    }

    /**
     * Show the form for editing a food truck
     */
    public function edit(FoodTruck $foodTruck): View
    {
        return view('admin.food-trucks.edit', compact('foodTruck'));
    }

    /**
     * Update the specified food truck
     */
    public function update(Request $request, FoodTruck $foodTruck): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'food_type' => 'required|string|max:255',
            'location_description' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'menu_info' => 'nullable|string',
            'news' => 'nullable|string',
            'reported_by' => 'required|string|max:100',
            'is_active' => 'boolean'
        ]);

        $foodTruck->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Food truck updated successfully!');
    }

    /**
     * Remove the specified food truck
     */
    public function destroy(FoodTruck $foodTruck): RedirectResponse
    {
        $foodTruck->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Food truck deleted successfully!');
    }
}
