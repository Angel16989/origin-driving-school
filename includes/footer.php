    </main>
    <!-- End Main Content Wrapper -->
    
    <!-- Footer (DWIN309 Compliant - Consistent across all pages) -->
    <footer style="background: var(--road-dark); color: white; padding: 3rem 2rem 2rem; text-align: center; margin-top: auto;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 2rem;">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--yellow-line), #ffed4e); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-right: 1rem;">🚗</div>
                <div>
                    <h3 style="margin: 0; font-size: 1.5rem;">Origin Driving School</h3>
                    <p style="margin: 0; opacity: 0.8;">Professional Driving Education</p>
                </div>
            </div>
            
            <!-- DWIN309 Required Footer Text -->
            <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
                <p style="margin: 0; font-size: 1rem; line-height: 1.6;">
                    This website was created by <strong>Ms Isha Shrestha (K241002), Mr Rojan Shrestha (K240867), and Mr Rasik Tiwari (K240750)</strong> for the final assessment of <strong>DWIN309</strong> at <strong>Kent Institute Australia</strong>.
                </p>
            </div>
            
            <div style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <p style="margin: 0; opacity: 0.8;">&copy; 2025 Origin Driving School. All rights reserved.</p>
                <div style="display: flex; gap: 2rem;">
                    <a href="privacy-policy.php" style="color: rgba(255,255,255,0.8); text-decoration: none;">Privacy Policy</a>
                    <a href="terms-of-service.php" style="color: rgba(255,255,255,0.8); text-decoration: none;">Terms of Service</a>
                    <a href="contact.php" style="color: rgba(255,255,255,0.8); text-decoration: none;">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Visual Enhancements Script -->
    <script src="<?php echo $path_prefix; ?>js/visual-enhancements.js"></script>
    
    <script>
        // Add scroll effect to navigation only
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.main-nav');
            if (nav && window.scrollY > 100) {
                nav.style.background = 'rgba(12, 36, 97, 0.98)';
            } else if (nav) {
                nav.style.background = 'rgba(12, 36, 97, 0.95)';
            }
        });
    </script>
</body>
</html>
