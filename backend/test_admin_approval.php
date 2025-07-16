<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\LocationReport;
use App\Models\FoodTruck;
use App\Http\Controllers\AdminController;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING ADMIN APPROVAL WORKFLOW ===\n\n";

// Find the latest pending report
$report = LocationReport::where('status', 'pending')->latest()->first();

if (!$report) {
    echo "No pending reports found.\n";
    exit;
}

echo "Found pending report ID: {$report->id}\n";
echo "Location: {$report->location_name}\n";
echo "Food truck: {$report->foodTruck->name}\n";
echo "Coordinates: lat=" . ($report->latitude ?? 'null') . ", lng=" . ($report->longitude ?? 'null') . "\n\n";

// Get the food truck before approval
$truck = $report->foodTruck;
echo "Food truck before approval:\n";
echo "  Location: {$truck->location_description}\n";
echo "  Coordinates: lat={$truck->latitude}, lng={$truck->longitude}\n\n";

// Simulate the approval process using the same logic as AdminController
try {
    // If the report doesn't have coordinates, simulate geocoding attempt
    if ($report->latitude === null || $report->longitude === null) {
        echo "Report has no coordinates, would attempt geocoding...\n";
        // For this test, we'll skip actual geocoding and just proceed
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
        echo "Using coordinates from report\n";
    } else {
        echo "No coordinates in report, keeping existing truck coordinates\n";
    }

    // Update the food truck with the new location
    $truck->update($updateData);

    // Mark the report as approved
    $report->update([
        'status' => 'approved',
        'reviewed_at' => now(),
        'reviewed_by' => 'Test Admin',
    ]);

    echo "\nApproval successful!\n";
    echo "Food truck after approval:\n";
    echo "  Location: {$truck->fresh()->location_description}\n";
    echo "  Coordinates: lat={$truck->fresh()->latitude}, lng={$truck->fresh()->longitude}\n";
    echo "  Report status: {$report->fresh()->status}\n";

} catch (Exception $e) {
    echo "Error during approval: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";
