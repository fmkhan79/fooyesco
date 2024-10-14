<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; 


?>

<?php 

// Get saved settings
$heading = $this->order_model->getSetting('heading');
$description = $this->order_model->getSetting('description');
$ctaLink = $this->order_model->getSetting('ctaLink');

?>

<?php /* foreach ($cuisines as $cuisine_row) : ?>
<option value="<?php echo sanitize($cuisine_row['id']); ?>"
    <?php if ($cuisine_row['id'] == $cuisine) echo "selected"; ?>><?php echo sanitize($cuisine_row['name']); ?></option>
<?php endforeach; */?>
<!--============================= DETAIL =============================-->
<section class="order-toplist mt-4 mb-2">
    <div class="container bg-white p-4 text-dark rounded border border-light">
        <ul class="p-0 m-0 order-toplist-slider owl-carousel owl-theme">
            <!-- <li><a href="#"><img
            src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />GROCRIES</a>
      </li>
      <li><a href="#"><img src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />DEALS</a>
      </li>
      <li><a href="#"><img
            src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />Breakfast</a>
      </li> -->
            <!-- <li><a href="#"><img
            src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />sandwich</a>
      </li> -->
            <!-- <li><a href="#"><img
            src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />BURGERS</a>
      </li> -->
            <!-- <li><a href="#"><img src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />PIZZA</a>
      </li> -->
            <!-- <li><a href="#"><img src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />Kebab</a>
      </li> -->
            <!-- <li><a href="#"><img
            src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />sandwich</a>
      </li> -->
            <!-- <li><a href="#"><img
            src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />BURGERS</a>
      </li> -->
            <!-- <li><a href="#"><img src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" />PIZZA</a>
      </li> -->
            <?php foreach ($cuisines as $cuisine_row) : 
       
        ?>
            <li><a href="<?php echo base_url("site/restaurants/filter?cuisine=").$cuisine_row["id"]; ?>"><img
                        src="<?php echo base_url('assets/frontend/default/images/grocries-icon.png'); ?>" /><?php echo sanitize($cuisine_row['name']); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="free-delivery-section mt-4 mb-2">
    <div class="container bg-red p-4 text-light rounded border-light">
        <div class="d-md-flex align-items-center">
            <div class="col-md-9">
                <h3><?php echo !is_null($heading) ? $heading : 'Offers Coming soon'; ?></h3>
                <p class="p-0 m-0">
                    <?php echo !is_null($description) ? $description : 'Be there, we will have an amazing offer.'; ?>
                </p>
            </div>
            <div class="col-md-3 text-center"><a <?php if (!empty($ctaLink)) echo 'href="' . $ctaLink . '"'; ?>
                    class="w-rounded-btn">More
                    Offers</a></div>
        </div>
    </div>
</section>


<section class="order-listing mt-4 mb-2">
    <div class="container p-4 text-dark">
        <div class="d-md-flex">

            <!-- Filter -->
            <div class="col-md-4 bg-white rounded sidebar p-0">
                <div class="form-group has-search dt-hide">
                    <input type="text" class="search-box" placeholder="Search for a dish or Restaurant">
                </div>
                <div class="sort-box float-right dt-hide">Sorted by Best match
                    <a href="#"><img src="images/filter-icon.png" /></a>
                </div>
                <div class="location-box d-flex">
                  <div class="location-icon">
                      <img src="<?php echo base_url('assets/frontend/default/images/location-icon.png') ?>" /></div>
                    <div class="location-txt">
                      <span class="red-txt"><?php echo ($type == "filter" && isset($_GET['query']) && !empty(sanitize($_GET['query']))) ? sanitize($_GET['query']) : "UK"; ?></span>
                      <a href="<?php echo base_url('/') ?>" class="text-dark">Change location</a>
                  </div>
                </div>


                <form action="<?php echo site_url('site/restaurants/filter'); ?>" class="filter-dropdown" method="GET">
                    <div class="filter-box">
                        <div class="filter-clear-box d-flex justify-content-between mb-4">
                            <?php echo site_phrase('filter_by'); ?>
                            <a href="<?php echo site_url('site/restaurants/filter'); ?>">Clear</a>
                        </div>

                        <div class="filter-list mb-4 all-other">
                            <div class="filter-heading d-flex justify-content-between align-items-center">
                                <?php echo ucwords(site_phrase('all_cuisine')); ?>
                                <span class="icon-arrow-down"></span>
                            </div>

                            <ul class="my-3 mx-0 p-0">
                                <?php foreach ($cuisines as $cuisine_row): ?>
                                <li>
                                    <input name="cuisine" type="checkbox"
                                        id="cuisine_<?php echo sanitize($cuisine_row['id']); ?>"
                                        value="<?php echo sanitize($cuisine_row['id']); ?>"
                                        <?php if ($cuisine_row['id'] == $cuisine) echo "checked"; ?> />
                                    <?php echo sanitize($cuisine_row['name']); ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>

                        </div>

                        <div class="filter-list mb-4 price">
                            <div class="filter-heading d-flex justify-content-between align-items-center">
                                <?php echo ucwords(site_phrase('all_category')); ?>
                                <span class="icon-arrow-down"></span>
                            </div>

                            <ul class="my-3 mx-0 p-0">
                                <li><input type="checkbox" /> Free delivery</li>
                                <?php foreach ($categories as $category_row): ?>
                                <li><input name="category" type="checkbox"
                                        id="category_<?php echo sanitize($cuisine_row['id']); ?>"
                                        value="<?php echo sanitize($category_row['id']); ?>" <?php if ($category_row['id'] == $category)
                      echo "checked"; ?> /><?php echo sanitize($category_row['name']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg w-100" style="border-radius: 22px">
                            <?php echo site_phrase('filter'); ?>
                        </button>
                    </div>
                </form>



                <!-- <div class="p-2">
          <p>
            </?php echo site_phrase('filter_by'); ?>
          </p>
          <form action="</?php echo site_url('site/restaurants/filter'); ?>" class="filter-dropdown" method="GET">
            <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect" name="cuisine">
              <option value="">
                </?php echo ucwords(site_phrase('all_cuisine')); ?>
              </option>
              </?php foreach ($cuisines as $cuisine_row): ?>
                <option value="</?php echo sanitize($cuisine_row['id']); ?>" </?php if ($cuisine_row['id'] == $cuisine)
                     echo "selected"; ?>>
                  </?php echo sanitize($cuisine_row['name']); ?>
                </option>
              </?php endforeach; ?>
            </select>

            <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect1" name="category">
              <option value="">
                </?php echo ucwords(site_phrase('all_category')); ?>
              </option>
              </?php foreach ($categories as $category_row): ?>
                <option value="</?php echo sanitize($category_row['id']); ?>" </?php if ($category_row['id'] == $category)
                     echo "selected"; ?>>
                  </?php echo sanitize($category_row['name']); ?>
                </option>
              </?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-dark">
              </?php echo site_phrase('filter'); ?>
            </button>
          </form>
        </div> -->

                <!-- <div class="filter-box">
          <div class="filter-clear-box d-flex justify-content-between mb-4">Filter
            products <a href="#">Clear</a></div>

          <div class="filter-list mb-4 all-other">
            <div class="filter-heading d-flex justify-content-between align-items-center">
              All others (A-Z) <span class="icon-arrow-down"></span>
            </div>

            <ul class="my-3 mx-0 p-0">
              <li><input type="checkbox" /> African2</li>
              <li><input type="checkbox" /> Alcohol</li>
              <li><input type="checkbox" /> American</li>
              <li><input type="checkbox" /> Asian</li>
              <li><input type="checkbox" /> Asian2</li>
              <li><input type="checkbox" /> Bangladeshi</li>
              <li><input type="checkbox" /> BBQ</li>
              <li><input type="checkbox" /> British6</li>
              <li><input type="checkbox" /> Burgers</li>
            </ul>

          </div>

          <div class="filter-list mb-4 price">
            <div class="filter-heading d-flex justify-content-between align-items-center">
              Price <span class="icon-arrow-down"></span>
            </div>

            <ul class="my-3 mx-0 p-0">
              <li><input type="checkbox" /> Free delivery</li>
              <li><input type="checkbox" /> 5+ stars</li>
              <li><input type="checkbox" /> Open now</li>
              <li><input type="checkbox" /> Collection</li>
              <li><input type="checkbox" /> New</li>
              <li><input type="checkbox" /> Halal</li>
              <li><input type="checkbox" /> Hygiene Rating 3+ /
                Pass</li>
            </ul>

          </div>

        </div> -->

            </div>
            <!-- .// end filter -->


            <div class="col-md-8 mt-4 pt-5 ml-4">


                <div class="form-group has-search mob-hide">
                    <input type="text" class="search-box" placeholder="Search for a dish or Restaurant">
                </div>


                <div class="sort-box float-right mob-hide">Sorted by Best match
                    <a href="#"><img
                            src="<?php echo base_url('assets/frontend/default/images/filter-icon.png') ?>" /></a>
                </div>

                <div class="red">
                    <p>
                        <span>
                            <?php echo sanitize($page_header); ?>
                            <?php echo ($type == "filter" && isset($_GET['query']) && !empty(sanitize($_GET['query']))) ? strtolower(site_phrase("for_query")) . " '" . sanitize($_GET['query']) . "'" : ""; ?>
                        </span>
                        <small>
                            <?php echo sanitize($total_rows); ?> <span>
                                <?php echo site_phrase('restaurants_found'); ?>
                            </span>
                        </small>
                    </p>
                </div>

                <div class="clear"></div>

                <?php foreach ($restaurants as $key => $restaurant): ?>
                <div class="single-item-order">
                    <div class="order-box d-md-flex align-items-center mb-4">
                        <div class="order-img-box main-img">
                            <a
                                href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant['slug'])) . '/' . sanitize($restaurant['id'])); ?>">
                                <img src="<?php echo base_url('uploads/restaurant/thumbnail/' . sanitize($restaurant['thumbnail'])); ?>"
                                    alt="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 250 250"
                                    fill="none">
                                    <circle cx="125.035" cy="124.965" r="116.153"
                                        transform="rotate(178.687 125.035 124.965)" stroke="url(#paint0_linear_33_536)"
                                        stroke-width="16"></circle>
                                    <defs>
                                        <lineargradient id="paint0_linear_33_536" x1="131.787" y1="144.132" x2="131.787"
                                            y2="280.046" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#F54748" stop-opacity="0"></stop>
                                            <stop offset="1" stop-color="#FDC55E"></stop>
                                        </lineargradient>
                                    </defs>
                                </svg>
                                <div class="percent-box">%15</div>
                            </a>
                        </div>

                        <div class="order-detail">
                            <h4><a
                                    href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant['slug'])) . '/' . sanitize($restaurant['id'])); ?>">
                                    <?php echo sanitize($restaurant['name']); ?>
                                </a></h4>
                            <div class="review-grid d-flex justify-content-around align-items-center">
                                <?php if($restaurant['rating']){ ?>
                                <ul class="inline-grid">
                                    <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt
                                            width="38" height="38">
                                    </li>
                                    <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt
                                            width="38" height="38">
                                    </li>
                                    <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt
                                            width="38" height="38">
                                    </li>
                                </ul>
                                <div class="star">
                                    <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.0489 0.926805C11.3483 0.00549436 12.6517 0.00549579 12.9511 0.926806L14.9187 6.98253C15.0526 7.39456 15.4365 7.67352 15.8697 7.67352H22.2371C23.2058 7.67352 23.6086 8.91313 22.8249 9.48253L17.6736 13.2252C17.3231 13.4798 17.1764 13.9312 17.3103 14.3432L19.2779 20.3989C19.5773 21.3203 18.5228 22.0864 17.7391 21.517L12.5878 17.7743C12.2373 17.5197 11.7627 17.5197 11.4122 17.7743L6.2609 21.517C5.47719 22.0864 4.42271 21.3203 4.72206 20.3989L6.68969 14.3432C6.82356 13.9312 6.6769 13.4798 6.32642 13.2252L1.17511 9.48253C0.391392 8.91313 0.794168 7.67352 1.76289 7.67352H8.13026C8.56349 7.67352 8.94744 7.39456 9.08132 6.98253L11.0489 0.926805Z"
                                            fill="#FFB800"></path>
                                    </svg>
                                </div>
                                <p class="p-0 m-0">(
                                    <?php echo sanitize($restaurant['rating']); ?>)
                                </p>
                                <?php } ?>
                            </div>

                            <div class="order-time-delivery-list">

                                <ul>
                                    <li class="red"><img
                                            src="<?php echo base_url('assets/frontend/default/images/time-icon.png') ?>"
                                            alt="time-icon" /><?php echo $restaurant["maximum_time_to_deliver"]; ?> mins
                                    </li>
                                    <li class="gray"><img
                                            src="<?php echo base_url('assets/frontend/default/images/delivery-icon.png') ?>"
                                            alt="delivery-icon" />Delivery fee
                                        : 0-<?php echo $restaurant["delivery_charge"]; ?> £ Min
                                        Order : 10£</li>
                                    <li><img src="<?php echo base_url('assets/frontend/default/images/cheeky-icon.png') ?>"
                                            alt="cheeky-icon" />Cheeky tuesday - 20%
                                        off when you spend</li>
                                    <li><img src="<?php echo base_url('assets/frontend/default/images/price-icon.png') ?>"
                                            alt="price-icon" />$15</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>


            </div>
        </div>
</section>

<section class="dt-hide"><img class="img-fluid"
        src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png'); ?>" /></section>
<section class="footer-top mt-4">
    <div class="container-fluid">
        <div class="d-md-flex ">
            <div class="col-md-6">
                <h3>It’s Now <span class="red">More Easy</span> to <span class="yellow">Order</span> by Our Mobile <span
                        class="red">App</span></h3>
                <p>All you need to do is downlode one of the best delivery apps, make a and most companies are opting
                    for mobile app devlopment for food delivery</p>
                <div class="google-btns"><a href="#" class="goole-play-btn"><img
                            src="<?php echo base_url('assets/frontend/default/images/google-play-icon.png'); ?>" /></a>
                    <a href="#"><img
                            src="<?php echo base_url('assets/frontend/default/images/app-store-icon.png'); ?>" /></a>
                </div>
            </div>
            <div class="col-md-6 mob-hide"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/footer-top-img.png'); ?>" /></div>
        </div>
    </div>
</section>
<!--//END DETAIL -->