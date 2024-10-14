<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>

<!-- RESTAURANT GALLERY -->
<?php include 'gallery.php'; ?>

<!-- RESTAURANT TITLE HEADER -->
<section class="reserve-block">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h5 class="mb-3 text-theme-dark">
          <?php echo sanitize($restaurant_details['name']); ?>
          <div class="reserve-rating">
            <span>
              <?php echo sanitize($restaurant_details['rating']); ?>
            </span>
          </div>
        </h5>
        <div class="reserve-description">
          <?php foreach (json_decode($restaurant_details['cuisine']) as $cuisine): ?>
            <?php
            $cuisine = $this->cuisine_model->get_by_id($cuisine);
            if (isset($cuisine) && count($cuisine)): ?>
              <label class="custom-checkbox">
                <span class="ti-check-box text-danger"></span>
                <span class="custom-control-description">
                  <?php echo sanitize($cuisine['name']); ?>
                </span>
              </label>
            <?php endif; ?>
          <?php endforeach; ?>
          <?php if (count(json_decode($restaurant_details['cuisine'])) == 0): ?>
            <small>
              <?php echo site_phrase('no_cuisine_found'); ?>
            </small>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-4">
        <div class="d-block">
          <p class="reserve-description text-dark d-block text-right">
            <?php echo site_phrase('delivery_charge'); ?> : <strong>
              <?php echo delivery_charge($restaurant_details['id']) > 0 ? currency(sanitize(delivery_charge($restaurant_details['id']))) : site_phrase('free'); ?>
            </strong>.
          </p>
          <p class="reserve-description text-dark d-block text-right">
            <?php echo site_phrase('maximum_time_to_deliver'); ?> : <strong>
              <?php echo sanitize(maximum_time_to_deliver($restaurant_details['id'])); ?>
            </strong>
            <?php echo site_phrase('minutes'); ?>.
          </p>
        </div>
      </div>
    </div>
  </div>

</section>


<!-- MAIN CONTENT -->
<section class="light-bg booking-details_wrap">

  <div class="container-fluid">
    <div class="row">
      <div class="col food-ractangle d-flex flex-row justify-content-between align-items-center">
        <div class="d-flex flex-column">
          <h6>
            Free Delivery for your first 14 days!
          </h6>
          <small class="text-uppercase">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip.</small>
        </div>
        <a class="btn" href="#">Order Now</a>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-9 responsive-wrap">
        <!-- <div class="card menu-listing">
          <div class="row">
            <div class="col-3">
              <div class="left-listing">
                <img src="http://localhost:8000/uploads/menu/placeholder.png" alt="">
                <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 250 250" fill="none">
                        <circle cx="125.035" cy="124.965" r="116.153" transform="rotate(178.687 125.035 124.965)" stroke="url(#paint0_linear_33_536)" stroke-width="16"/>
                        <defs>
                            <linearGradient id="paint0_linear_33_536" x1="131.787" y1="144.132" x2="131.787" y2="280.046" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#F54748" stop-opacity="0"/>
                            <stop offset="1" stop-color="#FDC55E"/>
                            </linearGradient>
                        </defs>
                        </svg>
              </div>
            </div>
            <div class="col-9">
              <h1>Hello</h1>
            </div>
          </div>
        </div> -->
        <div class="bg-gradient-primary">
          <?php
          $categories = $this->category_model->get_categories_by_restaurant_id($restaurant_details['id']);
          foreach ($categories as $category): ?>
            <div class="booking-checkbox_wrap">
              <h5 class="text-left">
                <?php echo sanitize($category['name']); ?>
              </h5>
              <hr>
              <div class="booking-checkbox">
                <div class="row">
                  <?php
                  $menus = $this->menu_model->get_menu_by_condition(['category_id' => sanitize($category['id']), 'restaurant_id' => sanitize($restaurant_details['id'])]);
                  foreach ($menus as $key => $menu): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 featured-responsive">
                      <div class="featured-place-wrap food-item-card">
                        <a href="javascript:void(0)"
                          onclick="showCartModal('<?php echo site_url('modal/showup/restaurant/cart/' . $menu['id']); ?>', '<?php echo sanitize($menu['name']); ?>')">
                          <img src="<?php echo base_url('uploads/menu/' . sanitize($menu['thumbnail'])); ?>"
                            class="img-fluid" alt="#">
                        </a>
                        <div class="featured-title-box">
                          <a href="javascript:void(0)"
                            onclick="showCartModal('<?php echo site_url('modal/showup/restaurant/cart/' . $menu['id']); ?>', '<?php echo sanitize($menu['name']); ?>')">
                            <h6 class="text-theme-dark" data-toggle="tooltip" data-placement="top" title="<?php echo sanitize($menu['name']); ?>">
                              <?php echo sanitize($menu['name']); ?>
                            </h6>
                          </a>

                          <!-- PRICE SECTION -->
                          <di class="menu-price-section">
                            <!-- IF SERVINGS IS MENU -->
                            <?php if ($menu['servings'] == "menu"): ?>
                              <p>
                                <?php echo site_phrase('menu'); ?>:
                              </p>
                              <span class="p-0">
                                <?php if (has_discount($menu['id'])): ?>
                                  <span class="strikethrough">
                                    <?php echo currency(sanitize(get_menu_price($menu['id'], "menu", "actual_price"))); ?>
                                  </span>
                                  <?php echo currency(get_menu_price($menu['id'])); ?>
                                <?php else: ?>
                                  <?php echo currency(sanitize(get_menu_price($menu['id']))); ?>
                                <?php endif; ?>
                              </span>
                              <!-- IF SERVINGS IS PLATE -->
                            <?php else: ?>
                              <p>
                                <?php echo site_phrase('full_plate'); ?>:
                              </p>
                              <span class="p-0">
                                <?php if (has_discount($menu['id'], "full_plate")): ?>
                                  <span class="strikethrough">
                                    <?php echo currency(get_menu_price($menu['id'], "full_plate", "actual_price")); ?>
                                  </span>
                                  <?php echo currency(sanitize(get_menu_price($menu['id'], "full_plate"))); ?>
                                <?php else: ?>
                                  <?php echo currency(sanitize(get_menu_price($menu['id'], "full_plate"))); ?>
                                <?php endif; ?>
                              </span>
                              <br>
                              <p>
                                <?php echo site_phrase('half_plate'); ?>:
                              </p>
                              <span class="p-0">
                                <?php if (has_discount($menu['id'], "half_plate")): ?>
                                  <span class="strikethrough">
                                    <?php echo currency(get_menu_price($menu['id'], "half_plate", "actual_price")); ?>
                                  </span>
                                  <?php echo currency(get_menu_price($menu['id'], "half_plate")); ?>
                                <?php else: ?>
                                  <?php echo currency(get_menu_price($menu['id'], "half_plate")); ?>
                                <?php endif; ?>
                              </span>
                            <?php endif; ?>
                        </div>
                        <br>

                        <div class="restaurant-body">
                          <div class="review-grid">
                            <ul class="inline-grid">
                              <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                  height="38"></li>
                              <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                  height="38"></li>
                              <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                  height="38"></li>
                            </ul>
                            <div class="star">
                              <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                  d="M11.0489 0.926805C11.3483 0.00549436 12.6517 0.00549579 12.9511 0.926806L14.9187 6.98253C15.0526 7.39456 15.4365 7.67352 15.8697 7.67352H22.2371C23.2058 7.67352 23.6086 8.91313 22.8249 9.48253L17.6736 13.2252C17.3231 13.4798 17.1764 13.9312 17.3103 14.3432L19.2779 20.3989C19.5773 21.3203 18.5228 22.0864 17.7391 21.517L12.5878 17.7743C12.2373 17.5197 11.7627 17.5197 11.4122 17.7743L6.2609 21.517C5.47719 22.0864 4.42271 21.3203 4.72206 20.3989L6.68969 14.3432C6.82356 13.9312 6.6769 13.4798 6.32642 13.2252L1.17511 9.48253C0.391392 8.91313 0.794168 7.67352 1.76289 7.67352H8.13026C8.56349 7.67352 8.94744 7.39456 9.08132 6.98253L11.0489 0.926805Z"
                                  fill="#FFB800" />
                              </svg>
                            </div>
                            <p>(3)</p>
                          </div>

                          <div class="bottom-icons <?php if ($menu['servings'] == "menu")
                            echo 'mt-2'; ?>">
                            <?php if ($menu['availability']): ?>
                              <div class="closed-now">
                                <a href="javascript:void(0)"
                                  onclick="showModalWithHeader('<?php echo site_url('modal/showup/restaurant/menu/' . $menu['id']); ?>', '<?php echo sanitize($menu['name']); ?>')">
                                  <span class="fas fa-question-circle"></span>
                                </a>
                              </div>
                            <?php else: ?>
                              <div class="closed-now">
                                <?php echo strtoupper(site_phrase('unavailable')); ?>
                              </div>
                            <?php endif; ?>

                            <!-- FAVOURITE ICON -->
                            <?php $class_name = $this->favourite_model->is_added($menu['id']) ? "fas fa-heart filled-favourite" : "far fa-heart"; ?>
                            <span class="<?php echo sanitize($class_name); ?>"
                              onclick="confirm_modal('<?php echo site_url('favourite/update/' . $menu['id']); ?>')"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- REVIEW PORTION -->
        <?php $reviews = $this->review_model->get_by_condition(['restaurant_id' => $restaurant_details['id']]); ?>
        <div class="booking-checkbox_wrap mt-4">
          <h5>
            <?php echo count($reviews) . ' ' . site_phrase('Reviews'); ?>
          </h5>

          <?php foreach ($reviews as $key => $review):
            $customer_details = $this->db->get_where('users', ['id' => $review['customer_id']])->row_array();
            ?>
            <hr>
            <div class="customer-review_wrap">
              <div class="customer-img">
                <img src="<?php echo base_url('uploads/user/' . $customer_details['thumbnail']); ?>" class="img-fluid"
                  alt="#">
                <p>
                  <?php echo sanitize($customer_details['name']); ?>
                </p>
              </div>
              <div class="customer-content-wrap">
                <div class="customer-content">
                  <div class="customer-review">
                    <?php for ($i = 1; $i <= $review['rating']; $i++): ?>
                      <span></span>
                    <?php endfor; ?>
                    <?php $rest_rating = 5 - $review['rating'];
                    for ($i = 1; $i <= $rest_rating; $i++): ?>
                      <span class="round-icon-blank"></span>
                    <?php endfor; ?>
                    <p>
                      <?php echo site_phrase('Reviewed'); ?>
                      <?php echo date('D, d-M-Y', $review['timestamp']); ?>
                    </p>
                  </div>
                  <div class="customer-rating">
                    <?php echo sanitize($review['rating']); ?>
                  </div>
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
        <div class="border border-1 border-dark rounded">
          <h3 class="text-theme-dark">Filter Products Area</h1>
        </div>
        <div class="contact-info">
          <div id="map"></div>
          <div class="address">
            <span class="icon-location-pin"></span>
            <p>
              <?php echo getter(sanitize($restaurant_details['address']), site_phrase('not_found')); ?>
            </p>
          </div>
          <div class="address">
            <span class="icon-screen-smartphone"></span>
            <p>
              <?php echo getter(sanitize($restaurant_details['phone']), site_phrase('not_found')); ?>
            </p>
          </div>
          <div class="address">
            <span class="icon-link"></span>
            <p><a href="<?php echo sanitize($restaurant_details['website']); ?>" target="_blank" class="text-body">
                <?php echo getter(sanitize($restaurant_details['website']), site_phrase('not_found')); ?>
              </a></p>
          </div>
          <div class="address pb-3">
            <span class="icon-clock"></span>
            <p>
              <?php if (!empty($restaurant_details['schedule'])): ?>
                <?php $time_configurations = json_decode($restaurant_details['schedule'], true);
                $today = strtolower(date('l'));
                echo ucfirst($today); ?> :
                <?php if (is_open($restaurant_details['id'])): ?>
                  <span class="open-now">
                    <?php echo strtoupper(site_phrase('open_now')); ?>
                  </span>
                <?php else: ?>
                  <span class="closed-now">
                    <?php echo strtoupper(site_phrase('close_now')); ?>
                  </span>
                <?php endif; ?>
              <?php else: ?>
                <?php echo site_phrase('not_found'); ?>
              <?php endif; ?>
            </p>
          </div>
        </div>

        <div class="follow">
          <div class="follow-img text-theme-dark">
            <h6>
              <?php echo site_phrase('availability', true); ?>
            </h6>
          </div>
          <div class="restaurant-schedule">
            <?php $schedule = json_decode($restaurant_details['schedule'], true);
            $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']; ?>
            <table class="w-100">
              <?php foreach ($days as $key => $day): ?>
                <tr class="text-center">
                  <td class="w-50 restaurant-day-schedule">
                    <?php echo ucfirst($day); ?>
                  </td>
                  <td class="w-50 restaurant-time-schedule">
                    <?php if (!isset($schedule[$day . '_opening']) || $schedule[$day . '_opening'] == "closed"): ?>
                      <span class="text-danger">
                        <?php echo site_phrase('closed'); ?>
                      </span>
                    <?php else: ?>
                      <?php echo date("h:i A", strtotime($schedule[$day . '_opening'])); ?> -
                      <?php echo date("h:i A", strtotime($schedule[$day . '_closing'])); ?>
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