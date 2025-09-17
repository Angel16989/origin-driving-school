# Origin Driving School Online Management System

## Modern Design Features
- 🎨 **Beautiful Modern UI** - Gradient backgrounds, smooth animations, and professional styling
- 📱 **Fully Responsive** - Works perfectly on desktop, tablet, and mobile devices  
- ✨ **Interactive Elements** - Hover effects, button animations, and smooth transitions
- 🎭 **Professional Color Scheme** - Carefully chosen colors for optimal user experience
- 🚀 **Performance Optimized** - Clean CSS with hardware-accelerated animations

## Setup Instructions

### 🚀 Quick Start:
1. **Start XAMPP** - Open XAMPP Control Panel and start Apache and MySQL services
2. **Create Database** - Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Click "New" to create a database
   - Name it `origin_driving_school`
   - Click "Create"
3. **Import Database** - Select the new database and click "Import"
   - Choose file: `db/database.sql`
   - Click "Go" to import
4. **Test Setup** - Visit [http://localhost/Groupprojectdevelopingweb/test_setup.php](http://localhost/Groupprojectdevelopingweb/test_setup.php)
5. **Access Site** - Go to [http://localhost/Groupprojectdevelopingweb](http://localhost/Groupprojectdevelopingweb)

### 🔑 Login Credentials:
   - **Admin:** admin / password
   - **Student:** student1 / password  
   - **Instructor:** instructor1 / password

## Project Structure
- `/css/styles.css` - Main stylesheet
- `/js/scripts.js` - JavaScript for validation/UI
- `/php/` - Backend PHP scripts (controllers/models)
- `/db/database.sql` - MySQL schema + sample data
- `index.php` - Home page
- `login.php` - Login page
- `register.php` - Student registration
- `dashboard.php` - Main dashboard

## Features
- Login/Register (students, instructors, admin)
- Student & Instructor management
- Booking system (with calendar)
- Invoice & Payment management
- Dashboard with statistics and quick navigation
- Messaging system with user-to-user communication

### 🛠️ Troubleshooting:
- **Database Connection Error**: Ensure XAMPP MySQL is running and database is created
- **Login Issues**: Use test credentials (admin/password) and check database import
- **Page Not Loading**: Check Apache service in XAMPP and file permissions
- **Missing Data**: Re-import database.sql file in phpMyAdmin

### 🧪 Testing:
- Visit `/test_setup.php` to verify all components are working
- Check database tables and sample data are properly imported
- Test all login credentials and page navigation

## Notes
- No frameworks used (pure PHP, MySQL, HTML, CSS, JS)
- All code is commented and beginner-friendly
- Sample data included for demo
- For any issues, check your XAMPP configuration and database connection settings in `/php/db_connect.php`
