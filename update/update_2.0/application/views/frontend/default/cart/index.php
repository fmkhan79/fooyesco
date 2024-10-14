<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>

<!-- RESTAURANT TITLE HEADER -->
<div class="container-fluid">
    <div class="row">
        <div class="booking-checkbox_wrap">
            <h5><i class="fas fa-shopping-cart"></i> <?php echo site_phrase('your_orders', true); ?></h5>
        </div>
    </div>
</div>
<!-- MAIN CONTENT -->
<section class=" light-bg booking-details_wrap">
    <div class="container-fluid">
        <?php if ($this->session->userdata('customer_login') || $this->session->userdata('owner_login')) : ?>
            <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>
            <div class="row">
                <div class="col-md-9 responsive-wrap">
                    <?php include 'list.php'; ?>
                </div>
                <div class="col-md-3 responsive-wrap">
                    <div class="contact-info p-2">
                        <div class="delivery-address-list"><i class="ti-direction-alt"></i> <?php echo site_phrase('choose_delivery_address', true); ?></div>
                        <div id="mapid1" class="mb-1 address-map img-thumbnail"></div>
                        <div id="mapid2" class="mb-1 address-map img-thumbnail"></div>
                        <div id="mapid3" class="mb-1 address-map img-thumbnail"></div>
                        <?php if (!empty($customer_details['address_1'])) : ?>
                            <div class="callout callout-warning">
                                <input type="radio" name="address" value="1" onchange="toggleMap(this.value)" checked> <strong><?php echo site_phrase('address_1'); ?> : </strong> <?php echo sanitize($customer_details['address_1']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($customer_details['address_2'])) : ?>
                            <div class="callout callout-warning">
                                <input type="radio" name="address" value="2" onchange="toggleMap(this.value)"> <strong><?php echo site_phrase('address_2'); ?> : </strong><?php echo sanitize($customer_details['address_2']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($customer_details['address_3'])) : ?>
                            <div class="callout callout-warning">
                                <input type="radio" name="address" value="3" onchange="toggleMap(this.value)"> <strong><?php echo site_phrase('address_3'); ?> : </strong><?php echo sanitize($customer_details['address_3']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="text-center">
                <h5><?php echo site_phrase('user_is_not_logged_in'); ?></h5>
            </div>
        <?php endif; ?>
    </div>
</section>
