<?php
session_start();
$page_title = "Image Showcase - Origin Driving School";
$page_description = "View our beautiful CSS-generated graphics and SVG illustrations.";
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/enhanced-styles.css">
<link rel="stylesheet" href="css/css-graphics.css">

<style>
.showcase-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 3rem;
    margin: 3rem 0;
}

.showcase-item {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: all 0.4s ease;
}

.showcase-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
}

.showcase-item h3 {
    color: var(--dashboard-blue);
    margin-top: 1rem;
}

.code-preview {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 10px;
    margin-top: 1rem;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    text-align: left;
    overflow-x: auto;
}
</style>

<!-- Hero Section -->
<section class="hero-enhanced hero-pattern-1" style="padding: 6rem 2rem 4rem; text-align: center; color: white;">
    <div class="hero-content" style="max-width: 900px; margin: 0 auto;">
        <h1 class="hero-title" style="font-size: 3rem; margin-bottom: 1rem;">
            🎨 AI-Generated Graphics Showcase
        </h1>
        <p class="hero-subtitle" style="font-size: 1.3rem; opacity: 0.9; line-height: 1.6;">
            Beautiful, pure CSS & SVG graphics - No external images needed! All created with code.
        </p>
        <div class="section-divider"></div>
    </div>
</section>

<div class="container">

    <section style="margin: 4rem 0;">
        <h2 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 1rem; font-size: 2.5rem;">
            🚗 CSS-Generated Graphics
        </h2>
        <p style="text-align: center; color: #666; font-size: 1.2rem; margin-bottom: 3rem;">
            Lightweight, scalable, and beautiful - all made with pure CSS!
        </p>

        <div class="showcase-grid">
            
            <!-- Car -->
            <div class="showcase-item scroll-reveal">
                <div class="css-car floating-car">
                    <div class="css-car-roof"></div>
                    <div class="css-car-body"></div>
                    <div class="css-car-window"></div>
                    <div class="css-car-window css-car-window-right"></div>
                    <div class="css-car-wheel css-car-wheel-front rotating-wheel"></div>
                    <div class="css-car-wheel css-car-wheel-back rotating-wheel"></div>
                    <div class="css-car-light"></div>
                </div>
                <h3>Training Vehicle</h3>
                <p style="color: #666;">Animated CSS car with rotating wheels and floating effect</p>
                <div class="badge-enhanced badge-success">Pure CSS</div>
            </div>

            <!-- Trophy -->
            <div class="showcase-item scroll-reveal">
                <div class="css-trophy">
                    <div class="css-trophy-cup"></div>
                    <div class="css-trophy-stem"></div>
                    <div class="css-trophy-base"></div>
                    <div class="css-trophy-star">★</div>
                </div>
                <h3>Success Trophy</h3>
                <p style="color: #666;">Golden trophy for celebrating student achievements</p>
                <div class="badge-enhanced badge-warning">Gradient Magic</div>
            </div>

            <!-- Instructor -->
            <div class="showcase-item scroll-reveal">
                <div class="css-instructor">
                    <div class="css-instructor-head"></div>
                    <div class="css-instructor-body"></div>
                    <div class="css-instructor-arm css-instructor-arm-left"></div>
                    <div class="css-instructor-arm css-instructor-arm-right"></div>
                </div>
                <h3>Instructor Avatar</h3>
                <p style="color: #666;">Professional instructor representation</p>
                <div class="badge-enhanced badge-info">CSS Shapes</div>
            </div>

            <!-- Road Scene -->
            <div class="showcase-item scroll-reveal">
                <div class="css-road-scene">
                    <div class="css-sun"></div>
                    <div class="css-road-marking"></div>
                    <div class="css-road-marking"></div>
                    <div class="css-road-marking"></div>
                </div>
                <h3>Highway Scene</h3>
                <p style="color: #666;">Animated road with moving lane markings</p>
                <div class="badge-enhanced badge-success">Animated</div>
            </div>

            <!-- License Card -->
            <div class="showcase-item scroll-reveal">
                <div class="css-license">
                    <div class="css-license-photo"></div>
                    <div class="css-license-text">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <h3>Driver License</h3>
                <p style="color: #666;">Professional license card design</p>
                <div class="badge-enhanced badge-info">3D Effect</div>
            </div>

            <!-- Parking -->
            <div class="showcase-item scroll-reveal">
                <div class="css-parking"></div>
                <h3>Parking Sign</h3>
                <p style="color: #666;">Bold parking indicator with shadow</p>
                <div class="badge-enhanced badge-info">Simple & Clean</div>
            </div>

            <!-- Checkmark -->
            <div class="showcase-item scroll-reveal">
                <div class="css-checkmark"></div>
                <h3>Success Checkmark</h3>
                <p style="color: #666;">Perfect for showing achievements</p>
                <div class="badge-enhanced badge-success">Icon Perfect</div>
            </div>

            <!-- Steering Wheel -->
            <div class="showcase-item scroll-reveal">
                <div class="css-steering"></div>
                <h3>Steering Wheel</h3>
                <p style="color: #666;">Detailed steering wheel with 3D effect</p>
                <div class="badge-enhanced badge-warning">3D Styled</div>
            </div>

            <!-- Traffic Light -->
            <div class="showcase-item scroll-reveal">
                <div class="css-traffic-light">
                    <div class="css-light css-light-red"></div>
                    <div class="css-light css-light-yellow"></div>
                    <div class="css-light css-light-green"></div>
                </div>
                <h3>Traffic Light</h3>
                <p style="color: #666;">Animated traffic signal with blinking green</p>
                <div class="badge-enhanced badge-success">Animated</div>
            </div>

        </div>
    </section>

    <!-- Features Section -->
    <section class="scroll-reveal" style="background: linear-gradient(135deg, #0c2461, #40407a); color: white; padding: 4rem 2rem; border-radius: 25px; text-align: center; margin: 4rem 0;">
        <h2 style="font-size: 2.5rem; margin-bottom: 2rem;">✨ Why CSS Graphics?</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin: 2rem 0;">
            <div>
                <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                <h3>Lightning Fast</h3>
                <p style="opacity: 0.9;">No HTTP requests, instant loading, better performance</p>
            </div>
            
            <div>
                <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
                <h3>Responsive</h3>
                <p style="opacity: 0.9;">Scales perfectly on any screen size without quality loss</p>
            </div>
            
            <div>
                <div style="font-size: 3rem; margin-bottom: 1rem;">🎨</div>
                <h3>Customizable</h3>
                <p style="opacity: 0.9;">Easy to change colors, sizes, and animations with CSS</p>
            </div>
            
            <div>
                <div style="font-size: 3rem; margin-bottom: 1rem;">♿</div>
                <h3>Accessible</h3>
                <p style="opacity: 0.9;">Better for screen readers and SEO optimization</p>
            </div>
        </div>
    </section>

    <!-- How to Use -->
    <section class="scroll-reveal" style="margin: 4rem 0;">
        <h2 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 3rem; font-size: 2.5rem;">
            💻 How to Use
        </h2>
        
        <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Step 1: Include the CSS</h3>
            <div class="code-preview">
                &lt;link rel="stylesheet" href="css/css-graphics.css"&gt;
            </div>

            <h3 style="color: var(--dashboard-blue); margin-top: 2rem; margin-bottom: 1rem;">Step 2: Add the HTML Structure</h3>
            <div class="code-preview">
&lt;div class="css-car floating-car"&gt;<br>
&nbsp;&nbsp;&lt;div class="css-car-roof"&gt;&lt;/div&gt;<br>
&nbsp;&nbsp;&lt;div class="css-car-body"&gt;&lt;/div&gt;<br>
&nbsp;&nbsp;&lt;div class="css-car-window"&gt;&lt;/div&gt;<br>
&nbsp;&nbsp;&lt;div class="css-car-wheel css-car-wheel-front"&gt;&lt;/div&gt;<br>
&nbsp;&nbsp;&lt;div class="css-car-wheel css-car-wheel-back"&gt;&lt;/div&gt;<br>
&lt;/div&gt;
            </div>

            <h3 style="color: var(--dashboard-blue); margin-top: 2rem; margin-bottom: 1rem;">Step 3: Enjoy!</h3>
            <p style="color: #666; font-size: 1.1rem;">
                🎉 That's it! The graphics are now rendered with pure CSS - no images needed!
            </p>
        </div>
    </section>

    <!-- Benefits -->
    <section class="scroll-reveal" style="margin: 4rem 0;">
        <h2 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 3rem; font-size: 2.5rem;">
            🏆 Technical Benefits
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            <div class="card-enhanced" style="padding: 2rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🚀</div>
                <h4 style="color: var(--dashboard-blue);">Zero HTTP Requests</h4>
                <p style="color: #666;">Graphics load instantly with your CSS, no external file downloads</p>
            </div>
            
            <div class="card-enhanced" style="padding: 2rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                <h4 style="color: var(--dashboard-blue);">Tiny File Size</h4>
                <p style="color: #666;">All graphics combined are smaller than a single JPG image</p>
            </div>
            
            <div class="card-enhanced" style="padding: 2rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🎬</div>
                <h4 style="color: var(--dashboard-blue);">Built-in Animations</h4>
                <p style="color: #666;">Smooth 60fps animations without JavaScript</p>
            </div>
            
            <div class="card-enhanced" style="padding: 2rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                <h4 style="color: var(--dashboard-blue);">SEO Friendly</h4>
                <p style="color: #666;">Better for search engines than image-heavy sites</p>
            </div>
            
            <div class="card-enhanced" style="padding: 2rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🌈</div>
                <h4 style="color: var(--dashboard-blue);">Easy Theming</h4>
                <p style="color: #666;">Change entire color scheme by editing CSS variables</p>
            </div>
            
            <div class="card-enhanced" style="padding: 2rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">♾️</div>
                <h4 style="color: var(--dashboard-blue);">Infinite Scaling</h4>
                <p style="color: #666;">Vector-like quality at any resolution</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="scroll-reveal" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 4rem 2rem; border-radius: 25px; text-align: center; margin: 4rem 0;">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">🎨 See Them in Action!</h2>
        <p style="font-size: 1.2rem; opacity: 0.9; margin-bottom: 2rem;">
            Visit our gallery and features pages to see these graphics used in real context
        </p>
        <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
            <a href="gallery.php" class="btn-enhanced btn-primary-enhanced">
                📸 View Gallery
            </a>
            <a href="features.php" class="btn-enhanced btn-secondary-enhanced" style="background: white; color: #28a745;">
                🌟 Explore Features
            </a>
        </div>
    </section>

</div>

<?php include 'includes/footer.php'; ?>
