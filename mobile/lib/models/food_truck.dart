class FoodTruck {
  final int id;
  final String name;
  final String foodType;
  final String locationDescription;
  final double latitude;
  final double longitude;
  final String? menuInfo;
  final String? news;
  final String reportedBy;
  final DateTime lastReportedAt;
  final String lastReportedHuman;

  FoodTruck({
    required this.id,
    required this.name,
    required this.foodType,
    required this.locationDescription,
    required this.latitude,
    required this.longitude,
    this.menuInfo,
    this.news,
    required this.reportedBy,
    required this.lastReportedAt,
    required this.lastReportedHuman,
  });

  factory FoodTruck.fromJson(Map<String, dynamic> json) {
    return FoodTruck(
      id: json['id'],
      name: json['name'],
      foodType: json['food_type'],
      locationDescription: json['location_description'],
      latitude: json['latitude'].toDouble(),
      longitude: json['longitude'].toDouble(),
      menuInfo: json['menu_info'],
      news: json['news'],
      reportedBy: json['reported_by'],
      lastReportedAt: DateTime.parse(json['last_reported_at']),
      lastReportedHuman: json['last_reported_human'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'food_type': foodType,
      'location_description': locationDescription,
      'latitude': latitude,
      'longitude': longitude,
      'menu_info': menuInfo,
      'news': news,
      'reported_by': reportedBy,
      'last_reported_at': lastReportedAt.toIso8601String(),
      'last_reported_human': lastReportedHuman,
    };
  }
}
