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
      print('API: Attempting to connect to: $baseUrl/food-trucks');
      final response = await http
          .get(Uri.parse('$baseUrl/food-trucks'), headers: headers)
          .timeout(const Duration(seconds: 10));
      print('API: Response status: ${response.statusCode}');

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
      print('API: Error occurred: $e');
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

  /// Update food truck location
  static Future<ApiResponse<FoodTruck>> updateLocation(
    int truckId,
    double latitude,
    double longitude,
    String locationDescription,
    String reportedBy,
  ) async {
    try {
      final response = await http.put(
        Uri.parse('$baseUrl/food-trucks/$truckId/location'),
        headers: headers,
        body: json.encode({
          'latitude': latitude,
          'longitude': longitude,
          'location_description': locationDescription,
          'reported_by': reportedBy,
        }),
      );

      final Map<String, dynamic> jsonResponse = json.decode(response.body);

      if (response.statusCode == 200) {
        if (jsonResponse['success'] == true && jsonResponse['data'] != null) {
          final FoodTruck truck = FoodTruck.fromJson(jsonResponse['data']);

          return ApiResponse<FoodTruck>(
            success: true,
            data: truck,
            message: jsonResponse['message'] ?? 'Location updated successfully',
          );
        } else {
          return ApiResponse<FoodTruck>(
            success: false,
            message: jsonResponse['message'] ?? 'Failed to update location',
            error: jsonResponse['error'],
          );
        }
      } else {
        return ApiResponse<FoodTruck>(
          success: false,
          message: jsonResponse['message'] ?? 'Failed to update location',
          error: jsonResponse['error'],
        );
      }
    } catch (e) {
      return ApiResponse<FoodTruck>(
        success: false,
        message: 'Error updating location: $e',
        error: e.toString(),
      );
    }
  }

  /// Submit location report for admin review
  static Future<ApiResponse<Map<String, dynamic>>> submitLocationReport(
    int truckId,
    String locationName,
    String locationDescription,
    String reportedBy,
  ) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/location-reports'),
        headers: headers,
        body: json.encode({
          'food_truck_id': truckId,
          'location_name': locationName,
          'location_description': locationDescription,
          'reported_by': reportedBy,
        }),
      );

      final Map<String, dynamic> jsonResponse = json.decode(response.body);

      if (response.statusCode == 201) {
        return ApiResponse<Map<String, dynamic>>(
          success: true,
          data: jsonResponse['data'],
          message:
              jsonResponse['message'] ??
              'Location report submitted successfully',
        );
      } else {
        return ApiResponse<Map<String, dynamic>>(
          success: false,
          message:
              jsonResponse['message'] ?? 'Failed to submit location report',
          error: jsonResponse['error'],
        );
      }
    } catch (e) {
      return ApiResponse<Map<String, dynamic>>(
        success: false,
        message: 'Error submitting location report: $e',
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
