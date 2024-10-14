<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>

<!-- RESTAURANT GALLERY -->
<?php include 'gallery.php'; ?>

<!-- RESTAURANT TITLE HEADER -->
<section class="reserve-block">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h5 class="mb-3">
          <?php echo sanitize($restaurant_details['name']); ?>
          <div class="reserve-rating">
            <span><?php echo sanitize($restaurant_details['rating']); ?></span>
          </div>
        </h5>
        <div class="reserve-description">
          <?php foreach (json_decode($restaurant_details['cuisine']) as $cuisine) : ?>
            <?php
            $cuisine = $this->cuisine_model->get_by_id($cuisine);
            if (isset($cuisine) && count($cuisine)) : ?>
              <label class="custom-checkbox">
                <span class="ti-check-box text-danger"></span>
                <span class="custom-control-description">
                  <?php echo sanitize($cuisine['name']); ?>
                </span>
              </label>
            <?php endif; ?>
          <?php endforeach; ?>
          <?php if (count(json_decode($restaurant_details['cuisine'])) == 0) : ?>
            <small><?php echo site_phrase('no_cuisine_found'); ?></small>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-4">
        <div class="d-block">
          <p class="reserve-description text-dark d-block text-right"><?php echo site_phrase('delivery_charge'); ?> : <strong><?php echo delivery_charge($restaurant_details['id']) > 0 ? currency(sanitize(delivery_charge($restaurant_details['id']))) : site_phrase('free'); ?></strong>.</p>
          <p class="reserve-description text-dark d-block text-right"><?php echo site_phrase('maximum_time_to_deliver'); ?> : <strong><?php echo sanitize(maximum_time_to_deliver($restaurant_details['id'])); ?></strong> <?php echo site_phrase('minutes'); ?>.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- MAIN CONTENT -->
<section class="light-bg booking-details_wrap">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-9 responsive-wrap">
        <?php
        $categories = $this->category_model->get_categories_by_restaurant_id($restaurant_details['id']);
        foreach ($categories as $category) : ?>
          <div class="booking-checkbox_wrap">
            <h5 class="text-left"><?php echo sanitize($category['name']); ?></h5>
            <hr>
            <div class="booking-checkbox">
              <div class="row">
                <?php
                $menus = $this->menu_model->get_menu_by_condition(['category_id' => sanitize($category['id']), 'restaurant_id' => sanitize($restaurant_details['id'])]);
                foreach ($menus as $key => $menu) : ?>
                  <div class="col-xl-3 col-lg-4 col-md-6 featured-responsive">
                    <div class="featured-place-wrap food-item-card">
                      <a href="javascript:void(0)" onclick="showCartModal('<?php echo site_url('modal/showup/restaurant/cart/' . $menu['id']); ?>', '<?php echo sanitize($menu['name']); ?>')">
                        <img src="<?php echo base_url('uploads/menu/' . sanitize($menu['thumbnail'])); ?>" class="img-fluid" alt="#">
                      </a>
                      <div class="featured-title-box">
                        <a href="javascript:void(0)" onclick="showCartModal('<?php echo site_url('modal/showup/restaurant/cart/' . $menu['id']); ?>', '<?php echo sanitize($menu['name']); ?>')">
                          <h6 data-toggle="tooltip" data-placement="top" title="<?php echo sanitize($menu['name']); ?>"><?php echo sanitize($menu['name']); ?></h6>
                        </a>

                        <!-- PRICE SECTION -->
                        <di class="menu-price-section">
                          <!-- IF SERVINGS IS MENU -->
                          <?php if ($menu['servings'] == "menu") : ?>
                            <p><?php echo site_phrase('menu'); ?>:</p>
                            <span class="p-0">
                              <?php if (has_discount($menu['id'])) : ?>
                                <span class="strikethrough"><?php echo currency(sanitize(get_menu_price($menu['id'], "menu", "actual_price"))); ?></span><?php echo currency(get_menu_price($menu['id'])); ?>
                              <?php else : ?>
                                <?php echo currency(sanitize(get_menu_price($menu['id']))); ?>
                              <?php endif; ?>
                            </span>
                            <!-- IF SERVINGS IS PLATE -->
                          <?php else : ?>
                            <p><?php echo site_phrase('full_plate'); ?>:</p>
                            <span class="p-0">
                              <?php if (has_discount($menu['id'], "full_plate")) : ?>
                                <span class="strikethrough"><?php echo currency(get_menu_price($menu['id'], "full_plate", "actual_price")); ?></span><?php echo currency(sanitize(get_menu_price($menu['id'], "full_plate"))); ?>
                              <?php else : ?>
                                <?php echo currency(sanitize(get_menu_price($menu['id'], "full_plate"))); ?>
                              <?php endif; ?>
                            </span>
                            <br>
                            <p><?php echo site_phrase('half_plate'); ?>:</p>
                            <span class="p-0">
                              <?php if (has_discount($menu['id'], "half_plate")) : ?>
                                <span class="strikethrough"><?php echo currency(get_menu_price($menu['id'], "half_plate", "actual_price")); ?></span><?php echo currency(get_menu_price($menu['id'], "half_plate")); ?>
                              <?php else : ?>
                                <?php echo currency(get_menu_price($menu['id'], "half_plate")); ?>
                              <?php endif; ?>
                            </span>
                          <?php endif; ?>
                        </di>
                        <br>

                        <div class="bottom-icons <?php if ($menu['servings'] == "menu") echo 'mt-22'; ?>">
                          <?php if ($menu['availability']) : ?>
                            <div class="closed-now">
                              <a href="javascript:void(0)" onclick="showModalWithHeader('<?php echo site_url('modal/showup/restaurant/menu/' . $menu['id']); ?>', '<?php echo sanitize($menu['name']); ?>')">
                                <span class="fas fa-question-circle"></span>
                              </a>
                            </div>
                          <?php else : ?>
                            <div class="closed-now"><?php echo strtoupper(site_phrase('unavailable')); ?></div>
                          <?php endif; ?>

                          <!-- FAVOURITE ICON -->
                          <?php $class_name = $this->favourite_model->is_added($menu['id']) ? "fas fa-heart filled-favourite" : "far fa-heart";  ?>
                          <span class="<?php echo sanitize($class_name); ?>" onclick="confirm_modal('<?php echo site_url('favourite/update/' . $menu['id']); ?>')"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <!-- REVIEW PORTION -->
        <?php $reviews = $this->review_model->get_by_condition(['restaurant_id' => $restaurant_details['id']]); ?>
        <div class="booking-checkbox_wrap mt-4">
          <h5> <?php echo count($reviews) . ' ' . site_phrase('Reviews'); ?></h5>

          <?php foreach ($reviews as $key => $review) :
            $customer_details = $this->db->get_where('users', ['id' => $review['customer_id']])->row_array();
          ?>
            <hr>
            <div class="customer-review_wrap">
              <div class="customer-img">
                <img src="<?php echo base_url('uploads/user/' . $customer_details['thumbnail']); ?>" class="img-fluid" alt="#">
                <p><?php echo sanitize($customer_details['name']); ?></p>
              </div>
              <div class="customer-content-wrap">
                <div class="customer-content">
                  <div class="customer-review">
                    <?php for ($i = 1; $i <= $review['rating']; $i++) : ?>
                      <span></span>
                    <?php endfor; ?>
                    <?php $rest_rating = 5 - $review['rating'];
                    for ($i = 1; $i <= $rest_rating; $i++) : ?>
                      <span class="round-icon-blank"></span>
                    <?php endfor; ?>
                    <p><?php echo site_phrase('Reviewed'); ?> <?php echo date('D, d-M-Y', $review['timestamp']); ?></p>
                  </div>
                  <div class="customer-rating"><?php echo sanitize($review['rating']); ?></div>
                </div>
                <p class="customer-text">
                  <?php echo sanitize($review['review']); ?>
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-md-3 responsive-wrap">
        <div class="contact-info">
          <div id="map"></div>
          <div class="address">
            <span class="icon-location-pin"></span>
            <p><?php echo getter(sanitize($restaurant_details['address']), site_phrase('not_found')); ?></p>
          </div>
          <div class="address">
            <span class="icon-screen-smartphone"></span>
            <p><?php echo getter(sanitize($restaurant_details['phone']), site_phrase('not_found')); ?></p>
          </div>
          <div class="address">
            <span class="icon-link"></span>
            <p><a href="<?php echo sanitize($restaurant_details['website']); ?>" target="_blank" class="text-body"><?php echo getter(sanitize($restaurant_details['website']), site_phrase('not_found')); ?></a></p>
          </div>
          <div class="address pb-3">
            <span class="icon-clock"></span>
            <p>
              <?php if (!empty($restaurant_details['schedule'])) : ?>
                <?php $time_configurations = json_decode($restaurant_details['schedule'], true);
                $today = strtolower(date('l'));
                echo ucfirst($today); ?> :
                <?php if (is_open($restaurant_details['id'])) : ?>
                  <span class="open-now"><?php echo strtoupper(site_phrase('open_now')); ?></span>
                <?php else : ?>
                  <span class="closed-now"><?php echo strtoupper(site_phrase('close_now')); ?></span>
                <?php endif; ?>
              <?php else : ?>
                <?php echo site_phrase('not_found'); ?>
              <?php endif; ?>
            </p>
          </div>
        </div>

        <div class="follow">
          <div class="follow-img">
            <h6><?php echo site_phrase('availability', true); ?></h6>
          </div>
          <div class="restaurant-schedule">
            <?php $schedule = json_decode($restaurant_details['schedule'], true);
            $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']; ?>
            <table class="w-100">
              <?php foreach ($days as $key => $day) : ?>
                <tr class="text-center">
                  <td class="w-50 restaurant-day-schedule"><?php echo ucfirst($day); ?></td>
                  <td class="w-50 restaurant-time-schedule">
                    <?php if (!isset($schedule[$day . '_opening']) || $schedule[$day . '_opening'] == "closed") : ?>
                      <span class="text-danger"><?php echo site_phrase('closed'); ?></span>
                    <?php else : ?>
                      <?php echo date("h:i A", strtotime($schedule[$day . '_opening'])); ?> - <?php echo date("h:i A", strtotime($schedule[$day . '_closing'])); ?>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>