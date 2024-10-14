<?php $restaurant_ids = $this->cart_model->get_restaurant_ids(); ?>
<?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>
<div class="row justify-content-md-end">
<div class="col-sm-4">

<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $this->session->userdata('user_id');  ?>" >
</div>
    <div class="col-sm-4">
        <h6><i class="fas fa-spinner fa-pulse summary-loader mr-2 d-none"></i><?php echo site_phrase('total_bill', true); ?></h6>
        <table class="bill-table">
            <tr>
                <td class="bill-type"><?php echo site_phrase('total_menu_price'); ?> :</td>
                <td class="bill-value font-weight-bold"><?php echo currency(sanitize($this->cart_model->get_total_menu_price())); ?></td>
            </tr>
            <tr>
                <td class="bill-type">VAT :</td>
                <td class="bill-value font-weight-bold"><?php echo currency(sanitize($this->cart_model->get_vat_amount())); ?></td>
            </tr>
            <tr>
                <td class="bill-type"><?php echo site_phrase('sub_total'); ?> :</td>
                <td class="bill-value font-weight-bold"><?php echo currency(sanitize($this->cart_model->get_sub_total())); ?></td>
            </tr>
            <tr>
                <td class="bill-type">
                    <?php echo site_phrase('delivery_charge'); ?> :
                </td>
                <td class="bill-value font-weight-bold"><?php echo currency(sanitize($this->cart_model->get_total_delivery_charge())); ?></td>
            </tr>
            <tr>
                <td class="bill-type">
                    <?php echo site_phrase('service_charge'); ?> :
                </td>
                <td class="bill-value font-weight-bold"><?php echo currency(sanitize($this->cart_model->get_service_amount())); ?></td>
            </tr>
            <?php
             $grand_total = $this->cart_model->get_grand_total();
             $discount =  $this->cart_model->get_discound_val();
             $discountAmount = 0;
             if($discount && $discount > 0){
                $discountAmount =  ($grand_total * $discount) / 100;
                }
              ?>
              <?php if($discountAmount > 0){ ?>
            <tr  style="">
           
            <input type="hidden" name="discount_amount" id="discount_amount" value="<?php echo $discountAmount; ?>">
                <td class="bill-type"><?php echo site_phrase('discount'); ?> :</td>
                <td class="bill-value font-weight-bold" id="discount_amount_lable"><?php echo currency($discountAmount); ?> </td>
            </tr>
            <?php } ?>
            <tr class="text-danger">
            <input type="hidden" name="grand_total_code" id="grand_total_code" value="<?php echo sanitize($this->cart_model->get_grand_total()); ?>">
                <td class="bill-type"><?php echo site_phrase('grand_total'); ?> :</td>
                <td class="bill-value font-weight-bold" id="grand_total_label"><?php echo currency(sanitize($this->cart_model->get_grand_total())); ?></td>
            </tr>
            <tr>
                <td class="buttonsWrapper">
                    <?php if (!$customer_details || count($customer_details) == 0) : ?>
                        <a href="<?php echo site_url('auth'); ?>" class="rr-btn"><?php echo site_phrase('login_first', true); ?></a>
                        <a href="<?php echo site_url('GuestCheckout'); ?>" class="rr-btn">Guest Checkout</a>
                    <?php else : ?>
                        <form action="<?php echo site_url('checkout'); ?>" method="get">
                            <input type="hidden" name="address_number" id="address-number" value="1">
                            <div class="featured-btn-wrap text-right mt-3"><button type="submit" class="btn btn-danger btn-sm pl-5 pr-5 pt-2 pb-2 bg-danger rr-btn w-100"><?php echo site_phrase('checkout', true); ?></button></div>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</div>