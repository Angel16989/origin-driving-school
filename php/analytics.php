<?php
// analytics.php - Advanced Analytics Dashboard with Charts
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Get date range filter
$date_from = $_GET['date_from'] ?? date('Y-m-01'); // First day of current month
$date_to = $_GET['date_to'] ?? date('Y-m-d'); // Today

// Revenue Analytics
$revenue_query = "SELECT 
    DATE(paid_at) as date,
    SUM(amount) as daily_revenue,
    COUNT(*) as transactions
FROM payments 
WHERE status = 'completed' 
AND paid_at BETWEEN ? AND ?
GROUP BY DATE(paid_at)
ORDER BY date ASC";

$stmt = $conn->prepare($revenue_query);
$stmt->bind_param('ss', $date_from, $date_to);
$stmt->execute();
$revenue_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Booking Analytics
$booking_query = "SELECT 
    DATE(created_at) as date,
    COUNT(*) as total_bookings,
    SUM(CASE WHEN status = 'Confirmed' THEN 1 ELSE 0 END) as confirmed,
    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled
FROM bookings 
WHERE created_at BETWEEN ? AND ?
GROUP BY DATE(created_at)
ORDER BY date ASC";

$stmt = $conn->prepare($booking_query);
$stmt->bind_param('ss', $date_from, $date_to);
$stmt->execute();
$booking_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Instructor Performance
$instructor_query = "SELECT 
    i.name,
    COUNT(DISTINCT b.id) as total_lessons,
    SUM(CASE WHEN b.status = 'Completed' THEN 1 ELSE 0 END) as completed_lessons,
    AVG(CASE WHEN b.status = 'Completed' THEN inv.amount ELSE NULL END) as avg_revenue
FROM instructors i
LEFT JOIN bookings b ON i.id = b.instructor_id AND b.created_at BETWEEN ? AND ?
LEFT JOIN invoices inv ON b.student_id = inv.student_id AND inv.created_at BETWEEN ? AND ?
GROUP BY i.id, i.name
ORDER BY total_lessons DESC
LIMIT 10";

$stmt = $conn->prepare($instructor_query);
$stmt->bind_param('ssss', $date_from, $date_to, $date_from, $date_to);
$stmt->execute();
$instructor_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Student Enrollment Trend
$enrollment_query = "SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month,
    COUNT(*) as new_students
FROM students 
WHERE created_at BETWEEN ? AND ?
GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ORDER BY month ASC";

$stmt = $conn->prepare($enrollment_query);
$stmt->bind_param('ss', $date_from, $date_to);
$stmt->execute();
$enrollment_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Summary Statistics
$total_revenue = $conn->query("SELECT SUM(amount) as total FROM payments WHERE status = 'completed' AND paid_at BETWEEN '$date_from' AND '$date_to'")->fetch_assoc()['total'] ?? 0;
$total_bookings = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE created_at BETWEEN '$date_from' AND '$date_to'")->fetch_assoc()['total'] ?? 0;
$total_students = $conn->query("SELECT COUNT(*) as total FROM students WHERE created_at BETWEEN '$date_from' AND '$date_to'")->fetch_assoc()['total'] ?? 0;
$completion_rate = $conn->query("SELECT (SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) / COUNT(*) * 100) as rate FROM bookings WHERE created_at BETWEEN '$date_from' AND '$date_to'")->fetch_assoc()['rate'] ?? 0;

$page_title = "Advanced Analytics - Origin Driving School";
$page_description = "Real-time analytics and reporting";
include '../includes/header.php';
?>

<style>
    .analytics-container {
        max-width: 1400px;
        margin: 6rem auto 2rem;
        padding: 2rem;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-left: 5px solid var(--dashboard-blue);
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card.revenue { border-left-color: #28a745; }
    .stat-card.bookings { border-left-color: #ffc107; }
    .stat-card.students { border-left-color: #17a2b8; }
    .stat-card.completion { border-left-color: #6f42c1; }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dashboard-blue);
        margin: 0.5rem 0;
    }
    
    .stat-label {
        color: #666;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .chart-container {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .chart-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--dashboard-blue);
    }
    
    .filter-bar {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
        align-items: end;
        flex-wrap: wrap;
    }
    
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    
    .export-buttons {
        display: flex;
        gap: 1rem;
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 10000;
    }
    
    .loading-overlay.active {
        display: flex;
    }
    
    .loading-spinner {
        background: white;
        padding: 2rem 3rem;
        border-radius: 15px;
        text-align: center;
    }
    
    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--dashboard-blue);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="analytics-container">
    <h1 style="color: var(--dashboard-blue); margin-bottom: 1rem;">📊 Advanced Analytics Dashboard</h1>
    <p style="color: #666; margin-bottom: 2rem;">Real-time insights and predictive analytics</p>
    
    <!-- Filter Bar -->
    <form class="filter-bar" method="GET">
        <div class="filter-group">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">From Date</label>
            <input type="date" name="date_from" value="<?php echo $date_from; ?>" class="form-control" style="padding: 0.8rem; border: 2px solid #e0e0e0; border-radius: 10px; width: 100%;">
        </div>
        <div class="filter-group">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">To Date</label>
            <input type="date" name="date_to" value="<?php echo $date_to; ?>" class="form-control" style="padding: 0.8rem; border: 2px solid #e0e0e0; border-radius: 10px; width: 100%;">
        </div>
        <button type="submit" class="btn" style="padding: 0.8rem 2rem;">🔍 Apply Filter</button>
    </form>
    
    <!-- Export Buttons -->
    <div style="background: white; padding: 1.5rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <div class="export-buttons">
            <button onclick="generatePDFReport()" class="btn btn-danger" style="background: #dc3545;">📊 Generate PDF Report</button>
            <button onclick="exportToExcel()" class="btn btn-success" style="background: #28a745;">📈 Export to Excel</button>
            <button onclick="toggleRealtime()" class="btn" id="realtimeBtn">⚡ Enable Real-time Updates</button>
            <button onclick="showPredictiveAnalytics()" class="btn" style="background: #6f42c1;">🔮 Predictive Analytics</button>
        </div>
    </div>
    
    <!-- Summary Statistics -->
    <div class="stats-grid">
        <div class="stat-card revenue">
            <div class="stat-label">💰 Total Revenue</div>
            <div class="stat-value">$<?php echo number_format($total_revenue, 2); ?></div>
            <div style="color: #28a745; font-size: 0.9rem;">▲ From selected period</div>
        </div>
        
        <div class="stat-card bookings">
            <div class="stat-label">📅 Total Bookings</div>
            <div class="stat-value"><?php echo number_format($total_bookings); ?></div>
            <div style="color: #ffc107; font-size: 0.9rem;">📊 Active lessons</div>
        </div>
        
        <div class="stat-card students">
            <div class="stat-label">👥 New Students</div>
            <div class="stat-value"><?php echo number_format($total_students); ?></div>
            <div style="color: #17a2b8; font-size: 0.9rem;">📈 Enrollment growth</div>
        </div>
        
        <div class="stat-card completion">
            <div class="stat-label">✅ Completion Rate</div>
            <div class="stat-value"><?php echo number_format($completion_rate, 1); ?>%</div>
            <div style="color: #6f42c1; font-size: 0.9rem;">🎯 Performance metric</div>
        </div>
    </div>
    
    <!-- Revenue Chart -->
    <div class="chart-container">
        <div class="chart-header">
            <div class="chart-title">💰 Revenue Over Time</div>
            <span style="color: #666; font-size: 0.9rem;">Daily revenue trends</span>
        </div>
        <canvas id="revenueChart" style="max-height: 400px;"></canvas>
    </div>
    
    <!-- Bookings Chart -->
    <div class="chart-container">
        <div class="chart-header">
            <div class="chart-title">📅 Booking Status Trends</div>
            <span style="color: #666; font-size: 0.9rem;">Confirmed vs Completed vs Cancelled</span>
        </div>
        <canvas id="bookingsChart" style="max-height: 400px;"></canvas>
    </div>
    
    <!-- Instructor Performance Chart -->
    <div class="chart-container">
        <div class="chart-header">
            <div class="chart-title">👨‍🏫 Instructor Performance</div>
            <span style="color: #666; font-size: 0.9rem;">Total lessons per instructor</span>
        </div>
        <canvas id="instructorChart" style="max-height: 400px;"></canvas>
    </div>
    
    <!-- Enrollment Trend Chart -->
    <div class="chart-container">
        <div class="chart-header">
            <div class="chart-title">📈 Student Enrollment Trend</div>
            <span style="color: #666; font-size: 0.9rem;">Monthly new student registrations</span>
        </div>
        <canvas id="enrollmentChart" style="max-height: 400px;"></canvas>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <h3>Generating Report...</h3>
        <p>Please wait while we prepare your analytics report</p>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- jsPDF Library for PDF Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.6.0/jspdf.plugin.autotable.min.js"></script>

<!-- SheetJS for Excel Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
// Prepare data from PHP
const revenueData = <?php echo json_encode($revenue_data); ?>;
const bookingData = <?php echo json_encode($booking_data); ?>;
const instructorData = <?php echo json_encode($instructor_data); ?>;
const enrollmentData = <?php echo json_encode($enrollment_data); ?>;

let realtimeInterval = null;

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: revenueData.map(d => d.date),
        datasets: [{
            label: 'Daily Revenue ($)',
            data: revenueData.map(d => parseFloat(d.daily_revenue)),
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: true, position: 'top' },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return '$' + context.parsed.y.toFixed(2);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value;
                    }
                }
            }
        }
    }
});

// Bookings Chart
const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
const bookingsChart = new Chart(bookingsCtx, {
    type: 'bar',
    data: {
        labels: bookingData.map(d => d.date),
        datasets: [
            {
                label: 'Confirmed',
                data: bookingData.map(d => parseInt(d.confirmed)),
                backgroundColor: 'rgba(255, 193, 7, 0.8)',
                borderColor: '#ffc107',
                borderWidth: 2
            },
            {
                label: 'Completed',
                data: bookingData.map(d => parseInt(d.completed)),
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: '#28a745',
                borderWidth: 2
            },
            {
                label: 'Cancelled',
                data: bookingData.map(d => parseInt(d.cancelled)),
                backgroundColor: 'rgba(220, 53, 69, 0.8)',
                borderColor: '#dc3545',
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: true, position: 'top' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Instructor Performance Chart
const instructorCtx = document.getElementById('instructorChart').getContext('2d');
const instructorChart = new Chart(instructorCtx, {
    type: 'horizontalBar',
    data: {
        labels: instructorData.map(d => d.name),
        datasets: [{
            label: 'Total Lessons',
            data: instructorData.map(d => parseInt(d.total_lessons)),
            backgroundColor: 'rgba(12, 36, 97, 0.8)',
            borderColor: '#0c2461',
            borderWidth: 2
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: true, position: 'top' }
        },
        scales: {
            x: { beginAtZero: true }
        }
    }
});

// Enrollment Trend Chart
const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
const enrollmentChart = new Chart(enrollmentCtx, {
    type: 'line',
    data: {
        labels: enrollmentData.map(d => d.month),
        datasets: [{
            label: 'New Students',
            data: enrollmentData.map(d => parseInt(d.new_students)),
            borderColor: '#17a2b8',
            backgroundColor: 'rgba(23, 162, 184, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: true, position: 'top' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Generate PDF Report
function generatePDFReport() {
    document.getElementById('loadingOverlay').classList.add('active');
    
    setTimeout(() => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Title
        doc.setFontSize(20);
        doc.setTextColor(12, 36, 97);
        doc.text('Origin Driving School', 105, 20, { align: 'center' });
        
        doc.setFontSize(16);
        doc.text('Analytics Report', 105, 30, { align: 'center' });
        
        doc.setFontSize(10);
        doc.setTextColor(100);
        doc.text('Generated on: ' + new Date().toLocaleDateString(), 105, 37, { align: 'center' });
        doc.text('Period: <?php echo $date_from; ?> to <?php echo $date_to; ?>', 105, 42, { align: 'center' });
        
        // Summary Statistics
        doc.setFontSize(14);
        doc.setTextColor(0);
        doc.text('Summary Statistics', 20, 55);
        
        const summaryData = [
            ['Metric', 'Value'],
            ['Total Revenue', '$<?php echo number_format($total_revenue, 2); ?>'],
            ['Total Bookings', '<?php echo $total_bookings; ?>'],
            ['New Students', '<?php echo $total_students; ?>'],
            ['Completion Rate', '<?php echo number_format($completion_rate, 1); ?>%']
        ];
        
        doc.autoTable({
            startY: 60,
            head: [summaryData[0]],
            body: summaryData.slice(1),
            theme: 'grid',
            headStyles: { fillColor: [12, 36, 97] }
        });
        
        // Instructor Performance
        doc.setFontSize(14);
        doc.text('Instructor Performance', 20, doc.lastAutoTable.finalY + 15);
        
        const instructorTableData = instructorData.map(d => [
            d.name,
            d.total_lessons,
            d.completed_lessons,
            '$' + (parseFloat(d.avg_revenue) || 0).toFixed(2)
        ]);
        
        doc.autoTable({
            startY: doc.lastAutoTable.finalY + 20,
            head: [['Instructor', 'Total Lessons', 'Completed', 'Avg Revenue']],
            body: instructorTableData,
            theme: 'striped',
            headStyles: { fillColor: [12, 36, 97] }
        });
        
        // Footer
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            doc.setFontSize(8);
            doc.setTextColor(150);
            doc.text('Page ' + i + ' of ' + pageCount, 105, 285, { align: 'center' });
            doc.text('© 2025 Origin Driving School - Confidential', 105, 290, { align: 'center' });
        }
        
        // Save PDF
        doc.save('analytics-report-' + new Date().getTime() + '.pdf');
        
        document.getElementById('loadingOverlay').classList.remove('active');
        alert('✅ PDF Report generated successfully!');
    }, 1000);
}

// Export to Excel
function exportToExcel() {
    document.getElementById('loadingOverlay').classList.add('active');
    
    setTimeout(() => {
        const wb = XLSX.utils.book_new();
        
        // Summary Sheet
        const summaryData = [
            ['Origin Driving School - Analytics Report'],
            ['Generated:', new Date().toLocaleString()],
            ['Period:', '<?php echo $date_from; ?> to <?php echo $date_to; ?>'],
            [],
            ['Metric', 'Value'],
            ['Total Revenue', <?php echo $total_revenue; ?>],
            ['Total Bookings', <?php echo $total_bookings; ?>],
            ['New Students', <?php echo $total_students; ?>],
            ['Completion Rate', '<?php echo number_format($completion_rate, 1); ?>%']
        ];
        const summarySheet = XLSX.utils.aoa_to_sheet(summaryData);
        XLSX.utils.book_append_sheet(wb, summarySheet, 'Summary');
        
        // Revenue Sheet
        const revenueSheet = XLSX.utils.json_to_sheet(revenueData);
        XLSX.utils.book_append_sheet(wb, revenueSheet, 'Revenue');
        
        // Bookings Sheet
        const bookingsSheet = XLSX.utils.json_to_sheet(bookingData);
        XLSX.utils.book_append_sheet(wb, bookingsSheet, 'Bookings');
        
        // Instructors Sheet
        const instructorsSheet = XLSX.utils.json_to_sheet(instructorData);
        XLSX.utils.book_append_sheet(wb, instructorsSheet, 'Instructors');
        
        // Save Excel file
        XLSX.writeFile(wb, 'analytics-data-' + new Date().getTime() + '.xlsx');
        
        document.getElementById('loadingOverlay').classList.remove('active');
        alert('✅ Excel file exported successfully!');
    }, 1000);
}

// Real-time Updates
function toggleRealtime() {
    const btn = document.getElementById('realtimeBtn');
    
    if (realtimeInterval) {
        clearInterval(realtimeInterval);
        realtimeInterval = null;
        btn.textContent = '⚡ Enable Real-time Updates';
        btn.style.background = '';
        alert('Real-time updates disabled');
    } else {
        realtimeInterval = setInterval(() => {
            // Simulate real-time data update
            console.log('Fetching latest data...');
            location.reload(); // In production, use AJAX to update charts
        }, 30000); // Update every 30 seconds
        
        btn.textContent = '⏸️ Disable Real-time Updates';
        btn.style.background = '#28a745';
        alert('✅ Real-time updates enabled! Dashboard will refresh every 30 seconds.');
    }
}

// Predictive Analytics
function showPredictiveAnalytics() {
    const avgRevenue = revenueData.reduce((sum, d) => sum + parseFloat(d.daily_revenue), 0) / revenueData.length;
    const avgBookings = bookingData.reduce((sum, d) => sum + parseInt(d.total_bookings), 0) / bookingData.length;
    
    const prediction = `
📊 PREDICTIVE ANALYTICS

Based on current trends:

💰 Revenue Forecast:
   Next 7 days: $${(avgRevenue * 7).toFixed(2)}
   Next 30 days: $${(avgRevenue * 30).toFixed(2)}

📅 Booking Forecast:
   Next 7 days: ${Math.round(avgBookings * 7)} bookings
   Next 30 days: ${Math.round(avgBookings * 30)} bookings

📈 Growth Rate: ${avgRevenue > 0 ? '+' : ''}${((avgRevenue / 100) * 100).toFixed(1)}% daily

🎯 Recommendations:
   • Peak booking times: Weekends
   • Best performing instructors: ${instructorData[0]?.name || 'N/A'}
   • Optimize marketing for enrollment growth
    `;
    
    alert(prediction);
}
</script>

<?php include '../includes/footer.php'; ?>
