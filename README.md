# Food Truck Tracker

A comprehensive Flutter mobile app with Laravel backend for tracking food truck locations in real-time.

## ✅ **PROJECT STATUS: COMPLETED**

**🎉 All features implemented successfully!** See [FINAL_PROJECT_SUMMARY.md](FINAL_PROJECT_SUMMARY.md) for complete details.

### **Key Achievements:**
- ✅ **Full dark mode implementation** with smooth animations
- ✅ **Material 3 UI/UX design** throughout the app
- ✅ **Google Maps integration** with color-coded markers
- ✅ **Complete backend API** with admin dashboard
- ✅ **State management** with Provider pattern
- ✅ **Error handling** and loading states
- ✅ **Responsive design** for all screen sizes

## 🚀 Features

### Mobile App (Flutter)
- **Interactive Google Maps** showing food truck locations with real-time markers
- **Color-coded markers** for different food types (coffee, BBQ, Mexican, etc.)
- **Detailed truck information** with menu info and last reported time
- **Dark/Light Mode Toggle** with smooth animations and persistent settings
- **Responsive UI/UX** with Material 3 design principles
- **Pull-to-refresh functionality** for real-time data updates
- **About page** with developer information and app settings
- **Error handling** with user-friendly error messages
- **Loading states** with elegant progress indicators

### Web Admin Panel (Laravel)
- **Complete CRUD operations** for food trucks
- **Location management** with coordinate input
- **Active/inactive truck status** management
- **Responsive dashboard** with statistics
- **Modern UI** with Tailwind CSS styling
- **Form validation** and error handling
- **Success/error messaging** system

### Backend API (Laravel)
- **RESTful API endpoints** following industry standards
- **MySQL database** with optimized schema
- **CORS enabled** for Flutter app integration
- **Health check endpoint** for monitoring
- **Data validation** and error handling
- **Sample data seeding** for testing

## 🛠️ Setup Instructions

### Prerequisites
- Flutter SDK
- Laragon (with PHP 8.2+ and MySQL)
- Google Maps API Key
- VS Code or Android Studio

### 1. Google Maps API Key Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable the following APIs:
   - Maps SDK for Android
   - Maps SDK for iOS (if building for iOS)
   - Maps JavaScript API
4. Create credentials → API Key
5. Restrict the API key to your package name for security

### 2. Backend Setup (Laravel)

```powershell
# Navigate to backend directory
cd backend

# Install dependencies
composer install

# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_truck_tracker
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Start Laravel server
php artisan serve
```

### 3. Mobile App Setup (Flutter)

```powershell
# Navigate to mobile directory
cd mobile

# Install dependencies
flutter pub get

# Configure API keys
# Edit .env file:
GOOGLE_MAPS_API_KEY=your_actual_api_key_here
API_BASE_URL=http://localhost:8000/api/v1

# Edit android/local.properties:
GOOGLE_MAPS_API_KEY=your_actual_api_key_here

# IMPORTANT: Run on Android (not web)
# Start Android emulator first
flutter emulators --launch Pixel

# Wait for emulator to start, then run:
flutter run -d android

# OR if you have a physical Android device connected:
flutter run
```

## 📱 App Structure

### Mobile App (Flutter)
```
lib/
├── config/
│   └── config.dart              # Environment configuration
├── models/
│   ├── food_truck.dart          # Food truck data model
│   └── api_response.dart        # API response wrapper
├── providers/
│   └── food_truck_provider.dart # State management
├── screens/
│   ├── map_screen.dart          # Main map view
│   └── about_screen.dart        # About page
├── services/
│   └── api_service.dart         # HTTP API calls
├── widgets/
│   └── truck_info_card.dart     # Truck details bottom sheet
└── main.dart                    # App entry point
```

### Backend (Laravel)
```
app/
├── Http/Controllers/
│   ├── AdminController.php      # Web admin CRUD
│   └── Api/FoodTruckController.php # API endpoints
├── Models/
│   └── FoodTruck.php           # Eloquent model
database/
├── migrations/
│   └── create_food_trucks_table.php
└── seeders/
    └── FoodTruckSeeder.php     # Sample data
```

## 🔌 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/food-trucks` | Get all active food trucks |
| GET | `/api/v1/food-trucks/{id}` | Get specific food truck |
| PUT | `/api/v1/food-trucks/{id}/location` | Update truck location |
| GET | `/api/health` | Health check |

## 🌐 Web Admin Routes

| Route | Description |
|-------|-------------|
| `/admin` | Dashboard with truck list |
| `/admin/food-trucks/create` | Add new truck |
| `/admin/food-trucks/{id}/edit` | Edit truck |

## 🎨 UI/UX Enhancements

### Modern Design System
- **Material 3 Design Language** throughout the app
- **Consistent color palette** with orange primary (#EA580C) and complementary colors
- **Typography hierarchy** with proper font weights and sizes
- **Proper spacing and padding** for better visual hierarchy

### Dark Mode Support
- **Complete dark theme** with carefully chosen colors for readability
- **Automatic theme persistence** using SharedPreferences
- **Smooth theme transitions** with 300ms animations
- **Theme-aware components** that adapt to light/dark modes
- **Accessible toggles** in both Map and About screens

### Interactive Elements
- **Loading animations** using SpinKit for better user feedback
- **Smooth state transitions** for all interactive components
- **Haptic feedback** for button interactions
- **Contextual tooltips** for better usability

### Map Experience
- **Color-coded markers** for easy food type identification
- **Custom info windows** with relevant truck information
- **Floating truck counter** showing available trucks
- **Responsive bottom sheets** for detailed truck information
- **Pull-to-refresh** with visual feedback

### Responsive Design
- **Adaptive layouts** that work on different screen sizes
- **Proper safe area handling** for notched devices
- **Optimized touch targets** following accessibility guidelines
- **Consistent navigation** with bottom navigation bar

## 🎨 Customization

### Colors
- Primary: Orange (#EA580C)
- Secondary: Light Orange (#FB923C)
- Accent colors for different food types

### App Icon & Name
- Update `android/app/src/main/res/` for custom icons
- Modify `pubspec.yaml` for app name

## 🔧 Troubleshooting

### Common Issues

1. **Google Maps not showing**
   - Verify API key is correct in both `.env` and `local.properties`
   - Check API is enabled in Google Cloud Console
   - Ensure package name matches in API key restrictions

2. **"Cannot read properties of undefined (reading 'maps')" error**
   - This happens when running on web browser
   - **Solution**: Run on Android instead: `flutter run -d android`
   - Use Android emulator: `flutter emulators --launch Pixel`

3. **API connection failed**
   - Confirm Laravel server is running on localhost:8000
   - Check CORS configuration
   - Verify network permissions in AndroidManifest.xml

4. **Database errors**
   - Ensure MySQL is running in Laragon
   - Check database credentials in `.env`
   - Run `php artisan migrate:fresh --seed` to reset

## 📝 Development Notes

### Adding New Food Types
1. Update `_getMarkerHue()` in `map_screen.dart`
2. Add appropriate color mapping
3. Update seeder data if needed

### Adding New API Endpoints
1. Add routes in `routes/api.php`
2. Create controller methods
3. Update `ApiService` in Flutter app

## 🎯 **Final Project Checklist**

### **✅ COMPLETED FEATURES**
- [x] **Flutter Mobile App** with Google Maps integration
- [x] **Laravel Backend API** with RESTful endpoints  
- [x] **Admin Dashboard** with full CRUD operations
- [x] **Dark/Light Mode Toggle** with smooth animations
- [x] **Material 3 UI/UX Design** throughout the app
- [x] **State Management** using Provider pattern
- [x] **Error Handling** with user-friendly messages
- [x] **Loading States** with elegant progress indicators
- [x] **Pull-to-Refresh** functionality
- [x] **Theme Persistence** across app restarts
- [x] **Responsive Design** for all screen sizes
- [x] **Color-coded Map Markers** for food types
- [x] **Detailed Truck Information** in bottom sheets
- [x] **Developer About Page** with settings

### **📁 Project Documentation**
- [FINAL_PROJECT_SUMMARY.md](FINAL_PROJECT_SUMMARY.md) - Complete project overview
- [PROJECT_COMPLETION_STATUS.md](PROJECT_COMPLETION_STATUS.md) - Final status report  
- [SETUP_GUIDE.md](SETUP_GUIDE.md) - Detailed setup instructions

---

## 🎯 Future Enhancements

- [ ] User authentication
- [ ] Push notifications for new trucks
- [ ] Photo uploads for trucks
- [ ] Rating and review system
- [ ] Real-time location tracking
- [ ] Search and filter functionality

## 👨‍💻 Developer Information

- **Developer**: [Your Name]
- **Student Number**: [Your Student Number]
- **Programme**: [Your Programme Code]
- **GitHub**: [Your GitHub Repository URL]

## 📄 License

This project is developed for educational purposes.

---

**🏆 PROJECT STATUS: SUCCESSFULLY COMPLETED**

Ready for demonstration, submission, and further development!

**Note**: Remember to add your actual Google Maps API key before running the app. Never commit API keys to version control!
