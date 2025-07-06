import 'package:flutter/foundation.dart';
import '../models/food_truck.dart';
import '../services/api_service.dart';

class FoodTruckProvider with ChangeNotifier {
  List<FoodTruck> _foodTrucks = [];
  bool _isLoading = false;
  String? _error;
  FoodTruck? _selectedTruck;

  // Getters
  List<FoodTruck> get foodTrucks => _foodTrucks;
  bool get isLoading => _isLoading;
  String? get error => _error;
  FoodTruck? get selectedTruck => _selectedTruck;

  /// Load all food trucks from API
  Future<void> loadFoodTrucks() async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final response = await ApiService.getFoodTrucks();
      
      if (response.success && response.data != null) {
        _foodTrucks = response.data!;
        _error = null;
      } else {
        _error = response.message;
        _foodTrucks = [];
      }
    } catch (e) {
      _error = 'Failed to load food trucks: $e';
      _foodTrucks = [];
    } finally {
      _isLoading = false;
      notifyListeners();
    }
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

  /// Refresh data
  Future<void> refresh() async {
    await loadFoodTrucks();
  }

  /// Get truck by ID
  FoodTruck? getTruckById(int id) {
    try {
      return _foodTrucks.firstWhere((truck) => truck.id == id);
    } catch (e) {
      return null;
    }
  }

  /// Check if there are any trucks available
  bool get hasTrucks => _foodTrucks.isNotEmpty;

  /// Get trucks by food type
  List<FoodTruck> getTrucksByFoodType(String foodType) {
    return _foodTrucks
        .where((truck) => truck.foodType.toLowerCase().contains(foodType.toLowerCase()))
        .toList();
  }
}
