<?php
// test_analytics_simple.php - Simple analytics test
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'admin';
$_SESSION['name'] = 'Test Admin';

require_once 'php/db_connect.php';

// Use same date range as analytics.php
$date_from = date('Y-m-d', strtotime('-12 months'));
$date_to = date('Y-m-d');

// Get sample data
$revenue_query = "SELECT DATE(paid_at) as date, SUM(amount) as daily_revenue FROM payments WHERE paid_at BETWEEN '$date_from' AND '$date_to' GROUP BY DATE(paid_at) ORDER BY date ASC LIMIT 10";
$revenue_data = [];
$result = $conn->query($revenue_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $revenue_data[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Analytics Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .chart-container { width: 100%; height: 400px; margin: 20px 0; padding: 20px; border: 2px solid #ddd; }
        canvas { max-width: 100%; }
    </style>
</head>
<body>
    <h1>🧪 Simple Analytics Test</h1>
    
    <h3>📊 Data Check:</h3>
    <p>Date Range: <?php echo $date_from; ?> to <?php echo $date_to; ?></p>
    <p>Revenue Data Points: <?php echo count($revenue_data); ?></p>
    
    <?php if (count($revenue_data) > 0): ?>
        <h4>Sample Data:</h4>
        <ul>
            <?php foreach (array_slice($revenue_data, 0, 5) as $item): ?>
                <li><?php echo $item['date']; ?>: $<?php echo number_format($item['daily_revenue'], 2); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <div class="chart-container">
        <h3>💰 Simple Revenue Chart</h3>
        <canvas id="testChart" width="800" height="400"></canvas>
    </div>
    
    <div id="status"></div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script>
        console.log('🔧 Starting Simple Analytics Test...');
        
        // Check if Chart.js loaded
        if (typeof Chart === 'undefined') {
            document.getElementById('status').innerHTML = '❌ Chart.js failed to load from CDN!';
            console.error('Chart.js not loaded!');
        } else {
            console.log('✅ Chart.js loaded successfully');
            document.getElementById('status').innerHTML = '✅ Chart.js loaded successfully';
        }
        
        // Get data from PHP
        const testData = <?php echo json_encode($revenue_data); ?>;
        console.log('📊 Revenue Data:', testData);
        
        if (testData.length === 0) {
            document.getElementById('status').innerHTML += '<br>❌ No data available!';
        } else {
            document.getElementById('status').innerHTML += '<br>✅ Data loaded: ' + testData.length + ' points';
            
            // Create simple chart
            try {
                const ctx = document.getElementById('testChart').getContext('2d');
                
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: testData.map(d => d.date),
                        datasets: [{
                            label: 'Daily Revenue ($)',
                            data: testData.map(d => parseFloat(d.daily_revenue)),
                            borderColor: '#ff6b6b',
                            backgroundColor: 'rgba(255, 107, 107, 0.1)',
                            borderWidth: 3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Revenue Test Chart'
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
                
                document.getElementById('status').innerHTML += '<br>🎉 Chart created successfully!';
                console.log('🎉 Chart rendered successfully!');
                
            } catch (error) {
                document.getElementById('status').innerHTML += '<br>❌ Chart creation failed: ' + error.message;
                console.error('Chart creation error:', error);
            }
        }
    </script>
</body>
</html>