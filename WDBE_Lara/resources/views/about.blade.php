<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vibes - About Us</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="site-container">
        <!-- Navigation Header -->
        @include('components.navbar')

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Hero Banner Section -->
            <section class="hero-banner">
                <div class="hero-content">
                    <h1 class="hero-title">About Vinyl Vibes</h1>
                    <p class="hero-description">Preserving the authentic sound of music since 2015</p>
                </div>
            </section>

            <!-- About Content Section -->
            <section class="about-section">
                <!-- Our Story -->
                <div class="about-content">
                    <h2>Our Story</h2>
                    <p>
                        Vinyl Vibes was born from a deep passion for authentic music experiences. Founded in 2015, we started as a small record shop in the heart of the city, driven by the belief that music sounds better on vinyl. What began as a personal collection shared among friends has grown into a thriving community of music enthusiasts.
                    </p>
                    <p>
                        Today, we curate one of the most diverse vinyl collections available, spanning decades of musical history. From classic rock to contemporary jazz, from underground hip-hop to timeless soul, we believe every album tells a story worth preserving.
                    </p>
                </div>

                <!-- Our Mission -->
                <div class="about-content">
                    <h2>Our Mission</h2>
                    <p>
                        At Vinyl Vibes, we're dedicated to keeping the art of vinyl alive. We believe in the warmth of analog sound, the ritual of playing records, and the tangible connection between artist and listener that only physical media can provide.
                    </p>
                    <p>
                        Our mission is to make quality vinyl accessible to everyone, from seasoned collectors to those just discovering the joy of records. We carefully select each album in our collection, ensuring authenticity and sound quality that honors the original recordings.
                    </p>
                </div>

                <!-- Our Values -->
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">🎵</div>
                        <h3>Quality First</h3>
                        <p>Every record is carefully inspected and graded to ensure you receive the best listening experience possible.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">🌍</div>
                        <h3>Sustainability</h3>
                        <p>We promote sustainable consumption by giving new life to vintage records and supporting eco-friendly packaging.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">❤️</div>
                        <h3>Community</h3>
                        <p>Music brings people together. We foster a passionate community of collectors, artists, and music lovers.</p>
                    </div>
                </div>

                <!-- Team Section -->
                <div class="team-section">
                    <h2>Meet Our Team</h2>
                    <div class="team-grid">
                        <div class="team-member">
                            <div class="team-member-avatar">LK</div>
                            <h4>Lucas Knol</h4>
                            <p>Founder</p>
                        </div>
                        <div class="team-member">
                            <div class="team-member-avatar">IW</div>
                            <h4>Ian Waals</h4>
                            <p>Founder</p>
                        </div>
                        
                    </div>
                </div>
            </section>
        </main>

        <!-- Site Footer -->
        <footer class="site-footer">
            <p class="footer-copyright">&copy; 2025 Vinyl Vibes. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>