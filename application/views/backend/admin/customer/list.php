<div class="card">
  <div class="card-body">
    <form action="<?php echo site_url('customer'); ?>" action="get">
      <div class="row justify-content-sm-center">
        <div class="col-lg-4">
          <div class="form-group">
            <label><?php echo get_phrase('status'); ?></label>
            <select class="form-control select2 w-100" name="status">
              <option value="approved" <?php if ($status == "approved") echo "selected"; ?>><?php echo get_phrase('approved'); ?></option>
              <option value="pending" <?php if ($status == "pending") echo "selected"; ?>><?php echo get_phrase('pending'); ?></option>
            </select>
          </div>
        </div>
        <div class="col-1">
          <div class="form-group mt-30">
            <button type="submit" class="btn btn-primary"><?php echo get_phrase('filter'); ?></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<?php if (count($customers)) : ?>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="alert alert-info alert-dismissible fade show lighten-info" role="alert">
        <strong><?php echo get_phrase('heads_up'); ?>!</strong>
        <p>
          <?php echo get_phrase('every_restaurant_owner_is_also_a_customer'); ?>. <?php echo get_phrase('a_restaurant_owner_has_all_the_features_that_a_customer_has'); ?>.
        </p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <?php foreach ($customers as $key => $customer) : ?>
      <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
        <div class="card bg-light">
          <div class="card-header text-muted border-bottom-0">
            <h2 class="lead"><b><?php echo sanitize($customer['name']); ?></b></h2>
          </div>
          <div class="card-body pt-0">
            <div class="row">
              <div class="col-7">
                <?php if (is_restaurant_owner(sanitize($customer['id']))) : ?>
                  <div class="text-muted text-sm mb-1"><i class="fas fa-user-tie"></i> <strong><span class="badge badge-info lighten-info"><?php echo get_phrase('restaurant_owner'); ?></span></strong> </div>
                <?php endif; ?>
                <div class="text-muted text-sm mb-1">
                  <i class="far fa-calendar-check"></i> <b><?php echo get_phrase('Total_ordered'); ?></b> :
                  <?php echo count($this->order_model->get_by_condition(['customer_id' => sanitize($customer['id'])])); ?>
                </div>
                <div class="text-muted text-sm mb-1"><i class="far fa-calendar-times"></i> <b><?php echo get_phrase('Total_canceled'); ?></b>:
                  <?php echo count($this->order_model->get_by_condition(['customer_id' => sanitize($customer['id']), 'order_status' => 'canceled'])); ?>
                </div>
                <div class="text-muted text-sm mb-1"><i class="fas fa-phone-square"></i> <b><?php echo get_phrase('Phone'); ?></b>: <?php echo getter(sanitize($customer['phone']), get_phrase('not_found')); ?> </div>
                <div class="text-muted text-sm mb-1"><i class="fas fa-map-signs"></i> <b><?php echo get_phrase('adress'); ?></b>: <?php echo getter(ellipsis(sanitize($customer['address_1']), 40), get_phrase('not_found')); ?> </div>
              </div>
              <div class="col-5 text-center">
                <img src="<?php echo base_url('uploads/user/' . sanitize($customer['thumbnail'])); ?>" alt="" class="img-circle img-fluid">
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-12">
                <div class="text-right">
                  <a href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('customer/delete/' . sanitize($customer['id'])); ?>')" class="btn btn-sm bg-danger" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('delete'); ?>">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                  <a href="<?php echo site_url('customer/profile/' . sanitize($customer['id']) . '/profile'); ?>" class="btn btn-sm bg-teal" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('edit'); ?>">
                    <i class="fas fa-user-edit"></i>
                  </a>
                  <a href="<?php echo site_url('customer/profile/' . sanitize($customer['id'])); ?>" class="btn btn-sm btn-primary">
                    <?php echo get_phrase('View_Profile'); ?>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<nav aria-label="Page Navigation">
  <?php echo $this->pagination->create_links(); ?>
</nav>

<?php if (count($customers) == 0) : ?>
  <?php isEmpty(); ?>
<?php endif; ?>
