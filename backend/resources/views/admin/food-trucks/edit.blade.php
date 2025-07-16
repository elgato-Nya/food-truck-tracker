@extends('layouts.admin')

@section('title', 'Edit Food Truck')

@section('content')
<div class="animate-fade-in">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg">
                <i class="fas fa-edit text-orange-600 dark:text-orange-400 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Food Truck</h1>
                <p class="text-gray-600 dark:text-gray-400">Update information for: {{ $foodTruck->name }}</p>
            </div>
        </div>
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dashboard
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Food Truck Information</h2>
                    <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-clock"></i>
                        <span>Last updated: {{ $foodTruck->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.food-trucks.update', $foodTruck) }}" method="POST" class="p-6" id="edit-form">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Basic Information Section -->
                    <div class="lg:col-span-2">
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-info-circle mr-2 text-orange-500"></i>
                                Basic Information
                            </h3>
                        </div>
                    </div>

                    <!-- Truck Name -->
                    <div class="lg:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-truck mr-1"></i>Truck Name *
                        </label>
                        <input type="text" name="name" id="name" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors"
                               value="{{ old('name', $foodTruck->name) }}" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Food Type -->
                    <div>
                        <label for="food_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-utensils mr-1"></i>Food Type *
                        </label>
                        <input type="text" name="food_type" id="food_type" 
                               placeholder="e.g., Coffee, BBQ, Mee Goreng"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors"
                               value="{{ old('food_type', $foodTruck->food_type) }}" required>
                        @error('food_type')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Reported By -->
                    <div>
                        <label for="reported_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-user mr-1"></i>Reported By *
                        </label>
                        <input type="text" name="reported_by" id="reported_by" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors"
                               value="{{ old('reported_by', $foodTruck->reported_by) }}" required>
                        @error('reported_by')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Location Section -->
                    <div class="lg:col-span-2">
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6 mt-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
                                Location Information
                            </h3>
                        </div>
                    </div>

                    <!-- Location Description -->
                    <div class="lg:col-span-2">
                        <label for="location_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-map-pin mr-1"></i>Location Description *
                        </label>
                        <input type="text" name="location_description" id="location_description" 
                               placeholder="e.g., Outside KLCC, Jalan Alor Night Market"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors"
                               value="{{ old('location_description', $foodTruck->location_description) }}" required>
                        @error('location_description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Coordinates -->
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-crosshairs mr-1"></i>Latitude *
                        </label>
                        <input type="number" name="latitude" id="latitude" step="0.00000001"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors"
                               value="{{ old('latitude', $foodTruck->latitude) }}" required>
                        @error('latitude')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-crosshairs mr-1"></i>Longitude *
                        </label>
                        <input type="number" name="longitude" id="longitude" step="0.00000001"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors"
                               value="{{ old('longitude', $foodTruck->longitude) }}" required>
                        @error('longitude')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Additional Information Section -->
                    <div class="lg:col-span-2">
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6 mt-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-info mr-2 text-orange-500"></i>
                                Additional Information
                            </h3>
                        </div>
                    </div>

                    <!-- Menu Info -->
                    <div class="lg:col-span-2">
                        <label for="menu_info" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-menu mr-1"></i>Menu Information
                        </label>
                        <textarea name="menu_info" id="menu_info" rows="4"
                                  placeholder="Popular items, prices, special offers..."
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors resize-none">{{ old('menu_info', $foodTruck->menu_info) }}</textarea>
                        @error('menu_info')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- News -->
                    <div class="lg:col-span-2">
                        <label for="news" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-newspaper mr-1"></i>News & Updates
                        </label>
                        <textarea name="news" id="news" rows="4"
                                  placeholder="Special events, new items, schedule changes..."
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors resize-none">{{ old('news', $foodTruck->news) }}</textarea>
                        @error('news')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="lg:col-span-2">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                       class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
                                       {{ old('is_active', $foodTruck->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="ml-3 flex items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        <i class="fas fa-eye mr-1"></i>Active Status
                                    </span>
                                </label>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 ml-7">
                                When checked, this food truck will be visible in the mobile app
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105"
                            id="submit-btn">
                        <i class="fas fa-save mr-2"></i>
                        <span id="submit-text">Update Food Truck</span>
                        <i class="fas fa-spinner fa-spin ml-2 hidden" id="submit-spinner"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Last Reported Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900 dark:text-white">Last Reported</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                    <strong>Date:</strong> {{ $foodTruck->last_reported_at->format('F j, Y \a\t g:i A') }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Time ago:</strong> {{ $foodTruck->last_reported_at->diffForHumans() }}
                </p>
            </div>

            <!-- Current Status Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-{{ $foodTruck->is_active ? 'green' : 'red' }}-100 dark:bg-{{ $foodTruck->is_active ? 'green' : 'red' }}-900 rounded-lg">
                        <i class="fas fa-{{ $foodTruck->is_active ? 'check-circle' : 'times-circle' }} text-{{ $foodTruck->is_active ? 'green' : 'red' }}-600 dark:text-{{ $foodTruck->is_active ? 'green' : 'red' }}-400"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900 dark:text-white">Current Status</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    This food truck is currently <strong class="text-{{ $foodTruck->is_active ? 'green' : 'red' }}-600 dark:text-{{ $foodTruck->is_active ? 'green' : 'red' }}-400">{{ $foodTruck->is_active ? 'Active' : 'Inactive' }}</strong>
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                    {{ $foodTruck->is_active ? 'Visible in mobile app' : 'Hidden from mobile app' }}
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edit-form');
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const submitSpinner = document.getElementById('submit-spinner');

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitText.textContent = 'Updating...';
        submitSpinner.classList.remove('hidden');
        submitBtn.classList.add('opacity-75');
    });

    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });

    // Form validation enhancements
    const inputs = document.querySelectorAll('input[required], textarea[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('border-red-500', 'dark:border-red-400');
                this.classList.remove('border-gray-300', 'dark:border-gray-600');
            } else {
                this.classList.remove('border-red-500', 'dark:border-red-400');
                this.classList.add('border-gray-300', 'dark:border-gray-600');
            }
        });
    });

    // Coordinate validation
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    
    function validateCoordinate(input, min, max) {
        input.addEventListener('input', function() {
            const value = parseFloat(this.value);
            if (isNaN(value) || value < min || value > max) {
                this.classList.add('border-red-500', 'dark:border-red-400');
            } else {
                this.classList.remove('border-red-500', 'dark:border-red-400');
            }
        });
    }

    validateCoordinate(latInput, -90, 90);
    validateCoordinate(lngInput, -180, 180);
});
</script>
@endsection
