# Entity Relationship Diagram Explanation
## Origin Driving School Management System

**Project:** Origin Driving School Management System  
**Course:** DWIN309 - Developing Web-based Information System  
**Institution:** Kent Institute Australia  
**Team Members:**
- Ms Isha Shrestha (K241002)
- Mr Rojan Shrestha (K240867)
- Mr Rasik Tiwari (K240750)

---

## Overview

The Origin Driving School ERD shows how our database tables connect to manage students, instructors, bookings, and payments. The database has **12 tables** working together to run the complete driving school system.

---

## Main Tables

### 1. USERS
Manages login accounts and user roles (admin, student, instructor).
- Stores: username, password (hashed), role
- Connects to: Students, Instructors, Messages

### 2. STUDENTS
Stores student profiles and learning progress.
- Stores: name, email, phone, license_no, progress
- **One Student → Many Bookings**: A student can book multiple lessons
- **One Student → Many Invoices**: A student receives multiple bills

### 3. INSTRUCTORS
Manages instructor information and schedules.
- Stores: name, email, qualifications, schedule, branch_id
- **One Instructor → Many Bookings**: An instructor teaches multiple students

### 4. BOOKINGS
Connects students with instructors for lessons.
- Stores: student_id, instructor_id, date, time, status
- **Bridge Table**: Links students and instructors together
- Status: Pending → Confirmed → Completed → Cancelled

### 5. INVOICES
Tracks bills sent to students.
- Stores: student_id, amount, status, created_at
- **One Student → Many Invoices**: A student gets multiple bills
- **One Invoice → Many Payments**: An invoice can be paid in installments
- Status: Unpaid, Paid, Partial, Overdue

### 6. PAYMENTS
Records payment transactions.
- Stores: invoice_id, amount, method, paid_at
- **Many Payments → One Invoice**: Multiple payments can settle one bill
- Methods: Cash, Credit Card, Bank Transfer, PayPal

### 7. MESSAGES
Enables communication between users.
- Stores: sender_type, sender_id, recipient_type, recipient_id, subject, message
- Allows: Student ↔ Instructor, Student ↔ Admin, Instructor ↔ Admin

---

## Key Relationships Explained

### 1. Student → Bookings (One-to-Many)
**One student can book many lessons**
- Example: John Doe has 5 bookings this month with different instructors

### 2. Instructor → Bookings (One-to-Many)
**One instructor conducts many lessons**
- Example: Mike Brown teaches 20 lessons this week to various students

### 3. Student → Invoices → Payments (Chain)
**One student gets many invoices, each invoice can have many payments**
- Student "Jane Smith" 
  - Invoice #1: $299 → Payment: $299 (Paid)
  - Invoice #2: $150 → Payment #1: $75, Payment #2: $50 (Partial - $25 remaining)
  - Invoice #3: $50 → (Unpaid)

---

## Summary

### Main Relationships:
- **1 Student → Many Bookings** - Students book multiple lessons
- **1 Instructor → Many Bookings** - Instructors teach multiple students  
- **1 Student → Many Invoices** - Students receive multiple bills
- **1 Invoice → Many Payments** - Bills can be paid in installments

### Why This Design Works:
✅ Organized data structure  
✅ Easy to track student progress  
✅ Flexible payment system  
✅ Secure user authentication  
✅ Clear relationships between tables  

---

**Created By:** Origin Driving School Development Team  
**Date:** October 3, 2025
