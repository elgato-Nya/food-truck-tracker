import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:url_launcher/url_launcher.dart';
import '../providers/theme_provider.dart';

class AboutScreen extends StatelessWidget {
  const AboutScreen({super.key});

  Future<void> _launchGitHub() async {
    final Uri url = Uri.parse(
      'https://github.com/elgato-Nya/food-truck-tracker',
    );
    if (!await launchUrl(url, mode: LaunchMode.externalApplication)) {
      throw Exception('Could not launch $url');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('About'),
        actions: [
          // Dark mode toggle in app bar
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
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(24),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // App icon and name
            Container(
              width: 100,
              height: 100,
              decoration: BoxDecoration(
                color: const Color(0xFFEA580C),
                borderRadius: BorderRadius.circular(20),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.1),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: const Icon(
                Icons.local_dining,
                size: 60,
                color: Colors.white,
              ),
            ),

            const SizedBox(height: 24),

            Text(
              'Food Truck Tracker Malaysia',
              style: TextStyle(
                fontSize: 28,
                fontWeight: FontWeight.bold,
                color: Theme.of(context).colorScheme.primary,
              ),
            ),

            const SizedBox(height: 8),

            Text(
              'Version 2.0.0',
              style: TextStyle(
                fontSize: 16,
                color: Theme.of(
                  context,
                ).textTheme.bodyMedium?.color?.withOpacity(0.6),
              ),
            ),

            const SizedBox(height: 32),

            // Description
            Container(
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: Theme.of(context).colorScheme.surface.withOpacity(0.3),
                borderRadius: BorderRadius.circular(12),
              ),
              child: Text(
                'Discover Malaysia\'s best food trucks from Perlis to Johor, Sabah to Sarawak! '
                'From traditional Nasi Lemak to modern fusion cuisine, find authentic Malaysian '
                'street food wherever you are. Search, filter, and explore the rich culinary heritage of Malaysia.',
                textAlign: TextAlign.center,
                style: TextStyle(
                  fontSize: 16,
                  height: 1.5,
                  color: Theme.of(context).textTheme.bodyLarge?.color,
                ),
              ),
            ),

            const SizedBox(height: 32),

            // Settings section
            _buildSettingsCard(),

            const SizedBox(height: 24),

            // Developers info
            _buildDevelopersSection(context),

            const SizedBox(height: 24),

            // Project info
            _buildInfoCard(
              context,
              title: 'Project Information',
              items: [
                _InfoItem(
                  icon: Icons.flutter_dash,
                  label: 'Built with',
                  value: 'Flutter & Laravel',
                ),
                _InfoItem(
                  icon: Icons.map,
                  label: 'Maps',
                  value: 'Google Maps Platform',
                ),
                _InfoItem(
                  icon: Icons.api,
                  label: 'Backend',
                  value: 'Laravel REST API',
                ),
              ],
            ),

            const SizedBox(height: 32),

            // GitHub link
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: _launchGitHub,
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.black,
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(vertical: 16),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                ),
                child: const Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(Icons.code),
                    SizedBox(width: 8),
                    Text(
                      'View on GitHub',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ),
            ),

            const SizedBox(height: 32),

            // Copyright
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                border: Border.all(color: Theme.of(context).dividerColor),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Column(
                children: [
                  Icon(
                    Icons.copyright,
                    color: Theme.of(context).iconTheme.color?.withOpacity(0.7),
                    size: 20,
                  ),
                  const SizedBox(height: 8),
                  Text(
                    '© ${DateTime.now().year} Food Truck Tracker',
                    style: TextStyle(
                      color: Theme.of(context).textTheme.bodyMedium?.color,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    'All rights reserved',
                    style: TextStyle(
                      color: Theme.of(context).textTheme.bodySmall?.color,
                      fontSize: 12,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildSettingsCard() {
    return Consumer<ThemeProvider>(
      builder: (context, themeProvider, child) {
        return Container(
          width: double.infinity,
          padding: const EdgeInsets.all(20),
          decoration: BoxDecoration(
            color: Theme.of(context).cardColor,
            borderRadius: BorderRadius.circular(12),
            border: Border.all(color: Theme.of(context).dividerColor),
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'Settings',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: Theme.of(context).colorScheme.primary,
                ),
              ),
              const SizedBox(height: 16),
              Row(
                children: [
                  Icon(
                    themeProvider.isDarkMode
                        ? Icons.dark_mode
                        : Icons.light_mode,
                    size: 20,
                    color: Theme.of(context).iconTheme.color,
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: Text(
                      'Dark Mode',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.w500,
                        color: Theme.of(context).textTheme.bodyLarge?.color,
                      ),
                    ),
                  ),
                  Switch.adaptive(
                    value: themeProvider.isDarkMode,
                    onChanged: (value) => themeProvider.toggleTheme(),
                    activeColor: Theme.of(context).colorScheme.primary,
                  ),
                ],
              ),
              const SizedBox(height: 8),
              Text(
                themeProvider.isDarkMode
                    ? 'Enjoy the dark side! Your eyes will thank you.'
                    : 'Let there be light! Classic and clean.',
                style: TextStyle(
                  fontSize: 12,
                  color: Theme.of(context).textTheme.bodySmall?.color,
                ),
              ),
            ],
          ),
        );
      },
    );
  }

  Widget _buildInfoCard(
    BuildContext context, {
    required String title,
    required List<_InfoItem> items,
  }) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Theme.of(context).cardColor,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Theme.of(context).dividerColor),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            title,
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: Theme.of(context).colorScheme.primary,
            ),
          ),
          const SizedBox(height: 16),
          ...items.map(
            (item) => Padding(
              padding: const EdgeInsets.only(bottom: 12),
              child: Row(
                children: [
                  Icon(
                    item.icon,
                    size: 20,
                    color: Theme.of(context).iconTheme.color?.withOpacity(0.7),
                  ),
                  const SizedBox(width: 12),
                  Text(
                    '${item.label}:',
                    style: TextStyle(
                      fontSize: 14,
                      color: Theme.of(context).textTheme.bodySmall?.color,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  const SizedBox(width: 8),
                  Expanded(
                    child: Text(
                      item.value,
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w600,
                        color: Theme.of(context).textTheme.bodyLarge?.color,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildDevelopersSection(BuildContext context) {
    final developers = [
      _Developer(
        name: 'Mohamad Afiq bin Mohamad Sharifuzan',
        studentId: '2023197751',
        programCode: 'CS2515A',
        email: '2023197751@student.uitm.edu.my',
      ),
      _Developer(
        name: 'Muhammad Afif Bin Mat Tarmizi',
        studentId: '2023367671',
        programCode: 'CS2515A',
        email: '2023367671@student.uitm.edu.my',
      ),
      _Developer(
        name: 'Wan Muhammad Danish Aiman bin Wan Mohd Nazim',
        studentId: '2023516353',
        programCode: 'CS2515A',
        email: '2023516353@student.uitm.edu.my',
      ),
      _Developer(
        name: 'Muhammad Hakimie Bin Ahmad Zikri',
        studentId: '2023136019',
        programCode: 'CS2515A',
        email: '2023136019@student.uitm.edu.my',
      ),
    ];

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Theme.of(context).cardColor,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Theme.of(context).dividerColor),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Development Team',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: Theme.of(context).colorScheme.primary,
            ),
          ),
          const SizedBox(height: 16),
          ...developers.asMap().entries.map((entry) {
            final index = entry.key;
            final developer = entry.value;
            return Column(
              children: [
                _buildDeveloperInfo(context, developer, index + 1),
                if (index < developers.length - 1)
                  Padding(
                    padding: const EdgeInsets.symmetric(vertical: 12),
                    child: Divider(color: Theme.of(context).dividerColor),
                  ),
              ],
            );
          }),
        ],
      ),
    );
  }

  Widget _buildDeveloperInfo(
    BuildContext context,
    _Developer developer,
    int number,
  ) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'Developer $number',
          style: TextStyle(
            fontSize: 14,
            fontWeight: FontWeight.w600,
            color: Theme.of(context).colorScheme.primary,
          ),
        ),
        const SizedBox(height: 8),
        _buildDeveloperField(context, Icons.person, 'Name', developer.name),
        const SizedBox(height: 6),
        _buildDeveloperField(
          context,
          Icons.school,
          'Student ID',
          developer.studentId,
        ),
        const SizedBox(height: 6),
        _buildDeveloperField(
          context,
          Icons.code,
          'Program Code',
          developer.programCode,
        ),
        const SizedBox(height: 6),
        _buildDeveloperField(context, Icons.email, 'Email', developer.email),
      ],
    );
  }

  Widget _buildDeveloperField(
    BuildContext context,
    IconData icon,
    String label,
    String value,
  ) {
    return Row(
      children: [
        Icon(
          icon,
          size: 16,
          color: Theme.of(context).iconTheme.color?.withOpacity(0.7),
        ),
        const SizedBox(width: 8),
        Text(
          '$label:',
          style: TextStyle(
            fontSize: 12,
            color: Theme.of(context).textTheme.bodySmall?.color,
            fontWeight: FontWeight.w500,
          ),
        ),
        const SizedBox(width: 6),
        Expanded(
          child: Text(
            value,
            style: TextStyle(
              fontSize: 12,
              fontWeight: FontWeight.w600,
              color: Theme.of(context).textTheme.bodyLarge?.color,
            ),
          ),
        ),
      ],
    );
  }
}

class _Developer {
  final String name;
  final String studentId;
  final String programCode;
  final String email;

  _Developer({
    required this.name,
    required this.studentId,
    required this.programCode,
    required this.email,
  });
}

class _InfoItem {
  final IconData icon;
  final String label;
  final String value;

  _InfoItem({required this.icon, required this.label, required this.value});
}
