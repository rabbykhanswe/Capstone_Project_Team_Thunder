<?php
    $navCategories = \App\Models\Category::orderBy('name')->get();
    $cartCount = session('cart') ? array_sum(session('cart')) : 0;
    $wishlistCount = auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0;
?>

<header class="site-header" id="siteHeader">
    <div class="header-container">

        
        <a href="<?php echo e(route('home')); ?>" class="header-logo">
            <img src="<?php echo e(asset('images/footer/logo.png')); ?>" alt="<?php echo e($site['site_name'] ?? 'Oronno Plants'); ?>" class="nav-logo-img">
            <span class="logo-text"><?php echo e($site['site_name'] ?? 'Oronno Plants'); ?></span>
        </a>

        
        <nav class="header-nav" id="headerNav">
            <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(request()->routeIs('home') ? 'nav-link-active' : ''); ?>">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="<?php echo e(route('products')); ?>" class="nav-link <?php echo e(request()->routeIs('products*') ? 'nav-link-active' : ''); ?>">
                <i class="fas fa-seedling"></i> Shop
            </a>

            
            <div class="nav-dropdown-wrap">
                <button class="nav-link nav-dropdown-trigger <?php echo e(request()->has('category') ? 'nav-link-active' : ''); ?>">
                    <i class="fas fa-layer-group"></i> Categories
                    <i class="fas fa-chevron-down nav-chevron-icon"></i>
                </button>
                <div class="nav-dropdown-panel">
                    <a href="<?php echo e(route('products')); ?>" class="dropdown-item">
                        <span class="dropdown-icon"><i class="fas fa-border-all"></i></span> All Plants
                    </a>
                    <div class="dropdown-divider"></div>
                    <?php $__empty_1 = true; $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('products', ['category' => $cat->name])); ?>" class="dropdown-item">
                            <span class="dropdown-icon"><i class="fas fa-leaf"></i></span> <?php echo e(ucfirst($cat->name)); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <a href="<?php echo e(route('products')); ?>" class="dropdown-item">
                            <span class="dropdown-icon"><i class="fas fa-border-all"></i></span> All Plants
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <a href="<?php echo e(route('about')); ?>" class="nav-link <?php echo e(request()->routeIs('about') ? 'nav-link-active' : ''); ?>">
                <i class="fas fa-info-circle"></i> About
            </a>
            <a href="<?php echo e(route('contact')); ?>" class="nav-link <?php echo e(request()->routeIs('contact') ? 'nav-link-active' : ''); ?>">
                <i class="fas fa-envelope"></i> Contact
            </a>
        </nav>

        
        <div class="header-actions">

            <button class="action-icon-btn" id="searchToggle" title="Search">
                <i class="fas fa-search"></i>
            </button>

            <a href="<?php echo e(route('wishlist')); ?>" class="action-icon-btn action-badge-wrap" title="Wishlist">
                <i class="fas fa-heart"></i>
                <?php if($wishlistCount > 0): ?>
                    <span class="action-badge" id="wishlist-count-badge"><?php echo e($wishlistCount); ?></span>
                <?php else: ?>
                    <span class="action-badge" id="wishlist-count-badge" style="display:none;">0</span>
                <?php endif; ?>
            </a>

            <a href="<?php echo e(route('cart')); ?>" class="action-icon-btn action-badge-wrap" title="Cart">
                <i class="fas fa-shopping-cart"></i>
                <span class="action-badge cart-count-badge" style="<?php echo e($cartCount > 0 ? '' : 'display:none;'); ?>"><?php echo e($cartCount); ?></span>
            </a>

            <?php if(auth()->guard()->check()): ?>
                <div class="nav-dropdown-wrap">
                    <button class="action-icon-btn action-badge-wrap notification-btn" id="notificationToggle" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="action-badge" id="notification-count-badge" style="display:none;">0</span>
                    </button>
                    <div class="nav-dropdown-panel nav-dropdown-panel-right" id="notificationDropdown" style="display: none;">
                        <div class="dropdown-header">
                            <div class="text-sm font-semibold" style="color:#111827">Notifications</div>
                            <button type="button" id="markAllReadBtn" class="text-xs text-green-600 hover:text-green-700">Mark all as read</button>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div id="notificationList" class="max-h-80 overflow-y-auto">
                            <div class="text-center py-4 text-gray-400 text-sm">
                                <i class="fas fa-bell-slash text-2xl mb-2 block"></i>
                                No notifications
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <div class="nav-dropdown-wrap">
                    <button class="user-dropdown-btn">
                        <?php if(auth()->user()->profile_picture): ?>
                            <img src="<?php echo e(asset('images/profile_pictures/' . auth()->user()->profile_picture)); ?>" alt="Profile" class="user-avatar" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                        <?php else: ?>
                            <div class="user-avatar"><i class="fas fa-user"></i></div>
                        <?php endif; ?>
                        <span class="user-name"><?php echo e(auth()->user()->fname); ?></span>
                        <i class="fas fa-chevron-down nav-chevron-icon"></i>
                    </button>
                    <div class="nav-dropdown-panel nav-dropdown-panel-right">
                        <div class="dropdown-header">
                            <div class="text-sm font-semibold" style="color:#111827"><?php echo e(auth()->user()->fname); ?> <?php echo e(auth()->user()->lname); ?></div>
                            <div class="text-xs" style="color:#9ca3af"><?php echo e(auth()->user()->phone); ?></div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo e(route('account.dashboard')); ?>" class="dropdown-item">
                            <span class="dropdown-icon"><i class="fas fa-th-large"></i></span> My Dashboard
                        </a>
                        <a href="<?php echo e(route('orders.index')); ?>" class="dropdown-item">
                            <span class="dropdown-icon di-blue"><i class="fas fa-box"></i></span> My Orders
                        </a>
                        <a href="<?php echo e(route('profile')); ?>" class="dropdown-item">
                            <span class="dropdown-icon"><i class="fas fa-user-circle"></i></span> My Profile
                        </a>
                        <a href="<?php echo e(route('wishlist')); ?>" class="dropdown-item">
                            <span class="dropdown-icon di-red"><i class="fas fa-heart"></i></span> Wishlist
                        </a>
                        <a href="<?php echo e(route('cart')); ?>" class="dropdown-item">
                            <span class="dropdown-icon di-blue"><i class="fas fa-shopping-cart"></i></span> My Cart
                        </a>
                        <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="dropdown-item">
                            <span class="dropdown-icon di-yellow"><i class="fas fa-cog"></i></span> Admin Panel
                        </a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item dropdown-item-btn">
                                <span class="dropdown-icon di-red"><i class="fas fa-sign-out-alt"></i></span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login_form')); ?>" class="btn-nav-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="<?php echo e(route('register')); ?>" class="btn-nav-register">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            <?php endif; ?>

            <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    
    <div class="header-search-bar" id="headerSearchBar">
        <form action="<?php echo e(route('products')); ?>" method="GET">
            <div class="search-bar-inner">
                <i class="fas fa-search search-bar-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search for plants, pots, categories..." autocomplete="off">
                <button type="submit" class="search-bar-btn">Search</button>
                <button type="button" class="search-bar-close" id="searchClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Autocomplete Dropdown -->
            <div id="searchSuggestions" class="search-suggestions" style="display: none;">
                <div class="suggestions-list" id="suggestionsList">
                    <!-- Suggestions will be inserted here -->
                </div>
            </div>
        </form>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchToggle = document.getElementById('searchToggle');
    const searchBar    = document.getElementById('headerSearchBar');
    const searchClose  = document.getElementById('searchClose');
    const searchInput  = document.getElementById('searchInput');
    const hamburger    = document.getElementById('hamburgerBtn');
    const nav          = document.getElementById('headerNav');
    const header       = document.getElementById('siteHeader');

    if (searchToggle) searchToggle.addEventListener('click', function () {
        searchBar.classList.toggle('search-bar-open');
        if (searchBar.classList.contains('search-bar-open')) searchInput.focus();
    });
    if (searchClose) searchClose.addEventListener('click', function () {
        searchBar.classList.remove('search-bar-open');
    });
    if (hamburger) hamburger.addEventListener('click', function () {
        nav.classList.toggle('nav-open');
        this.classList.toggle('hamburger-active');
    });
    window.addEventListener('scroll', function () {
        header.classList.toggle('header-scrolled', window.scrollY > 10);
    });

    // Autocomplete functionality
    const searchSuggestions = document.getElementById('searchSuggestions');
    const suggestionsList = document.getElementById('suggestionsList');
    let searchTimeout;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                hideSuggestions();
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetch(`/api/autocomplete?term=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(suggestions => {
                        displaySuggestions(suggestions);
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                        hideSuggestions();
                    });
            }, 300);
        });

        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                fetch(`/api/autocomplete?term=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(suggestions => {
                        displaySuggestions(suggestions);
                    })
                    .catch(error => console.error('Error fetching suggestions:', error));
            }
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                hideSuggestions();
            }
        });
    }

    function displaySuggestions(suggestions) {
        if (!suggestions || suggestions.length === 0) {
            suggestionsList.innerHTML = '<div class="no-suggestions">No plants found</div>';
        } else {
            suggestionsList.innerHTML = suggestions.map(plant => {
                const baseUrl = '<?php echo e(asset('')); ?>';
                const imageUrl = plant.image ? baseUrl + 'images/plants/' + plant.image : null;
                const productUrl = `/products/${plant.id}`;
                
                return `
                    <a href="${productUrl}" class="suggestion-item">
                        ${plant.image ? 
                            `<img src="${imageUrl}" alt="${plant.name}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="width:48px;height:48px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-leaf" style="color:#9ca3af;"></i>
                            </div>` : 
                            `<div style="width:48px;height:48px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-leaf" style="color:#9ca3af;"></i>
                            </div>`
                        }
                        <div class="suggestion-details">
                            <div class="suggestion-name">${plant.name}</div>
                            <div class="suggestion-meta">
                                <span class="suggestion-price">৳${plant.price}</span>
                                <span class="suggestion-category">${plant.category}</span>
                                <span class="suggestion-stock ${plant.stock_count > 0 ? '' : 'out-of-stock'}">
                                    ${plant.stock_count > 0 ? plant.stock_count + ' in stock' : 'Out of stock'}
                                </span>
                            </div>
                        </div>
                    </a>
                `;
            }).join('');
        }
        searchSuggestions.style.display = 'block';
    }

    function hideSuggestions() {
        searchSuggestions.style.display = 'none';
    }

    // Notification functionality
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationList = document.getElementById('notificationList');
    const notificationCountBadge = document.getElementById('notification-count-badge');
    const markAllReadBtn = document.getElementById('markAllReadBtn');

    if (notificationToggle) {
        // Load notifications on page load
        loadNotifications();

        notificationToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.style.display = notificationDropdown.style.display === 'block' ? 'none' : 'block';
            if (notificationDropdown.style.display === 'block') {
                loadNotifications();
            }
        });

        // Mark all as read
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function() {
                fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateNotificationCount(0);
                        loadNotifications();
                    }
                });
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationToggle.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.style.display = 'none';
            }
        });
    }

    function loadNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                displayNotifications(data.notifications);
                updateNotificationCount(data.unread_count);
            })
            .catch(error => console.error('Error loading notifications:', error));
    }

    function getNotificationUrl(notification) {
        const data = notification.data;
        if (!data) return null;
        if (notification.type === 'review_approved' && data.plant_id) {
            return '/products/' + data.plant_id + '#reviews-tab';
        }
        if (notification.type === 'order_status' && data.order_id) {
            return '/orders/' + data.order_id;
        }
        return null;
    }

    function displayNotifications(notifications) {
        if (!notifications || notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="text-center py-4 text-gray-400 text-sm">
                    <i class="fas fa-bell-slash text-2xl mb-2 block"></i>
                    No notifications
                </div>
            `;
            return;
        }

        notificationList.innerHTML = notifications.map(notification => {
            const createdAt = new Date(notification.created_at);
            const timeAgo = getTimeAgo(createdAt);
            const icon = notification.type === 'review_approved' ? 'fa-star' : 'fa-box';
            const iconColor = notification.type === 'review_approved' ? 'text-green-500' : 'text-blue-500';
            const url = getNotificationUrl(notification);

            return `
                <div class="notification-item ${notification.read_at ? 'read' : 'unread'} cursor-pointer p-3 hover:bg-gray-50 transition-colors" data-id="${notification.id}" data-url="${url || ''}">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas ${icon} ${iconColor} mt-1"></i>
                        </div>
                        <div class="flex-grow">
                            <div class="font-semibold text-sm">${notification.title}</div>
                            <div class="text-gray-600 text-xs mt-1">${notification.message}</div>
                            <div class="text-gray-400 text-xs mt-1">${timeAgo}</div>
                        </div>
                        ${!notification.read_at ? '<div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-2"></div>' : '<div class="w-2"></div>'}
                    </div>
                </div>
            `;
        }).join('');

        // Add click handlers: mark as read then redirect
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function() {
                const notificationId = this.dataset.id;
                const url = this.dataset.url;
                if (!this.classList.contains('read')) {
                    markAsRead(notificationId, url);
                } else if (url) {
                    window.location.href = url;
                }
            });
        });
    }

    function markAsRead(id, redirectUrl) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    loadNotifications();
                }
            }
        });
    }

    function updateNotificationCount(count) {
        if (notificationCountBadge) {
            notificationCountBadge.textContent = count;
            notificationCountBadge.style.display = count > 0 ? '' : 'none';
        }
    }

    function getTimeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        
        if (seconds < 60) return 'Just now';
        if (seconds < 3600) return Math.floor(seconds / 60) + ' minutes ago';
        if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
        if (seconds < 604800) return Math.floor(seconds / 86400) + ' days ago';
        
        return date.toLocaleDateString();
    }

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }
});
</script>

<style>
/* Search Suggestions Dropdown */
.search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e5e7eb;
    border-top: none;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    max-height: 400px;
    overflow-y: auto;
    z-index: 1000;
}

.suggestions-list {
    padding: 8px 0;
}

.suggestion-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    cursor: pointer;
    transition: background-color 0.2s;
    text-decoration: none;
    color: inherit;
}

.suggestion-item:hover {
    background-color: #f9fafb;
}

.suggestion-item img {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 12px;
}

.suggestion-details {
    flex: 1;
}

.suggestion-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 2px;
}

.suggestion-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
    color: #6b7280;
}

.suggestion-price {
    font-weight: 700;
    color: #16a34a;
}

.suggestion-category {
    background: #f3f4f6;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    color: #374151;
}

.suggestion-stock {
    color: #059669;
    font-weight: 500;
}

.suggestion-stock.out-of-stock {
    color: #dc2626;
}

.no-suggestions {
    padding: 20px;
    text-align: center;
    color: #6b7280;
    font-size: 14px;
}
</style><?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/partials/header.blade.php ENDPATH**/ ?>