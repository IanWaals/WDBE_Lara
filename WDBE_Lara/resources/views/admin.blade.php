<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vibes - Admin Products</title>
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
                <div class="admin-card">
                    <h2 class="admin-card__title">Add New Product</h2>
                    
                    <form class="admin-form" id="addProductForm">
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
                                    <option value="">Select a category</option>
                                    <option value="Rock">Rock</option>
                                    <option value="Pop">Pop</option>
                                    <option value="Jazz">Jazz</option>
                                    <option value="R&B">R&B</option>
                                    <option value="Electronic">Electronic</option>
                                    <option value="Classical">Classical</option>
                                    <option value="Hip-Hop">Hip-Hop</option>
                                    <option value="Country">Country</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="product-image" class="form-label">Album Cover Image</label>
                            <div class="file-upload-wrapper">
                                <input type="file" id="product-image" name="image" class="form-input-file" accept="image/*" required>
                                <label for="product-image" class="file-upload-label">
                                    <span class="file-upload-text">Choose Image</span>
                                    <span class="file-upload-name" id="fileName">No file chosen</span>
                                </label>
                            </div>
                            <div id="imagePreview" class="image-preview"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="product-description" class="form-label">Description</label>
                            <textarea id="product-description" name="description" class="form-textarea" placeholder="Enter product description..." rows="4" required></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button--primary">Add Product</button>
                            <button type="reset" class="button button--secondary">Clear Form</button>
                        </div>
                    </form>
                </div>

                <div class="admin-card">
                    <h2 class="admin-card__title">Manage Products</h2>
                    <div class="admin-products-list" id="productsList"></div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <p class="footer-copyright">&copy; 2025 Vinyl Vibes. All rights reserved.</p>
        </footer>
    </div>

    @include('components.loginregister')

    <!-- Edit Product Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="login-modal">
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
            <h2 class="login-modal__title">Edit Product</h2>
            <p class="login-modal__subtitle">Update product information</p>
            
            <form class="login-form" id="editProductForm">
                <div class="form-group">
                    <label for="edit-title" class="form-label">Album Title</label>
                    <input type="text" id="edit-title" name="title" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-artist" class="form-label">Artist Name</label>
                    <input type="text" id="edit-artist" name="artist" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-price" class="form-label">Price ($)</label>
                    <input type="number" id="edit-price" name="price" class="form-input" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-category" class="form-label">Category</label>
                    <select id="edit-category" name="category" class="form-input" required>
                        <option value="">Select a category</option>
                        <option value="Rock">Rock</option>
                        <option value="Pop">Pop</option>
                        <option value="Jazz">Jazz</option>
                        <option value="R&B">R&B</option>
                        <option value="Electronic">Electronic</option>
                        <option value="Classical">Classical</option>
                        <option value="Hip-Hop">Hip-Hop</option>
                        <option value="Country">Country</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit-description" class="form-label">Description</label>
                    <textarea id="edit-description" name="description" class="form-input" rows="3" required></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="button button--login">Update Product</button>
                    <button type="button" class="button button--secondary" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let products = [
            {
                id: 1,
                title: "Abbey Road",
                artist: "The Beatles",
                price: 29.99,
                category: "Rock",
                image: "https://via.placeholder.com/150x150?text=Abbey+Road",
                description: "The eleventh studio album by The Beatles, released in 1969."
            },
            {
                id: 2,
                title: "Thriller",
                artist: "Michael Jackson",
                price: 24.99,
                category: "Pop",
                image: "https://via.placeholder.com/150x150?text=Thriller",
                description: "The sixth studio album by Michael Jackson, released in 1982."
            },
            {
                id: 3,
                title: "Kind of Blue",
                artist: "Miles Davis",
                price: 22.99,
                category: "Jazz",
                image: "https://via.placeholder.com/150x150?text=Kind+of+Blue",
                description: "A studio album by Miles Davis, released in 1959."
            },
            {
                id: 4,
                title: "Back in Black",
                artist: "AC/DC",
                price: 27.50,
                category: "Rock",
                image: "https://via.placeholder.com/150x150?text=Back+in+Black",
                description: "The seventh studio album by AC/DC, released in 1980."
            }
        ];

        let nextId = 5;
        let editingId = null;

        function renderProducts() {
            const productsList = document.getElementById('productsList');
            
            if (products.length === 0) {
                productsList.innerHTML = '<p class="no-products">No products available. Add your first product above!</p>';
                return;
            }
            
            productsList.innerHTML = `
                <table class="admin-products-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${products.map(p => `
                            <tr>
                                <td><img src="${p.image}" alt="${p.title}" class="admin-products-table__image"></td>
                                <td>${p.title}</td>
                                <td>${p.artist}</td>
                                <td>${p.category}</td>
                                <td>$${p.price.toFixed(2)}</td>
                                <td>${p.description}</td>
                                <td>
                                    <button class="button button--edit" onclick="editProduct(${p.id})">Edit</button>
                                    <button class="button button--delete" onclick="deleteProduct(${p.id})">Delete</button>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
        }

        // Add new product
        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const productData = {
                id: nextId++,
                title: formData.get('title'),
                artist: formData.get('artist'),
                price: parseFloat(formData.get('price')),
                category: formData.get('category'),
                image: formData.get('image'),
                description: formData.get('description')
            };
            
            products.push(productData);
            showNotification('Product added successfully!');
            renderProducts();
            e.target.reset();
        });

        // Edit product - open modal
        function editProduct(id) {
            const product = products.find(p => p.id === id);
            if (!product) return;
            
            editingId = id;
            document.getElementById('edit-title').value = product.title;
            document.getElementById('edit-artist').value = product.artist;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-category').value = product.category;
            document.getElementById('edit-description').value = product.description;
            
            document.getElementById('editModal').classList.add('active');
        }

        // Update product
        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const index = products.findIndex(p => p.id === editingId);
            
            products[index] = {
                ...products[index],
                title: formData.get('title'),
                artist: formData.get('artist'),
                price: parseFloat(formData.get('price')),
                category: formData.get('category'),
                description: formData.get('description')
            };
            
            closeEditModal();
            renderProducts();
            showNotification('Product updated successfully!');
        });

        // Close edit modal
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            editingId = null;
        }

        // Delete product
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                products = products.filter(p => p.id !== id);
                renderProducts();
                showNotification('Product deleted successfully!');
            }
        }

        // Show notification
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.classList.add('notification--show'), 10);
            setTimeout(() => {
                notification.classList.remove('notification--show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Close modal on overlay click
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        renderProducts();
    </script>
</body>
</html>