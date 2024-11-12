
<div class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mt-1 text-dark"><?php echo ucwords($page_title); ?></h4>
                        </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<script>
    setInterval(function() {
        $.ajax({
            url: 'orders/check_new_order/',
            method: 'GET',
            success: function(data) {
                if (data.length > 0) {
                    // Update the dashboard with the new orders
                    showNewOrderNotification(data);
                }
            },
            error: function() {
                console.error('Error fetching new orders.');
            }
        });
    }, 8000);

    function showNewOrderNotification(data) {
        const obj = JSON.parse(data);
        const add = JSON.parse(obj.address);
 

        const notificationSound = new Audio('<?php echo base_url('assets/auth/audio/foodpanda.mp3'); ?>'); 
        notificationSound.play();
        let text;
        if(obj.order_type == "delivery"){
            text = "DELIVERY | Order ID: " + obj.id + " | Total Amount: " + obj.grand_total +
                " | Address: " + add.additional_address;
        }else if(obj.order_type == "pickup"){
            text = "COLLECTION | Order ID: " + obj.id + " | Total Amount: " + obj.grand_total; 
        }
       
        Swal.fire({
            title: "New Order Received!",
            text: text,
            icon: "success",
            // showDenyButton: true, // Enable the "Deny" button
            showCancelButton: true,
            confirmButtonText: "Accept Order ",
            cancelButtonText: "Close",
            // denyButtonText: "Print", // Button text for printing 
            allowOutsideClick: false, // Prevent closing by clicking outside the modal
        }).then((result) => {
            notificationSound.pause();
            notificationSound.currentTime = 0;
            if (result.isConfirmed) {
                // Only update the order read status when the "Acknowledge" button is clicked
                updateOrderReadStatus(obj.id, obj.code);
            }
        });
    }

    function updateOrderReadStatus(orderId,code) {
        $.ajax({
            url: 'orders/mark_order_as_read/',
            method: 'POST',
            data: { order_id: orderId },
            success: function(response) {
                    $.ajax({
                        url: 'orders/process/'+code+"/approved",
                        method: 'POST',
                        data: { order_id: orderId },
                        success: function(response) {
                            window.location.href = "orders/print_recipt/" + code;
                            console.log('Order marked as read successfully');
                        },
                        error: function() {
                            console.error('Error marking order as read.');
                        }
                    });
            },
            error: function() {
                console.error('Error marking order as read.');
            }
        });
    }
</script>
