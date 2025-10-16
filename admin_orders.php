<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Orders | La Tavola Bella</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:#fef3c7;padding:20px;}
h1{text-align:center;color:#92400e;margin-bottom:30px;}
.table thead{background:#d97706;color:white;}
.completed{background:#10b981;color:white;border:none;border-radius:5px;padding:5px 10px;cursor:pointer;}
.cancelled{background:#ef4444;color:white;border:none;border-radius:5px;padding:5px 10px;cursor:pointer;}
.pending{background:#facc15;color:white;border-radius:5px;padding:5px 10px;}
.table-responsive{box-shadow:0 5px 15px rgba(0,0,0,0.1);border-radius:10px;overflow:hidden;}
audio{display:none;}
</style>
</head>
<body>
<h1>Customer Orders</h1>
<div class="table-responsive">
<table class="table table-striped align-middle">
<thead>
<tr>
<th>ID</th>
<th>Customer Name</th>
<th>Address</th>
<th>Phone</th>
<th>Item</th>
<th>Price (LKR)</th>
<th>Order Time</th>
<th>Status</th>
</tr>
</thead>
<tbody id="ordersBody">
<tr><td colspan="8" class="text-center">Loading orders...</td></tr>
</tbody>
</table>
</div>
<audio id="orderSound" src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_8b29d8a9b1.mp3" preload="auto"></audio>
<script>
let lastOrderIds=[];
function loadOrders(playSound=false){
    fetch('fetch_orders.php').then(r=>r.json()).then(data=>{
        const tbody=document.getElementById('ordersBody');
        tbody.innerHTML='';
        if(data.length===0){tbody.innerHTML='<tr><td colspan="8" class="text-center">No orders yet.</td></tr>'; return;}
        const currentIds=data.map(o=>o.id);
        if(playSound && currentIds.length>lastOrderIds.length) document.getElementById('orderSound').play();
        lastOrderIds=currentIds;
        data.forEach(order=>{
            tbody.innerHTML+=`<tr>
            <td>${order.id}</td>
            <td>${order.customer_name}</td>
            <td>${order.customer_address}</td>
            <td>${order.customer_phone}</td>
            <td>${order.item_name}</td>
            <td>${parseFloat(order.price).toFixed(2)}</td>
            <td>${order.order_time}</td>
            <td>
                <div class="d-flex align-items-center flex-wrap gap-1">
                    <button onclick="updateStatus(${order.id},'Completed')" class="completed">Completed</button>
                    <button onclick="updateStatus(${order.id},'Cancelled')" class="cancelled">Cancelled</button>
                    <span class="pending mt-1">${order.status}</span>
                </div>
            </td>
            </tr>`;
        });
    }).catch(console.error);
}
function updateStatus(id,status){
    fetch('admin_update.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`order_id=${id}&status=${status}`
    }).then(()=>loadOrders());
}
loadOrders();
setInterval(()=>loadOrders(true),10000);
</script>
</body>
</html>
