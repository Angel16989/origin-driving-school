<!DOCTYPE html>
<html>
<head>
    <title>Navigation Test</title>
</head>
<body>
    <h1>Navigation Test Page</h1>
    <p>This page is to test navigation links</p>
    
    <div style="background: #f0f0f0; padding: 20px; margin: 20px 0;">
        <h2>Test Navigation Links:</h2>
        <ul style="list-style: none; padding: 0;">
            <li style="margin: 10px 0;"><a href="about.php" style="color: blue; font-size: 18px;">→ About Page</a></li>
            <li style="margin: 10px 0;"><a href="services.php" style="color: blue; font-size: 18px;">→ Services Page</a></li>
            <li style="margin: 10px 0;"><a href="contact.php" style="color: blue; font-size: 18px;">→ Contact Page</a></li>
            <li style="margin: 10px 0;"><a href="instructors.php" style="color: blue; font-size: 18px;">→ Instructors Page</a></li>
        </ul>
    </div>
    
    <div style="background: #e0e0e0; padding: 20px; margin: 20px 0;">
        <h2>Current Page Info:</h2>
        <p><strong>Current URL:</strong> <span id="currentUrl"></span></p>
        <p><strong>Page Title:</strong> <span id="pageTitle"></span></p>
    </div>
    
    <script>
        document.getElementById('currentUrl').textContent = window.location.href;
        document.getElementById('pageTitle').textContent = document.title;
        
        // Log clicks for debugging
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                console.log('Clicked link to:', this.href);
                console.log('Current page:', window.location.href);
            });
        });
    </script>
</body>
</html>