@extends('layouts.admin')

@section('title', 'Location Reports')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Location Reports</h1>
            <p class="text-gray-600 dark:text-gray-400">Review and manage location updates from users</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="flex space-x-3">
                <div class="flex items-center space-x-2 bg-white dark:bg-gray-800 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $reports->where('status', 'pending')->count() }} pending</span>
                </div>
                <div class="flex items-center space-x-2 bg-white dark:bg-gray-800 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $reports->where('status', 'approved')->count() }} approved</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reports Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Status</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Food Truck</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Reported Location</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Reporter</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Submitted</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <!-- Status -->
                            <td class="py-4 px-4">
                                @if($report->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1.5 animate-pulse"></div>
                                        Pending
                                    </span>
                                @elseif($report->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                        <i class="fas fa-check mr-1"></i>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                        <i class="fas fa-times mr-1"></i>
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Food Truck -->
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-truck text-orange-600 dark:text-orange-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $report->foodTruck->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $report->foodTruck->food_type }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Reported Location -->
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $report->location_name }}</div>
                                @if($report->location_description)
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($report->location_description, 50) }}</div>
                                @endif
                                @if($report->latitude && $report->longitude)
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ number_format($report->latitude, 6) }}, {{ number_format($report->longitude, 6) }}
                                    </div>
                                @else
                                    <div class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Coordinates not available
                                    </div>
                                @endif
                            </td>
                            
                            <!-- Reporter -->
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $report->reported_by }}</div>
                            </td>
                            
                            <!-- Submitted -->
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $report->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $report->created_at->format('H:i') }}</div>
                            </td>
                            
                            <!-- Actions -->
                            <td class="py-4 px-4">
                                @if($report->status === 'pending')
                                    <div class="flex space-x-2">
                                        <form action="{{ route('admin.location-reports.approve', $report) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors"
                                                    onclick="return confirm('Are you sure you want to approve this location report?')">
                                                <i class="fas fa-check mr-1"></i>
                                                Approve
                                            </button>
                                        </form>
                                        <button type="button" 
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors"
                                                onclick="showRejectModal('{{ $report->id }}')">>
                                            <i class="fas fa-times mr-1"></i>
                                            Reject
                                        </button>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        @if($report->reviewed_at)
                                            <div>Reviewed {{ $report->reviewed_at->diffForHumans() }}</div>
                                            @if($report->reviewed_by)
                                                <div>by {{ $report->reviewed_by }}</div>
                                            @endif
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No location reports</h3>
                                    <p class="text-gray-500 dark:text-gray-400">No location reports have been submitted yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    @if($reports->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $reports->links() }}
        </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-times text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Reject Location Report</h3>
            </div>
            
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Reason for rejection (optional)
                    </label>
                    <textarea name="admin_notes" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                              rows="3" 
                              placeholder="Provide feedback to help improve future reports..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="hideRejectModal()"
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        Reject Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(reportId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/location-reports/${reportId}/reject`;
    modal.classList.remove('hidden');
}

function hideRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endsection
