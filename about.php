<?php
include 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<link rel="stylesheet" href="assets/css/about.css">

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <h1>About Intern Hub</h1>
        <p>Your gateway to the perfect internship opportunity</p>
    </div>
</section>

<!-- ABOUT CONTENT -->
<section class="about-content">
    <div class="container">
        
        <!-- Mission Section -->
        <div class="about-section">
            <div class="section-title centered">
                <h2>Our Mission</h2>
            </div>
            <p>
                Intern Hub is dedicated to bridging the gap between talented students and leading companies. 
                We believe that internships are crucial for career development and skill enhancement. Our platform 
                makes it easy for students to discover, apply, and secure internships that align with their career goals.
            </p>
        </div>

        <!-- Features Section -->
        <div class="about-section">
            <div class="section-title centered">
                <h2>Why Choose Intern Hub?</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <h3>Wide Selection</h3>
                    <p>Explore 1500+ internship opportunities across multiple domains and industries.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <h3>Top Companies</h3>
                    <p>Get connected with 250+ leading companies actively hiring for internships.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <h3>Profile Management</h3>
                    <p>Create a comprehensive profile and showcase your skills to employers.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <h3>Save & Track</h3>
                    <p>Save your favorite internships and track your applications in one place.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3>Career Growth</h3>
                    <p>Gain real-world experience and enhance your resume with valuable internship opportunities.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-message"></i>
                    </div>
                    <h3>Support</h3>
                    <p>Get 24/7 support from our team to help you through your internship journey.</p>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="about-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>1500+</h3>
                    <p>Active Internships</p>
                </div>
                <div class="stat-item">
                    <h3>250+</h3>
                    <p>Partner Companies</p>
                </div>
                <div class="stat-item">
                    <h3>5000+</h3>
                    <p>Registered Students</p>
                </div>
                <div class="stat-item">
                    <h3>15+</h3>
                    <p>Career Domains</p>
                </div>
            </div>
        </div>

        <!-- How It Works -->
        <div class="about-section">
            <div class="section-title centered">
                <h2>How It Works</h2>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Register</h3>
                    <p>Create an account and complete your profile with your skills and experience.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Explore</h3>
                    <p>Browse through thousands of internship opportunities across various domains.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Apply</h3>
                    <p>Submit your application to the internships that match your interests.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h3>Get Selected</h3>
                    <p>Hear back from companies and secure your ideal internship opportunity.</p>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="about-section cta-section">
            <div class="section-title centered">
                <h2>Have Questions?</h2>
                <p>Get in touch with our support team</p>
            </div>
            <a href="contact.php" class="btn-primary btn-large">Contact Us</a>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
