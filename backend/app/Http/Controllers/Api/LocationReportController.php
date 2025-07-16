<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocationReport;
use App\Models\FoodTruck;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocationReportController extends Controller
{
    /**
     * Submit a new location report
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'food_truck_id' => 'required|exists:food_trucks,id',
                'reported_by' => 'string|max:255',
                'location_name' => 'required|string|max:255',
                'location_description' => 'nullable|string',
            ]);

            // Set default reporter name if not provided
            if (empty($validated['reported_by'])) {
                $validated['reported_by'] = 'Anonymous';
            }

            // Create the report without coordinates initially
            $report = LocationReport::create([
                'food_truck_id' => $validated['food_truck_id'],
                'reported_by' => $validated['reported_by'],
                'location_name' => $validated['location_name'],
                'location_description' => $validated['location_description'] ?? null,
                'status' => 'pending',
            ]);

            // Try to geocode the location name to get coordinates
            $this->geocodeLocationReport($report);

            return response()->json([
                'success' => true,
                'data' => $report->load('foodTruck'),
                'message' => 'Location report submitted successfully. It will be reviewed by our team.',
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating location report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error submitting location report',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Geocode the location name to get coordinates
     */
    private function geocodeLocationReport(LocationReport $report): void
    {
        try {
            // Use Google Maps Geocoding API (you can also use OpenStreetMap Nominatim as a free alternative)
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
