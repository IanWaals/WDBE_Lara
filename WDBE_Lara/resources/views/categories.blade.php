<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vibes - Category Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="site-container">
        @include('components.navbar')

        <main class="main-content">
            <section class="hero-banner">
                <div class="hero-content">
                    <h1 class="hero-title">Category Management</h1>
                    <p class="hero-description">Manage music genres and categories</p>
                </div>
            </section>

            <section class="admin-section">
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
                    <h2 class="admin-card__title">Add New Category</h2>
                    
                    <form class="admin-form" action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="category-name" class="form-label">Category Name</label>
                            <input type="text" id="category-name" name="name" class="form-input" placeholder="e.g., Jazz, Rock, Hip-Hop" required>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button--primary">Add Category</button>
                        </div>
                    </form>
                </div>

                <div class="admin-card">
                    <h2 class="admin-card__title">Manage Categories</h2>
                    <div class="admin-products-list">
                        @if($categories->count() > 0)
                            <table class="admin-products-table">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Products Count</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr data-category-id="{{ $category->id }}">
                                            <td><strong>{{ $category->genreName }}</strong></td>
                                            <td>{{ $category->product_count }} products</td>
                                            <td>{{ date('M d, Y', strtotime($category->created_at)) }}</td>
                                            <td>
                                                <button class="button button--edit" onclick="editCategory({{ $category->id }}, '{{ addslashes($category->genreName) }}')">Edit</button>
                                                <button class="button button--delete" onclick="deleteCategory({{ $category->id }}, '{{ addslashes($category->genreName) }}', {{ $category->product_count }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="no-products">No categories available. Add your first category above!</p>
                        @endif
                    </div>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('admin') }}" class="button button--secondary">Back to Product Management</a>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <p class="footer-copyright">&copy; 2025 Vinyl Vibes. All rights reserved.</p>
        </footer>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="login-modal">
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
            <h2 class="login-modal__title">Edit Category</h2>
            <p class="login-modal__subtitle">Update category name</p>
            
            <form class="login-form" id="editCategoryForm">
                @csrf
                <input type="hidden" id="edit-category-id">
                
                <div class="form-group">
                    <label for="edit-name" class="form-label">Category Name</label>
                    <input type="text" id="edit-name" name="name" class="form-input" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="button button--login">Update Category</button>
                    <button type="button" class="button button--secondary" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function editCategory(id, name) {
        document.getElementById('edit-category-id').value = id;
        document.getElementById('edit-name').value = name;
        document.getElementById('editModal').classList.add('active');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const categoryId = document.getElementById('edit-category-id').value;
        const name = document.getElementById('edit-name').value;
        
        fetch(`/admin/categories/${categoryId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name, _method: 'PUT' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeEditModal();
                showNotification(data.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message || 'Error updating category', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating category: ' + error.message, 'error');
        });
    });

    function deleteCategory(id, name, productCount) {
        let confirmMsg = `Are you sure you want to delete the "${name}" category?`;
        if (productCount > 0) {
            confirmMsg += `\n\nWARNING: This will also delete ${productCount} product(s) and all their images!`;
        }
        
        if (confirm(confirmMsg)) {
            fetch(`/admin/categories/${id}`, {
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
                    const row = document.querySelector(`tr[data-category-id="${id}"]`);
                    if (row) row.remove();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(data.message || 'Error deleting category', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error deleting category: ' + error.message, 'error');
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