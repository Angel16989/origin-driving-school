<?php
session_start();
$page_title = "About Us - Origin Driving School";
$page_description = "Learn about Origin Driving School - Our mission, instructors, and commitment to safe driving education.";
include 'includes/header.php';
?>

    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white; padding: 6rem 2rem 4rem; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
        
        <div style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🚗</div>
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Your Journey to Safe Driving Starts Here</h2>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">At Origin Driving School, we're not just teaching you to drive – we're building confident, responsible drivers who contribute to safer roads for everyone.</p>
        </div>
    </section>
    
    <div class="container">
        
        <!-- Our Story -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem;">📖 Our Story</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem; align-items: center;">
                <div>
                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; border-left: 5px solid #007bff;">
                        <h3>🌟 Founded in 2010</h3>
                        <p>Origin Driving School was founded with a simple mission: to provide the highest quality driver education that prioritizes safety, confidence, and responsibility. What started as a small local driving school has grown into a trusted institution serving thousands of students.</p>
                        
                        <h3 style="margin-top: 2rem;">🎯 Our Mission</h3>
                        <p>To create safe, confident, and responsible drivers through comprehensive education, personalized instruction, and a commitment to excellence that extends far beyond the driver's seat.</p>
                    </div>
                </div>
                
                <div>
                    <div style="background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%); padding: 2rem; border-radius: 15px; border-left: 5px solid #28a745;">
                        <h3>🏆 Our Achievements</h3>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin: 1rem 0; padding-left: 2rem; position: relative;">
                                <span style="position: absolute; left: 0; top: 0;">✅</span>
                                Over 15,000 students successfully trained
                            </li>
                            <li style="margin: 1rem 0; padding-left: 2rem; position: relative;">
                                <span style="position: absolute; left: 0; top: 0;">🏅</span>
                                98% first-time pass rate on driving tests
                            </li>
                            <li style="margin: 1rem 0; padding-left: 2rem; position: relative;">
                                <span style="position: absolute; left: 0; top: 0;">⭐</span>
                                4.9/5 average customer satisfaction rating
                            </li>
                            <li style="margin: 1rem 0; padding-left: 2rem; position: relative;">
                                <span style="position: absolute; left: 0; top: 0;">🎓</span>
                                State-certified and fully licensed
                            </li>
                            <li style="margin: 1rem 0; padding-left: 2rem; position: relative;">
                                <span style="position: absolute; left: 0; top: 0;">🚗</span>
                                Modern, well-maintained training fleet
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Our Values -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem;">💎 Our Core Values</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div style="background: white; padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
                    <h3>Safety First</h3>
                    <p>Safety is our top priority in everything we do. We maintain the highest safety standards in our vehicles, instruction methods, and facilities.</p>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🌟</div>
                    <h3>Excellence</h3>
                    <p>We strive for excellence in every aspect of our service, from our experienced instructors to our modern training vehicles and comprehensive curriculum.</p>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🤝</div>
                    <h3>Respect</h3>
                    <p>We treat every student with respect, patience, and understanding, recognizing that everyone learns at their own pace and in their own way.</p>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
                    <h3>Innovation</h3>
                    <p>We embrace modern teaching methods and technology to provide the most effective and engaging learning experience possible.</p>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🏆</div>
                    <h3>Integrity</h3>
                    <p>We operate with complete honesty and transparency, building trust through reliable service and ethical business practices.</p>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💚</div>
                    <h3>Community</h3>
                    <p>We're committed to making our community safer through responsible driver education and active participation in local safety initiatives.</p>
                </div>
            </div>
        </section>
        
        <!-- Meet Our Team -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem;">👥 Meet Our Expert Team</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; margin: 0 auto 2rem auto; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white;">👨‍💼</div>
                    <h3>Mike Johnson</h3>
                    <p style="color: var(--secondary-color); font-weight: 600; margin-bottom: 1rem;">Chief Instructor & Founder</p>
                    <p>With over 20 years of driving instruction experience and a background in traffic safety, Mike founded Origin Driving School to revolutionize driver education with a focus on safety and confidence building.</p>
                    <div style="margin: 1rem 0;">
                        <span style="background: var(--success-color); color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin: 0.2rem;">Certified Instructor</span>
                        <span style="background: var(--info-color); color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin: 0.2rem;">Safety Specialist</span>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 50%; margin: 0 auto 2rem auto; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white;">👩‍🏫</div>
                    <h3>Sarah Williams</h3>
                    <p style="color: var(--secondary-color); font-weight: 600; margin-bottom: 1rem;">Senior Driving Instructor</p>
                    <p>Sarah specializes in working with nervous and anxious drivers, using patience and proven techniques to build confidence behind the wheel. She has successfully trained over 3,000 students.</p>
                    <div style="margin: 1rem 0;">
                        <span style="background: var(--warning-color); color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin: 0.2rem;">Anxiety Specialist</span>
                        <span style="background: var(--success-color); color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin: 0.2rem;">15 Years Experience</span>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%); border-radius: 50%; margin: 0 auto 2rem auto; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white;">👨‍🏫</div>
                    <h3>David Chen</h3>
                    <p style="color: var(--secondary-color); font-weight: 600; margin-bottom: 1rem;">Technology & Innovation Director</p>
                    <p>David leads our technology initiatives and online learning platforms. He combines traditional driving instruction with modern digital tools to enhance the learning experience.</p>
                    <div style="margin: 1rem 0;">
                        <span style="background: var(--info-color); color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin: 0.2rem;">Tech Innovation</span>
                        <span style="background: var(--secondary-color); color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin: 0.2rem;">Digital Learning</span>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Our Facilities -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem;">🏢 Our Facilities & Fleet</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
                <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); padding: 2rem; border-radius: 15px;">
                    <h3>🚗 Modern Training Vehicles</h3>
                    <ul style="margin: 1rem 0;">
                        <li>Dual-control safety systems</li>
                        <li>Regular maintenance and safety inspections</li>
                        <li>Latest safety technology and features</li>
                        <li>Comfortable, stress-free learning environment</li>
                        <li>Variety of vehicle types for different learning needs</li>
                    </ul>
                </div>
                
                <div style="background: linear-gradient(135deg, #e7f3ff 0%, #cce7ff 100%); padding: 2rem; border-radius: 15px;">
                    <h3>🏫 Classroom Facilities</h3>
                    <ul style="margin: 1rem 0;">
                        <li>Modern, comfortable classrooms</li>
                        <li>Interactive learning technology</li>
                        <li>Small class sizes for personalized attention</li>
                        <li>Flexible scheduling options</li>
                        <li>Online learning platform access</li>
                    </ul>
                </div>
                
                <div style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); padding: 2rem; border-radius: 15px;">
                    <h3>🛣️ Practice Areas</h3>
                    <ul style="margin: 1rem 0;">
                        <li>Safe, controlled practice environments</li>
                        <li>Various road conditions and scenarios</li>
                        <li>Parking practice areas</li>
                        <li>Highway and city driving routes</li>
                        <li>Test route familiarization</li>
                    </ul>
                </div>
                
                <div style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); padding: 2rem; border-radius: 15px;">
                    <h3>💻 Digital Platform</h3>
                    <ul style="margin: 1rem 0;">
                        <li>24/7 online scheduling system</li>
                        <li>Progress tracking and reporting</li>
                        <li>Direct instructor communication</li>
                        <li>Digital learning materials</li>
                        <li>Mobile-friendly interface</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <!-- Why Choose Us -->
        <section style="margin: 4rem 0;">
            <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 3rem 2rem; border-radius: 20px; text-align: center;">
                <h2 style="margin-bottom: 2rem;">🌟 Why Choose Origin Driving School?</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin: 2rem 0;">
                    <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 15px;">
                        <h3>📊 Proven Results</h3>
                        <p>98% first-time pass rate and over 15,000 successful graduates speak to our effective teaching methods.</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 15px;">
                        <h3>👨‍🏫 Expert Instructors</h3>
                        <p>All our instructors are state-certified, experienced professionals committed to your success.</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 15px;">
                        <h3>🕐 Flexible Scheduling</h3>
                        <p>We work around your schedule with evening, weekend, and online learning options.</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 15px;">
                        <h3>💰 Fair Pricing</h3>
                        <p>Competitive rates with no hidden fees and flexible payment options available.</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 15px;">
                        <h3>🏆 Quality Guarantee</h3>
                        <p>We stand behind our instruction with a satisfaction guarantee and ongoing support.</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 15px;">
                        <h3>📱 Modern Technology</h3>
                        <p>State-of-the-art learning platform and vehicles equipped with the latest safety technology.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Call to Action -->
        <div style="text-align: center; margin: 4rem 0;">
            <h2 style="margin-bottom: 2rem;">🚗 Ready to Start Your Driving Journey?</h2>
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">Join thousands of satisfied students who have chosen Origin Driving School for their driver education needs.</p>
            <div>
                <a href="register.php" class="btn btn-success" style="margin: 0.5rem;">📝 Register Now</a>
                <a href="contact.php" class="btn" style="margin: 0.5rem;">📞 Contact Us</a>
                <a href="index.php#services" class="btn" style="margin: 0.5rem;">💰 View Pricing</a>
            </div>
        </div>
    </div>
    
<?php include 'includes/footer.php'; ?>
