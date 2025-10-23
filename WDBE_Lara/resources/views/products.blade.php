<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vibes - Shop</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="site-container">
        @include('components.navbar')

        <main class="main-content">
            <!-- Category Filter Section -->
            <section class="category-filter-section">
                <h2 class="section-title">Browse by Category</h2>
                <div class="category-filter-grid">
                    @php
                        // Fetch all genres from database and get their names
                        $availableCategories = ['All']; // Start with 'All'
                        $genres = \App\Models\Genre::all()->pluck('genreName')->toArray();
                        $availableCategories = array_merge($availableCategories, $genres);
                    @endphp
                    @foreach($availableCategories as $categoryName)
                    <button 
                        class="category-filter-button {{ $categoryName === 'All' ? 'active' : '' }}" 
                        data-category="{{ $categoryName }}"
                        aria-label="Filter by {{ $categoryName }}"
                        onclick="filterByCategory('{{ $categoryName }}')"
                    >
                        {{ $categoryName }}
                    </button>
                    @endforeach
                </div>
            </section>

            <!-- Product Catalog Section -->
            <section id="shop" class="product-catalog-section">
                @php
                    // Fetch all products from database
                    $products = DB::table('products')
                        ->where('stock', '>', 0)
                        ->get();
                    
                    // Map database fields to display format
                    $vinylProductCatalog = $products->map(function($product) {
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
                    @foreach($vinylProductCatalog as $productItem)
                    <article class="product-card" data-category="{{ $productItem['category'] }}">
                        <img 
                            src="{{ $productItem['image'] }}" 
                            alt="{{ $productItem['title'] }} album cover"
                            class="product-card__image"
                        >
                        <div class="product-card__info">
                            <div class="product-card__header">
                                <h2 class="product-card__title">{{ $productItem['title'] }}</h2>
                                <p class="product-card__artist">{{ $productItem['artist'] }}</p>
                                <p class="product-card__category">{{ $productItem['category'] }}</p>
                            </div>
                            <div class="product-card__footer">
                                <p class="product-card__price">${{ number_format($productItem['price'], 2) }}</p>
                                <div class="product-card__actions">
                                    @if(Session::has('user_id'))
                                        <button onclick="addToCart('{{ addslashes($productItem['title']) }}', '{{ addslashes($productItem['artist']) }}', '{{ $productItem['price'] }}', '{{ $productItem['image'] }}')" class="button button--add-to-cart">Add to Basket</button>
                                    @endif
                                    <button onclick="showVinylInfo('{{ addslashes($productItem['title']) }}', '{{ addslashes($productItem['artist']) }}', '{{ $productItem['price'] }}', '{{ addslashes($productItem['category']) }}', '{{ $productItem['image'] }}', '{{ addslashes($productItem['description']) }}')" class="button button--info">Info</button>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
        </main>

        @include('components.footer')
    </div>

    <!-- Vinyl Info Modal -->
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
        function filterByCategory(category) {
            const productCards = document.querySelectorAll('.product-card');
            const filterButtons = document.querySelectorAll('.category-filter-button');
            
            // Update active button
            filterButtons.forEach(button => {
                if (button.dataset.category === category) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            });
            
            // Filter products
            productCards.forEach(card => {
                if (category === 'All' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
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