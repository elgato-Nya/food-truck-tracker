import 'package:flutter_dotenv/flutter_dotenv.dart';

class Config {
  static String get googleMapsApiKey => dotenv.env['GOOGLE_MAPS_API_KEY'] ?? '';
  static String get apiBaseUrl => dotenv.env['API_BASE_URL'] ?? 'http://localhost:8000/api/v1';
  
  static bool get isGoogleMapsConfigured => googleMapsApiKey.isNotEmpty && googleMapsApiKey != 'your_google_maps_api_key_here';
  
  static Future<void> load() async {
    await dotenv.load(fileName: ".env");
  }
}
