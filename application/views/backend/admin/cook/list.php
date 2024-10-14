<?php if (count($cooks)) : ?>
  <div class="row justify-content-center">
    <?php foreach ($cooks as $key => $cook) :
      $belongs = $this->cook_model->restaurants_he_belongs_to($cook['id']);
    ?>
      <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
        <div class="card bg-light">
          <div class="card-header text-muted border-bottom-0">
            <h2 class="lead"><b><?php echo sanitize($cook['name']); ?></b></h2>
          </div>
          <div class="card-body pt-0">
            <div class="row">
              <div class="col-7">
                <div class="text-muted text-sm mb-1"><i class="fas fa-envelope"></i> <b><?php echo get_phrase('email'); ?></b>: <?php echo sanitize($cook['email']); ?> </div>
                <div class="text-muted text-sm mb-1"><i class="fas fa-phone-square"></i> <b><?php echo get_phrase('Phone'); ?></b>: <?php echo sanitize($cook['phone']); ?> </div>
                <div class="text-muted text-sm mb-1"><i class="fas fa-calendar-alt"></i> <b><?php echo get_phrase('joined'); ?></b>: <?php echo date('D, d-M-Y', sanitize($cook['created_at'])); ?> </div>
                <?php foreach ($belongs as $key => $belong) : ?>
                  <div class="text-muted text-sm mb-1"><i class="fas fa-utensils"></i> <b><?php echo get_phrase('belongs'); ?></b>:
                    <a href="<?php echo site_url('site/restaurant/' . $belong['restaurant_slug'] . '/' . $belong['restaurant_id']); ?>" target="_blank">
                      <?php echo sanitize($belong['restaurant_name']); ?>
                    </a>
                    <a href="javascript:void(0);" class="text-danger" onclick="confirm_modal('<?php echo site_url('cook/remove_from_restaurant/' . sanitize($belong['id'])); ?>')">
                      <i class="fas fa-times-circle"></i>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="col-5 text-center">
                <img src="<?php echo base_url('uploads/user/' . sanitize($cook['thumbnail'])); ?>" alt="" class="img-circle img-fluid">
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-12">
                <div class="text-right">
                  <a href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('cook/delete/' . sanitize($cook['id'])); ?>')" class="btn btn-sm bg-danger" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('delete'); ?>">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                  <a href="<?php echo site_url('cook/profile/' . sanitize($cook['id']) . '/profile'); ?>" class="btn btn-sm bg-teal" data-toggle="tooltip" data-placement="top" title="<?php echo get_phrase('edit'); ?>">
                    <i class="fas fa-user-edit"></i>
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

<?php if (count($cooks) == 0) : ?>
  <?php isEmpty(); ?>
<?php endif; ?>