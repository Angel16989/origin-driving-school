# Origin Driving School Online Management System

## Modern Design Features
- 🎨 **Beautiful Modern UI** - Gradient backgrounds, smooth animations, and professional styling
- 📱 **Fully Responsive** - Works perfectly on desktop, tablet, and mobile devices  
- ✨ **Interactive Elements** - Hover effects, button animations, and smooth transitions
- 🎭 **Professional Color Scheme** - Carefully chosen colors for optimal user experience
- 🚀 **Performance Optimized** - Clean CSS with hardware-accelerated animations

## Setup Instructions

1. Import `db/database.sql` into phpMyAdmin (create a new database, e.g., `origin_driving_school`).
2. Copy the entire project folder into your XAMPP `htdocs` directory.
3. Start Apache and MySQL from XAMPP Control Panel.
4. Access the site via [http://localhost/Groupprojectdevelopingweb](http://localhost/Groupprojectdevelopingweb).
5. Login with sample credentials:
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
- Messaging/Notifications
- Dashboard with statistics

## Notes
- No frameworks used (pure PHP, MySQL, HTML, CSS, JS)
- All code is commented and beginner-friendly
- Sample data included for demo
- For any issues, check your XAMPP configuration and database connection settings in `/php/db_connect.php`
