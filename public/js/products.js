/**
 * Product Pages JavaScript
 * Handles all interactive functionality for product listing and detail pages
 */

// Product Listing Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeProductListing();
    initializeProductDetail();
    initializeCommonFunctionality();
});

/**
 * Initialize product listing page functionality
 */
function initializeProductListing() {
    // Filter functionality
    const filterForm = document.getElementById('filter-form');
    const applyFiltersBtn = document.getElementById('apply-filters');
    const clearFiltersBtn = document.getElementById('clear-filters');
    
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
            applyFilters();
        });
    }
    
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            filterForm.reset();
            applyFilters();
        });
    }
    
    // Auto-apply filters on change
    const filterElements = document.querySelectorAll('.filter-select, .filter-input');
    filterElements.forEach(element => {
        element.addEventListener('change', function() {
            applyFilters();
        });
    });
    
    // Add to cart functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart')) {
            e.preventDefault();
            
            const plantId = e.target.dataset.plantId;
            const button = e.target;
            
            if (button.disabled) return;
            
            addToCart(plantId, button);
        }
    });
    
    // Quick view (eye icon) - navigate to product details
    document.addEventListener('click', function(e) {
        const quickViewBtn = e.target.closest('.quick-view');
        if (quickViewBtn) {
            e.preventDefault();
            const plantId = quickViewBtn.dataset.plantId;
            window.location.href = `/products/${plantId}`;
        }
    });

    // Wishlist functionality
    document.addEventListener('click', function(e) {
        const wishlistBtn = e.target.closest('.wishlist-btn');
        if (wishlistBtn) {
            e.preventDefault();
            
            const plantId = wishlistBtn.dataset.plantId;
            const icon = wishlistBtn.querySelector('i');
            
            toggleWishlist(plantId, icon);
        }
    });
}

/**
 * Apply filters and update URL
 */
function applyFilters() {
    const filterForm = document.getElementById('filter-form');
    if (!filterForm) return;
    
    const formData = new FormData(filterForm);
    const params = new URLSearchParams();
    
    for (let [key, value] of formData.entries()) {
        if (value) {
            params.append(key, value);
        }
    }
    
    const url = params.toString() ? `/products?${params.toString()}` : '/products';
    window.location.href = url;
}

/**
 * Initialize product detail page functionality
 */
function initializeProductDetail() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active classes from all buttons and contents
            tabButtons.forEach(btn => {
                btn.classList.remove('border-green-500', 'text-green-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Add active classes to clicked button and corresponding content
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-green-500', 'text-green-600');
            
            const targetContent = document.getElementById(targetTab + '-tab');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });

    // Auto-activate tab from URL hash (e.g. #reviews-tab opens the reviews tab)
    if (window.location.hash && tabButtons.length > 0) {
        const hashTab = window.location.hash.replace('#', '').replace('-tab', '');
        const targetBtn = document.querySelector(`.tab-btn[data-tab="${hashTab}"]`);
        if (targetBtn) {
            targetBtn.click();
            setTimeout(function() {
                targetBtn.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 150);
        }
    }

    // Image gallery functionality
    const mainImage = document.getElementById('main-image');
    const thumbnailImages = document.querySelectorAll('.thumbnail-image');
    
    thumbnailImages.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const imageSrc = this.dataset.image;
            mainImage.src = `/images/plants/${imageSrc}`;
            
            // Update active thumbnail
            thumbnailImages.forEach(img => {
                img.classList.remove('border-green-500');
                img.classList.add('border-transparent');
            });
            this.classList.remove('border-transparent');
            this.classList.add('border-green-500');
        });
    });
    
    // Quantity controls
    const quantityInput = document.querySelector('input[name="quantity"]');
    const minusBtn = document.querySelector('.quantity-btn.minus');
    const plusBtn = document.querySelector('.quantity-btn.plus');
    const maxQuantity = parseInt(quantityInput?.max) || 1;
    
    if (minusBtn && plusBtn && quantityInput) {
        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
            } else {
                showNotification('Maximum stock limit reached!', 'error');
            }
        });
        
        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (value < 1) {
                this.value = 1;
            } else if (value > maxQuantity) {
                this.value = maxQuantity;
                showNotification('Maximum stock limit reached!', 'error');
            }
        });
    }
    
    // Add to cart form
    const addToCartForm = document.getElementById('add-to-cart-form');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const quantity = quantityInput ? quantityInput.value : 1;
            const plantId = parseInt(addToCartForm.dataset.plantId) || 1;
            
            fetch(`/cart/add/${plantId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    showNotification(data.message, 'success');
                    if (quantityInput) {
                        quantityInput.value = 1; // Reset quantity
                    }
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            });
        });
    }
    
    // Wishlist toggle
    const wishlistToggle = document.querySelector('.wishlist-toggle');
    if (wishlistToggle) {
        const plantId = parseInt(wishlistToggle.dataset.plantId) || 1;
        
        // Check if already in wishlist
        fetch(`/api/wishlist/check/${plantId}`)
            .then(response => response.json())
            .then(data => {
                if (data.is_wishlisted) {
                    wishlistToggle.innerHTML = '<i class="fas fa-heart mr-2"></i>Wishlisted';
                    wishlistToggle.classList.add('bg-red-500', 'text-white');
                    wishlistToggle.classList.remove('bg-white', 'border-red-500', 'text-red-500');
                }
            })
            .catch(error => console.error('Error checking wishlist status:', error));
        
        wishlistToggle.addEventListener('click', function() {
            fetch(`/wishlist/toggle/${plantId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_wishlisted) {
                        this.innerHTML = '<i class="fas fa-heart mr-2"></i>Wishlisted';
                        this.classList.add('bg-red-500', 'text-white');
                        this.classList.remove('bg-white', 'border-red-500', 'text-red-500');
                        showNotification('Added to wishlist!', 'success');
                    } else {
                        this.innerHTML = '<i class="far fa-heart mr-2"></i>Wishlist';
                        this.classList.remove('bg-red-500', 'text-white');
                        this.classList.add('bg-white', 'border-red-500', 'text-red-500');
                        showNotification('Removed from wishlist!', 'success');
                    }
                    updateWishlistCount(data.wishlist_count);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            });
        });
    }
}

/**
 * Initialize common functionality used across pages
 */
function initializeCommonFunctionality() {
    // Search autocomplete
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;
            
            if (query.length < 2) {
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetch(`/api/autocomplete?term=${query}`)
                    .then(response => response.json())
                    .then(suggestions => {
                        // Display suggestions (you can implement a dropdown here)
                        console.log('Suggestions:', suggestions);
                    })
                    .catch(error => console.error('Error:', error));
            }, 300);
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Add product to cart
 */
function addToCart(plantId, button) {
    fetch(`/cart/add/${plantId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.cart_count);
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    });
}

/**
 * Toggle wishlist status
 */
function toggleWishlist(plantId, icon) {
    fetch(`/wishlist/toggle/${plantId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.is_wishlisted) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                showNotification('Added to wishlist!', 'success');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                showNotification('Removed from wishlist!', 'success');
            }
            updateWishlistCount(data.wishlist_count);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    });
}

/**
 * Update cart count in UI
 */
function updateCartCount(count) {
    const el = document.querySelector('.cart-count-badge');
    if (el) { el.textContent = count; el.style.display = count > 0 ? '' : 'none'; }
}

/**
 * Update wishlist count in UI
 */
function updateWishlistCount(count) {
    const el = document.getElementById('wishlist-count-badge');
    if (el) { el.textContent = count; el.style.display = count > 0 ? '' : 'none'; }
}

/**
 * Show notification message
 */
function showNotification(message, type = 'success') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

/**
 * Get CSRF token from meta tag
 */
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/**
 * Format price with currency symbol
 */
function formatPrice(price) {
    return '৳' + parseFloat(price).toFixed(2);
}

/**
 * Debounce function for search and other input events
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttle function for scroll events
 */
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

/**
 * Check if element is in viewport
 */
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

/**
 * Lazy load images
 */
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                img.classList.remove('loading');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading
document.addEventListener('DOMContentLoaded', lazyLoadImages);

// Export functions for global use if needed
window.ProductPages = {
    addToCart,
    toggleWishlist,
    showNotification,
    updateCartCount,
    updateWishlistCount,
    formatPrice,
    debounce,
    throttle,
    isInViewport
};
