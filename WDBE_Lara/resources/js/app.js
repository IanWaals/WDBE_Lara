import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Add to cart function
function addToCart(title, artist, price, image) {
    // Your cart logic here
    console.log('Added to cart:', title);
    alert(`Added "${title}" by ${artist} to your basket!`);
}

// Show vinyl info modal
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

// Close modal
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