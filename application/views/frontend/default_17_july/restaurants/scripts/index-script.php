<!-- INIT JS -->
<script src="<?php echo base_url('assets/frontend/default/js/init.js') ?>"></script>
<script src="<?php echo base_url('assets/frontend/default/js/owl.carousel.min.js') ?>"></script>


<script>
  "use strict";
  $(window).scroll(function () {
    // 100 = The point you would like to fade the nav in.

    if ($(window).scrollTop() > 100) {

      $('.fixed').addClass('is-sticky');

    } else {

      $('.fixed').removeClass('is-sticky');

    };
  });


  // control filter arrow
  jQuery(".filter-list.all-other .icon-arrow-down").click(function () {
    jQuery(".filter-list.all-other ul").toggle();
  });

  jQuery(".filter-list.price .icon-arrow-down").click(function () {
    jQuery(".filter-list.price ul").toggle();
  });

  jQuery('.order-toplist-slider').owlCarousel({
    loop: true,
    margin: 13,
    nav: true,
    dots: false,
    responsive: {
      375: {
        items: 3
      },
      768: {
        items: 4
      },
      1000: {
        items: 7
      }
    }
  });

  // INITIALIZE TOOLTIPS
  initToolTip();
</script>