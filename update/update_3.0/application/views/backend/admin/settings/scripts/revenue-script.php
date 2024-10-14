<script type="text/javascript">
  "use strict";

  function calculateRestaurantRevenue(adminRevenue) {
    if (adminRevenue >= 0 && adminRevenue <= 100) {
      var restaurantRevenue = 100 - adminRevenue;
      $('#restaurant_revenue').val(restaurantRevenue);
    } else {
      $('#restaurant_revenue').val(0);
    }
  }
</script>