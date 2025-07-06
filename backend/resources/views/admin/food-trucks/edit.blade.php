@extends('layouts.admin')

@section('title', 'Edit Food Truck')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Edit Food Truck: {{ $foodTruck->name }}</h2>
        </div>

        <form action="{{ route('admin.food-trucks.update', $foodTruck) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Truck Name</label>
                    <input type="text" name="name" id="name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           value="{{ old('name', $foodTruck->name) }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Food Type -->
                <div>
                    <label for="food_type" class="block text-sm font-medium text-gray-700 mb-2">Food Type</label>
                    <input type="text" name="food_type" id="food_type" 
                           placeholder="e.g., Coffee, BBQ, Mee Goreng"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           value="{{ old('food_type', $foodTruck->food_type) }}" required>
                    @error('food_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reported By -->
                <div>
                    <label for="reported_by" class="block text-sm font-medium text-gray-700 mb-2">Reported By</label>
                    <input type="text" name="reported_by" id="reported_by" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           value="{{ old('reported_by', $foodTruck->reported_by) }}" required>
                    @error('reported_by')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location Description -->
                <div class="md:col-span-2">
                    <label for="location_description" class="block text-sm font-medium text-gray-700 mb-2">Location Description</label>
                    <input type="text" name="location_description" id="location_description" 
                           placeholder="e.g., Outside KLCC, Jalan Alor Night Market"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           value="{{ old('location_description', $foodTruck->location_description) }}" required>
                    @error('location_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Coordinates -->
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                    <input type="number" name="latitude" id="latitude" step="0.00000001"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           value="{{ old('latitude', $foodTruck->latitude) }}" required>
                    @error('latitude')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                    <input type="number" name="longitude" id="longitude" step="0.00000001"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           value="{{ old('longitude', $foodTruck->longitude) }}" required>
                    @error('longitude')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Menu Info -->
                <div class="md:col-span-2">
                    <label for="menu_info" class="block text-sm font-medium text-gray-700 mb-2">Menu Info (Optional)</label>
                    <textarea name="menu_info" id="menu_info" rows="3"
                              placeholder="Popular items, prices, special offers..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">{{ old('menu_info', $foodTruck->menu_info) }}</textarea>
                    @error('menu_info')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- News -->
                <div class="md:col-span-2">
                    <label for="news" class="block text-sm font-medium text-gray-700 mb-2">News/Updates (Optional)</label>
                    <textarea name="news" id="news" rows="3"
                              placeholder="Special events, new items, schedule changes..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">{{ old('news', $foodTruck->news) }}</textarea>
                    @error('news')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                               class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded"
                               {{ old('is_active', $foodTruck->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Active (visible in mobile app)
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <i class="fas fa-save mr-2"></i>Update Food Truck
                </button>
            </div>
        </form>
    </div>

    <!-- Last Updated Info -->
    <div class="mt-4 text-sm text-gray-600">
        <p><strong>Last reported:</strong> {{ $foodTruck->last_reported_at->format('F j, Y \a\t g:i A') }} ({{ $foodTruck->last_reported_at->diffForHumans() }})</p>
    </div>
</div>
@endsection
