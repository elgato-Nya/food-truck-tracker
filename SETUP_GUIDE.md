# Food Truck Tracker - Complete Setup Guide

## 🎯 Project Overview
This is a complete food truck location tracking system with:
- **Flutter Mobile App**: Real-time map with food truck locations
- **Laravel Backend**: RESTful API and admin dashboard  
- **MySQL Database**: Stores truck data and locations

## 🚀 Quick Start

### 1. Backend Setup (Laravel)
```powershell
# Navigate to backend
cd backend

# Install PHP dependencies
composer install

# Setup environment
copy .env.example .env
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_truck_tracker
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seed data
php artisan migrate
php artisan db:seed

# Start server
php artisan serve
```

### 2. Mobile App Setup (Flutter)
```powershell
# Navigate to mobile
cd mobile

# Install dependencies
flutter pub get

# Configure API keys in .env
GOOGLE_MAPS_API_KEY=your_actual_api_key_here
API_BASE_URL=http://localhost:8000/api/v1

# Configure Android API key in android/local.properties
GOOGLE_MAPS_API_KEY=your_actual_api_key_here

# Run the app
flutter run
```

## 📍 Important URLs

- **Laravel Backend**: http://localhost:8000
- **Admin Dashboard**: http://localhost:8000/admin  
- **API Health Check**: http://localhost:8000/api/health
- **API Endpoints**: http://localhost:8000/api/v1/food-trucks

## 🔑 Required API Keys

### Google Maps API Key Setup:
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create project and enable these APIs:
   - Maps SDK for Android
   - Maps SDK for iOS  
   - Maps JavaScript API
3. Create API Key credentials
4. Add to both:
   - `mobile/.env` → `GOOGLE_MAPS_API_KEY=your_key`
   - `mobile/android/local.properties` → `GOOGLE_MAPS_API_KEY=your_key`

## 🎨 Features Implemented

### Mobile App ✅
- [x] Google Maps integration with custom markers
- [x] Color-coded markers by food type
- [x] Truck info bottom sheets with details
- [x] Pull-to-refresh functionality
- [x] About page with developer info
- [x] **Dark/Light Mode Toggle with persistence**
- [x] **Smooth theme transitions and animations**
- [x] **Enhanced Material 3 UI/UX design**
- [x] **Responsive AppBar with theme toggle**
- [x] **Loading states with progress indicators**
- [x] Environment-based configuration
- [x] Error handling and loading states

### Backend API ✅
- [x] RESTful API endpoints
- [x] CORS configuration for Flutter
- [x] Food truck CRUD operations
- [x] Database migrations and seeders
- [x] Health check endpoint

### Admin Dashboard ✅
- [x] Responsive web interface
- [x] Food truck management (CRUD)
- [x] Statistics dashboard
- [x] Form validation
- [x] Success/error messaging

### UI/UX Enhancements ✅
- [x] **Complete dark theme implementation**
- [x] **Theme-aware components throughout**
- [x] **Smooth animations and transitions**
- [x] **Consistent Material 3 design language**
- [x] **Proper accessibility features**
- [x] **Enhanced loading and error states**

## 📱 App Structure

```
mobile/lib/
├── config/config.dart              # Environment variables
├── models/
│   ├── food_truck.dart            # Data model
│   └── api_response.dart          # API wrapper
├── providers/
│   └── food_truck_provider.dart   # State management
├── screens/
│   ├── map_screen.dart            # Main map view
│   └── about_screen.dart          # Developer info
├── services/
│   └── api_service.dart           # HTTP client
├── widgets/
│   └── truck_info_card.dart       # Bottom sheet component
└── main.dart                      # App entry point
```

## 🛠️ Development Commands

### Backend (Laravel)
```bash
php artisan migrate:fresh --seed    # Reset database
php artisan route:list              # View all routes  
php artisan tinker                  # Laravel REPL
```

### Mobile (Flutter)
```bash
flutter analyze                     # Static analysis
flutter test                       # Run tests
flutter build apk                  # Build APK
flutter devices                    # List devices
```

## 🐛 Troubleshooting

### Common Issues:

1. **Google Maps not showing**
   - Verify API key in both `.env` and `local.properties`
   - Check API restrictions in Google Cloud Console

2. **API connection failed**  
   - Ensure Laravel server running on localhost:8000
   - Check CORS configuration
   - Verify internet permissions in AndroidManifest.xml

3. **Database connection error**
   - Confirm MySQL running in Laragon
   - Check credentials in backend/.env
   - Create database manually if needed

4. **Flutter build errors**
   - Run `flutter clean && flutter pub get`
   - Check Dart/Flutter versions compatibility

## 🎯 Next Steps

### Planned Enhancements:
- [ ] User authentication system
- [ ] Real-time location updates
- [ ] Push notifications
- [ ] Photo uploads for trucks  
- [ ] Rating and review system
- [ ] Search and filter functionality
- [ ] Offline caching

### Customization Ideas:
- [x] **Dark mode support** ✅ COMPLETED
- [ ] Custom app icon and splash screen
- [ ] Different marker designs
- [ ] Sound notifications
- [ ] Multiple language support

## 📋 Testing Checklist

### Backend Testing:
- [ ] API endpoints return correct data
- [ ] Admin dashboard CRUD operations work
- [ ] Database seeder creates sample data
- [ ] CORS allows Flutter app requests

### Mobile Testing:  
- [ ] Maps load with correct initial position
- [ ] Markers appear for all active trucks
- [ ] Truck details show in bottom sheet
- [ ] About page displays developer info
- [ ] Pull-to-refresh updates data
- [ ] Error states display properly

## 👨‍💻 Developer Notes

Remember to update the About page with your actual information:
- Developer name
- Student number  
- Programme code
- GitHub repository URL

## 📄 File Structure Summary

```
food-truck-tracker/
├── backend/                    # Laravel API & Admin
│   ├── app/Models/FoodTruck.php
│   ├── app/Http/Controllers/
│   ├── database/migrations/
│   ├── routes/api.php
│   └── resources/views/admin/
├── mobile/                     # Flutter App
│   ├── lib/
│   ├── android/
│   ├── .env
│   └── pubspec.yaml
└── README.md                   # This file
```

---

**Ready to code!** 🚀 Both backend and mobile app are fully set up and ready for development.
