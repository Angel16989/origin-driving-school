# 🚗 Setup Guide for Team Members - Origin Driving School

**Easy step-by-step guide for teammates who are new to GitHub and coding**

---

## 📋 What You Need First

1. **XAMPP** - This runs the website on your computer
   - Download from: https://www.apachefriends.org/
   - Install it (just keep clicking "Next")
   - Default location: `C:\xampp\`

2. **GitHub Desktop** (Optional - makes it easier)
   - Download from: https://desktop.github.com/
   - Or just use the simple download method below

---

## 🎯 Method 1: Super Easy (No GitHub Account Needed)

### Step 1: Download the Code
1. Go to: **https://github.com/Angel16989/origin-driving-school**
2. Click the green **"Code"** button
3. Click **"Download ZIP"**
4. Save it to your Downloads folder

### Step 2: Extract the Files
1. Find the downloaded file: `origin-driving-school-main.zip`
2. Right-click on it
3. Choose **"Extract All..."**
4. Extract to: `C:\xampp\htdocs\`
5. Rename the folder from `origin-driving-school-main` to `Groupprojectdevelopingweb`

### Step 3: Setup the Database
1. Open XAMPP Control Panel
2. Click **"Start"** next to Apache
3. Click **"Start"** next to MySQL
4. Open your web browser
5. Go to: `http://localhost/phpmyadmin`
6. Click **"New"** on the left side
7. Database name: `origin_driving_school`
8. Click **"Create"**
9. Click on the database name `origin_driving_school`
10. Click **"Import"** at the top
11. Click **"Choose File"**
12. Find: `C:\xampp\htdocs\Groupprojectdevelopingweb\database.sql`
13. Click **"Import"** at the bottom

### Step 4: Open the Website
1. Open your web browser
2. Go to: `http://localhost/Groupprojectdevelopingweb/`
3. **DONE!** 🎉 The website should now be working!

---

## 🎯 Method 2: Using GitHub Desktop (A Bit More Professional)

### Step 1: Install GitHub Desktop
1. Download from: https://desktop.github.com/
2. Install it
3. Sign in with your GitHub account (or create one)

### Step 2: Clone the Repository
1. Open GitHub Desktop
2. Click **"File"** → **"Clone Repository"**
3. Click **"URL"** tab
4. Paste: `https://github.com/Angel16989/origin-driving-school`
5. Local Path: `C:\xampp\htdocs\Groupprojectdevelopingweb`
6. Click **"Clone"**

### Step 3: Setup Database (Same as Method 1)
Follow Step 3 from Method 1 above

### Step 4: Open the Website
Go to: `http://localhost/Groupprojectdevelopingweb/`

---

## 🧪 Test the Website

### Test Login (Use These Demo Accounts):
1. Go to: `http://localhost/Groupprojectdevelopingweb/login.php`
2. Try these usernames with password: `Test@1234`
   - `indianuser1` (Student account)
   - `nepaliuser1` (Student account)
   - `instructor1` (Instructor account)

### Test Registration:
1. Go to: `http://localhost/Groupprojectdevelopingweb/register.php`
2. Fill out the form
3. Create your own account
4. Login with your new account

---

## ❓ Common Problems & Solutions

### Problem: "Apache won't start"
**Solution:** 
- Something else is using port 80 (usually Skype or IIS)
- Open XAMPP → Click "Config" next to Apache → Click "httpd.conf"
- Find `Listen 80` and change to `Listen 8080`
- Save and restart Apache
- Now use: `http://localhost:8080/Groupprojectdevelopingweb/`

### Problem: "MySQL won't start"
**Solution:**
- Something else is using port 3306
- Open Task Manager → End any MySQL processes
- Try starting MySQL again in XAMPP

### Problem: "Page shows error: Cannot connect to database"
**Solution:**
- Make sure MySQL is running in XAMPP (green light)
- Make sure you imported the database.sql file
- Check the database name is: `origin_driving_school`

### Problem: "Cannot find the website"
**Solution:**
- Make sure XAMPP Apache is running (green light)
- Make sure the folder is in: `C:\xampp\htdocs\Groupprojectdevelopingweb`
- Try: `http://localhost/Groupprojectdevelopingweb/index.php`

---

## 📱 Need Help?

1. **Check XAMPP is running:**
   - Open XAMPP Control Panel
   - Both Apache and MySQL should have green "Running" status

2. **Check the folder location:**
   - Go to: `C:\xampp\htdocs\`
   - You should see: `Groupprojectdevelopingweb` folder

3. **Check the database:**
   - Go to: `http://localhost/phpmyadmin`
   - You should see: `origin_driving_school` database on the left

---

## 👥 Team Members

- **Ms Isha Shrestha** - K241002
- **Mr Rojan Shrestha** - K240867
- **Mr Rasik Tiwari** - K240750

---

## 📚 What This Website Does

- **Registration System** - Students can create accounts
- **Login System** - Secure authentication with passwords
- **Dashboard** - Different dashboards for students and instructors
- **Instructor Directory** - Shows all instructors with real-time data
- **Booking System** - Book driving lessons
- **Messages** - Communication between students and instructors
- **Responsive Design** - Works on phones, tablets, and computers

---

## 🎓 DWIN309 Project

This is our group project for DWIN309 - Developing for the Web course.

**GitHub Repository:** https://github.com/Angel16989/origin-driving-school

---

**Made with ❤️ by the Origin Driving School Team**
