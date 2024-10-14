<?php
    $total_paid_commission = $this->report_model->get_total_paid_commission($param2);
    $total_payable_commission = $this->report_model->get_total_payable_commission($param2);
    $due = $total_payable_commission - $total_paid_commission;
 ?>
<form action="<?php echo site_url('report/pay'); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input type="hidden" name="restaurant_id" value="<?php echo sanitize($param2); ?>">
        <label for="amount_to_pay"><?php echo get_phrase("amount_to_pay"); ?></label>
        <input type="text" class="form-control" id="amount_to_pay" name="amount_to_pay" placeholder="<?php echo get_phrase("due_commission_is").' '.currency(sanitize($due)); ?>" required>
        <small class="text-danger"><strong><?php echo get_phrase('note') ?></strong> : <?php echo get_phrase('you_can_not_pay_more_than').' '.currency(sanitize($due)); ?></small>
    </div>
    <button type="submit" class="btn btn-primary" name="button"><?php echo get_phrase("pay"); ?></button>
</form>
