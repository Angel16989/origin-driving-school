# Mermaid AI Prompts for Origin Driving School System
## Data Flow Diagrams & ERD Generation

---

## Prompt 1: Level 0 DFD (Context Diagram)

```
Create a Level 0 Data Flow Diagram (Context Diagram) for an Origin Driving School Management System.

External Entities:
- Student
- Instructor
- Administrator
- Payment Gateway

System: Origin Driving School Management System

Data Flows:
- Student provides: registration details, booking requests, payments
- Student receives: lesson schedules, invoices, progress reports
- Instructor provides: availability, lesson feedback, attendance
- Instructor receives: booking schedules, student information
- Administrator provides: system configuration, approvals, reports
- Administrator receives: system data, financial reports
- Payment Gateway processes: payment transactions

Use Mermaid flowchart syntax with clear labels and directional arrows.
```

---

## Prompt 2: Level 1 DFD (Major Processes)

```
Create a Level 1 Data Flow Diagram for Origin Driving School Management System showing these major processes:

Processes:
1. User Authentication & Management
   - Login/Registration
   - Role-based access control
   - Security logging

2. Student Management
   - Student enrollment
   - Profile management
   - Progress tracking

3. Instructor Management
   - Instructor profiles
   - Availability scheduling
   - Branch assignment

4. Booking System
   - Lesson scheduling
   - Instructor-student matching
   - Booking confirmation/cancellation

5. Financial Management
   - Invoice generation
   - Payment processing
   - Financial reporting

6. Communication System
   - Internal messaging
   - Notifications
   - Message tracking

Data Stores:
- D1: Users
- D2: Students
- D3: Instructors
- D4: Bookings
- D5: Invoices
- D6: Payments
- D7: Messages

External Entities:
- Student
- Instructor
- Administrator
- Payment Gateway

Show data flows between processes, data stores, and external entities.
Use Mermaid flowchart syntax with numbered processes and labeled data stores.
```

---

## Prompt 3: Level 2 DFD (Booking System Detail)

```
Create a Level 2 Data Flow Diagram focusing on the Booking System process (Process 4) for Origin Driving School.

Sub-processes:
4.1 Check Instructor Availability
    - Input: Date, time, instructor_id
    - Data Store: D3 (Instructors), D4 (Bookings)
    - Output: Available time slots

4.2 Create Booking Request
    - Input: Student details, preferred time, instructor
    - Data Store: D2 (Students), D3 (Instructors)
    - Output: Pending booking

4.3 Validate Booking
    - Input: Booking details
    - Data Store: D4 (Bookings)
    - Output: Validation status

4.4 Confirm/Reject Booking
    - Input: Instructor/admin decision
    - Data Store: D4 (Bookings)
    - Output: Booking confirmation

4.5 Generate Invoice
    - Input: Confirmed booking
    - Data Store: D4 (Bookings), D5 (Invoices)
    - Output: Invoice for student

4.6 Send Notifications
    - Input: Booking status changes
    - Data Store: D7 (Messages)
    - Output: Email/message to student and instructor

External Entities:
- Student
- Instructor
- Administrator

Show detailed data flows between sub-processes with clear labels.
Use Mermaid flowchart syntax.
```

---

## Prompt 4: Level 3 ERD (Crow's Foot Notation)

```
Create a comprehensive Entity Relationship Diagram for Origin Driving School Management System using Mermaid ER diagram syntax with crow's foot notation.

Entities and Attributes:

USERS
- id (PK)
- username
- password
- role (admin/student/instructor)
- created_at

STUDENTS
- id (PK)
- user_id (FK)
- name
- email
- phone
- license_no
- progress
- created_at

INSTRUCTORS
- id (PK)
- user_id (FK)
- name
- email
- qualifications
- schedule
- branch_id (FK)
- created_at

BOOKINGS
- id (PK)
- student_id (FK)
- instructor_id (FK)
- date
- time
- status (Pending/Confirmed/Completed/Cancelled)
- created_at

INVOICES
- id (PK)
- student_id (FK)
- amount
- status (Unpaid/Paid/Partial/Overdue)
- created_at

PAYMENTS
- id (PK)
- invoice_id (FK)
- amount
- method
- paid_at

MESSAGES
- id (PK)
- sender_type
- sender_id
- recipient_type
- recipient_id
- subject
- message
- read_status
- created_at

BRANCHES
- id (PK)
- name
- location
- phone
- created_at

SECURITY_LOG
- id (PK)
- user_id (FK)
- action
- ip_address
- created_at

RATE_LIMITS
- id (PK)
- ip_address
- endpoint
- attempts
- last_attempt

IP_BLACKLIST
- id (PK)
- ip_address
- reason
- created_at

Relationships (Crow's Foot Notation):

1. USERS ||--o| STUDENTS : "has profile"
2. USERS ||--o| INSTRUCTORS : "has profile"
3. STUDENTS ||--o{ BOOKINGS : "makes"
4. INSTRUCTORS ||--o{ BOOKINGS : "conducts"
5. STUDENTS ||--o{ INVOICES : "receives"
6. INVOICES ||--o{ PAYMENTS : "paid by"
7. BRANCHES ||--o{ INSTRUCTORS : "employs"
8. USERS ||--o{ SECURITY_LOG : "generates"

Cardinality Legend:
- || : Exactly one
- |o : Zero or one
- }o : Zero or many
- }| : One or many

Use Mermaid erDiagram syntax with proper crow's foot notation.
Include all attributes and relationships.
Show cardinality clearly on both sides of each relationship.
```

---

## Prompt 5: Alternative ERD (Simplified View)

```
Create a simplified ERD for Origin Driving School focusing on core entities only:

Core Entities:
1. USERS (id, username, password, role)
2. STUDENTS (id, user_id, name, email, progress)
3. INSTRUCTORS (id, user_id, name, email, schedule)
4. BOOKINGS (id, student_id, instructor_id, date, time, status)
5. INVOICES (id, student_id, amount, status)
6. PAYMENTS (id, invoice_id, amount, method)

Key Relationships:
- One USER can be one STUDENT (1:1)
- One USER can be one INSTRUCTOR (1:1)
- One STUDENT has many BOOKINGS (1:N)
- One INSTRUCTOR has many BOOKINGS (1:N)
- One STUDENT has many INVOICES (1:N)
- One INVOICE has many PAYMENTS (1:N)

Use Mermaid erDiagram syntax with crow's foot notation.
Make it visually clean and easy to understand.
```

---

## Usage Instructions

1. **Copy the prompt** you want to use
2. **Paste it into Mermaid AI** or Mermaid Live Editor (https://mermaid.live/)
3. **Adjust styling** as needed for your presentation
4. **Export as PNG/SVG** for documentation

## Tips for Best Results

- Start with Level 0, then progress to Level 1, Level 2, and ERD
- Modify entity names and attributes to match your exact database
- Add colors using Mermaid styling for better visual clarity
- Test each diagram in Mermaid Live Editor before finalizing

---

**Created By:** Origin Driving School Development Team  
**Date:** October 5, 2025  
**For:** DWIN309 Project Documentation
