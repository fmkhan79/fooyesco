<?php $restaurant_ids = $this->cart_model->get_restaurant_ids(); ?>
<?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>
<div class="row justify-content-md-end">
    <div class="col-sm-8 text-right">
        <h6><i class="fas fa-spinner fa-pulse summary-loader mr-2 d-none"></i><?php echo site_phrase('total_bill', true); ?></h6>
        <table class="bill-table">
            <tr>
                <td class="bill-type"><?php echo site_phrase('total_menu_price'); ?> :</td>
                <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_total_menu_price())); ?></td>
            </tr>
            <tr>
                <td class="bill-type">VAT :</td>
                <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_vat_amount())); ?></td>
            </tr>
            <tr>
                <td class="bill-type"><?php echo site_phrase('sub_total'); ?> :</td>
                <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_sub_total())); ?></td>
            </tr>
            <tr>
                <td class="bill-type">
                    <?php echo site_phrase('delivery_charge_for') . ' ' . count($restaurant_ids) . ' ' . site_phrase('restaurants'); ?> :
                </td>
                <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_total_delivery_charge())); ?></td>
            </tr>
            <tr>
                <td class="bill-type"><?php echo site_phrase('grand_total'); ?> :</td>
                <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_grand_total())); ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php if (!$customer_details || count($customer_details) == 0) : ?>
                        <a href="<?php echo site_url('auth'); ?>" class="btn btn-primary btn-sm pl-5 pr-5 pt-2 pb-2 btn-block"><?php echo site_phrase('login_first', true); ?></a>
                    <?php else : ?>
                        <form action="<?php echo site_url('checkout'); ?>" method="get">
                            <input type="hidden" name="address_number" id="address-number" value="1">
                            <div class="featured-btn-wrap text-right mt-3"><button type="submit" class="btn btn-danger btn-sm pl-5 pr-5 pt-2 pb-2"><?php echo site_phrase('checkout_order', true); ?></button></div>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</div>