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

## Introduction

The Entity Relationship Diagram (ERD) for the Origin Driving School Management System illustrates the database structure and relationships between different entities in our system. This document provides a comprehensive explanation of each table, their purpose, and how they connect to create a fully functional driving school management platform.

---

## System Overview

The Origin Driving School Management System is designed to manage:
- **User Authentication** and role-based access control
- **Student Management** including profiles and progress tracking
- **Instructor Management** with schedules and qualifications
- **Lesson Booking System** connecting students with instructors
- **Financial Management** through invoices and payments
- **Internal Communication** via messaging system
- **Security Features** with logging and rate limiting

The database consists of **12 interconnected tables** that work together to provide a complete driving school management solution.

---

## Core Tables and Their Relationships

### 1. USERS Table (Central Authentication Hub)

**Purpose:** The USERS table serves as the central authentication hub for the entire system. It manages login credentials and determines user roles.

**Structure:**
- `id` - Unique identifier for each user
- `username` - Unique login name
- `password` - Securely hashed password using bcrypt encryption
- `role` - User type: 'admin', 'student', or 'instructor'
- `created_at` - Account creation timestamp

**Key Features:**
- Implements role-based access control (RBAC)
- Ensures secure authentication with password hashing
- Acts as the gateway for all system access

**Relationships:**
The USERS table connects to:
- **STUDENTS** - Users with 'student' role have corresponding student profiles
- **INSTRUCTORS** - Users with 'instructor' role have corresponding instructor profiles
- **MESSAGES** - All users can send and receive messages
- **SECURITY_LOG** - Tracks all user-related security events

**Example:**
```
User "john_doe" → Role: 'student' → Links to Student profile "John Doe"
User "mike_instructor" → Role: 'instructor' → Links to Instructor profile "Mike Brown"
User "admin" → Role: 'admin' → Full system access
```

---

### 2. STUDENTS Table (Student Profile Management)

**Purpose:** The STUDENTS table stores comprehensive information about each student enrolled in the driving school, including their learning progress and contact details.

**Structure:**
- `id` - Unique student identifier
- `name` - Student's full name
- `email` - Contact email address
- `phone` - Contact phone number
- `license_no` - Driver's license number (if applicable)
- `progress` - Current learning stage
- `created_at` - Enrollment date

**Progress Tracking:**
The system tracks students through various stages:
1. "Profile Setup Required" - Initial registration
2. "Getting Started" - Account activated
3. "Registered" - Enrollment complete
4. "Theory Complete" - Passed theory test
5. "Practical Scheduled" - Practical lessons arranged
6. "Test Ready" - Prepared for driving test
7. "Licensed" - Successfully obtained license

**Relationships:**

**→ One Student to Many Bookings (1:N)**
- Each student can book multiple driving lessons
- Relationship: `students.id` → `bookings.student_id`
- Example: Student "John Doe" has 5 bookings scheduled throughout the month

**→ One Student to Many Invoices (1:N)**
- Each student receives multiple invoices for various services
- Relationship: `students.id` → `invoices.student_id`
- Example: Student "Jane Smith" has invoices for:
  - Initial enrollment fee
  - 10-lesson package
  - Theory test materials
  - Test day vehicle rental

**→ One Student to Many Messages (1:N)**
- Each student can send and receive multiple messages
- Relationship: Polymorphic via `messages.sender_id` or `messages.recipient_id` where `sender_type`/`recipient_type` = 'student'

---

### 3. INSTRUCTORS Table (Instructor Management)

**Purpose:** The INSTRUCTORS table manages information about driving instructors, including their qualifications, schedules, and branch assignments.

**Structure:**
- `id` - Unique instructor identifier
- `name` - Instructor's full name
- `email` - Contact email address
- `qualifications` - Certifications and credentials
- `schedule` - Working hours and availability
- `branch_id` - Assigned branch location

**Key Features:**
- Tracks instructor certifications and qualifications
- Manages working schedules and availability
- Links instructors to specific branch locations
- Enables efficient instructor-student matching

**Relationships:**

**→ One Instructor to Many Bookings (1:N)**
- Each instructor conducts multiple lessons with different students
- Relationship: `instructors.id` → `bookings.instructor_id`
- Example: Instructor "Mike Brown" has 20 lessons scheduled this week with various students

**→ Many Instructors to One Branch (N:1)**
- Each instructor is assigned to one branch location
- Relationship: `instructors.branch_id` → `branches.id`
- Example: Branch "Central" has 5 instructors assigned

**→ One Instructor to Many Messages (1:N)**
- Each instructor can communicate with students and admin
- Relationship: Polymorphic via messages table

**Example Scenario:**
```
Instructor: Mike Brown
├─ Qualifications: "Certified Driving Instructor, 10 years experience"
├─ Schedule: "Mon-Fri 9am-5pm"
├─ Branch: Central Branch
└─ Active Bookings:
   ├─ Monday 9am - John Doe (Highway Practice)
   ├─ Monday 11am - Jane Smith (Parallel Parking)
   ├─ Tuesday 10am - Bob Johnson (City Driving)
   └─ ... (17 more bookings this week)
```

---

### 4. BOOKINGS Table (Lesson Scheduling System)

**Purpose:** The BOOKINGS table is the core scheduling system that connects students with instructors for driving lessons. It manages all lesson appointments, their status, and timing.

**Structure:**
- `id` - Unique booking identifier
- `student_id` - Foreign key to STUDENTS table
- `instructor_id` - Foreign key to INSTRUCTORS table
- `date` - Lesson date
- `time` - Lesson time
- `status` - Current booking status

**Booking Status Workflow:**
1. **"Pending"** - Student requests a lesson, awaiting confirmation
2. **"Confirmed"** - Instructor/admin approves the booking
3. **"Completed"** - Lesson successfully finished
4. **"Cancelled"** - Booking cancelled by student or instructor

**Dual Foreign Key Relationships:**

**Relationship 1: Student to Bookings (1:N)**
- One student can have many bookings
- `bookings.student_id` → `students.id`
- Allows tracking of all lessons for a specific student

**Relationship 2: Instructor to Bookings (1:N)**
- One instructor can have many bookings
- `bookings.instructor_id` → `instructors.id`
- Enables viewing instructor's schedule and workload

**Many-to-Many Bridge:**
The BOOKINGS table effectively creates a many-to-many relationship between STUDENTS and INSTRUCTORS:
- Many students can book lessons with many instructors
- The booking table stores the specific date, time, and status

**Example Scenario:**
```
Booking #1234:
├─ Student: John Doe (ID: 1)
├─ Instructor: Mike Brown (ID: 1)
├─ Date: 2025-10-15
├─ Time: 10:00 AM
├─ Status: Confirmed
└─ Purpose: Highway driving practice

This creates the relationship:
John Doe ←→ [Booking #1234] ←→ Mike Brown
```

**Query Example:**
To find all bookings for student John Doe:
```sql
SELECT b.date, b.time, b.status, i.name AS instructor
FROM bookings b
JOIN instructors i ON b.instructor_id = i.id
WHERE b.student_id = 1
ORDER BY b.date, b.time;
```

---

### 5. INVOICES Table (Financial Billing)

**Purpose:** The INVOICES table manages all financial billing for students, tracking charges for lessons, packages, materials, and other services.

**Structure:**
- `id` - Unique invoice identifier
- `student_id` - Foreign key to STUDENTS table
- `amount` - Total invoice amount (decimal)
- `status` - Payment status
- `created_at` - Invoice generation date

**Invoice Status Types:**
- **"Unpaid"** - Outstanding balance due
- **"Paid"** - Fully settled
- **"Partial"** - Partially paid, balance remaining
- **"Overdue"** - Past due date, requires attention

**Relationships:**

**→ One Student to Many Invoices (1:N)**
- Each student can have multiple invoices over time
- Relationship: `invoices.student_id` → `students.id`
- Enables comprehensive financial tracking per student

**→ One Invoice to Many Payments (1:N)**
- Each invoice can receive multiple payments (installments)
- Relationship: `invoices.id` → `payments.invoice_id`
- Supports flexible payment plans

**Example Scenario:**
```
Student: Jane Smith (ID: 2)
└─ Invoice History:
   ├─ Invoice #101: $299 - Beginner Package (Paid)
   ├─ Invoice #102: $50 - Theory Test Materials (Paid)
   ├─ Invoice #103: $150 - Additional Lessons (Partial: $75 paid)
   └─ Invoice #104: $45 - Test Day Vehicle (Unpaid)
   
   Total Billed: $544
   Total Paid: $424
   Outstanding: $120
```

---

### 6. PAYMENTS Table (Payment Processing)

**Purpose:** The PAYMENTS table records all payment transactions, linking them to specific invoices and tracking payment methods and timing.

**Structure:**
- `id` - Unique payment identifier
- `invoice_id` - Foreign key to INVOICES table
- `amount` - Payment amount (decimal)
- `method` - Payment method used
- `paid_at` - Payment timestamp

**Supported Payment Methods:**
- Cash
- Credit Card
- Debit Card
- Bank Transfer
- PayPal
- Other digital payment methods

**Relationships:**

**→ Many Payments to One Invoice (N:1)**
- Multiple payments can be applied to a single invoice
- Relationship: `payments.invoice_id` → `invoices.id`
- Enables installment/split payments

**Complete Payment Chain:**
```
STUDENT → INVOICE → PAYMENT(S)

Example:
John Doe (Student)
  ↓
  Invoice #105: $499 (Premium Package)
    ↓
    Payment #1: $200 (Credit Card) - Sept 1
    Payment #2: $150 (Cash) - Sept 15
    Payment #3: $149 (Bank Transfer) - Sept 30
    
Total: $499 PAID IN FULL
```

**Financial Relationship Flow:**
1. **Student enrolls** → Record created in STUDENTS table
2. **Service provided** → Invoice generated in INVOICES table
3. **Student pays** → Payment recorded in PAYMENTS table
4. **Invoice status updates** → "Unpaid" → "Partial" → "Paid"

**Query Example - Student's Financial Summary:**
```sql
SELECT 
    s.name AS student_name,
    i.id AS invoice_id,
    i.amount AS invoice_amount,
    i.status AS invoice_status,
    SUM(p.amount) AS total_paid,
    (i.amount - COALESCE(SUM(p.amount), 0)) AS balance
FROM students s
JOIN invoices i ON s.id = i.student_id
LEFT JOIN payments p ON i.id = p.invoice_id
WHERE s.id = 1
GROUP BY i.id;
```

---

### 7. MESSAGES Table (Internal Communication System)

**Purpose:** The MESSAGES table facilitates internal communication between all system users (students, instructors, and administrators), enabling efficient coordination and support.

**Structure:**
- `id` - Unique message identifier
- `sender_type` - Role of sender ('admin', 'instructor', 'student')
- `sender_id` - ID of the sending user
- `recipient_type` - Role of recipient ('admin', 'instructor', 'student')
- `recipient_id` - ID of the receiving user
- `subject` - Message subject line
- `message` - Message content (text)
- `created_at` - Timestamp when message was sent
- `read_status` - Boolean: 0 = unread, 1 = read

**Polymorphic Relationship Design:**
The MESSAGES table uses a polymorphic relationship pattern, allowing it to connect to different user types:

```
Sender Side:
├─ sender_type = 'student' → sender_id links to students.id
├─ sender_type = 'instructor' → sender_id links to instructors.id
└─ sender_type = 'admin' → sender_id links to users.id (admin)

Recipient Side:
├─ recipient_type = 'student' → recipient_id links to students.id
├─ recipient_type = 'instructor' → recipient_id links to instructors.id
└─ recipient_type = 'admin' → recipient_id links to users.id (admin)
```

**Communication Flows:**
1. **Student → Instructor:** Questions about lessons, scheduling
2. **Instructor → Student:** Lesson feedback, tips, reminders
3. **Admin → Student:** Welcome messages, policy updates
4. **Admin → Instructor:** Schedule changes, announcements
5. **Student → Admin:** Support requests, complaints
6. **Instructor → Admin:** Reports, requests

**Example Message Flow:**
```
Message #1:
├─ From: student (John Doe, ID: 1)
├─ To: instructor (Mike Brown, ID: 1)
├─ Subject: "Question about parallel parking"
├─ Content: "Hi Mike, could you explain the reference point technique again?"
├─ Sent: 2025-10-03 14:30:00
└─ Status: Read

Message #2 (Reply):
├─ From: instructor (Mike Brown, ID: 1)
├─ To: student (John Doe, ID: 1)
├─ Subject: "RE: Question about parallel parking"
├─ Content: "Sure John! The reference point is when your side mirror..."
├─ Sent: 2025-10-03 15:45:00
└─ Status: Unread
```

**Relationship Summary:**
- **One User → Many Messages (as sender)**: Each user can send multiple messages
- **One User → Many Messages (as recipient)**: Each user can receive multiple messages
- **Many-to-Many Communication**: Any user type can communicate with any other user type

---

## Complete Relationship Chain Examples

### Example 1: New Student Journey

**Step 1: User Registration**
```
USERS table:
├─ username: "john_doe"
├─ password: [hashed]
├─ role: 'student'
└─ created_at: 2025-10-01
```

**Step 2: Student Profile Creation**
```
STUDENTS table:
├─ name: "John Doe"
├─ email: "john@example.com"
├─ phone: "555-1234"
├─ progress: "Registered"
└─ created_at: 2025-10-01
```

**Step 3: Welcome Message**
```
MESSAGES table:
├─ sender_type: 'admin'
├─ recipient_type: 'student'
├─ recipient_id: 1 (John Doe)
├─ subject: "Welcome to Origin!"
└─ message: "Welcome John..."
```

**Step 4: Lesson Booking**
```
BOOKINGS table:
├─ student_id: 1 (John Doe)
├─ instructor_id: 1 (Mike Brown)
├─ date: 2025-10-15
├─ time: 10:00:00
└─ status: 'Confirmed'
```

**Step 5: Invoice Generation**
```
INVOICES table:
├─ student_id: 1 (John Doe)
├─ amount: $299.00
├─ status: 'Unpaid'
└─ created_at: 2025-10-01
```

**Step 6: Payment Processing**
```
PAYMENTS table:
├─ invoice_id: 1
├─ amount: $299.00
├─ method: 'Credit Card'
└─ paid_at: 2025-10-02

↓ Updates ↓

INVOICES table:
└─ status: 'Paid'
```

---

### Example 2: Instructor's Daily Schedule

**Instructor Profile:**
```
INSTRUCTORS table:
├─ id: 1
├─ name: "Mike Brown"
├─ email: "mike@origin.com"
├─ schedule: "Mon-Fri 9am-5pm"
└─ branch_id: 1
```

**Day's Bookings (One Instructor → Many Bookings):**
```
BOOKINGS table:
├─ Booking #1: student_id=1, time=09:00, status='Confirmed'
├─ Booking #2: student_id=3, time=11:00, status='Confirmed'
├─ Booking #3: student_id=5, time=14:00, status='Confirmed'
└─ Booking #4: student_id=7, time=16:00, status='Pending'

Result: Mike has 4 lessons scheduled today
```

---

### Example 3: Student's Financial Overview

**Student:**
```
STUDENTS table:
└─ id: 2, name: "Jane Smith"
```

**Multiple Invoices (One Student → Many Invoices):**
```
INVOICES table:
├─ Invoice #101: amount=$299, status='Paid'
├─ Invoice #102: amount=$150, status='Partial'
└─ Invoice #103: amount=$50, status='Unpaid'
```

**Payment History (One Invoice → Many Payments):**
```
Invoice #102 ($150 - Partial):
├─ Payment #1: $75 (Credit Card) - Sept 15
└─ Payment #2: $50 (Cash) - Sept 30
Balance: $25 remaining
```

**Financial Summary:**
- Total Billed: $499
- Total Paid: $424
- Outstanding: $75

---

## Database Relationships Summary

### One-to-Many (1:N) Relationships

| Parent Table | Child Table | Relationship Description |
|--------------|-------------|-------------------------|
| **USERS** | STUDENTS | One user account → One student profile |
| **USERS** | INSTRUCTORS | One user account → One instructor profile |
| **STUDENTS** | BOOKINGS | One student → Many lesson bookings |
| **INSTRUCTORS** | BOOKINGS | One instructor → Many lesson bookings |
| **STUDENTS** | INVOICES | One student → Many invoices |
| **INVOICES** | PAYMENTS | One invoice → Many payments (installments) |
| **BRANCHES** | INSTRUCTORS | One branch → Many instructors |
| **USERS** | MESSAGES | One user → Many messages (sent) |
| **USERS** | MESSAGES | One user → Many messages (received) |

### Many-to-Many (M:N) Relationships

| Table 1 | Bridge Table | Table 2 | Description |
|---------|--------------|---------|-------------|
| **STUDENTS** | BOOKINGS | **INSTRUCTORS** | Students can book lessons with multiple instructors; instructors teach multiple students |

---

## Key Database Design Principles Applied

### 1. **Normalization (3NF)**
- All tables are in Third Normal Form
- No repeating groups
- No partial dependencies
- No transitive dependencies

### 2. **Referential Integrity**
- Foreign key constraints ensure data consistency
- Cascading rules prevent orphaned records
- Relationship enforcement at database level

### 3. **Data Consistency**
- ENUM types for fixed values (roles, status)
- Default values for timestamps
- NOT NULL constraints on critical fields

### 4. **Scalability**
- Indexed foreign keys for fast joins
- Composite indexes on frequently queried columns
- Efficient query performance

### 5. **Security**
- Password hashing (bcrypt)
- Role-based access control
- Security logging and audit trails

---

## Business Logic Examples

### Booking a Lesson
```
1. Student logs in → USERS table authentication
2. Student selects instructor → Query INSTRUCTORS table
3. Student picks date/time → Check availability in BOOKINGS
4. Booking created → Insert into BOOKINGS (status='Pending')
5. Instructor confirms → Update BOOKINGS (status='Confirmed')
6. Invoice generated → Insert into INVOICES
7. Student pays → Insert into PAYMENTS
8. Payment complete → Update INVOICES (status='Paid')
```

### Progress Tracking
```
1. Student starts → progress='Registered'
2. Theory passed → Update STUDENTS (progress='Theory Complete')
3. Lessons booked → Multiple BOOKINGS created
4. Lessons completed → Update BOOKINGS (status='Completed')
5. Ready for test → Update STUDENTS (progress='Test Ready')
6. Test passed → Update STUDENTS (progress='Licensed')
```

---

## Benefits of This Database Design

✅ **Efficient Data Management**
- Centralized storage with minimal redundancy
- Fast queries through proper indexing
- Clear data ownership and relationships

✅ **Flexibility**
- Easy to add new features
- Supports multiple payment methods
- Scalable to handle growth

✅ **Data Integrity**
- Foreign keys prevent invalid references
- Constraints ensure data quality
- Audit trails through timestamps

✅ **Security**
- Role-based access control
- Encrypted passwords
- Security logging

✅ **User Experience**
- Fast lookups and searches
- Real-time status updates
- Comprehensive communication

---

## Conclusion

The Entity Relationship Diagram for the Origin Driving School Management System demonstrates a well-structured, normalized database design that efficiently manages:

1. **User authentication and authorization** through the USERS table
2. **Student profiles and progress tracking** via the STUDENTS table
3. **Instructor management and scheduling** using the INSTRUCTORS table
4. **Lesson booking coordination** with the BOOKINGS table (bridging students and instructors)
5. **Financial operations** through the INVOICES and PAYMENTS tables (with proper chaining)
6. **Internal communication** via the MESSAGES table (polymorphic relationships)

The **key relationship chains** are:
- **Student → Bookings**: One student can have many lesson bookings
- **Instructor → Bookings**: One instructor can conduct many lesson bookings
- **Student → Invoices → Payments**: One student has many invoices, each invoice can have many payments

This design ensures data integrity, supports business operations efficiently, and provides a solid foundation for the driving school management system to grow and evolve.

---

**Document Created By:** Origin Driving School Development Team  
**Date:** October 3, 2025  
**Version:** 1.0
