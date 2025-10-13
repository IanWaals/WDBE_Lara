<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vibes - Home</title>
    @vite('resources/css/app.css')
    
</head>
<body>
    <div class="site-container">
        @include('components.navbar')

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Hero Banner Section -->
            <section class="hero-banner hero-banner--large">
                <div class="hero-content">
                    <h1 class="hero-title">Discover Your Favorite Vinyls</h1>
                    <p class="hero-description">Collect timeless music on vinyl records</p>
                    <a href="/products" class="button button--primary">Explore Collection</a>
                </div>
            </section>

            <!-- Featured Vinyl Records Section -->
            <section class="featured-vinyl-section">
                <h2 class="section-title">Featured This Week</h2>
                <p class="section-subtitle">Handpicked selections rotating daily</p>
                
                @php
                    $vinylCatalog = [
                        [
                            "title" => "Abbey Road",
                            "artist" => "The Beatles",
                            "price" => 29.99,
                            "category" => "Rock",
                            "image" => "https://via.placeholder.com/300x300?text=Abbey+Road",
                            "description" => "The eleventh studio album by The Beatles, featuring iconic tracks like 'Come Together' and 'Here Comes the Sun'. This masterpiece showcases the band's musical maturity and remains one of the best-selling albums of all time."
                        ],
                        [
                            "title" => "Thriller",
                            "artist" => "Michael Jackson",
                            "price" => 24.99,
                            "category" => "Pop",
                            "image" => "https://via.placeholder.com/300x300?text=Thriller",
                            "description" => "The best-selling album of all time, Thriller revolutionized pop music with its innovative production and unforgettable hits. Features classics like 'Billie Jean', 'Beat It', and the title track 'Thriller'."
                        ],
                        [
                            "title" => "Back in Black",
                            "artist" => "AC/DC",
                            "price" => 27.50,
                            "category" => "Rock",
                            "image" => "https://via.placeholder.com/300x300?text=Back+in+Black",
                            "description" => "A tribute to their late lead singer Bon Scott, this hard rock masterpiece features powerful riffs and anthemic choruses. Home to classics like 'You Shook Me All Night Long' and the title track."
                        ],
                        [
                            "title" => "Kind of Blue",
                            "artist" => "Miles Davis",
                            "price" => 22.99,
                            "category" => "Jazz",
                            "image" => "https://via.placeholder.com/300x300?text=Kind+of+Blue",
                            "description" => "Regarded as one of the greatest jazz albums ever made, this modal jazz masterpiece features an all-star lineup including John Coltrane and Bill Evans. A timeless exploration of improvisation and melody."
                        ],
                        [
                            "title" => "Nevermind",
                            "artist" => "Nirvana",
                            "price" => 28.50,
                            "category" => "Rock",
                            "image" => "https://via.placeholder.com/300x300?text=Nevermind",
                            "description" => "The album that brought grunge to the mainstream, featuring the iconic 'Smells Like Teen Spirit'. Nevermind captures the raw energy and angst of a generation with its powerful lyrics and distorted guitars."
                        ],
                        [
                            "title" => "The Miseducation",
                            "artist" => "Lauryn Hill",
                            "price" => 26.99,
                            "category" => "R&B",
                            "image" => "https://via.placeholder.com/300x300?text=Lauryn+Hill",
                            "description" => "Lauryn Hill's groundbreaking debut solo album blends R&B, hip-hop, soul, and reggae. Winner of five Grammy Awards, it features deeply personal lyrics and innovative production that influenced a generation."
                        ],
                        [
                            "title" => "Electric Ladyland",
                            "artist" => "Jimi Hendrix",
                            "price" => 30.00,
                            "category" => "Electronic",
                            "image" => "https://via.placeholder.com/300x300?text=Electric+Ladyland",
                            "description" => "Jimi Hendrix's psychedelic rock masterpiece showcases his innovative guitar work and experimental production. Features the epic 'Voodoo Child' and demonstrates Hendrix's genius as both performer and producer."
                        ],
                        [
                            "title" => "AM",
                            "artist" => "Arctic Monkeys",
                            "price" => 29.00,
                            "category" => "Rock",
                            "image" => "https://via.placeholder.com/300x300?text=Arctic+Monkeys+AM",
                            "description" => "Arctic Monkeys' fifth studio album features a darker, more mature sound with heavy riffs and hip-hop influences. Home to hits like 'Do I Wanna Know?' and 'R U Mine?', it's their most commercially successful release."
                        ]
                    ];
                    
                    // Randomize the catalog and select featured items
                    shuffle($vinylCatalog);
                    $featuredVinylRecords = array_slice($vinylCatalog, 0, 6);
                @endphp

                <div class="product-catalog-grid">
                    @foreach($featuredVinylRecords as $index => $vinylRecord)
                    <article class="product-card">
                        <img 
                            src="{{ $vinylRecord['image'] }}" 
                            alt="{{ $vinylRecord['title'] }} album cover"
                            class="product-card__image"
                        >
                        <div class="product-card__info">
                            <div class="product-card__header">
                                <h2 class="product-card__title">{{ $vinylRecord['title'] }}</h2>
                                <p class="product-card__artist">{{ $vinylRecord['artist'] }}</p>
                                <p class="product-card__category">{{ $vinylRecord['category'] }}</p>
                            </div>
                            <div class="product-card__footer">
                                <p class="product-card__price">${{ number_format($vinylRecord['price'], 2) }}</p>
                                <!-- Replace the product card actions section in your home page -->
                            <div class="product-card__actions">
                            <button onclick="addToCart('{{ addslashes($vinylRecord['title']) }}', '{{ addslashes($vinylRecord['artist']) }}', '{{ $vinylRecord['price'] }}', '{{ $vinylRecord['image'] }}')" class="button button--add-to-cart">Add to Basket</button>
                            <button onclick="showVinylInfo('{{ addslashes($vinylRecord['title']) }}', '{{ addslashes($vinylRecord['artist']) }}', '{{ $vinylRecord['price'] }}', '{{ addslashes($vinylRecord['category']) }}', '{{ $vinylRecord['image'] }}', '{{ addslashes($vinylRecord['description']) }}')" class="button button--info">info</button>
                            </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="section-cta">
                    <a href="/products" class="button button--secondary">View Full Collection</a>
                </div>
            </section>
        </main>

        @include('components.footer')
    </div>

    <!-- Info Modal -->
    <div id="vinylInfoModal" class="modal-overlay" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 id="modalTitle">Vinyl Information</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="" class="modal-image">
                
                <div class="modal-info-section">
                    <div class="modal-info-label">Album Title</div>
                    <div class="modal-info-value" id="modalAlbumTitle"></div>
                </div>

                <div class="modal-info-section">
                    <div class="modal-info-label">Artist</div>
                    <div class="modal-info-value" id="modalArtist"></div>
                </div>

                <div class="modal-info-section">
                    <div class="modal-info-label">Category</div>
                    <div class="modal-info-value" id="modalCategory"></div>
                </div>

                <div class="modal-price" id="modalPrice"></div>

                <div class="modal-info-section">
                    <div class="modal-info-label">About This Album</div>
                    <div class="modal-description" id="modalDescription"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showVinylInfo(title, artist, price, category, image, description) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalAlbumTitle').textContent = title;
            document.getElementById('modalArtist').textContent = artist;
            document.getElementById('modalCategory').textContent = category;
            document.getElementById('modalPrice').textContent = '$' + parseFloat(price).toFixed(2);
            document.getElementById('modalImage').src = image;
            document.getElementById('modalImage').alt = title + ' album cover';
            document.getElementById('modalDescription').textContent = description;
            
            document.getElementById('vinylInfoModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(event) {
            if (!event || event.target.id === 'vinylInfoModal') {
                document.getElementById('vinylInfoModal').classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>