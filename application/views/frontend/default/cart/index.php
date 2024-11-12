<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>

<!-- MAIN CONTENT -->
<section class="detail-wbox mt-4 mb-2 booking-details_wrap">
    <div class="container bg-white text-dark border border-light">
        <div class="row">
            <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>
            <?php if (!$customer_details || count($customer_details) == 0) : ?>
                <div class="col-md-12 responsive-wrap">
                    <?php include 'list.php'; ?>
                </div>
            <?php else : ?>
                <div class="col-md-12 responsive-wrap">
                    <?php include 'list.php'; ?>
                </div>
                <div class="responsive-wrap">
                    <div class="contact-info p-2">
                        <!-- <div class="delivery-address-list"><i class="ti-direction-alt"></i> <?php echo site_phrase('choose_delivery_address', true); ?></div> -->
                        <!-- <div id="mapid1" class="mb-1 address-map img-thumbnail"></div> -->
                        <!-- <div id="mapid2" class="mb-1 address-map img-thumbnail"></div> -->
                        <!-- <div id="mapid3" class="mb-1 address-map img-thumbnail"></div> -->
                        <?php if (!empty($customer_details['address_1'])) : ?>
                            <div class="callout callout-warning">
                                <!-- <input type="radio" name="address" value="1" onchange="toggleMap(this.value)" checked> <strong><?php echo site_phrase('address_1'); ?> : </strong> <?php echo sanitize($customer_details['address_1']); ?> -->
                                <input type="hidden" name="address" value="1" onchange="toggleMap(this.value)" checked>
                            </div>
                        <?php endif; ?>
                        <!-- <?php if (!empty($customer_details['address_2'])) : ?>
                            <div class="callout callout-warning">
                                <input type="radio" name="address" value="2" onchange="toggleMap(this.value)"> <strong><?php echo site_phrase('address_2'); ?> : </strong><?php echo sanitize($customer_details['address_2']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($customer_details['address_3'])) : ?>
                            <div class="callout callout-warning">
                                <input type="radio" name="address" value="3" onchange="toggleMap(this.value)"> <strong><?php echo site_phrase('address_3'); ?> : </strong><?php echo sanitize($customer_details['address_3']); ?>
                            </div>
                        <?php endif; ?> -->
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<script>
    // Delay session destruction by 5 seconds
    setTimeout(function() {
        // Make an AJAX call to destroy the session
        fetch('<?php echo site_url('cart/session_destroy'); ?>')  // Using PHP to get the correct URL
            .then(response => {
                if (response.ok) {
                    console.log('Session destroyed successfully.');
                }
            })
            .catch(error => console.error('Error:', error));
    }, 5000); // 5000 milliseconds = 5 seconds
</script>