import 'package:flutter/material.dart';
import 'package:flutter/foundation.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:provider/provider.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import '../providers/food_truck_provider.dart';
import '../providers/theme_provider.dart';
import '../models/food_truck.dart';
import '../widgets/truck_info_card.dart';
import '../widgets/search_filter_widget.dart';
import '../config/config.dart';
import 'food_truck_list_screen.dart';

class MapScreen extends StatefulWidget {
  const MapScreen({super.key});

  @override
  State<MapScreen> createState() => _MapScreenState();
}

class _MapScreenState extends State<MapScreen> {
  GoogleMapController? _mapController;
  final Set<Marker> _markers = {};
  FoodTruckProvider? _provider; // Store provider reference

  // Default to Malaysia center for better coverage
  static const CameraPosition _initialPosition = CameraPosition(
    target: LatLng(4.2105, 101.9758), // Center of Malaysia
    zoom: 6.0, // Zoom level to show entire Malaysia
  );

  @override
  void initState() {
    super.initState();

    // Debug API key configuration
    print('Google Maps API Key configured: ${Config.isGoogleMapsConfigured}');
    print(
      'API Key: ${Config.googleMapsApiKey.isEmpty ? 'Empty' : 'Set (${Config.googleMapsApiKey.length} chars)'}',
    );
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();

    // Safely get provider reference during dependencies phase
    if (_provider == null) {
      _provider = context.read<FoodTruckProvider>();

      // Load food trucks when the screen initializes
      WidgetsBinding.instance.addPostFrameCallback((_) {
        _provider?.loadFoodTrucks();
        // Add listener to update markers when trucks change
        _provider?.addListener(_updateMarkers);
      });
    }
  }

  @override
  void dispose() {
    // Safely remove listener using stored reference
    _provider?.removeListener(_updateMarkers);
    _mapController?.dispose();
    super.dispose();
  }

  void _updateMarkers() {
    if (_provider != null) {
      _createMarkers(_provider!.foodTrucks);
    }
  }

  void _onMapCreated(GoogleMapController controller) {
    _mapController = controller;
  }

  void _createMarkers(List<FoodTruck> trucks) {
    final newMarkers = <Marker>{};

    for (FoodTruck truck in trucks) {
      newMarkers.add(
        Marker(
          markerId: MarkerId(truck.id.toString()),
          position: LatLng(truck.latitude, truck.longitude),
          infoWindow: InfoWindow(
            title: truck.name,
            snippet: '${truck.foodType} • ${truck.lastReportedHuman}',
          ),
          icon: BitmapDescriptor.defaultMarkerWithHue(
            _getMarkerHue(truck.foodType),
          ),
          onTap: () => _onMarkerTapped(truck),
        ),
      );
    }

    if (mounted) {
      setState(() {
        _markers.clear();
        _markers.addAll(newMarkers);
      });
    }
  }

  double _getMarkerHue(String foodType) {
    // Different colors for different Malaysian food types
    switch (foodType.toLowerCase()) {
      case 'nasi lemak':
        return BitmapDescriptor.hueRed; // Red for national dish
      case 'char kuey teow':
        return BitmapDescriptor.hueOrange; // Orange for noodles
      case 'assam laksa':
      case 'sarawak laksa':
      case 'laksa johor':
        return BitmapDescriptor.hueBlue; // Blue for laksa varieties
      case 'satay celup':
      case 'otak-otak':
        return BitmapDescriptor.hueGreen; // Green for grilled items
      case 'chicken rice ball':
      case 'hor fun':
      case 'tuaran mee':
      case 'kolo mee':
        return BitmapDescriptor.hueYellow; // Yellow for rice/noodle dishes
      case 'bak kut teh':
        return BitmapDescriptor.hueMagenta; // Magenta for soup
      case 'roti canai':
      case 'roti john':
        return BitmapDescriptor.hueViolet; // Violet for bread items
      case 'cendol':
      case 'dessert':
        return BitmapDescriptor.hueCyan; // Cyan for desserts
      case 'hinava':
        return BitmapDescriptor.hueAzure; // Azure for Sabahan dishes
      case 'chai tow kway':
      case 'rojak':
        return BitmapDescriptor.hueRose; // Rose for street snacks
      case 'korean bbq':
        return BitmapDescriptor.hueRed; // Red for Korean
      case 'fusion burger':
        return BitmapDescriptor.hueOrange; // Orange for fusion
      case 'coffee & pastries':
        return BitmapDescriptor.hueCyan; // Cyan for coffee
      default:
        return BitmapDescriptor.hueBlue; // Default blue
    }
  }

  void _onMarkerTapped(FoodTruck truck) {
    // Show bottom sheet with truck details
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => TruckInfoCard(truck: truck),
    );
  }

  @override
  Widget build(BuildContext context) {
    // Check if running on web platform
    if (kIsWeb) {
      return Scaffold(
        appBar: AppBar(title: const Text('Food Truck Tracker')),
        body: const Center(
          child: Padding(
            padding: EdgeInsets.all(16.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Icon(Icons.phone_android, size: 64, color: Colors.orange),
                SizedBox(height: 16),
                Text(
                  'Mobile App Required',
                  style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                ),
                SizedBox(height: 8),
                Text(
                  'This Food Truck Tracker is designed for mobile devices.',
                  textAlign: TextAlign.center,
                  style: TextStyle(fontSize: 16),
                ),
                SizedBox(height: 16),
                Text(
                  'Please run this app on:\n'
                  '• Android device or emulator\n'
                  '• iOS device or simulator\n\n'
                  'Use: flutter run -d android',
                  textAlign: TextAlign.center,
                  style: TextStyle(fontSize: 14, color: Colors.grey),
                ),
              ],
            ),
          ),
        ),
      );
    }

    // Check if Google Maps is configured
    if (!Config.isGoogleMapsConfigured) {
      return Scaffold(
        appBar: AppBar(title: const Text('Food Truck Tracker')),
        body: const Center(
          child: Padding(
            padding: EdgeInsets.all(16.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Icon(Icons.error_outline, size: 64, color: Colors.orange),
                SizedBox(height: 16),
                Text(
                  'Google Maps Not Configured',
                  style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                ),
                SizedBox(height: 8),
                Text(
                  'Please add your Google Maps API key to the .env file and local.properties file.',
                  textAlign: TextAlign.center,
                  style: TextStyle(fontSize: 16),
                ),
                SizedBox(height: 16),
                Text(
                  'Steps:\n'
                  '1. Get API key from Google Cloud Console\n'
                  '2. Add to mobile/.env: GOOGLE_MAPS_API_KEY=your_key\n'
                  '3. Add to mobile/android/local.properties: GOOGLE_MAPS_API_KEY=your_key',
                  textAlign: TextAlign.left,
                  style: TextStyle(fontSize: 14, color: Colors.grey),
                ),
              ],
            ),
          ),
        ),
      );
    }

    return Scaffold(
      appBar: AppBar(
        title: const Text('Food Truck Tracker'),
        actions: [
          // Refresh button with loading state
          Consumer<FoodTruckProvider>(
            builder: (context, provider, child) {
              return IconButton(
                icon: provider.isLoading
                    ? const SizedBox(
                        width: 20,
                        height: 20,
                        child: CircularProgressIndicator(strokeWidth: 2),
                      )
                    : const Icon(Icons.refresh),
                onPressed: provider.isLoading ? null : () => provider.refresh(),
                tooltip: 'Refresh',
              );
            },
          ),
          // Dark mode toggle
          Consumer<ThemeProvider>(
            builder: (context, themeProvider, child) {
              return IconButton(
                icon: Icon(
                  themeProvider.isDarkMode ? Icons.light_mode : Icons.dark_mode,
                ),
                onPressed: themeProvider.toggleTheme,
                tooltip: themeProvider.isDarkMode
                    ? 'Switch to Light Mode'
                    : 'Switch to Dark Mode',
              );
            },
          ),
        ],
      ),
      body: Stack(
        children: [
          // Always show the GoogleMap widget
          GoogleMap(
            onMapCreated: _onMapCreated,
            initialCameraPosition: _initialPosition,
            markers: _markers,
            myLocationEnabled: true,
            myLocationButtonEnabled: true,
            mapType: MapType.normal,
            zoomControlsEnabled: false,
          ),

          // Overlay UI elements based on provider state
          Consumer<FoodTruckProvider>(
            builder: (context, provider, child) {
              return Stack(
                children: [
                  // Search widget at the top
                  Positioned(
                    top: 16,
                    left: 16,
                    right: 16,
                    child: SearchAndFilterWidget(),
                  ),

                  // Loading overlay
                  if (provider.isLoading && !provider.hasTrucks)
                    Container(
                      color: Colors.black.withOpacity(0.5),
                      child: const Center(
                        child: SpinKitFadingCircle(
                          color: Color(0xFFEA580C),
                          size: 50.0,
                        ),
                      ),
                    ),

                  // Error overlay
                  if (provider.error != null && !provider.hasTrucks)
                    Container(
                      color: Colors.black.withOpacity(0.8),
                      child: Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            const Icon(
                              Icons.error_outline,
                              size: 64,
                              color: Colors.red,
                            ),
                            const SizedBox(height: 16),
                            Text(
                              'Unable to load food trucks',
                              style: Theme.of(context).textTheme.headlineSmall
                                  ?.copyWith(color: Colors.white),
                            ),
                            const SizedBox(height: 8),
                            Text(
                              provider.error!,
                              textAlign: TextAlign.center,
                              style: Theme.of(context).textTheme.bodyMedium
                                  ?.copyWith(color: Colors.white),
                            ),
                            const SizedBox(height: 16),
                            ElevatedButton(
                              onPressed: () => provider.refresh(),
                              child: const Text('Retry'),
                            ),
                          ],
                        ),
                      ),
                    ),

                  // Food truck count badge
                  if (provider.hasTrucks)
                    Positioned(
                      top:
                          kToolbarHeight +
                          MediaQuery.of(context).padding.top +
                          16,
                      left: 16,
                      child: Container(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 12,
                          vertical: 8,
                        ),
                        decoration: BoxDecoration(
                          color: Theme.of(context).cardColor,
                          borderRadius: BorderRadius.circular(20),
                          boxShadow: [
                            BoxShadow(
                              color: Colors.black.withOpacity(0.1),
                              blurRadius: 4,
                              offset: const Offset(0, 2),
                            ),
                          ],
                        ),
                        child: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            Icon(
                              Icons.local_dining,
                              color: Theme.of(context).colorScheme.primary,
                              size: 16,
                            ),
                            const SizedBox(width: 4),
                            Text(
                              '${provider.foodTrucks.length} trucks',
                              style: TextStyle(
                                color: Theme.of(context).colorScheme.primary,
                                fontWeight: FontWeight.bold,
                                fontSize: 12,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                ],
              );
            },
          ),
        ],
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () => _showReportDialog(context),
        backgroundColor: Theme.of(context).colorScheme.primary,
        foregroundColor: Theme.of(context).colorScheme.onPrimary,
        tooltip: 'Report Food Truck',
        child: const Icon(Icons.add_location),
      ),
    );
  }

  void _showReportDialog(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Report Food Truck'),
        content: const Text(
          'Select a food truck from the list to report its new location.',
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text('Cancel'),
          ),
          TextButton(
            onPressed: () {
              Navigator.of(context).pop();
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => const FoodTruckListScreen(),
                ),
              );
            },
            child: const Text('Go to List'),
          ),
        ],
      ),
    );
  }
}
