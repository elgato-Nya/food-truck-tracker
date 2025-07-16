import 'package:flutter/foundation.dart';
import 'dart:math' as math;
import '../models/food_truck.dart';
import '../services/api_service.dart';

class FoodTruckProvider with ChangeNotifier {
  List<FoodTruck> _allFoodTrucks = [];
  List<FoodTruck> _filteredFoodTrucks = [];
  bool _isLoading = false;
  String? _error;
  FoodTruck? _selectedTruck;

  // Search and filter state
  String _searchQuery = '';
  Set<String> _selectedFoodTypes = {};
  List<String> _availableFoodTypes = [];

  // Getters
  List<FoodTruck> get foodTrucks => _filteredFoodTrucks;
  List<FoodTruck> get allFoodTrucks => _allFoodTrucks;
  bool get isLoading => _isLoading;
  String? get error => _error;
  FoodTruck? get selectedTruck => _selectedTruck;
  String get searchQuery => _searchQuery;
  Set<String> get selectedFoodTypes => _selectedFoodTypes;
  List<String> get availableFoodTypes => _availableFoodTypes;

  bool get hasTrucks => _filteredFoodTrucks.isNotEmpty;

  /// Load all food trucks from API
  Future<void> loadFoodTrucks() async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      print('Provider: Starting to load food trucks...');
      final response = await ApiService.getFoodTrucks();
      print('Provider: Response received - success: ${response.success}');

      if (response.success && response.data != null) {
        _allFoodTrucks = response.data!;
        _extractFoodTypes();
        _applyFilters();
        _error = null;
        print(
          'Provider: Successfully loaded ${_allFoodTrucks.length} food trucks',
        );
      } else {
        _error = response.message;
        _allFoodTrucks = [];
        _filteredFoodTrucks = [];
        print('Provider: Failed to load food trucks - ${response.message}');
      }
    } catch (e) {
      _error = 'Failed to load food trucks: $e';
      print('Provider: Exception occurred - $e');
      _allFoodTrucks = [];
      _filteredFoodTrucks = [];
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  /// Extract unique food types from all trucks
  void _extractFoodTypes() {
    final types = _allFoodTrucks
        .map((truck) => truck.foodType)
        .toSet()
        .toList();
    types.sort();
    _availableFoodTypes = types;
  }

  /// Apply search and filter
  void _applyFilters() {
    _filteredFoodTrucks = _allFoodTrucks.where((truck) {
      // Search filter
      final matchesSearch =
          _searchQuery.isEmpty ||
          truck.name.toLowerCase().contains(_searchQuery.toLowerCase()) ||
          truck.locationDescription.toLowerCase().contains(
            _searchQuery.toLowerCase(),
          ) ||
          truck.foodType.toLowerCase().contains(_searchQuery.toLowerCase());

      // Food type filter - matches if no types selected or if truck's type is in selected types
      final matchesFoodType =
          _selectedFoodTypes.isEmpty ||
          _selectedFoodTypes.contains(truck.foodType);

      return matchesSearch && matchesFoodType;
    }).toList();
  }

  /// Search food trucks by name, location, or food type
  void searchFoodTrucks(String query) {
    _searchQuery = query;
    _applyFilters();
    notifyListeners();
  }

  /// Toggle food type filter
  void toggleFoodTypeFilter(String foodType) {
    if (_selectedFoodTypes.contains(foodType)) {
      _selectedFoodTypes.remove(foodType);
    } else {
      _selectedFoodTypes.add(foodType);
    }
    _applyFilters();
    notifyListeners();
  }

  /// Filter by food type (legacy method - kept for backward compatibility)
  void filterByFoodType(String foodType) {
    _selectedFoodTypes.clear();
    if (foodType.isNotEmpty) {
      _selectedFoodTypes.add(foodType);
    }
    _applyFilters();
    notifyListeners();
  }

  /// Clear all filters
  void clearFilters() {
    _searchQuery = '';
    _selectedFoodTypes.clear();
    _applyFilters();
    notifyListeners();
  }

  /// Get food trucks near a specific location
  List<FoodTruck> getFoodTrucksNearLocation(
    double latitude,
    double longitude,
    double radiusKm,
  ) {
    return _filteredFoodTrucks.where((truck) {
      final distance = _calculateDistance(
        latitude,
        longitude,
        truck.latitude,
        truck.longitude,
      );
      return distance <= radiusKm;
    }).toList();
  }

  /// Calculate distance between two points using Haversine formula
  double _calculateDistance(
    double lat1,
    double lon1,
    double lat2,
    double lon2,
  ) {
    const double earthRadius = 6371; // Earth's radius in kilometers

    final double dLat = _degreesToRadians(lat2 - lat1);
    final double dLon = _degreesToRadians(lon2 - lon1);

    final double a =
        math.sin(dLat / 2) * math.sin(dLat / 2) +
        math.cos(_degreesToRadians(lat1)) *
            math.cos(_degreesToRadians(lat2)) *
            math.sin(dLon / 2) *
            math.sin(dLon / 2);

    final double c = 2 * math.asin(math.sqrt(a));

    return earthRadius * c;
  }

  double _degreesToRadians(double degrees) {
    return degrees * (math.pi / 180);
  }

  /// Select a specific food truck
  void selectTruck(FoodTruck truck) {
    _selectedTruck = truck;
    notifyListeners();
  }

  /// Clear selected truck
  void clearSelection() {
    _selectedTruck = null;
    notifyListeners();
  }

  /// Refresh food trucks
  Future<void> refresh() async {
    await loadFoodTrucks();
  }

  /// Get truck by ID
  FoodTruck? getTruckById(int id) {
    try {
      return _filteredFoodTrucks.firstWhere((truck) => truck.id == id);
    } catch (e) {
      return null;
    }
  }

  /// Get trucks by food type
  List<FoodTruck> getTrucksByFoodType(String foodType) {
    return _filteredFoodTrucks
        .where(
          (truck) =>
              truck.foodType.toLowerCase().contains(foodType.toLowerCase()),
        )
        .toList();
  }

  /// Report a new location for a food truck
  Future<void> reportLocation(
    int truckId,
    String locationName,
    String locationDescription,
    String reportedBy,
  ) async {
    try {
      final response = await ApiService.submitLocationReport(
        truckId,
        locationName,
        locationDescription,
        reportedBy,
      );

      if (response.success) {
        // Location report submitted successfully
        // Note: The actual truck location will be updated after admin approval
        notifyListeners();
      } else {
        throw Exception(response.message);
      }
    } catch (e) {
      throw Exception('Failed to submit location report: $e');
    }
  }
}
