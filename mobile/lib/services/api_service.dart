import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/food_truck.dart';
import '../models/api_response.dart';
import '../config/config.dart';

class ApiService {
  // Get base URL from environment
  static String get baseUrl => Config.apiBaseUrl;
  
  // Headers for requests
  static const Map<String, String> headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  /// Get all active food trucks
  static Future<ApiResponse<List<FoodTruck>>> getFoodTrucks() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/food-trucks'),
        headers: headers,
      );

      final Map<String, dynamic> jsonResponse = json.decode(response.body);

      if (response.statusCode == 200) {
        if (jsonResponse['success'] == true && jsonResponse['data'] != null) {
          final List<dynamic> trucksJson = jsonResponse['data'];
          final List<FoodTruck> trucks = trucksJson
              .map((json) => FoodTruck.fromJson(json))
              .toList();

          return ApiResponse<List<FoodTruck>>(
            success: true,
            data: trucks,
            message: jsonResponse['message'] ?? 'Success',
          );
        } else {
          return ApiResponse<List<FoodTruck>>(
            success: false,
            message: jsonResponse['message'] ?? 'Unknown error',
            error: jsonResponse['error'],
          );
        }
      } else {
        return ApiResponse<List<FoodTruck>>(
          success: false,
          message: 'HTTP ${response.statusCode}: ${response.reasonPhrase}',
          error: 'Network error',
        );
      }
    } catch (e) {
      return ApiResponse<List<FoodTruck>>(
        success: false,
        message: 'Failed to connect to server',
        error: e.toString(),
      );
    }
  }

  /// Get a specific food truck by ID
  static Future<ApiResponse<FoodTruck>> getFoodTruck(int id) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/food-trucks/$id'),
        headers: headers,
      );

      final Map<String, dynamic> jsonResponse = json.decode(response.body);

      if (response.statusCode == 200) {
        if (jsonResponse['success'] == true && jsonResponse['data'] != null) {
          final FoodTruck truck = FoodTruck.fromJson(jsonResponse['data']);

          return ApiResponse<FoodTruck>(
            success: true,
            data: truck,
            message: jsonResponse['message'] ?? 'Success',
          );
        } else {
          return ApiResponse<FoodTruck>(
            success: false,
            message: jsonResponse['message'] ?? 'Unknown error',
            error: jsonResponse['error'],
          );
        }
      } else {
        return ApiResponse<FoodTruck>(
          success: false,
          message: 'HTTP ${response.statusCode}: ${response.reasonPhrase}',
          error: 'Network error',
        );
      }
    } catch (e) {
      return ApiResponse<FoodTruck>(
        success: false,
        message: 'Failed to connect to server',
        error: e.toString(),
      );
    }
  }

  /// Check API health
  static Future<bool> checkHealth() async {
    try {
      final response = await http.get(
        Uri.parse('${baseUrl.replaceAll('/v1', '')}/health'),
        headers: headers,
      );
      return response.statusCode == 200;
    } catch (e) {
      return false;
    }
  }
}
