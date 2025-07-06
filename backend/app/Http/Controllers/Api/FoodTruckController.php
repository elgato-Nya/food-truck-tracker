<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodTruck;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FoodTruckController extends Controller
{
    /**
     * Get all active food trucks for mobile app
     */
    public function index(): JsonResponse
    {
        try {
            $foodTrucks = FoodTruck::active()
                ->orderBy('last_reported_at', 'desc')
                ->get()
                ->map(function ($truck) {
                    return $truck->toApiArray();
                });

            return response()->json([
                'success' => true,
                'data' => $foodTrucks,
                'message' => 'Food trucks retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving food trucks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific food truck
     */
    public function show(FoodTruck $foodTruck): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $foodTruck->toApiArray(),
                'message' => 'Food truck retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving food truck',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update truck location (for reporting new location)
     */
    public function updateLocation(Request $request, FoodTruck $foodTruck): JsonResponse
    {
        try {
            $validated = $request->validate([
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'location_description' => 'required|string|max:255',
                'reported_by' => 'required|string|max:100'
            ]);

            $foodTruck->update([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'location_description' => $validated['location_description'],
                'reported_by' => $validated['reported_by'],
                'last_reported_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'data' => $foodTruck->fresh()->toApiArray(),
                'message' => 'Location updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating location',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
