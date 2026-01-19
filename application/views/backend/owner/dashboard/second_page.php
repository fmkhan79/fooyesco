<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>POS Dashboard</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', Tahoma, sans-serif;
    background:#f4f6f8;
}

/* ================= TOP BAR ================= */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 20px;
    background:#f8f9fb;
    border-bottom:1px solid #ddd;
    font-size:14px;
}

.topbar-left{
    display:flex;
    gap:15px;
    font-weight:600;
}

.topbar-right{
    display:flex;
    gap:18px;
    font-size:16px;
    color:#777;
}

/* ================= TABS ================= */
.top-tabs{
    display:flex;
    justify-content:space-between; /* Left aur right ko separate karega */
    padding:12px 20px;
    background:#fff;
    border-bottom:1px solid #ddd;
}
.left-tabs, .right-tabs{
    display:flex;
    gap:30px;
}

.top-tab{
    font-weight:600;
    color:#777;
    text-decoration:none;
    position:relative;
}

.top-tab.active{
    color:#000;
}

.top-tab.active::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-12px;
    width:100%;
    height:3px;
    background:#4caf50;
    border-radius:4px;
}

/* ================= MAIN WRAPPER ================= */
.pos-wrapper{
    display:flex;
    height:calc(100vh - 100px);
}

/* ================= LEFT ================= */
.pos-left{
    flex:1;
    background:#f2f4f7;
    padding:25px;
}

.banner{
    width:100%;
    height:100%;
    border-radius:16px;
    background:url('https://images.unsplash.com/photo-1607082349566-187342175e2f?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
    display:flex;
    align-items:center;
    justify-content:center;
}

.banner-overlay{
    background:rgba(255,255,255,0.88);
    padding:40px;
    border-radius:16px;
    text-align:center;
}

.banner-overlay h1{
    font-size:70px;
    color:#ff5722;
    margin:0;
}

.banner-overlay h3{
    margin:10px 0;
    font-weight:600;
}

.banner-overlay p{
    color:#555;
}

/* ================= RIGHT ================= */
.pos-right{
    flex:1.2;
    padding:20px;
    overflow-y:auto;
    background:#fff;
}

.order{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px;
    border-bottom:1px solid #eee;
}

.order-left{
    display:flex;
    gap:14px;
}

.order-id{
    width:40px;
    font-weight:600;
}

.order-details strong{
    display:block;
}

.badge{
    padding:6px 10px;
    border-radius:6px;
    font-size:12px;
    font-weight:600;
}

.badge-green{background:#e8f5e9;color:#2e7d32;}
.badge-grey{background:#eee;color:#555;}
.badge-red{background:#fdecea;color:#c62828;}

.action-btn{
    padding:6px 10px;
    border-radius:6px;
    font-size:12px;
    font-weight:600;
    margin-left:5px;
}

.btn-accept{background:#4caf50;color:#fff;}
.btn-reject{background:#f44336;color:#fff;}

.pagination{
    margin-top:20px;
    text-align:center;
}

.pagination a{
    display:inline-block;
    padding:8px 12px;
    margin:0 3px;
    border:1px solid #ddd;
    border-radius:6px;
    text-decoration:none;
    color:#555;
}

.pagination a.active{
    background:#4caf50;
    color:#fff;
    border-color:#4caf50;
}
</style>

</head>
<body>

<!-- ============ TOP BAR ============ -->
<div class="topbar">
    <div class="topbar-left">
        <span>21:09</span>
        <span>Chilli Hut</span>
    </div>

    <div class="topbar-right">
        🖨 📞 👤 🔍
    </div>
</div>

<!-- ============ TABS ============ -->
<div class="top-tabs">
    <div class="left-tabs">
        <a href="<?= site_url('dashboard') ?>" class="top-tab active">CURRENT</a>
        <span class="top-tab">ON THE WAY</span>
        <span class="top-tab">COMPLETED</span>
    </div>

    <div class="right-tabs">
        <a href="<?= site_url('dashboard') ?>" class="top-tab">Dashboard</a>
    </div>
</div>

<!-- ============ MAIN ============ -->
<div class="pos-wrapper">

    <!-- LEFT -->
    <div class="pos-left">
        <div class="banner">
            <div class="banner-overlay">
                <h3>HAPPY NEW YEAR</h3>
                <h1>2026</h1>
                <h3>New Year. New Goals.</h3>
                <p>Wishing you a powerful and prosperous 2026.</p>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="pos-right">

       <?php 
$orders = $orders ?? []; // $orders comes from controller
$perPage = 4;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalOrders = count($orders);
$start = ($currentPage - 1) * $perPage;
$pagedOrders = array_slice($orders, $start, $perPage);
?>

<?php foreach($pagedOrders as $o): 
    $billing = json_decode($o['billing'], true);
    $address = json_decode($o['address'], true);
    $status = $o['order_status'];
?>
<div class="order" 
     onclick='showOrderDetail(<?= htmlspecialchars(json_encode($o), ENT_QUOTES, 'UTF-8') ?>)'>
    <div class="order-left">
        <div class="order-id"><?= $o['daily_order_number'] ?? $o['id'] ?></div>
        <div class="order-details">
            <strong><?= $billing['first_name'].' '.$billing['last_name'] ?></strong>
            <span><?= $address['address'] ?></span>
        </div>
    </div>

    <div>
        <?php if($status=='pending'): ?>
            <span class="badge badge-grey">Pending</span>
            <span class="action-btn btn-accept">✔</span>
            <span class="action-btn btn-reject">✖</span>
        <?php elseif($status=='ontheway'): ?>
            <span class="badge badge-green">On the Way</span>
        <?php elseif($status=='done' || $status=='completed'): ?>
            <span class="badge badge-red">Completed</span>
        <?php elseif($status=='canceled'): ?>
            <span class="badge badge-red">Canceled</span>
        <?php else: ?>
            <span class="badge badge-grey"><?= ucfirst($status) ?></span>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>


<!-- ===== Pagination ===== -->
<div class="pagination">
    <?php 
    $totalPages = ceil($totalOrders / $perPage);
    for($i=1; $i<=$totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= ($i==$currentPage)?'active':'' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>

    </div>
</div>

</body>
</html>
<script>
function showOrderDetail(order) {
    // Decode JSON agar string hai
    if(typeof order === "string") {
        order = JSON.parse(order);
    }

    let billing = JSON.parse(order.billing);
    let address = JSON.parse(order.address);

    // Left panel banner replace kar do
    const left = document.querySelector('.pos-left');
    left.innerHTML = `
        <div style="padding:20px;">
            <h3>Order #${order.daily_order_number ?? order.id}</h3>
            <p><strong>Customer:</strong> ${billing.first_name} ${billing.last_name}</p>
            <p><strong>Address:</strong> ${address.address}</p>
            <p><strong>Order Type:</strong> ${order.order_type}</p>
            <p><strong>Status:</strong> ${order.order_status}</p>
            <p><strong>Total:</strong> $${order.grand_total}</p>
            ${order.note ? `<p><strong>Note:</strong> ${order.note}</p>` : ''}
        </div>
    `;
}
</script>
