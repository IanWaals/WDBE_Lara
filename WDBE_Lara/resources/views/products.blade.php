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
                        $availableCategories = [
                            'All','Rap/HipHop','Rock','Heavy Metal','Pop',
                            'R&B','Soul','Country','Electronic','Jazz','Classical'
                        ];
                    @endphp
                    @foreach($availableCategories as $categoryName)
                    <button 
                        class="category-filter-button" 
                        data-category="{{ $categoryName }}"
                        aria-label="Filter by {{ $categoryName }}"
                    >
                        {{ $categoryName }}
                    </button>
                    @endforeach
                </div>
            </section>

            <!-- Product Catalog Section -->
            <section id="shop" class="product-catalog-section">
                @php
                    $vinylProductCatalog = [
                        [
                            "title" => "Abbey Road",
                            "artist" => "The Beatles",
                            "price" => 29.99,
                            "category" => "Rock",
                            "image" => "https://via.placeholder.com/300x300?text=Abbey+Road",
                            "description" => "The eleventh studio album by The Beatles, featuring 'Come Together' and 'Here Comes the Sun'."
                        ],
                        [
                            "title" => "Thriller",
                            "artist" => "Michael Jackson",
                            "price" => 24.99,
                            "category" => "Pop",
                            "image" => "https://via.placeholder.com/300x300?text=Thriller",
                            "description" => "The best-selling album ever, including 'Billie Jean' and 'Beat It'."
                        ],
                        [
                            "title" => "Back in Black",
                            "artist" => "AC/DC",
                            "price" => 27.50,
                            "category" => "Rock",
                            "image" => "https://via.placeholder.com/300x300?text=Back+in+Black",
                            "description" => "A hard rock classic dedicated to Bon Scott. Features 'You Shook Me All Night Long'."
                        ],
                        [
                            "title" => "Kind of Blue",
                            "artist" => "Miles Davis",
                            "price" => 22.99,
                            "category" => "Jazz",
                            "image" => "https://via.placeholder.com/300x300?text=Kind+of+Blue",
                            "description" => "A timeless jazz masterpiece featuring John Coltrane and Bill Evans."
                        ],
                        [
                            "title" => "Nevermind",
                            "artist" => "Nirvana",
                            "price" => 28.50,
                            "category" => "Rock",
                            "image" => "https://via.placeholder.com/300x300?text=Nevermind",
                            "description" => "The grunge-defining album that changed rock forever. Includes 'Smells Like Teen Spirit'."
                        ],
                        [
                            "title" => "The Miseducation",
                            "artist" => "Lauryn Hill",
                            "price" => 26.99,
                            "category" => "R&B",
                            "image" => "https://via.placeholder.com/300x300?text=Lauryn+Hill",
                            "description" => "A groundbreaking fusion of soul, R&B, and hip-hop that won 5 Grammys."
                        ],
                        [
                            "title" => "Electric Ladyland",
                            "artist" => "Jimi Hendrix",
                            "price" => 30.00,
                            "category" => "Electronic",
                            "image" => "https://via.placeholder.com/300x300?text=Electric+Ladyland",
                            "description" => "Hendrix's psychedelic masterpiece featuring 'Voodoo Child'."
                        ],
                        [
                            "title" => "AM",
                            "artist" => "Arctic Monkeys",
                            "price" => 29.00,
                            "category" => "Rock",
                            "image" => "https://via.placeholder.com/300x300?text=Arctic+Monkeys+AM",
                            "description" => "A modern rock gem with 'Do I Wanna Know?' and 'R U Mine?'."
                        ]
                    ];
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
                                    <button onclick="addToCart('{{ addslashes($productItem['title']) }}', '{{ addslashes($productItem['artist']) }}', '{{ $productItem['price'] }}', '{{ $productItem['image'] }}')" class="button button--add-to-cart">Add to Basket</button>
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
                <div class="
