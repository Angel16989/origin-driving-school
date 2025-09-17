-- database.sql - Origin Driving School Online Management System
-- Drop tables if they exist
DROP TABLE IF EXISTS payments, invoices, bookings, messages, students, instructors, users, branches;

-- Branches (optional bonus)
CREATE TABLE branches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    address VARCHAR(255)
);
INSERT INTO branches (name, address) VALUES ('Central', '123 Main St'), ('North', '456 North Rd');

-- Users (login)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','student','instructor'),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$abcdefghijklmnopqrstuv', 'admin'),
('student1', '$2y$10$abcdefghijklmnopqrstuv', 'student'),
('instructor1', '$2y$10$abcdefghijklmnopqrstuv', 'instructor');

-- Students
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    license_no VARCHAR(50),
    progress VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO students (name, email, phone, license_no, progress) VALUES
('John Doe', 'john@example.com', '1234567890', 'A1234567', 'Theory Complete'),
('Jane Smith', 'jane@example.com', '0987654321', 'B7654321', 'Practical Scheduled');

-- Instructors
CREATE TABLE instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    qualifications VARCHAR(255),
    schedule VARCHAR(255),
    branch_id INT,
    FOREIGN KEY (branch_id) REFERENCES branches(id)
);
INSERT INTO instructors (name, email, qualifications, schedule, branch_id) VALUES
('Mike Brown', 'mike@driving.com', 'Certified Instructor', 'Mon-Fri 9am-5pm', 1),
('Sara Lee', 'sara@driving.com', 'Senior Instructor', 'Tue-Thu 10am-4pm', 2);

-- Bookings
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    instructor_id INT,
    date DATE,
    time TIME,
    status VARCHAR(50),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (instructor_id) REFERENCES instructors(id)
);
INSERT INTO bookings (student_id, instructor_id, date, time, status) VALUES
(1, 1, '2025-09-20', '10:00:00', 'Confirmed'),
(2, 2, '2025-09-21', '11:00:00', 'Pending');

-- Invoices
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    amount DECIMAL(10,2),
    status VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id)
);
INSERT INTO invoices (student_id, amount, status) VALUES
(1, 100.00, 'Paid'),
(2, 150.00, 'Unpaid');

-- Payments
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT,
    amount DECIMAL(10,2),
    method VARCHAR(50),
    paid_at DATETIME,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);
INSERT INTO payments (invoice_id, amount, method, paid_at) VALUES
(1, 100.00, 'Cash', '2025-09-15 09:00:00');

-- Messages
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    message TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);
INSERT INTO messages (sender_id, receiver_id, message) VALUES
(2, 3, 'Hello Instructor, when is my next lesson?'),
(3, 2, 'Your next lesson is on 2025-09-21 at 11:00.');
