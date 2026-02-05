

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>POS Dashboard</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', Tahoma, sans-serif;
    /* background:#f4f6f8; */
background: url("<?php echo base_url('uploads/category/MaskGroup.png'); ?>") center/cover no-repeat;

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
    display: flex;
    justify-content: center;   /* horizontally center */
    align-items: center;       /* vertically center */
    height: calc(100vh - 100px);
    background: #F0F9FF;
}

.pos-container{
    display: flex;
    width: 80%;
    max-width: 1400px;         /* dashboard ko limit karega */
    height: 100%;
    background: transparent;
}

/* ================= LEFT ================= */
.pos-left{
    flex:1;
    background: url("<?php echo base_url('uploads/category/MaskGroup.png'); ?>") center/cover no-repeat;

    /* background:#F0F9FF; */
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

/* ===== ORDER DETAIL CARD ===== */
.order-card{
    background:#fff;
    border-radius:16px;
    padding:20px;
    /* height:100%; */
    display:flex;
    flex-direction:column;
}

.order-card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #eee;
    padding-bottom:12px;
    padding-top:16px;
}

.order-card-header h3{
    margin:0;
    font-size:18px;
}

.order-meta{
    font-size:34px;
    color:black;
    font-weight:bold;
}

.order-actions{
    display:flex;
    gap:8px;
    margin:14px 0;
    justify-content: center;
}

.order-actions button{
    padding:8px 12px;
    border-radius:5px;
    border:1px solid #ddd;
    background:#f7f7f7;
    font-size:12px;
    cursor:pointer;
     padding-right: 28px;
    padding-left: 28px;

}

.order-actions .primary{
    background:#424242;
    color:white;
    border:none;
}

.order-info{
    font-size:14px;
    margin-top:10px;
}

.order-info div{
    display:flex;
    justify-content:space-between;
    padding:6px 0;
}

.order-total{
    margin-top:auto;
    /* border-top:2px solid #000; */
    padding-top:25px;
    font-size:18px;
    font-weight:700;
    display:flex;
    justify-content:space-between;
}

.get-direction{
    color:#f54748;
    font-size:14px;
    cursor:pointer;
    margin-top:2px;
}
.right-left{
display: flex;
    gap: 5px;
    justify-content: space-between;
}

.order-info-details{
    color:#565656;
    font-family: 'Helix', Arial, sans-serif;
}

.line-item,
.options-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.options-list li {
    display: inline;
    margin-right: 6px;
}

ul {
    list-style: none;
}

.receipt-item {
    margin-bottom: 12px;
    font-family: 'Helix', Arial, sans-serif;
}

.receipt-header {
    display: flex;
    justify-content: space-between;
    font-weight: 700;
    font-size: 15px;
}

.receipt-sub {
    /* margin-left: 12px; */
    font-size: 13px;
    color: #565656;
    line-height: 1.4;
    margin-top:10px;
}

.receipt-addon {
    display: flex;
    justify-content: space-between;
    /* margin-left: 12px; */
    font-size: 13px;
    color: #565656;
    margin-top:5px;
}
/* BACK WHITE STRIP */
.nav-back{
    height:70px;
    width:100%;
    background:#ffffff;
    border-bottom:1px solid #eee;
}

/* FLOATING NAVBAR */
.nav-floating{
    position:relative;
    margin:-35px auto 0;   /* white bar ke upar float kare */
    width:85%;
    max-width:1200px;
    background:#fff;
    border-radius:14px;
    display:flex;
    align-items:center;
    padding:14px 30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    font-family:'Segoe UI', sans-serif;
}
body {
  font-family: 'Poppins', sans-serif;
}
/* LOGO */
.nav-logo img{
    /* height:36px; */
}

/* MENU */
.nav-menu{
    list-style:none;
    display:flex;
    gap:45px;
    margin:0 auto;
    padding:0;
}

.nav-menu li{
    display:flex;
    flex-direction:column;
    align-items:center;
    font-size:11px;
    color:#9e9e9e;
    cursor:pointer;
    position:relative;
}

.nav-menu li i{
    font-size:18px;
    margin-bottom:5px;
}

/* ACTIVE */
.nav-menu li.active{
    color:#f44336;
}

.nav-menu li.active::after{
    content:'';
    position:absolute;
    bottom:-10px;
    width:22px;
    height:3px;
    background:#f44336;
    border-radius:3px;
}


</style>

</head>
<!-- BACK WHITE BAR -->
<div class="nav-back"></div>

<!-- FLOATING NAVBAR -->
<nav class="nav-floating">
    <div class="nav-logo">
        <img src="<?= base_url('uploads/category/log.png') ?>" alt="Chilli Hut">
    </div>

    <ul class="nav-menu">
        <li class="active">
            <i class="fa-solid fa-house"></i>
                    <img src="<?= base_url('uploads/category/home.png') ?>" style="height:20px;" alt="Chilli Hut">
            <span>HOME</span>
        </li>
        <li>
            <i class="fa-solid fa-cash-register"></i>
              <img src="<?= base_url('uploads/category/point.png') ?>" style="height:20px;" alt="Chilli Hut">

            <span>POINT OF SALE</span>
        </li>
        <li>
            <i class="fa-solid fa-receipt"></i>
          <img src="<?= base_url('uploads/category/order.png') ?>" style="height:20px;" alt="Chilli Hut">

            <span>ORDERS</span>
        </li>
        <li>
            <i class="fa-solid fa-store"></i>
                      <img src="<?= base_url('uploads/category/res.png') ?>" style="height:20px;" alt="Chilli Hut">

            <span>RESTAURANTS</span>
        </li>
        <li>
            <i class="fa-solid fa-chart-line"></i>
                                  <img src="<?= base_url('uploads/category/copy.png') ?>" style="height:20px;" alt="Chilli Hut">

            <span>REPORT</span>
        </li>
    </ul>
</nav>

<body>

<!-- <div class="topbar">
    <div class="topbar-left">
        <span>21:09</span>
        <span>Chilli Hut</span>
    </div>

    <div class="topbar-right">
        🖨 📞 👤 🔍
    </div>
</div>

<div class="top-tabs">
    <div class="left-tabs">
        <a href="<?= site_url('dashboard') ?>" class="top-tab active">CURRENT</a>
        <span class="top-tab">ON THE WAY</span>
        <span class="top-tab">COMPLETED</span>
    </div>

    <div class="right-tabs">
        <a href="<?= site_url('dashboard') ?>" class="top-tab">Dashboard</a>
    </div>
</div> -->

<!-- ============ MAIN ============ -->
<div class="pos-wrapper">

    <div class="pos-container">

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
        $orders = $orders ?? [];
        $perPage = 7;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalOrders = count($orders);
        $start = ($currentPage - 1) * $perPage;
        $pagedOrders = array_slice($orders, $start, $perPage);
        ?>

        <?php foreach($pagedOrders as $o): 
            $billing = json_decode($o['billing'], true);
            $address = json_decode($o['address'], true);
            $status  = $o['order_status'];

            // Get order items
            $ordered_items = $this->order_model->details($o['code']);

            // Add menu + addon details
            foreach($ordered_items as &$item){
                $item['menu'] = $this->menu_model->get_by_id($item['menu_id'] ?? 0);

                // Decode addons if string
                if(!empty($item['addons']) && is_string($item['addons'])){
                    $addons = json_decode($item['addons'], true);
                    $realAddons = [];
                    foreach($addons as $addon){
                        if(!empty($addon['itemId'])){
                            $addonDetail = $this->menu_model->get_addon_item_detail($addon['itemId']);
                            if($addonDetail) $realAddons[] = $addonDetail;
                        }
                    }
                    $item['addons'] = $realAddons;
                }
            }
        ?>
        <div class="order" 
             onclick='showOrderDetail(<?= htmlspecialchars(json_encode([
                'order' => $o,
                'items' => $ordered_items
            ]), ENT_QUOTES, 'UTF-8') ?>)'>
            
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
</div>
<script>
function showOrderDetail(data) {
    if (typeof data === "string") data = JSON.parse(data);

    const order   = data.order;
    const items   = data.items || [];
    const billing = JSON.parse(order.billing);
    const address = JSON.parse(order.address);

    const left = document.querySelector('.pos-left');
    let itemsHTML = '';

    /* ================= ITEMS ================= */
    items.forEach(item => {

        const menu   = item.menu || {};
        const name   = menu.name || 'Menu Item';
        const detail = menu.details || '';
        const price  = Number(menu.price?.menu ?? item.total ?? 0).toFixed(2);

        itemsHTML += `
            <div class="receipt-item">

                <div class="receipt-header">
                    <span>${item.quantity}x ${name}</span>
                    <span>$${price}</span>
                </div>
        `;

        if (detail) {
            itemsHTML += `<div class="receipt-sub">${detail}</div>`;
        }

        if (item.variant_name) {
            itemsHTML += `<div class="receipt-sub">${item.variant_name}</div>`;
        }

        if (Array.isArray(item.addons) && item.addons.length) {
            item.addons.forEach(addon => {
                const addonName  = addon.subOptionName || addon.name || '';
                const addonPrice = addon.price > 0 
                    ? `$${parseFloat(addon.price).toFixed(2)}` 
                    : '';

                itemsHTML += `
                    <div class="receipt-addon">
                        <span>${addonName}</span>
                        <span>${addonPrice}</span>
                    </div>
                `;
            });
        }

        itemsHTML += `</div>`;
    });

    /* ================= RENDER ================= */
    left.innerHTML = `
        <div class="order-card">

            <div class="order-actions">
                <button class="primary">Edit</button>
                
                <button>Print</button>
                <button>Complete</button>
                <button>Options</button>
            </div>

            <div class="order-card-header">
                <div>
                    <div class="order-meta">
                        ${billing.first_name} ${billing.last_name}
                    </div>

                    ${address?.address || 'Collection Order'}

                    <p class="get-direction">Get Directions</p>

                    <div class="order-info-details">
                        ${billing.phone_mobile} ${billing.email}
                    </div>
                </div>
                 

            </div>

            <div style="display:flex; align-items:center; gap:8px; margin-top:15px;" >
        <img src="<?= base_url('uploads/category/Frame.png') ?>" alt="Directions" style="width:20px; height:20px;">
            Directions
                <img src="<?= base_url('uploads/category/detail.png') ?>" alt="Directions" style="width:20px; height:20px;">
                    Details
    </div>
        </div>

        <div class="order-card" style="margin-top:20px;">
            

            <div id="ordered_items">
                ${itemsHTML}
            </div>

            <hr>
                
            <div class="order-info-details">
                <div class="right-left">
                    <span>Sub Total:</span>
                    <span>$${parseFloat(order.total_menu_price).toFixed(2)}</span>
                </div>

                <div class="right-left">
                    <span>Service Charges:</span>
                    <span>$2.00</span>
                </div>

                <div class="right-left">
                    <span>Delivery Charges:</span>
                    <span>$${parseFloat(order.total_delivery_charge).toFixed(2)}</span>
                </div>

                <div class="right-left">
                    <span>Online Discount:</span>
                    <span>$2.00</span>
                </div>
            </div>
                
            <div class="order-total">
                <span>Grand Total</span>
                <span>$${parseFloat(order.grand_total).toFixed(2)}</span>
            </div>
        </div>
    `;
}
</script>