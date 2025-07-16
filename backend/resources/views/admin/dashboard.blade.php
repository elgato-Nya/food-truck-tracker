@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Dashboard Overview</h1>
            <p class="text-gray-600 dark:text-gray-400">Monitor and manage food trucks across Malaysia</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-clock mr-1"></i>
                Last updated: {{ now()->format('M d, Y H:i') }}
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Trucks Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-2">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3">
                        <i class="fas fa-truck text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Trucks</h3>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalTrucks }}</p>
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">registered</span>
                </div>
            </div>
            <div class="text-blue-600 dark:text-blue-400 opacity-20">
                <i class="fas fa-truck text-4xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
            <span>{{ $totalTrucks > 0 ? '+' . number_format((($activeTrucks / $totalTrucks) * 100), 1) : '0' }}% active</span>
        </div>
    </div>

    <!-- Active Trucks Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-2">
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Active Trucks</h3>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $activeTrucks }}</p>
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">online</span>
                </div>
            </div>
            <div class="text-green-600 dark:text-green-400 opacity-20">
                <i class="fas fa-check-circle text-4xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
            <div class="flex items-center">
                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                <span>Currently operating</span>
            </div>
        </div>
    </div>

    <!-- API Status Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-2">
                    <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-lg mr-3">
                        <i class="fas fa-mobile-alt text-orange-600 dark:text-orange-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">API Status</h3>
                </div>
                <div class="flex items-baseline">
                    <p class="text-xl font-semibold text-green-600 dark:text-green-400">Online</p>
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">v1.0</span>
                </div>
            </div>
            <div class="text-orange-600 dark:text-orange-400 opacity-20">
                <i class="fas fa-mobile-alt text-4xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
            <div class="flex items-center">
                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                <span>Mobile app connected</span>
            </div>
        </div>
    </div>

    <!-- Pending Reports Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-2">
                    <div class="p-2 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg mr-3">
                        <i class="fas fa-flag text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pending Reports</h3>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $pendingReports }}</p>
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">to review</span>
                </div>
            </div>
            <div class="text-yellow-600 dark:text-yellow-400 opacity-20">
                <i class="fas fa-flag text-4xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
            @if($pendingReports > 0)
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                    <span>Needs attention</span>
                </div>
            @else
                <div class="flex items-center">
                    <i class="fas fa-check text-green-500 mr-2"></i>
                    <span>All caught up</span>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions Bar -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8 border border-gray-200 dark:border-gray-700">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="mb-4 md:mb-0">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Quick Actions</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Manage food trucks efficiently</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.food-trucks.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 dark:bg-orange-700 dark:hover:bg-orange-600 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Add New Truck
            </a>
            <button onclick="refreshData()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-sync-alt mr-2"></i>
                Refresh Data
            </button>
            <button onclick="exportData()" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export Data
            </button>
        </div>
    </div>
</div>

<!-- Food Trucks Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Food Trucks</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Showing {{ $foodTrucks->count() }} of {{ $totalTrucks }} trucks
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <!-- Search/Filter could go here -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">View:</span>
                    <select class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option>All Trucks</option>
                        <option>Active Only</option>
                        <option>Inactive Only</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>Truck Details</span>
                            <i class="fas fa-sort text-gray-400"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>Food Type</span>
                            <i class="fas fa-sort text-gray-400"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>Location</span>
                            <i class="fas fa-sort text-gray-400"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>Last Activity</span>
                            <i class="fas fa-sort text-gray-400"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($foodTrucks as $truck)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                                    <i class="fas fa-utensils text-orange-600 dark:text-orange-400"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $truck->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-user mr-1"></i>{{ $truck->reported_by }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700">
                            <i class="fas fa-tag mr-1"></i>{{ $truck->food_type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                            <i class="fas fa-map-marker-alt mr-1 text-red-500"></i>{{ $truck->location_description }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-globe mr-1"></i>{{ number_format($truck->latitude, 4) }}, {{ number_format($truck->longitude, 4) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                            <i class="fas fa-clock mr-1 text-blue-500"></i>{{ $truck->last_reported_at->diffForHumans() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $truck->last_reported_at->format('M d, Y H:i') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($truck->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-700">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-700">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.food-trucks.edit', $truck) }}" 
                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
                               title="Edit truck">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="viewTruckDetails(this)" 
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                    title="View details"
                                    data-truck-id="{{ $truck->id }}"
                                    data-truck-name="{{ $truck->name }}"
                                    data-truck-food-type="{{ $truck->food_type }}"
                                    data-truck-location="{{ $truck->location_description }}"
                                    data-truck-latitude="{{ $truck->latitude }}"
                                    data-truck-longitude="{{ $truck->longitude }}"
                                    data-truck-last-reported="{{ $truck->last_reported_at->format('M d, Y H:i') }}"
                                    data-truck-status="{{ $truck->is_active ? 'Active' : 'Inactive' }}"
                                    data-truck-reported-by="{{ $truck->reported_by }}"
                                    data-truck-menu="{{ $truck->menu_info ?? '' }}"
                                    data-truck-news="{{ $truck->news ?? '' }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form action="{{ route('admin.food-trucks.destroy', $truck) }}" 
                                  method="POST" class="inline"
                                  id="deleteForm-{{ $truck->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="openDeleteModal('{{ $truck->name }}', document.getElementById('deleteForm-{{ $truck->id }}'))"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                        title="Delete truck">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-truck text-gray-400 dark:text-gray-500 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No food trucks found</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by adding your first food truck</p>
                            <a href="{{ route('admin.food-trucks.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i>Add Food Truck
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($foodTrucks->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Showing {{ $foodTrucks->firstItem() }} to {{ $foodTrucks->lastItem() }} of {{ $foodTrucks->total() }} results
            </div>
            <div class="pagination-wrapper">
                {{ $foodTrucks->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function refreshData() {
    window.location.reload();
}

function exportData() {
    // This would typically generate a CSV or PDF export
    alert('Export functionality would be implemented here');
}

function viewTruckDetails(button) {
    const data = button.dataset;
    
    // Populate the modal with truck data
    document.getElementById('detailTruckName').textContent = data.truckName;
    document.getElementById('detailFoodType').textContent = data.truckFoodType;
    document.getElementById('detailLocation').textContent = data.truckLocation;
    document.getElementById('detailCoordinates').textContent = `${data.truckLatitude}, ${data.truckLongitude}`;
    document.getElementById('detailLastReported').textContent = data.truckLastReported;
    document.getElementById('detailReportedBy').textContent = data.truckReportedBy;
    document.getElementById('detailMenu').textContent = data.truckMenu || 'No menu information available';
    document.getElementById('detailNews').textContent = data.truckNews || 'No news available';
    
    // Set status with appropriate styling
    const statusElement = document.getElementById('detailStatus');
    statusElement.textContent = data.truckStatus;
    statusElement.className = data.truckStatus === 'Active' 
        ? 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-700'
        : 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-700';
    
    // Show the modal
    const modal = document.getElementById('detailsModal');
    modal.classList.remove('hidden');
    modal.style.display = 'block';
    document.body.classList.add('overflow-hidden');
}

// Add loading states to buttons
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('button[onclick]');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i.fas');
            if (icon) {
                icon.classList.add('fa-spin');
                setTimeout(() => {
                    icon.classList.remove('fa-spin');
                }, 1000);
            }
        });
    });
});
</script>

<!-- Modern Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 dark:bg-red-900 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white text-center mb-2">Delete Food Truck</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                    Are you sure you want to delete <strong id="truckName"></strong>? This action cannot be undone.
                </p>
                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()" 
                            class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()" 
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Truck Details Modal -->
<div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full mx-4 transform transition-all">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <i class="fas fa-truck text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="detailTruckName">Truck Name</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Food Truck Details</p>
                        </div>
                    </div>
                    <button onclick="closeDetailsModal()" 
                            class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Food Type</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-sm text-gray-900 dark:text-white" id="detailFoodType">Coffee</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span id="detailStatus" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium">Active</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reported By</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-sm text-gray-900 dark:text-white" id="detailReportedBy">Reporter Name</span>
                            </div>
                        </div>
                    </div>

                    <!-- Location Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-sm text-gray-900 dark:text-white" id="detailLocation">Location Description</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Coordinates</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-sm text-gray-900 dark:text-white font-mono" id="detailCoordinates">0.0000, 0.0000</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Last Reported</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-sm text-gray-900 dark:text-white" id="detailLastReported">Date Time</span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Menu Information</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg min-h-[60px]">
                                <span class="text-sm text-gray-900 dark:text-white" id="detailMenu">Menu details...</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">News & Updates</label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg min-h-[60px]">
                                <span class="text-sm text-gray-900 dark:text-white" id="detailNews">Latest news...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button onclick="closeDetailsModal()" 
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let deleteForm = null;

function openDeleteModal(truckName, form) {
    document.getElementById('truckName').textContent = truckName;
    deleteForm = form;
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.style.display = 'block';
    document.body.classList.add('overflow-hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.classList.remove('overflow-hidden');
    deleteForm = null;
}

function closeDetailsModal() {
    const modal = document.getElementById('detailsModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.classList.remove('overflow-hidden');
}

function confirmDelete() {
    if (deleteForm) {
        deleteForm.submit();
    }
    closeDeleteModal();
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.getElementById('detailsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailsModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('deleteModal').classList.contains('hidden')) {
            closeDeleteModal();
        }
        if (!document.getElementById('detailsModal').classList.contains('hidden')) {
            closeDetailsModal();
        }
    }
});
</script>
@endsection
