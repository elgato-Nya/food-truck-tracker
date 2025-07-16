<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\LocationReport;
use App\Models\FoodTruck;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING APPROVAL FIX ===\n\n";

// Create a location report without coordinates (simulating failed geocoding)
$report = LocationReport::create([
    'food_truck_id' => 2,
    'reported_by' => 'Test User',
    'location_name' => 'Test Location',
    'location_description' => 'Test description',
    'status' => 'pending',
    'latitude' => null,
    'longitude' => null,
]);

echo "Created report ID: {$report->id}\n";
echo "Initial coordinates: lat={$report->latitude}, lng={$report->longitude}\n\n";

// Get the food truck to see current location
$truck = FoodTruck::find(2);
echo "Food truck: {$truck->name}\n";
echo "Current location: {$truck->location_description}\n";
echo "Current coordinates: lat={$truck->latitude}, lng={$truck->longitude}\n\n";

// Test the approval process
echo "Testing approval process...\n";

// Simulate the approval logic from AdminController
$updateData = [
    'location_description' => $report->location_description ?? $report->location_name,
    'reported_by' => $report->reported_by,
    'last_reported_at' => now(),
];

// Only update coordinates if they are available from the report
if ($report->latitude !== null && $report->longitude !== null) {
    $updateData['latitude'] = $report->latitude;
    $updateData['longitude'] = $report->longitude;
    echo "Using coordinates from report\n";
} else {
    echo "No coordinates in report, keeping existing truck coordinates\n";
}

// Update the food truck
$truck->update($updateData);

// Mark the report as approved
$report->update([
    'status' => 'approved',
    'reviewed_at' => now(),
    'admin_notes' => 'Test approval'
]);

echo "Approval successful!\n";
echo "Updated truck location: {$truck->fresh()->location_description}\n";
echo "Updated coordinates: lat={$truck->fresh()->latitude}, lng={$truck->fresh()->longitude}\n";
echo "Report status: {$report->fresh()->status}\n";
