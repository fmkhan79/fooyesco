<div class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mt-1 text-dark"><?php echo ucwords($page_title); ?></h4>
                    </div>
                    <div class="col-6">
                        <?php if ($page_name == 'menu/index') : ?>
                            <a href="<?php echo site_url('menu/create'); ?>" class="btn btn-outline-primary btn-rounded float-right" name="button"><?php echo get_phrase("add_new_menu", true); ?></a>
                            <a href="#" class="btn btn-outline-success btn-rounded float-right mr-1" data-toggle="modal" data-target="#priceIncreaseModal">
    <i class="fas fa-percentage"></i> Increase Prices / Decrease Prices
</a>

                        <?php elseif ($page_name == 'menu/create') : ?>
                            <a href="<?php echo site_url('menu'); ?>" class="btn btn-outline-primary btn-rounded float-right" name="button"><?php echo get_phrase("back_to_menu", true); ?></a>
                            
                        <?php elseif ($page_name == 'menu/edit') : ?>
                            <?php
                            $restaurant_id = $menu_data['restaurant_id'];
                            $restaurant_slug = slugify($menu_data['restaurant_name']);
                            ?>
                            <a href="<?php echo site_url('menu'); ?>" class="btn btn-outline-primary btn-rounded float-right" name="button"><?php echo get_phrase("back_to_menu", true); ?></a>
                            <a href="<?php echo site_url("site/restaurant/$restaurant_slug/$restaurant_id"); ?>" class="btn btn-outline-primary btn-rounded float-right mr-1" name="button" target="_blank"> <i class="fas fa-external-link-alt"></i> <?php echo get_phrase("view_in_frontend", true); ?></a>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>

<!-- Price Increase/Decrease Modal -->
<div class="modal fade" id="priceIncreaseModal" tabindex="-1" aria-labelledby="priceIncreaseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="priceUpdateForm" method="POST" action="<?php echo site_url('menu/update_prices'); ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="priceIncreaseModalLabel">Update Menu Prices</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="percentage">Enter percentage (%):</label>
            <input type="number" step="0.01" class="form-control" name="percentage" id="percentage" placeholder="e.g. 10 for +10% or -5 for -5%" required>
            <small class="form-text text-muted">
              Enter a positive value to increase or a negative value to decrease prices.
            </small>

              <!-- <?php if ($this->session->userdata('last_percentage')): ?> -->
              <small class="text-danger">
                  Last applied: <?= ($this->session->userdata('last_percentage') ?? 20) ?>%
              </small>

          <!-- <?php endif; ?> -->
            </div>
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Apply Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
