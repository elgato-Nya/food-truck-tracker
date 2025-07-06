# 📱 Food Truck Tracker - Mobile App

Flutter app for tracking food truck locations with Google Maps.

## Features

- Interactive Google Maps with color-coded markers
- Dark/Light mode toggle with animations
- Material 3 design and responsive UI
- Pull-to-refresh for real-time updates
- Provider state management

## Setup

### Prerequisites
- Flutter SDK 3.8.1+
- Google Maps API key

### Installation
```bash
flutter pub get
```

### Google Maps API Key
1. Get API key from [Google Cloud Console](https://console.cloud.google.com/)
2. Enable Maps SDK for Android/iOS
3. Add to `.env`:
```
GOOGLE_MAPS_API_KEY=your_api_key_here
```
4. Add to `android/local.properties`:
```
googleMapsApiKey=your_api_key_here
```

### Run
## Project Structure
```
mobile/lib/
├── models/          # Data models
├── providers/       # State management
├── screens/         # UI screens
├── services/        # API services
├── widgets/         # Reusable components
└── main.dart
```

## License
MIT License

### **Features**
- **Toggle locations**: Map AppBar, About AppBar, Settings card
- **Smooth transitions**: 300ms animated theme switching
- **Persistent storage**: Theme choice saved with SharedPreferences
- **Complete theming**: All components adapt automatically

### **Usage**
```dart
// Toggle theme programmatically
context.read<ThemeProvider>().toggleTheme();

// Check current theme
bool isDark = context.watch<ThemeProvider>().isDarkMode;
```

---

## 🗺️ **Google Maps Integration**

### **Marker Colors by Food Type**
- **Coffee & Pastries**: Cyan
- **BBQ & Grilled**: Red  
- **Mee Goreng**: Yellow
- **Burgers**: Orange
- **Mexican**: Green
- **Default**: Blue

### **Interactive Features**
- **Tap markers**: Show truck details in bottom sheet
- **Info windows**: Quick truck name and food type
- **My location**: Enable location services
- **Zoom controls**: Disabled for cleaner UI

---

## 🔧 **Development**

### **Build Commands**
```bash
# Debug build
flutter build apk --debug

# Release build
flutter build apk --release

# Run tests
flutter test

# Static analysis
flutter analyze
```

### **Adding New Features**

#### **New Food Type Colors**
Update `_getMarkerHue()` in `map_screen.dart`:
```dart
case 'new_food_type':
  return BitmapDescriptor.hueViolet;
```

#### **New API Endpoints**
Add to `api_service.dart`:
```dart
static Future<ApiResponse<T>> newEndpoint() async {
  // Implementation
}
```

---

## 🧪 **Testing**

### **Manual Testing Checklist**
- [ ] Maps load with KL city center view
- [ ] Markers appear for all trucks
- [ ] Marker colors match food types
- [ ] Tap markers show truck details
- [ ] Pull-to-refresh updates data
- [ ] Dark mode toggle works smoothly
- [ ] Theme persists after restart
- [ ] About page displays correctly
- [ ] Error states show retry options

### **Device Testing**
- [ ] Android phone/tablet
- [ ] Android emulator
- [ ] iOS device (if available)
- [ ] Different screen sizes
- [ ] Portrait/landscape orientations

---

## 🔍 **Troubleshooting**

### **Common Issues**

#### **1. Google Maps Not Showing**
```bash
# Check API key configuration
cat .env | grep GOOGLE_MAPS_API_KEY
cat android/local.properties | grep GOOGLE_MAPS_API_KEY

# Verify API is enabled in Google Cloud Console
# Ensure package name matches in API key restrictions
```

#### **2. "Cannot read properties of undefined" Error**
```bash
# This occurs on web - run on Android instead
flutter run -d android
```

#### **3. API Connection Failed**
```bash
# Verify backend is running
curl http://localhost:8000/api/health

# Check network permissions in android/app/src/main/AndroidManifest.xml
<uses-permission android:name="android.permission.INTERNET" />
```

#### **4. Build Failures**
```bash
# Clean and rebuild
flutter clean
flutter pub get
flutter build apk --debug
```

---

## 📊 **Performance**

### **Optimizations Implemented**
- **Efficient state management** with Provider
- **Lazy loading** of truck data
- **Optimized marker creation**
- **Memory management** for map resources
- **Smooth animations** with proper disposal

### **Best Practices**
- **Async operations** with proper error handling
- **Widget rebuilding** minimized with Consumer
- **Resource cleanup** in dispose methods
- **Responsive UI** with MediaQuery

---

## 🎯 **Future Enhancements**

- [ ] **Offline caching** with SQLite
- [ ] **Push notifications** for new trucks
- [ ] **Search and filter** functionality
- [ ] **User authentication** system
- [ ] **Photo uploads** for trucks
- [ ] **Rating system** for trucks
- [ ] **Real-time location** tracking
- [ ] **Multiple language** support

---

**🎉 Mobile app ready for production use!**

For backend setup, see `../backend/README.md`
