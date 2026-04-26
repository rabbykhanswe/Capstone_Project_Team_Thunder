// Admin plants index functionality
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('.plants-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    }

    // Category filter
    const categoryFilter = document.getElementById('categoryFilter');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            const filterValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('.plants-table tbody tr');
            
            rows.forEach(row => {
                if (filterValue === '') {
                    row.style.display = '';
                } else {
                    const categoryCell = row.querySelector('td:nth-child(3)');
                    if (categoryCell) {
                        const category = categoryCell.textContent.toLowerCase();
                        row.style.display = category.includes(filterValue) ? '' : 'none';
                    }
                }
            });
        });
    }
});

// Quick update function
function updateField(plantId, field) {
    const input = document.querySelector(`input[data-plant-id="${plantId}"][data-field="${field}"]`);
    if (!input) return;
    
    const value = input.value;
    const fieldName = field.replace('_', ' ');
    
    if (!confirm(`Update ${fieldName} to ${value}?`)) {
        return;
    }

    const formData = new FormData();
    formData.append(field, value);

    // Determine the correct endpoint
    const endpoint = field === 'price' ? 'price' : 'stock';
    
    fetch(`/admin/plants/${plantId}/${endpoint}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage('success', `${fieldName} updated successfully!`);
            
            // Reload page after a short delay to show updated data
            setTimeout(() => location.reload(), 1000);
        } else {
            showMessage('error', 'Failed to update. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('error', 'An error occurred. Please try again.');
    });
}

// Get CSRF token
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

// Show message function
function showMessage(type, message) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'error'}`;
    alertDiv.textContent = message;
    
    // Insert at the top of the container
    const container = document.querySelector('.plants-container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        
        // Remove after 3 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
}

// Add CSRF token meta tag if not exists
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = document.querySelector('input[name="_token"]')?.value || '';
    document.head.appendChild(meta);
}
