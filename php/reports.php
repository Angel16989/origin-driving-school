<?php
// reports.php - System Reports (Admin Only)
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

checkRoleAccess(['admin'], $_SESSION['role']);

// Generate comprehensive reports
$revenue_by_month = $conn->query("
    SELECT MONTH(created_at) as month, YEAR(created_at) as year, SUM(amount) as revenue 
    FROM invoices 
    WHERE status = 'Paid' 
    GROUP BY YEAR(created_at), MONTH(created_at) 
    ORDER BY year DESC, month DESC 
    LIMIT 12
");

$popular_instructors = $conn->query("
    SELECT i.name, COUNT(b.id) as total_bookings, AVG(CASE WHEN b.status = 'Completed' THEN 1 ELSE 0 END) * 100 as completion_rate
    FROM instructors i 
    LEFT JOIN bookings b ON i.id = b.instructor_id 
    GROUP BY i.id 
    ORDER BY total_bookings DESC
");

$student_progress = $conn->query("
    SELECT s.name, COUNT(b.id) as total_lessons, 
           COUNT(CASE WHEN b.status = 'Completed' THEN 1 END) as completed_lessons,
           s.progress
    FROM students s 
    LEFT JOIN bookings b ON s.id = b.student_id 
    GROUP BY s.id 
    ORDER BY total_lessons DESC
");

$monthly_bookings = $conn->query("
    SELECT MONTH(date) as month, YEAR(date) as year, COUNT(*) as booking_count, status
    FROM bookings 
    GROUP BY YEAR(date), MONTH(date), status
    ORDER BY year DESC, month DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Reports - Origin Driving School</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .report-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 2rem;
            margin: 1.5rem 0;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            border-left: 5px solid var(--primary-color);
        }
        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        .chart-placeholder {
            height: 200px;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e9ecef 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-dark);
            margin: 1rem 0;
        }
    </style>
</head>
<body class="page-transition">
    <header>
        <h1>📊 System Reports</h1>
        <p>Comprehensive analytics and performance insights</p>
    </header>
    
    <?php renderNavigation($_SESSION['role']); ?>
    
    <div class="container">
        <h2>🎯 Business Intelligence Dashboard</h2>
        
        <div class="report-grid">
            <!-- Revenue Report -->
            <div class="report-card">
                <h3>💰 Monthly Revenue Report</h3>
                <div class="chart-placeholder">📈 Revenue Chart (Chart.js integration ready)</div>
                <table class="table">
                    <tr><th>Month/Year</th><th>Revenue</th></tr>
                    <?php while($row = $revenue_by_month->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('F Y', mktime(0, 0, 0, $row['month'], 1, $row['year'])); ?></td>
                        <td>$<?php echo number_format($row['revenue'], 2); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            
            <!-- Instructor Performance -->
            <div class="report-card">
                <h3>👨‍🏫 Instructor Performance</h3>
                <div class="chart-placeholder">📊 Performance Chart (Chart.js ready)</div>
                <table class="table">
                    <tr><th>Instructor</th><th>Bookings</th><th>Completion Rate</th></tr>
                    <?php while($row = $popular_instructors->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo $row['total_bookings']; ?></td>
                        <td>
                            <span class="status-badge <?php echo $row['completion_rate'] > 80 ? 'success' : ($row['completion_rate'] > 60 ? 'warning' : 'danger'); ?>">
                                <?php echo number_format($row['completion_rate'], 1); ?>%
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        
        <!-- Student Progress Report -->
        <div class="report-card">
            <h3>🎓 Student Progress Overview</h3>
            <div class="chart-placeholder">📈 Progress Analytics (Chart.js ready)</div>
            <table class="table">
                <tr><th>Student Name</th><th>Total Lessons</th><th>Completed</th><th>Progress Status</th></tr>
                <?php while($row = $student_progress->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['total_lessons']; ?></td>
                    <td><?php echo $row['completed_lessons']; ?></td>
                    <td>
                        <span class="status-badge info">
                            <?php echo htmlspecialchars($row['progress']); ?>
                        </span>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        
        <!-- Monthly Booking Trends -->
        <div class="report-card">
            <h3>📅 Booking Trends Analysis</h3>
            <div class="chart-placeholder">📊 Booking Trends (Chart.js ready)</div>
            <table class="table">
                <tr><th>Month/Year</th><th>Total Bookings</th><th>Status</th></tr>
                <?php while($row = $monthly_bookings->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('F Y', mktime(0, 0, 0, $row['month'], 1, $row['year'])); ?></td>
                    <td><?php echo $row['booking_count']; ?></td>
                    <td>
                        <span class="status-badge <?php 
                            echo $row['status'] === 'Completed' ? 'success' : 
                                ($row['status'] === 'Confirmed' ? 'info' : 
                                ($row['status'] === 'Pending' ? 'warning' : 'danger')); 
                        ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        
        <!-- Quick Stats Summary -->
        <div style="background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white; padding: 2rem; border-radius: 20px; margin: 2rem 0; text-align: center;">
            <h3>🚀 System Performance Summary</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 2rem;">
                <?php
                $total_revenue = $conn->query("SELECT SUM(amount) as total FROM invoices WHERE status = 'Paid'")->fetch_assoc()['total'];
                $total_students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
                $total_instructors = $conn->query("SELECT COUNT(*) as count FROM instructors")->fetch_assoc()['count'];
                $total_bookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
                ?>
                <div>
                    <div style="font-size: 3rem; font-weight: 900;">$<?php echo number_format($total_revenue ?? 0, 0); ?></div>
                    <div style="font-size: 1.1rem; opacity: 0.9;">Total Revenue</div>
                </div>
                <div>
                    <div style="font-size: 3rem; font-weight: 900;"><?php echo $total_students; ?></div>
                    <div style="font-size: 1.1rem; opacity: 0.9;">Active Students</div>
                </div>
                <div>
                    <div style="font-size: 3rem; font-weight: 900;"><?php echo $total_instructors; ?></div>
                    <div style="font-size: 1.1rem; opacity: 0.9;">Certified Instructors</div>
                </div>
                <div>
                    <div style="font-size: 3rem; font-weight: 900;"><?php echo $total_bookings; ?></div>
                    <div style="font-size: 1.1rem; opacity: 0.9;">Total Lessons</div>
                </div>
            </div>
        </div>
        
        <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; text-align: center; margin-top: 2rem;">
            <h3>📈 Advanced Analytics</h3>
            <p>Ready for Chart.js integration • Real-time dashboard updates • Export to PDF/Excel • Predictive analytics</p>
            <div style="margin-top: 1.5rem;">
                <a href="#" class="btn">📊 Generate PDF Report</a>
                <a href="#" class="btn btn-success">📈 Export Data</a>
                <a href="#" class="btn btn-warning">⚡ Real-time Dashboard</a>
            </div>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - System Reports</footer>
</body>
</html>
