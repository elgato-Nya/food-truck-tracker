import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/food_truck_provider.dart';

class SearchAndFilterWidget extends StatefulWidget {
  const SearchAndFilterWidget({super.key});

  @override
  State<SearchAndFilterWidget> createState() => _SearchAndFilterWidgetState();
}

class _SearchAndFilterWidgetState extends State<SearchAndFilterWidget> {
  final TextEditingController _searchController = TextEditingController();
  bool _isExpanded = false;

  @override
  void initState() {
    super.initState();
    // Initialize search controller with current search query
    final provider = context.read<FoodTruckProvider>();
    _searchController.text = provider.searchQuery;
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Consumer<FoodTruckProvider>(
      builder: (context, provider, child) {
        return Container(
          margin: const EdgeInsets.all(16),
          decoration: BoxDecoration(
            color: Theme.of(context).cardColor,
            borderRadius: BorderRadius.circular(16),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.1),
                blurRadius: 8,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              // Search Bar
              Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 16,
                  vertical: 8,
                ),
                child: Row(
                  children: [
                    Expanded(
                      child: TextField(
                        controller: _searchController,
                        decoration: InputDecoration(
                          hintText:
                              'Search food trucks, locations, or cuisine...',
                          prefixIcon: const Icon(Icons.search),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                            borderSide: BorderSide.none,
                          ),
                          filled: true,
                          fillColor: Theme.of(context).colorScheme.surface,
                        ),
                        onChanged: (value) {
                          provider.searchFoodTrucks(value);
                        },
                      ),
                    ),
                    const SizedBox(width: 8),
                    IconButton(
                      icon: Icon(
                        _isExpanded ? Icons.filter_list : Icons.tune,
                        color:
                            provider.selectedFoodTypes.isNotEmpty ||
                                provider.searchQuery.isNotEmpty
                            ? Theme.of(context).colorScheme.primary
                            : Theme.of(context).colorScheme.onSurface,
                      ),
                      onPressed: () {
                        setState(() {
                          _isExpanded = !_isExpanded;
                        });
                      },
                    ),
                  ],
                ),
              ),

              // Filter Options (Expandable)
              AnimatedContainer(
                duration: const Duration(milliseconds: 300),
                height: _isExpanded ? null : 0,
                child: _isExpanded
                    ? Container(
                        padding: const EdgeInsets.all(16),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const Divider(),
                            const SizedBox(height: 8),

                            // Food Type Filter
                            Row(
                              children: [
                                const Icon(Icons.restaurant_menu, size: 20),
                                const SizedBox(width: 8),
                                Text(
                                  'Cuisine Type',
                                  style: Theme.of(context).textTheme.titleSmall,
                                ),
                                if (provider.selectedFoodTypes.isNotEmpty) ...[
                                  const SizedBox(width: 8),
                                  Container(
                                    padding: const EdgeInsets.symmetric(
                                      horizontal: 6,
                                      vertical: 2,
                                    ),
                                    decoration: BoxDecoration(
                                      color: Theme.of(
                                        context,
                                      ).colorScheme.primary,
                                      borderRadius: BorderRadius.circular(10),
                                    ),
                                    child: Text(
                                      '${provider.selectedFoodTypes.length}',
                                      style: TextStyle(
                                        color: Theme.of(
                                          context,
                                        ).colorScheme.onPrimary,
                                        fontSize: 12,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ),
                                ],
                              ],
                            ),
                            const SizedBox(height: 8),
                            Wrap(
                              spacing: 8,
                              runSpacing: 4,
                              children: [
                                // All filter chip
                                FilterChip(
                                  label: const Text('All'),
                                  selected: provider.selectedFoodTypes.isEmpty,
                                  onSelected: (selected) {
                                    if (selected) {
                                      provider.clearFilters();
                                    }
                                  },
                                ),
                                // Food type filter chips
                                ...provider.availableFoodTypes.map((foodType) {
                                  return FilterChip(
                                    label: Text(foodType),
                                    selected: provider.selectedFoodTypes
                                        .contains(foodType),
                                    onSelected: (selected) {
                                      provider.toggleFoodTypeFilter(foodType);
                                    },
                                  );
                                }),
                              ],
                            ),

                            const SizedBox(height: 16),

                            // Action Buttons
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                              children: [
                                TextButton.icon(
                                  onPressed: () {
                                    _searchController.clear();
                                    provider.clearFilters();
                                  },
                                  icon: const Icon(Icons.clear),
                                  label: const Text('Clear All'),
                                ),
                                ElevatedButton.icon(
                                  onPressed: () {
                                    setState(() {
                                      _isExpanded = false;
                                    });
                                  },
                                  icon: const Icon(Icons.done),
                                  label: const Text('Apply'),
                                ),
                              ],
                            ),
                          ],
                        ),
                      )
                    : const SizedBox.shrink(),
              ),
            ],
          ),
        );
      },
    );
  }
}
