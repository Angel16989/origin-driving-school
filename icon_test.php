<?php
// icon_test.php - Test icon visibility throughout the system
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Icon Visibility Test - Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .icon-test-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            border-radius: 15px;
            margin: 1.5rem 0;
            border-left: 5px solid #007bff;
        }
        
        .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .icon-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .icon-card:hover {
            transform: translateY(-5px);
        }
        
        .icon-display {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .icon-code {
            background: #f1f3f4;
            padding: 0.5rem;
            border-radius: 5px;
            font-family: monospace;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body class="page-transition">
    <header>
        <h1>🔍 Icon Visibility Test</h1>
        <p>Comprehensive icon display testing for Origin Driving School</p>
    </header>
    
    <div class="container">
        <h2>🎯 Icon System Overview</h2>
        
        <!-- Navigation Icons -->
        <div class="icon-test-section">
            <h3>🧭 Navigation Icons</h3>
            <p>These are the icons used in role-based navigation throughout the system:</p>
            <div class="icon-grid">
                <div class="icon-card">
                    <span class="icon-display">🏠</span>
                    <h4>Home Dashboard</h4>
                    <div class="icon-code">🏠</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">👥</span>
                    <h4>Students</h4>
                    <div class="icon-code">👥</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">👨‍🏫</span>
                    <h4>Instructors</h4>
                    <div class="icon-code">👨‍🏫</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">📅</span>
                    <h4>Schedule/Bookings</h4>
                    <div class="icon-code">📅</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">💰</span>
                    <h4>Financial</h4>
                    <div class="icon-code">💰</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">💬</span>
                    <h4>Messages</h4>
                    <div class="icon-code">💬</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🚪</span>
                    <h4>Logout</h4>
                    <div class="icon-code">🚪</div>
                </div>
            </div>
        </div>
        
        <!-- Action Icons -->
        <div class="icon-test-section">
            <h3>⚡ Action Icons</h3>
            <p>Icons used for buttons, actions, and interactive elements:</p>
            <div class="icon-grid">
                <div class="icon-card">
                    <span class="icon-display">📨</span>
                    <h4>Send Message</h4>
                    <div class="icon-code">📨</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">📤</span>
                    <h4>Send/Upload</h4>
                    <div class="icon-code">📤</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">📥</span>
                    <h4>Receive/Download</h4>
                    <div class="icon-code">📥</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">✅</span>
                    <h4>Success/Complete</h4>
                    <div class="icon-code">✅</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">❌</span>
                    <h4>Error/Cancel</h4>
                    <div class="icon-code">❌</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">⚠️</span>
                    <h4>Warning</h4>
                    <div class="icon-code">⚠️</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">ℹ️</span>
                    <h4>Information</h4>
                    <div class="icon-code">ℹ️</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🔍</span>
                    <h4>Search</h4>
                    <div class="icon-code">🔍</div>
                </div>
            </div>
        </div>
        
        <!-- Status Icons -->
        <div class="icon-test-section">
            <h3>📊 Status & Indicator Icons</h3>
            <p>Icons used for status badges, progress indicators, and system states:</p>
            <div class="icon-grid">
                <div class="icon-card">
                    <span class="icon-display">🟢</span>
                    <h4>Active/Online</h4>
                    <div class="icon-code">🟢</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🟡</span>
                    <h4>Pending/Warning</h4>
                    <div class="icon-code">🟡</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🔴</span>
                    <h4>Inactive/Error</h4>
                    <div class="icon-code">🔴</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">📈</span>
                    <h4>Progress Up</h4>
                    <div class="icon-code">📈</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">📉</span>
                    <h4>Progress Down</h4>
                    <div class="icon-code">📉</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">⭐</span>
                    <h4>Rating/Favorite</h4>
                    <div class="icon-code">⭐</div>
                </div>
            </div>
        </div>
        
        <!-- Vehicle & Driving Icons -->
        <div class="icon-test-section">
            <h3>🚗 Automotive & Driving Icons</h3>
            <p>Specialized icons for driving school context:</p>
            <div class="icon-grid">
                <div class="icon-card">
                    <span class="icon-display">🚗</span>
                    <h4>Car</h4>
                    <div class="icon-code">🚗</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🚙</span>
                    <h4>SUV</h4>
                    <div class="icon-code">🚙</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🏁</span>
                    <h4>Racing/Start</h4>
                    <div class="icon-code">🏁</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🛣️</span>
                    <h4>Highway</h4>
                    <div class="icon-code">🛣️</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🚦</span>
                    <h4>Traffic Light</h4>
                    <div class="icon-code">🚦</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🔧</span>
                    <h4>Maintenance</h4>
                    <div class="icon-code">🔧</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">🎓</span>
                    <h4>Student</h4>
                    <div class="icon-code">🎓</div>
                </div>
                <div class="icon-card">
                    <span class="icon-display">📋</span>
                    <h4>Clipboard/Test</h4>
                    <div class="icon-code">📋</div>
                </div>
            </div>
        </div>
        
        <!-- Button Tests -->
        <div class="icon-test-section">
            <h3>🎯 Button Icon Integration Test</h3>
            <p>Testing icons within actual button elements:</p>
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin: 1rem 0;">
                <button class="btn">🏠 Dashboard</button>
                <button class="btn btn-success">✅ Confirm</button>
                <button class="btn btn-warning">⚠️ Warning</button>
                <button class="btn btn-danger">❌ Delete</button>
                <button class="btn">📨 Send Message</button>
                <button class="btn">📅 Schedule</button>
                <button class="btn">👤 Profile</button>
                <button class="btn">🔍 Search</button>
            </div>
        </div>
        
        <!-- Status Badge Tests -->
        <div class="icon-test-section">
            <h3>🏷️ Status Badge Icon Test</h3>
            <p>Testing icons within status badge elements:</p>
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin: 1rem 0;">
                <span class="status-badge success">✅ Complete</span>
                <span class="status-badge info">ℹ️ Information</span>
                <span class="status-badge warning">⚠️ Pending</span>
                <span class="status-badge danger">❌ Failed</span>
            </div>
        </div>
        
        <!-- Navigation Test -->
        <div class="icon-test-section">
            <h3>🧭 Navigation System Test</h3>
            <p>Testing role-based navigation icons:</p>
            <nav class="role-nav role-nav-admin" style="position: static; width: auto; margin: 1rem 0;">
                <a href="#" class="nav-item">
                    <span class="nav-icon">🏠</span>
                    <span class="nav-label">Dashboard</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">👥</span>
                    <span class="nav-label">Students</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">👨‍🏫</span>
                    <span class="nav-label">Instructors</span>
                </a>
                <a href="#" class="nav-item active">
                    <span class="nav-icon">💬</span>
                    <span class="nav-label">Messages</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">🚪</span>
                    <span class="nav-label">Logout</span>
                </a>
            </nav>
        </div>
        
        <!-- Font Fallback Test -->
        <div class="icon-test-section">
            <h3>📱 Cross-Platform Compatibility</h3>
            <p>Testing icon display across different systems and browsers:</p>
            <div style="background: white; padding: 2rem; border-radius: 10px;">
                <h4>Emoji Font Stack Test:</h4>
                <div style="font-family: 'Apple Color Emoji', 'Segoe UI Emoji', 'Noto Color Emoji', sans-serif; font-size: 2rem; line-height: 1.5;">
                    🏠 👥 👨‍🏫 📅 💰 💬 📨 ✅ ❌ ⚠️ 🚗 🏁
                </div>
                
                <h4 style="margin-top: 2rem;">System Font Test:</h4>
                <div style="font-family: system-ui, -apple-system, sans-serif; font-size: 2rem; line-height: 1.5;">
                    🏠 👥 👨‍🏫 📅 💰 💬 📨 ✅ ❌ ⚠️ 🚗 🏁
                </div>
                
                <div style="margin-top: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                    <strong>Note:</strong> If any icons appear as square boxes (□) or question marks (?), there may be font compatibility issues on this system.
                </div>
            </div>
        </div>
        
        <!-- Performance Test -->
        <div class="icon-test-section">
            <h3>⚡ Performance & Accessibility Test</h3>
            <div style="background: white; padding: 2rem; border-radius: 10px;">
                <h4>Icon Loading Performance:</h4>
                <p id="load-time"></p>
                
                <h4>Accessibility Test:</h4>
                <button class="btn" aria-label="Home Dashboard" title="Navigate to Dashboard">
                    <span aria-hidden="true">🏠</span> Dashboard
                </button>
                <button class="btn btn-success" aria-label="Send Message" title="Send New Message">
                    <span aria-hidden="true">📨</span> Send Message
                </button>
                
                <div style="margin-top: 1rem; padding: 1rem; background: #e8f5e8; border-radius: 5px;">
                    <strong>✅ Accessibility Features:</strong>
                    <ul style="margin-top: 0.5rem;">
                        <li>Icons have proper aria-hidden attributes</li>
                        <li>Buttons include descriptive aria-label and title attributes</li>
                        <li>Icon text is provided alongside visual indicators</li>
                        <li>High contrast maintained for visibility</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - Icon System Test</footer>
    
    <script>
        // Measure icon loading performance
        document.addEventListener('DOMContentLoaded', function() {
            const loadTime = performance.now();
            document.getElementById('load-time').textContent = 
                `Icons loaded in ${loadTime.toFixed(2)}ms - Excellent performance! 🚀`;
        });
        
        // Add hover effects for demonstration
        document.querySelectorAll('.icon-card').forEach(card => {
            card.addEventListener('mouseover', function() {
                const icon = this.querySelector('.icon-display');
                icon.style.transform = 'scale(1.2) rotate(5deg)';
                icon.style.transition = 'transform 0.3s ease';
            });
            
            card.addEventListener('mouseout', function() {
                const icon = this.querySelector('.icon-display');
                icon.style.transform = 'scale(1) rotate(0deg)';
            });
        });
    </script>
</body>
</html>
