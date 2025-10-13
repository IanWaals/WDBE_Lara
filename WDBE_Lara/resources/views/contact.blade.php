<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vibes - Contact</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="site-container">
        @include('components.navbar')

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Hero Banner Section -->
            <section class="hero-banner">
                <div class="hero-content">
                    <h1 class="hero-title">Get in Touch</h1>
                    <p class="hero-description">We'd love to hear from you</p>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="contact-section">
                <div class="contact-grid">
                    <!-- Contact Form -->
                    <div class="contact-form-card">
                        <h2 class="contact-card__title">Send Us a Message</h2>
                        <p class="contact-card__subtitle">Fill out the form below and we'll get back to you shortly</p>
                        
                        <form class="contact-form" method="POST" action="/contact">
                            @csrf
                            
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    class="form-input" 
                                    placeholder="John Doe"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-input" 
                                    placeholder="john@example.com"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="subject" class="form-label">Subject</label>
                                <input 
                                    type="text" 
                                    id="subject" 
                                    name="subject" 
                                    class="form-input" 
                                    placeholder="How can we help you?"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="message" class="form-label">Message</label>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    class="form-textarea" 
                                    rows="6" 
                                    placeholder="Tell us what's on your mind..."
                                    required
                                ></textarea>
                            </div>

                            <button type="submit" class="button button--primary button--full-width">
                                Send Message
                            </button>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="contact-info-card">
                        <h2 class="contact-card__title">Contact Information</h2>
                        <p class="contact-card__subtitle">Reach out to us through any of these channels</p>
                        
                        <div class="contact-info-list">
                            <div class="contact-info-item">
                                <div class="contact-info-icon">📧</div>
                                <div class="contact-info-content">
                                    <h3 class="contact-info-title">Email Us</h3>
                                    <p class="contact-info-text">info@vinylvibes.com<br>support@vinylvibes.com</p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-info-icon">📞</div>
                                <div class="contact-info-content">
                                    <h3 class="contact-info-title">Call Us</h3>
                                    <p class="contact-info-text">+1 (555) 123-4567<br>Mon-Fri: 9AM - 6PM</p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-info-icon">🕒</div>
                                <div class="contact-info-content">
                                    <h3 class="contact-info-title">Business Hours</h3>
                                    <p class="contact-info-text">Monday - Friday: 9AM - 6PM<br>Saturday: 10AM - 4PM<br>Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="contact-faq">
                    <h2 class="contact-card__title">Frequently Asked Questions</h2>
                    <div class="faq-grid">
                        <div class="faq-item">
                            <h3 class="faq-question">Do you ship internationally?</h3>
                            <p class="faq-answer">Yes! We ship vinyl records worldwide. Shipping costs vary by location.</p>
                        </div>
                        <div class="faq-item">
                            <h3 class="faq-question">What is your return policy?</h3>
                            <p class="faq-answer">We accept returns within 30 days of purchase in original condition.</p>
                        </div>
                        <div class="faq-item">
                            <h3 class="faq-question">How do I track my order?</h3>
                            <p class="faq-answer">You'll receive a tracking number via email once your order ships.</p>
                        </div>
                        <div class="faq-item">
                            <h3 class="faq-question">Are the vinyls new or used?</h3>
                            <p class="faq-answer">We sell both new and carefully curated vintage vinyl records.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('components.footer')
    </div>

    <!-- Success Notification -->
    <div id="successNotification" class="notification">
        Message sent successfully! We'll get back to you soon.
    </div>

    <script>
        // Handle fake form submission
        document.querySelector('.contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form fields
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            
            // Simulate sending form 
            console.log('Form Data:', { name, email, subject, message });
            
            // Show success notification
            const notification = document.getElementById('successNotification');
            notification.classList.add('notification--show');
            
            // Reset form
            this.reset();
            
            // Hide notification after 3 seconds
            setTimeout(function() {
                notification.classList.remove('notification--show');
            }, 3000);
        });
    </script>
</body>
</html>
