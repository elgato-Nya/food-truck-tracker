#!/usr/bin/env php
<?php

// Simple API test script
$apiBaseUrl = 'http://127.0.0.1:8000/api/v1';

function testEndpoint($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status' => $httpCode,
        'response' => $response
    ];
}

echo "🚚 Food Truck Tracker API Test\n";
echo "==============================\n\n";

// Test 1: Health Check
echo "1. Testing Health Check...\n";
$health = testEndpoint($apiBaseUrl . '/../health');
echo "   Status: " . $health['status'] . "\n";
if ($health['status'] === 200) {
    echo "   ✅ Health check passed\n";
} else {
    echo "   ❌ Health check failed\n";
}
echo "\n";

// Test 2: Get All Food Trucks
echo "2. Testing Get All Food Trucks...\n";
$trucks = testEndpoint($apiBaseUrl . '/food-trucks');
echo "   Status: " . $trucks['status'] . "\n";
if ($trucks['status'] === 200) {
    $data = json_decode($trucks['response'], true);
    echo "   ✅ Got " . count($data['data']) . " food trucks\n";
    echo "   Sample truck: " . $data['data'][0]['name'] . "\n";
} else {
    echo "   ❌ Failed to get food trucks\n";
}
echo "\n";

// Test 3: Get Specific Food Truck
echo "3. Testing Get Specific Food Truck...\n";
$truck = testEndpoint($apiBaseUrl . '/food-trucks/1');
echo "   Status: " . $truck['status'] . "\n";
if ($truck['status'] === 200) {
    $data = json_decode($truck['response'], true);
    echo "   ✅ Got truck: " . $data['data']['name'] . "\n";
} else {
    echo "   ❌ Failed to get specific truck\n";
}
echo "\n";

// Test 4: Test Location Update (PUT)
echo "4. Testing Location Update...\n";
$updateData = [
    'latitude' => 3.1478,
    'longitude' => 101.7058,
    'location_description' => 'Test location update',
    'reported_by' => 'API Test Script'
];
$update = testEndpoint($apiBaseUrl . '/food-trucks/1/location', 'PUT', $updateData);
echo "   Status: " . $update['status'] . "\n";
if ($update['status'] === 200) {
    echo "   ✅ Location update successful\n";
} else {
    echo "   ❌ Location update failed\n";
    echo "   Response: " . substr($update['response'], 0, 200) . "...\n";
}
echo "\n";

echo "🎉 API test completed!\n";
