<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vibes - Admin Products</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="site-container">
        @include('components.navbar')

        <main class="main-content">
            <section class="hero-banner">
                <div class="hero-content">
                    <h1 class="hero-title">Product Management</h1>
                    <p class="hero-description">Add, edit, and manage your vinyl collection</p>
                </div>
            </section>

            <section class="admin-section">
                <div style="text-align: center; margin-bottom: 20px;">
                    <a href="{{ route('admin.categories') }}" class="button button--secondary">Manage Categories</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success" style="padding: 1rem; margin-bottom: 1rem; background: #4ade80; color: white; border-radius: 0.5rem;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error" style="padding: 1rem; margin-bottom: 1rem; background: #ef4444; color: white; border-radius: 0.5rem;">
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="admin-card">
                    <h2 class="admin-card__title">Add New Product</h2>
                    
                    <form class="admin-form" id="addProductForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="admin-form-grid">
                            <div class="form-group">
                                <label for="product-title" class="form-label">Album Title</label>
                                <input type="text" id="product-title" name="title" class="form-input" placeholder="e.g., Abbey Road" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="product-artist" class="form-label">Artist Name</label>
                                <input type="text" id="product-artist" name="artist" class="form-input" placeholder="e.g., The Beatles" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="product-price" class="form-label">Price ($)</label>
                                <input type="number" id="product-price" name="price" class="form-input" placeholder="29.99" step="0.01" min="0" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="product-category" class="form-label">Category</label>
                                <select id="product-category" name="category" class="form-input" required>
                                    @php
                                        $genres = \App\Models\Genre::all()->pluck('genreName')->toArray();
                                    @endphp
                                    @foreach($genres as $categoryName)
                                        <option value="{{ $categoryName }}">{{ $categoryName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="product-songs" class="form-label">Amount of songs</label>
                                <input type="number" id="product-songs" name="songs" class="form-input" placeholder="e.g., 14" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="product-stock" class="form-label">Amount of items in stock</label>
                                <input type="number" id="product-stock" name="stock" class="form-input" placeholder="e.g., 55" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product-description" class="form-label">Description</label>
                            <textarea id="product-description" name="description" class="form-textarea" rows="4" placeholder="Enter product description..." required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="product-images" class="form-label">Album Cover Images (Multiple allowed)</label>
                            <div class="file-upload-wrapper">
                                <input type="file" id="product-images" name="images[]" class="form-input-file" accept="image/*" multiple required>
                                <label for="product-images" class="file-upload-label">
                                    <span class="file-upload-text">Choose Images</span>
                                    <span class="file-upload-name" id="fileName">No files chosen</span>
                                </label>
                            </div>
                            <div id="imagePreview" class="image-preview" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px;"></div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button--primary">Add Product</button>
                            <button type="reset" class="button button--secondary">Clear Form</button>
                        </div>
                    </form>
                </div>

                <div class="admin-card">
                    <h2 class="admin-card__title">Manage Products</h2>
                    <div class="admin-products-list" id="productsList">
                        @if($products->count() > 0)
                            <table class="admin-products-table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Artist</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Songs</th>
                                        <th>Stock</th>
                                        <th>Sold</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr data-product-id="{{ $product->id }}">
                                            <td>{{ $product->productName }}</td>
                                            <td>{{ $product->Artist }}</td>
                                            <td>{{ $product->genre }}</td>
                                            <td>${{ number_format($product->Price, 2) }}</td>
                                            <td>{{ $product->songAmount }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ $product->sold }}</td>
                                            <td>
                                                <button class="button button--edit" onclick="editProduct({{ $product->id }})">Edit</button>
                                                <button class="button button--delete" onclick="deleteProduct({{ $product->id }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="no-products">No products available. Add your first product above!</p>
                        @endif
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <p class="footer-copyright">&copy; 2025 Vinyl Vibes. All rights reserved.</p>
        </footer>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="login-modal">
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
            <h2 class="login-modal__title">Edit Product</h2>
            <p class="login-modal__subtitle">Update product information</p>
            
            <form class="login-form" id="editProductForm">
                @csrf
                <input type="hidden" id="edit-product-id" name="product_id">
                
                <div class="form-group">
                    <label for="edit-title" class="form-label">Album Title</label>
                    <input type="text" id="edit-title" name="title" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-artist" class="form-label">Artist Name</label>
                    <input type="text" id="edit-artist" name="artist" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="edit-description" class="form-label">Description</label>
                    <textarea id="edit-description" name="description" class="form-textarea" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit-price" class="form-label">Price ($)</label>
                    <input type="number" id="edit-price" name="price" class="form-input" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-category" class="form-label">Category</label>
                    <select id="edit-category" name="category" class="form-input" required>
                        @foreach($genres as $categoryName)
                            <option value="{{ $categoryName }}">{{ $categoryName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit-songs" class="form-label">Amount of songs</label>
                    <input type="number" id="edit-songs" name="songs" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-stock" class="form-label">Amount of items in stock</label>
                    <input type="number" id="edit-stock" name="stock" class="form-input" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="button button--login">Update Product</button>
                    <button type="button" class="button button--secondary" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const productsData = @json($products);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Multiple image preview
    document.getElementById('product-images').addEventListener('change', function(e) {
        const files = e.target.files;
        const fileCount = files.length;
        document.getElementById('fileName').textContent = fileCount > 0 ? `${fileCount} file(s) selected` : 'No files chosen';
        
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'max-width: 150px; max-height: 150px; border-radius: 8px; border: 2px solid #248232; object-fit: cover;';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    function editProduct(id) {
        const product = productsData.find(p => p.productID == id || p.id == id);
        
        if (!product) {
            showNotification('Product not found', 'error');
            return;
        }
        
        document.getElementById('edit-product-id').value = product.productID || product.id;
        document.getElementById('edit-title').value = product.productName;
        document.getElementById('edit-artist').value = product.Artist;
        document.getElementById('edit-description').value = product.description || '';
        document.getElementById('edit-price').value = product.Price;
        document.getElementById('edit-category').value = product.genre;
        document.getElementById('edit-songs').value = product.songAmount;
        document.getElementById('edit-stock').value = product.stock;
        
        document.getElementById('editModal').classList.add('active');
    }

    document.getElementById('editProductForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productId = document.getElementById('edit-product-id').value;
        const formData = new FormData(e.target);
        
        const data = {
            title: formData.get('title'),
            artist: formData.get('artist'),
            description: formData.get('description'),
            price: formData.get('price'),
            category: formData.get('category'),
            songs: formData.get('songs'),
            stock: formData.get('stock'),
            _method: 'PUT'
        };
        
        fetch(`/admin/products/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeEditModal();
                showNotification(data.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message || 'Error updating product', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating product: ' + error.message, 'error');
        });
    });

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product? This will also delete all associated images.')) {
            fetch(`/admin/products/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    const row = document.querySelector(`tr[data-product-id="${id}"]`);
                    if (row) row.remove();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message || 'Error deleting product', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error deleting product: ' + error.message, 'error');
            });
        }
    }

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
            background: ${type === 'success' ? '#4ade80' : '#ef4444'};
            color: white; border-radius: 0.5rem; z-index: 10000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.3s;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.style.opacity = '1', 10);
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });
    </script>
</body>
</html>