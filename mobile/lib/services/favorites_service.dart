import 'package:shared_preferences/shared_preferences.dart';

class FavoritesService {
  static const String _favoritesKey = 'favorite_trucks';

  /// Get list of favorite truck IDs
  static Future<List<int>> getFavorites() async {
    final prefs = await SharedPreferences.getInstance();
    final favoriteStrings = prefs.getStringList(_favoritesKey) ?? [];
    return favoriteStrings.map((id) => int.parse(id)).toList();
  }

  /// Add a truck to favorites
  static Future<void> addToFavorites(int truckId) async {
    final prefs = await SharedPreferences.getInstance();
    final favorites = await getFavorites();

    if (!favorites.contains(truckId)) {
      favorites.add(truckId);
      final favoriteStrings = favorites.map((id) => id.toString()).toList();
      await prefs.setStringList(_favoritesKey, favoriteStrings);
    }
  }

  /// Remove a truck from favorites
  static Future<void> removeFromFavorites(int truckId) async {
    final prefs = await SharedPreferences.getInstance();
    final favorites = await getFavorites();

    if (favorites.contains(truckId)) {
      favorites.remove(truckId);
      final favoriteStrings = favorites.map((id) => id.toString()).toList();
      await prefs.setStringList(_favoritesKey, favoriteStrings);
    }
  }

  /// Check if a truck is in favorites
  static Future<bool> isFavorite(int truckId) async {
    final favorites = await getFavorites();
    return favorites.contains(truckId);
  }

  /// Toggle favorite status
  static Future<bool> toggleFavorite(int truckId) async {
    final isFav = await isFavorite(truckId);
    if (isFav) {
      await removeFromFavorites(truckId);
      return false;
    } else {
      await addToFavorites(truckId);
      return true;
    }
  }
}
