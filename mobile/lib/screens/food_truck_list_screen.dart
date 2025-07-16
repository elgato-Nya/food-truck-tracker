import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/food_truck_provider.dart';
import '../widgets/truck_info_card.dart';
import '../widgets/search_filter_widget.dart';
import '../models/food_truck.dart';
import 'report_location_screen.dart';

class FoodTruckListScreen extends StatelessWidget {
  const FoodTruckListScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Food Truck Explorer'),
        backgroundColor: Theme.of(context).colorScheme.surface,
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: () => context.read<FoodTruckProvider>().refresh(),
          ),
        ],
      ),
      body: Consumer<FoodTruckProvider>(
        builder: (context, provider, child) {
          return Column(
            children: [
              // Search and Filter Widget
              const SearchAndFilterWidget(),

              // Results Summary
              if (provider.hasTrucks)
                Container(
                  margin: const EdgeInsets.only(top: 25),
                  padding: const EdgeInsets.symmetric(
                    horizontal: 16,
                    vertical: 8,
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text(
                        '${provider.foodTrucks.length} food truck${provider.foodTrucks.length != 1 ? 's' : ''} found',
                        style: Theme.of(context).textTheme.bodyMedium,
                      ),
                      if (provider.searchQuery.isNotEmpty ||
                          provider.selectedFoodTypes.isNotEmpty)
                        TextButton(
                          onPressed: () => provider.clearFilters(),
                          child: const Text('Clear filters'),
                        ),
                    ],
                  ),
                ),

              // Food Trucks List
              Expanded(child: _buildContent(context, provider)),
            ],
          );
        },
      ),
    );
  }

  Widget _buildContent(BuildContext context, FoodTruckProvider provider) {
    if (provider.isLoading) {
      return const Center(child: CircularProgressIndicator());
    }

    if (provider.error != null) {
      return Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(Icons.error_outline, size: 64, color: Colors.red),
            const SizedBox(height: 16),
            Text(
              'Error loading food trucks',
              style: Theme.of(context).textTheme.headlineSmall,
            ),
            const SizedBox(height: 8),
            Text(
              provider.error!,
              textAlign: TextAlign.center,
              style: Theme.of(context).textTheme.bodyMedium,
            ),
            const SizedBox(height: 16),
            ElevatedButton(
              onPressed: () => provider.refresh(),
              child: const Text('Retry'),
            ),
          ],
        ),
      );
    }

    if (!provider.hasTrucks) {
      return Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(Icons.local_dining, size: 64, color: Colors.grey),
            const SizedBox(height: 16),
            Text(
              'No food trucks found',
              style: Theme.of(context).textTheme.headlineSmall,
            ),
            const SizedBox(height: 8),
            Text(
              provider.searchQuery.isNotEmpty ||
                      provider.selectedFoodTypes.isNotEmpty
                  ? 'Try adjusting your search or filters'
                  : 'No food trucks are currently available',
              textAlign: TextAlign.center,
              style: Theme.of(context).textTheme.bodyMedium,
            ),
            if (provider.searchQuery.isNotEmpty ||
                provider.selectedFoodTypes.isNotEmpty)
              Padding(
                padding: const EdgeInsets.only(top: 16),
                child: ElevatedButton(
                  onPressed: () => provider.clearFilters(),
                  child: const Text('Clear Filters'),
                ),
              ),
          ],
        ),
      );
    }

    return ListView.builder(
      padding: const EdgeInsets.all(16),
      itemCount: provider.foodTrucks.length,
      itemBuilder: (context, index) {
        final truck = provider.foodTrucks[index];
        return Card(
          margin: const EdgeInsets.only(bottom: 16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Header with truck name and food type
              Container(
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: Theme.of(context).colorScheme.primaryContainer,
                  borderRadius: const BorderRadius.only(
                    topLeft: Radius.circular(12),
                    topRight: Radius.circular(12),
                  ),
                ),
                child: Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            truck.name,
                            style: Theme.of(context).textTheme.titleLarge
                                ?.copyWith(
                                  fontWeight: FontWeight.bold,
                                  color: Theme.of(
                                    context,
                                  ).colorScheme.onPrimaryContainer,
                                ),
                          ),
                          const SizedBox(height: 4),
                          Container(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 8,
                              vertical: 4,
                            ),
                            decoration: BoxDecoration(
                              color: Theme.of(context).colorScheme.primary,
                              borderRadius: BorderRadius.circular(12),
                            ),
                            child: Text(
                              truck.foodType,
                              style: Theme.of(context).textTheme.bodySmall
                                  ?.copyWith(
                                    color: Theme.of(
                                      context,
                                    ).colorScheme.onPrimary,
                                    fontWeight: FontWeight.w500,
                                  ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    IconButton(
                      icon: const Icon(Icons.info_outline),
                      onPressed: () => _showTruckDetails(context, truck),
                    ),
                  ],
                ),
              ),

              // Truck details
              Padding(
                padding: const EdgeInsets.all(16),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Location
                    Row(
                      children: [
                        const Icon(Icons.location_on, size: 20),
                        const SizedBox(width: 8),
                        Expanded(
                          child: Text(
                            truck.locationDescription,
                            style: Theme.of(context).textTheme.bodyMedium,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 8),

                    // Menu info
                    if (truck.menuInfo != null && truck.menuInfo!.isNotEmpty)
                      Row(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Icon(Icons.restaurant_menu, size: 20),
                          const SizedBox(width: 8),
                          Expanded(
                            child: Text(
                              truck.menuInfo!,
                              style: Theme.of(context).textTheme.bodyMedium,
                            ),
                          ),
                        ],
                      ),

                    if (truck.menuInfo != null && truck.menuInfo!.isNotEmpty)
                      const SizedBox(height: 8),

                    // News/Updates
                    if (truck.news != null && truck.news!.isNotEmpty)
                      Row(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Icon(Icons.campaign, size: 20),
                          const SizedBox(width: 8),
                          Expanded(
                            child: Text(
                              truck.news!,
                              style: Theme.of(context).textTheme.bodyMedium
                                  ?.copyWith(fontStyle: FontStyle.italic),
                            ),
                          ),
                        ],
                      ),

                    if (truck.news != null && truck.news!.isNotEmpty)
                      const SizedBox(height: 8),

                    // Last reported
                    Row(
                      children: [
                        const Icon(Icons.access_time, size: 20),
                        const SizedBox(width: 8),
                        Text(
                          'Last updated: ${truck.lastReportedHuman}',
                          style: Theme.of(context).textTheme.bodySmall,
                        ),
                      ],
                    ),

                    // Report Location button
                    TextButton.icon(
                      onPressed: () => _reportLocation(context, truck),
                      icon: const Icon(Icons.location_on, size: 16),
                      label: const Text('Report Location'),
                      style: TextButton.styleFrom(
                        foregroundColor: Theme.of(context).colorScheme.primary,
                        textStyle: const TextStyle(fontSize: 12),
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        );
      },
    );
  }

  void _reportLocation(BuildContext context, FoodTruck truck) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => ReportLocationScreen(truck: truck),
      ),
    );
  }

  void _showTruckDetails(BuildContext context, truck) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text(truck.name),
        content: TruckInfoCard(truck: truck, showCard: false),
        // Removed actions since TruckInfoCard has its own close button
      ),
    );
  }
}
