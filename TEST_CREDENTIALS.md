# 🔐 Test Credentials - Origin Driving School

## All User Accounts & Passwords

**All accounts use the same password for testing: `Test@1234`**

---

## 👑 ADMIN ACCOUNTS

### Admin Account (Full System Access)
- **Username:** `admin`
- **Password:** `Test@1234`
- **Role:** Administrator
- **Access:** Full system control, manage all users, view all data, reports

**Admin Dashboard Features:**
- View total students, instructors, bookings
- Manage system users
- View financial reports
- Access all modules
- System-wide analytics

---

## 👨‍🏫 INSTRUCTOR ACCOUNTS

### Instructor 1
- **Username:** `instructor1`
- **Password:** `Test@1234`
- **Name:** Rajesh Patel
- **Role:** Driving Instructor
- **Access:** View schedule, manage students, update lesson status

### Instructor 2
- **Username:** `instructor2`
- **Password:** `Test@1234`
- **Name:** Anita Gurung
- **Role:** Driving Instructor
- **Access:** View schedule, manage students, update lesson status

**Instructor Dashboard Features:**
- View personal teaching schedule
- See assigned students
- Mark lessons complete
- View today's lessons
- Access student messages
- Update availability

---

## 🎓 STUDENT ACCOUNTS

### Student 1 (Indian User)
- **Username:** `indianuser1`
- **Password:** `Test@1234`
- **Name:** Priya Sharma
- **Role:** Student
- **Phone:** 555-1001

### Student 2 (Nepali User)
- **Username:** `nepaliuser1`
- **Password:** `Test@1234`
- **Name:** Suman Thapa
- **Role:** Student
- **Phone:** 555-1002

### Student 3 (General User)
- **Username:** `whiteuser1`
- **Password:** `Test@1234`
- **Name:** Mike Johnson
- **Role:** Student
- **Phone:** 555-1003

**Student Dashboard Features:**
- Book new lessons
- View booking history
- Update profile
- View invoices/payments
- Send messages to instructors
- Track learning progress

---

## 🚀 Quick Login Links

After logging in with any account:

### For Admin:
1. Go to: `http://localhost/Groupprojectdevelopingweb/login.php`
2. Username: `admin`
3. Password: `Test@1234`
4. **Dashboard:** Complete system overview with all statistics

### For Instructor:
1. Go to: `http://localhost/Groupprojectdevelopingweb/login.php`
2. Username: `instructor1` or `instructor2`
3. Password: `Test@1234`
4. **Dashboard:** Teaching schedule, student management, lesson tracking

### For Student:
1. Go to: `http://localhost/Groupprojectdevelopingweb/login.php`
2. Username: `indianuser1`, `nepaliuser1`, or `whiteuser1`
3. Password: `Test@1234`
4. **Dashboard:** Book lessons, view progress, manage profile

---

## 📊 Dashboard Comparison

### Admin Dashboard Features:
- 📈 Total Students Count
- 👨‍🏫 Total Instructors Count
- 📅 All Bookings Overview
- 💰 Revenue Statistics
- 🔧 User Management Links
- 📊 System Reports
- 💼 All Invoices Access

### Instructor Dashboard Features:
- 📚 Total Lessons Taught
- 📅 Today's Lessons
- ⏳ Pending Approvals
- ✅ Completed Lessons
- 👥 My Students List
- 📅 View My Schedule
- 💬 Messages from Students

### Student Dashboard Features:
- 📚 Total Lessons Booked
- ✅ Completed Lessons
- 📅 Upcoming Lessons
- 💳 Unpaid Invoices Count
- 📅 Book New Lesson Button
- 📋 View My Bookings
- 👤 Update Profile
- 💬 Messages to Instructors

---

## 🧪 Testing Different Roles

### Test Admin Functions:
1. Login as `admin`
2. View all system statistics
3. Check total users, bookings, revenue
4. Access student/instructor management
5. View reports and analytics

### Test Instructor Functions:
1. Login as `instructor1`
2. View your teaching schedule
3. See assigned students
4. Check pending/completed lessons
5. Access student messages

### Test Student Functions:
1. Login as `indianuser1`
2. Book a new lesson (click "Book New Lesson")
3. Choose instructor, date, time
4. View booking history
5. Check invoices

---

## 🔄 Password Reset

If you need to reset any password:

1. All accounts currently use: `Test@1234`
2. Passwords are hashed with bcrypt for security
3. To create new accounts, use the registration page

---

## 🎯 Quick Access URLs

- **Main Site:** http://localhost/Groupprojectdevelopingweb/
- **Login:** http://localhost/Groupprojectdevelopingweb/login.php
- **Register:** http://localhost/Groupprojectdevelopingweb/register.php
- **Dashboard:** http://localhost/Groupprojectdevelopingweb/dashboard.php (after login)
- **Instructors Directory:** http://localhost/Groupprojectdevelopingweb/instructors.php

---

## 📝 Notes for Team Members

### When Testing:
1. **Always logout** before testing different roles
2. **Clear browser cache** if you see old data
3. **Check role-specific navigation** - each role sees different menus
4. **Test CRUD operations:**
   - **Create:** Book a lesson (student)
   - **Read:** View bookings/schedule
   - **Update:** Edit profile
   - **Delete:** Cancel booking

### Dashboard Access:
- Each role automatically sees their appropriate dashboard
- Navigation menu adapts based on user role
- Links and features change per role

---

## 🔒 Security Features Active

All accounts benefit from:
- ✅ Bcrypt password hashing
- ✅ Session management
- ✅ CSRF protection
- ✅ SQL injection prevention (prepared statements)
- ✅ Input sanitization
- ✅ Rate limiting
- ✅ Secure session handling

---

## 💡 Pro Tips

1. **Admin can see everything** - Use this to verify data across the system
2. **Instructor dashboard updates in real-time** - Based on actual bookings in database
3. **Student can book with any active instructor** - All instructors from database shown
4. **Double-booking prevention** - System checks conflicts automatically

---

**Remember: All test accounts use password `Test@1234`** 🔑

**Need to create admin?** Run: `http://localhost/Groupprojectdevelopingweb/setup_admin.php`

---

*Last Updated: October 2, 2025*
