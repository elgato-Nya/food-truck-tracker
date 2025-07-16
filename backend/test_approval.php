<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\LocationReport;
use App\Models\FoodTruck;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get the first pending report
$report = LocationReport::where('status', 'pending')->first();

if (!$report) {
    echo "No pending reports found.\n";
    exit;
}

echo "Found report: {$report->location_name}\n";
echo "Status: {$report->status}\n";

// Get the food truck
$truck = FoodTruck::find($report->food_truck_id);

if (!$truck) {
    echo "Food truck not found.\n";
    exit;
}

echo "Food truck: {$truck->name}\n";
echo "Current location: {$truck->location_description}\n";

// Update the food truck location (simulating approval)
$truck->update([
    'latitude' => 3.0738,
    'longitude' => 101.6067,
    'location_description' => $report->location_name . ' - ' . $report->location_description,
    'last_reported_at' => now(),
    'reported_by' => $report->reported_by
]);

// Update the report status
$report->update([
    'status' => 'approved',
    'reviewed_at' => now(),
    'admin_notes' => 'Approved via test script'
]);

echo "Report approved and truck updated!\n";
echo "New location: {$truck->fresh()->location_description}\n";
