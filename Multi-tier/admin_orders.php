<?php 
include 'db_connect.php';
session_start();

// Simple admin authentication (you can enhance this)
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Orders | La Tavola Bella</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
:root {
    --primary-color: #ff6b6b;
    --secondary-color: #4ecdc4;
    --accent-color: #ffd93d;
    --dark-color: #2d3436;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding: 20px;
}

.admin-header {
    background: linear-gradient(135deg, var(--dark-color), #1a1a1a);
    color: white;
    padding: 30px 0;
    margin-bottom: 30px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.admin-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.8rem;
    background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0;
}

.admin-stats {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-left: 5px solid var(--primary-color);
}

.stat-card {
    text-align: center;
    padding: 20px;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.stat-pending { color: #ffc107; }
.stat-completed { color: #198754; }
.stat-cancelled { color: #dc3545; }
.stat-total { color: var(--primary-color); }

.table-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 30px;
}

.table thead {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.table th {
    border: none;
    padding: 20px 15px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
}

.table td {
    padding: 18px 15px;
    vertical-align: middle;
    border-color: #f1f3f4;
}

.status-badge {
    padding: 8px 15px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.85rem;
}

.status-pending { background: #fff3cd; color: #856404; }
.status-completed { background: #d1edff; color: #055160; }
.status-cancelled { background: #f8d7da; color: #721c24; }

.action-btn {
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    margin: 2px;
}

.btn-complete { background: #198754; color: white; }
.btn-complete:hover { background: #157347; transform: translateY(-2px); }

.btn-cancel { background: #dc3545; color: white; }
.btn-cancel:hover { background: #bb2d3b; transform: translateY(-2px); }

.btn-edit { background: #ffc107; color: #000; }
.btn-edit:hover { background: #ffca2c; transform: translateY(-2px); }

.btn-delete { background: #6c757d; color: white; }
.btn-delete:hover { background: #5c636a; transform: translateY(-2px); }

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.admin-actions {
    background: white;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.refresh-btn {
    background: linear-gradient(135deg, var(--secondary-color), #67e6dc);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.refresh-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(78,205,196,0.4);
}

.logout-btn {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.logout-btn:hover {
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(108,117,125,0.4);
}

.audio-controls {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.new-order-alert {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { background-color: #fff3cd; }
    50% { background-color: #ffeaa7; }
    100% { background-color: #fff3cd; }
}

@media (max-width: 768px) {
    .admin-title {
        font-size: 2rem;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .action-btn {
        padding: 6px 12px;
        font-size: 0.8rem;
        margin: 1px;
    }
}
</style>
</head>
<body>
<!-- Admin Header -->
<div class="admin-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="admin-title">
                    <i class="fas fa-concierge-bell me-3"></i>Order Management
                </h1>
                <p class="mb-0 text-light">Real-time order monitoring and management</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group">
                    <a href="admin_logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4" id="statsContainer">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number stat-total" id="totalOrders">0</div>
                <div>Total Orders</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number stat-pending" id="pendingOrders">0</div>
                <div>Pending</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number stat-completed" id="completedOrders">0</div>
                <div>Completed</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number stat-cancelled" id="cancelledOrders">0</div>
                <div>Cancelled</div>
            </div>
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="admin-actions">
        <div class="row align-items-center">
            <div class="col-md-6">
                <button class="refresh-btn" onclick="loadOrders(true)">
                    <i class="fas fa-sync-alt me-2"></i>Refresh Orders
                </button>
                <span class="ms-3 text-muted" id="lastUpdated">Last updated: Just now</span>
            </div>
            <div class="col-md-6 text-end">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="soundToggle" checked>
                    <label class="form-check-label" for="soundToggle">Notification Sound</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Order Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="ordersBody">
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="loading-spinner me-2"></div>
                            Loading orders...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Notification Sound -->
<audio id="orderSound" preload="auto">
    <source src="https://assets.mixkit.co/active_storage/sfx/286/286-preview.mp3" type="audio/mp3">
</audio>

<script>
let lastOrderCount = 0;
let ordersData = [];

// Load orders with statistics
function loadOrders(playSound = false) {
    fetch('fetch_orders.php')
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        ordersData = data;
        updateStatistics(data);
        displayOrders(data);
        updateLastUpdated();
        
        if (playSound && data.length > lastOrderCount && document.getElementById('soundToggle').checked) {
            document.getElementById('orderSound').play().catch(e => console.log('Audio play failed:', e));
        }
        lastOrderCount = data.length;
    })
    .catch(err => {
        console.error('Error fetching orders:', err);
        document.getElementById('ordersBody').innerHTML = `
            <tr>
                <td colspan="8" class="text-center text-danger py-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Failed to load orders. Please try again.
                </td>
            </tr>
        `;
    });
}

// Update statistics
function updateStatistics(orders) {
    const total = orders.length;
    const pending = orders.filter(order => order.status === 'Pending').length;
    const completed = orders.filter(order => order.status === 'Completed').length;
    const cancelled = orders.filter(order => order.status === 'Cancelled').length;
    
    document.getElementById('totalOrders').textContent = total;
    document.getElementById('pendingOrders').textContent = pending;
    document.getElementById('completedOrders').textContent = completed;
    document.getElementById('cancelledOrders').textContent = cancelled;
}

// Display orders in table
function displayOrders(orders) {
    const tbody = document.getElementById('ordersBody');
    
    if (!Array.isArray(orders) || orders.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                    <i class="fas fa-inbox me-2"></i>No orders found.
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = orders.map(order => {
        const total = (parseFloat(order.price) * parseInt(order.quantity)).toFixed(2);
        const orderTime = new Date(order.order_time).toLocaleString();
        
        return `
            <tr id="order-${order.id}" class="${order.status === 'Pending' ? 'new-order-alert' : ''}">
                <td><strong>#${order.id}</strong></td>
                <td>
                    <div class="fw-bold">${order.customer_name}</div>
                    <small class="text-muted">${order.customer_address}</small>
                </td>
                <td>${order.customer_phone}</td>
                <td>
                    <strong>${order.item_name}</strong>
                    <br><small class="text-muted">Qty: ${order.quantity}</small>
                </td>
                <td class="fw-bold text-success">LKR ${total}</td>
                <td><small>${orderTime}</small></td>
                <td>
                    <span class="status-badge status-${order.status.toLowerCase()}">
                        ${order.status}
                    </span>
                </td>
                <td>
                    <div class="btn-group">
                        ${order.status === 'Pending' ? `
                            <button class="action-btn btn-complete" onclick="updateStatus(${order.id}, 'Completed')">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="action-btn btn-cancel" onclick="updateStatus(${order.id}, 'Cancelled')">
                                <i class="fas fa-times"></i>
                            </button>
                        ` : ''}
                        <button class="action-btn btn-delete" onclick="deleteOrder(${order.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

// Update order status
function updateStatus(orderId, status) {
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    
    button.innerHTML = '<div class="loading-spinner"></div>';
    button.disabled = true;
    
    fetch('admin_update.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `order_id=${orderId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the row
            const row = document.getElementById(`order-${orderId}`);
            const statusBadge = row.querySelector('.status-badge');
            
            // Update status badge
            statusBadge.className = `status-badge status-${status.toLowerCase()}`;
            statusBadge.textContent = status;
            
            // Remove action buttons if not pending
            if (status !== 'Pending') {
                const actionsCell = row.querySelector('td:last-child');
                actionsCell.innerHTML = `
                    <button class="action-btn btn-delete" onclick="deleteOrder(${orderId})">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
            }
            
            // Remove new order alert
            row.classList.remove('new-order-alert');
            
            // Reload statistics
            loadOrders(false);
        } else {
            alert(data.message || 'Error updating status');
            button.innerHTML = originalHTML;
            button.disabled = false;
        }
    })
    .catch(err => {
        console.error('Error updating status:', err);
        alert('Failed to update status. Please try again.');
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

// Delete order
function deleteOrder(orderId) {
    if (!confirm('Are you sure you want to delete this order?')) {
        return;
    }
    
    fetch('delete_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `order_id=${orderId}`
    })
    .then(response => {
        if (response.ok) {
            document.getElementById(`order-${orderId}`).remove();
            loadOrders(false); // Reload statistics
        } else {
            alert('Failed to delete order.');
        }
    })
    .catch(err => {
        console.error('Error deleting order:', err);
        alert('Failed to delete order.');
    });
}

// Update last updated time
function updateLastUpdated() {
    const now = new Date();
    document.getElementById('lastUpdated').textContent = 
        `Last updated: ${now.toLocaleTimeString()}`;
}

// Auto-refresh every 10 seconds
setInterval(() => loadOrders(true), 10000);

// Initial load
loadOrders();
</script>
</body>
</html>