<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\LocationReport;
use App\Models\FoodTruck;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get the second pending report
$report = LocationReport::where('status', 'pending')->orderBy('id', 'desc')->first();

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

// Update the report status to rejected (without updating the food truck)
$report->update([
    'status' => 'rejected',
    'reviewed_at' => now(),
    'admin_notes' => 'Location description is too vague. Please provide more specific details.'
]);

echo "Report rejected!\n";
echo "Admin notes: {$report->admin_notes}\n";
