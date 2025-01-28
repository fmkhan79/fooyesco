<?php 
$menu_details = $this->menu_model->get_by_id($menuid); 

$starts_from = json_decode($menu_details["price"]);
// print_r($menuid);
$menu_main_catagories = $this->menu_model->get_options($menuid);
// var_dump($menu_main_catagories);
?>

<h3 class="text-center my-4">
    <?PHP   echo  $menu_details["name"];  ?>
</h3>
<div class="product-img">

    <div class="order-img-box main-img">
        <a href="#"><img class="rounded-circle"
                src="<?php echo base_url('uploads/menu/') . $menu_details["thumbnail"]; ?>" height="72px"
                width="72px" />
            <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 250 250" fill="none">
                <circle cx="125.035" cy="124.965" r="116.153" transform="rotate(178.687 125.035 124.965)"
                    stroke="url(#paint0_linear_33_536)" stroke-width="16"></circle>
                <defs>
                    <lineargradient id="paint0_linear_33_536" x1="131.787" y1="144.132" x2="131.787" y2="280.046"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F54748" stop-opacity="0"></stop>
                        <stop offset="1" stop-color="#FDC55E"></stop>
                    </lineargradient>
                </defs>
            </svg>
            <div class="percent-box">%15</div>
        </a>
    </div>

</div>

<div class="popup-price-detail text-center mb-4">
    <h4>Start From <?php echo currency($starts_from->menu); ?></h4>
    <?php echo $menu_details["details"]; ?>

</div>
<!-- Main Catagories Start -->
<form action="#" method="POST">
    <input type="hidden" name="menuid" id="menu-id" value="<?php echo $menuid; ?>">
    <input type="hidden" name="menuprice" id="menu-price" value="<?php echo $starts_from->menu; ?>">
    <input type="hidden" name="currency" id="currency" value="<?php echo currency(); ?>">
    <input type="hidden" name="totalprice" id="totalprice" value="0">

    <div class="main-div-1" id="main-catagories">
        <div class="d-flex align-items-center justify-content-between p-4 popup-gray-box">
            <h3 class="p-0 m-0">Choose one</h3>
            <div class="op-rq-box"><span>Required</span></div>
        </div>

        <?php
                  foreach($menu_main_catagories as $menu_main_catagory){
                  ?>
        <div class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between gray-border">
            <div class="label-box">
                <label>
                    <input name="variant" class="menuoptions" data-menu-option="menu-option-1"
                        data-item-price="<?php if($menu_main_catagory["price"] > 0) { echo $menu_main_catagory["price"]; }else{   echo $starts_from->menu;  }  ?>"
                        id="variant" type="radio" value="<?php echo $menu_main_catagory['id'];  ?>"
                        onclick="viewselected_cat_items(<?php echo $menu_main_catagory['id'];  ?>,'menu-option-1')" />
                    <?php echo $menu_main_catagory["name"];  ?>
                </label>
            </div>
            <div class="amount-box">
                <?php if($menu_main_catagory["price"] > 0) { echo currency($menu_main_catagory["price"]); }else{ echo "FREE";
}  ?></div>
        </div>
        <?php } 
                  ?>



        <!-- <div class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between">
                    <div class="label-box">
                      <label>
                        <input name="chooseone" value="lg-addons" type="radio" />
                        Large
                      </label>
                    </div>
                    <div class="amount-box">£10.00</div>
                  </div> -->

    </div>

    <!-- Main Catagories End -->

    <!-- Main Sub Catagories and Items Start -->

    <div class="menu-option-1" id="sub-catagories-and-items">

    </div>

    <?php if($menu_details["byoneoffer"] == 1){ ?>

    <div class="main-div-2" id="main-catagories ">
        <div class="d-flex align-items-center justify-content-between p-4 popup-gray-box">
            <h3 class="p-0 m-0">Choose one</h3>
            <div class="op-rq-box"><span>Required</span></div>
        </div>

        <?php
                  foreach($menu_main_catagories as $menu_main_catagory){
                  ?>
        <div class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between gray-border">
            <div class="label-box">
                <label>
                    <input name="variant-option-2" class="menuoptions"
                        data-item-price="<?php if($menu_main_catagory["price"] > 0) { echo $menu_main_catagory["price"]; }else{   echo $starts_from->menu;  }  ?>"
                        data-menu-option="menu-option-2" id="variant" type="radio"
                        value="<?php echo $menu_main_catagory['id'];  ?>"
                        onclick="viewselected_cat_items(<?php echo $menu_main_catagory['id'];  ?>,'menu-option-2')" />
                    <?php echo $menu_main_catagory["name"];  ?>
                </label>
            </div>
            <div class="amount-box">
                <?php if($menu_main_catagory["price"] > 0) { echo currency($menu_main_catagory["price"]); } else {echo "FREE";}  ?></div>
        </div>
        <?php } 
                  ?>



        <!-- <div class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between">
                    <div class="label-box">
                      <label>
                        <input name="chooseone" value="lg-addons" type="radio" />
                        Large
                      </label>
                    </div>
                    <div class="amount-box">£10.00</div>
                  </div> -->

    </div>

    <!-- Main Catagories End -->

    <!-- Main Sub Catagories and Items Start -->

    <div class="menu-option-2" id="sub-catagories-and-items">

    </div>

    <?php } ?>


    <!-- Main Sub Catagories and Items End -->


    <div class="qty-box my-4">
        <div class="input-group">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-number input-" disabled="disabled" data-type="minus"
                    data-field="quantity_for_menu">
                    <span class="glyphicon glyphicon-minus">-</span>
                </button>
            </span>
            <input type="text" name="quantity_for_menu" id="quantity_for_menu" class="form-control input-number"
                value="1" min="1" max="30">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-number" data-type="plus"
                    data-field="quantity_for_menu">
                    <span class="glyphicon glyphicon-plus">+</span>
                </button>
            </span>
        </div>
    </div>

    <div class="m-4 d-flex justify-content-between align-items-center add-order-box" onclick="addToCart()">
        <div class="add-order-txt">Add To Order</div>
        <div class="add-order-price" id="add-order-price">0</div>
        </button>
    </div>


    <!-- TODO:: +/- temp solution -->
    <script>
    jQuery(".filter-list.all-other .icon-arrow-down").click(function() {
        jQuery(".filter-list.all-other ul").toggle();
    });

    jQuery(".filter-list.price .icon-arrow-down").click(function() {
        jQuery(".filter-list.price ul").toggle();
    });

    jQuery(document).ready(function() {
        jQuery("input[name$='basket-switcher']").click(function() {
            var test = $(this).val();
            jQuery("span.collect-box").hide();
            jQuery("#" + test).show();
        });
    });

    jQuery('label.c-basketSwitcher-switch').click(function() {
        jQuery('label.c-basketSwitcher-switch').removeClass('c-basketSwitcher-switch--active');
        jQuery(this).addClass('c-basketSwitcher-switch--active');
    });

    jQuery('.c-basketSwitcher-switch input:checked').parent().addClass('c-basketSwitcher-switch--active');


    //add change event action on checkbox
    jQuery("#med-addons input:checkbox").on("change", function() {
        //change input #grandtotal value according check/uncheck checkboxes
        jQuery("#med-addons input#grandtotal").val(function() {
            //declare a variable to keep the sum of the values
            var sum = 0;
            //using an iterator find and sum the values of checked checkboxes
            jQuery("#med-addons input:checkbox:checked").each(function() {
                sum += ~~jQuery(this).val();
            });
            return sum;
        });
    });

    //here change the value according on checked checkboxes on DOM ready event
    jQuery("#grandtotal").val(function() {
        var sum = 0;
        jQuery("#med-addons input:checkbox:checked").each(function() {
            sum += ~~jQuery(this).val();
        });
        return sum;
    });


    //add change event action on checkbox
    jQuery("#lg-addons input:checkbox").on("change", function() {
        //change input #grandtotal value according check/uncheck checkboxes
        jQuery("#grandtotal2").val(function() {
            //declare a variable to keep the sum of the values
            var sum = 0;
            //using an iterator find and sum the values of checked checkboxes
            jQuery("#lg-addons input:checkbox:checked").each(function() {
                sum += ~~jQuery(this).val();
            });
            return sum;
        });
    });

    //here change the value according on checked checkboxes on DOM ready event
    jQuery("#grandtotal2").val(function() {
        var sum = 0;
        jQuery("#lg-addons input:checkbox:checked").each(function() {
            sum += ~~jQuery(this).val();
        });
        return sum;
    });


    jQuery(document).ready(function() {
        jQuery("input[name$='chooseone']").click(function() {
            var test2 = $(this).val();
            jQuery("div.addons").hide();
            jQuery("#" + test2).show();
        });
    });

    jQuery('.btn-number').click(function(e) {
        e.preventDefault();

        fieldName = jQuery(this).attr('data-field');
        type = jQuery(this).attr('data-type');
        var input = jQuery("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    jQuery(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    jQuery(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    jQuery('.input-number').focusin(function() {
        jQuery(this).data('oldValue', jQuery(this).val());
    });
    jQuery('.input-number').change(function() {

        minValue = parseInt(jQuery(this).attr('min'));
        maxValue = parseInt(jQuery(this).attr('max'));
        valueCurrent = parseInt(jQuery(this).val());

        name = jQuery(this).attr('name');
        if (valueCurrent >= minValue) {
            jQuery(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            jQuery(this).val(jQuery(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            jQuery(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            jQuery(this).val(jQuery(this).data('oldValue'));
        }
    });
    jQuery(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });


    jQuery('.order-detail-slider').owlCarousel({
        loop: true,
        margin: 13,
        nav: true,
        dots: false,
        autoWidth: true,
        responsive: {
            550: {
                items: 1
            },
            768: {
                items: 3
            },
            1000: {
                items: 8
            }
        }
    });
    </script>