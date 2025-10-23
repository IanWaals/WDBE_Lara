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
                    // Fetch products from database
                    $products = DB::table('products')
                        ->where('stock', '>', 0)
                        ->inRandomOrder()
                        ->limit(6)
                        ->get();
                    
                    // Map database fields to display format
                    $featuredVinylRecords = $products->map(function($product) {
                        return [
                            'id' => $product->id,
                            'title' => $product->productName,
                            'artist' => $product->Artist,
                            'price' => $product->Price,
                            'category' => $product->genre,
                            'image' => asset('images/album-cover/' . $product->productName . '.jpg'),
                            'description' => "Album featuring {$product->songAmount} tracks. Available in stock: {$product->stock} units.",
                            'songAmount' => $product->songAmount,
                            'stock' => $product->stock
                        ];
                    })->toArray();
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
                                <div class="product-card__actions">
                                    @if(Session::has('user_id'))
                                        <button onclick="addToCart('{{ addslashes($vinylRecord['title']) }}', '{{ addslashes($vinylRecord['artist']) }}', '{{ $vinylRecord['price'] }}', '{{ $vinylRecord['image'] }}')" class="button button--add-to-cart">Add to Basket</button>
                                    @endif
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