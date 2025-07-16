<?php

namespace App\Http\Controllers;

use App\Models\FoodTruck;
use App\Models\LocationReport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $pendingReports = LocationReport::pending()->count();
        
        return view('admin.dashboard', compact('foodTrucks', 'totalTrucks', 'activeTrucks', 'pendingReports'));
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

    /**
     * Display location reports management page
     */
    public function locationReports(): View
    {
        $reports = LocationReport::with('foodTruck')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.location-reports.index', compact('reports'));
    }

    /**
     * Approve a location report
     */
    public function approveLocationReport(LocationReport $report): RedirectResponse
    {
        // If the report doesn't have coordinates, try to geocode it now
        if ($report->latitude === null || $report->longitude === null) {
            $this->geocodeLocationReport($report);
            $report->refresh(); // Reload the report to get updated coordinates
        }

        // Prepare the update data
        $updateData = [
            'location_description' => $report->location_description ?? $report->location_name,
            'reported_by' => $report->reported_by,
            'last_reported_at' => now(),
        ];

        // Only update coordinates if they are available from the report
        if ($report->latitude !== null && $report->longitude !== null) {
            $updateData['latitude'] = $report->latitude;
            $updateData['longitude'] = $report->longitude;
        }
        // If coordinates are not available, keep the existing ones from the food truck

        // Update the food truck with the new location
        $report->foodTruck->update($updateData);

        // Mark the report as approved
        $report->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => 'Admin', // You can enhance this to use authenticated user
        ]);

        return redirect()->route('admin.location-reports')
            ->with('success', 'Location report approved and food truck updated!');
    }

    /**
     * Reject a location report
     */
    public function rejectLocationReport(Request $request, LocationReport $report): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $report->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => 'Admin',
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->route('admin.location-reports')
            ->with('success', 'Location report rejected.');
    }

    /**
     * Geocode the location name to get coordinates
     */
    private function geocodeLocationReport(LocationReport $report): void
    {
        try {
            // Use Google Maps Geocoding API
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            
            if (!$apiKey) {
                Log::warning('Google Maps API key not configured for geocoding');
                return;
            }

            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $report->location_name . ', Malaysia', // Add country for better results
                'key' => $apiKey,
            ]);

            $data = $response->json();

            if ($data['status'] === 'OK' && !empty($data['results'])) {
                $location = $data['results'][0]['geometry']['location'];
                
                $report->update([
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                ]);

                Log::info("Geocoded location report {$report->id}: {$report->location_name} -> {$location['lat']}, {$location['lng']}");
            } else {
                Log::warning("Could not geocode location: {$report->location_name}. Status: {$data['status']}");
            }
        } catch (\Exception $e) {
            Log::error("Error geocoding location report {$report->id}: " . $e->getMessage());
        }
    }
}
