import 'package:url_launcher/url_launcher.dart';
import 'package:flutter/material.dart';

class NavigationService {
  /// Open Google Maps with directions to a specific location
  static Future<void> openGoogleMaps(
    BuildContext context,
    double latitude,
    double longitude,
    String locationName,
  ) async {
    final Uri googleMapsUrl = Uri.parse(
      'https://www.google.com/maps/dir/?api=1&destination=$latitude,$longitude&destination_place_id=$locationName',
    );

    try {
      if (await canLaunchUrl(googleMapsUrl)) {
        await launchUrl(googleMapsUrl, mode: LaunchMode.externalApplication);
      } else {
        throw Exception('Could not open Google Maps');
      }
    } catch (e) {
      if (context.mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Error opening maps: $e'),
            backgroundColor: Colors.red,
          ),
        );
      }
    }
  }

  /// Open Apple Maps (iOS) with directions to a specific location
  static Future<void> openAppleMaps(
    BuildContext context,
    double latitude,
    double longitude,
    String locationName,
  ) async {
    final Uri appleMapsUrl = Uri.parse(
      'https://maps.apple.com/?daddr=$latitude,$longitude',
    );

    try {
      if (await canLaunchUrl(appleMapsUrl)) {
        await launchUrl(appleMapsUrl, mode: LaunchMode.externalApplication);
      } else {
        throw Exception('Could not open Apple Maps');
      }
    } catch (e) {
      if (context.mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Error opening maps: $e'),
            backgroundColor: Colors.red,
          ),
        );
      }
    }
  }

  /// Show a dialog to let user choose which maps app to use
  static void showMapsDialog(
    BuildContext context,
    double latitude,
    double longitude,
    String locationName,
  ) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Open in Maps'),
        content: Text('Get directions to $locationName?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text('Cancel'),
          ),
          TextButton(
            onPressed: () {
              Navigator.of(context).pop();
              openGoogleMaps(context, latitude, longitude, locationName);
            },
            child: const Text('Google Maps'),
          ),
          TextButton(
            onPressed: () {
              Navigator.of(context).pop();
              openAppleMaps(context, latitude, longitude, locationName);
            },
            child: const Text('Apple Maps'),
          ),
        ],
      ),
    );
  }
}
