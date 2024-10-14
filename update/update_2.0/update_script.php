<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

// INSERT VERSION NUMBER INSIDE SETTINGS TABLE
$version_data = array('value' => '2.0');
$CI->db->where('key', 'version');
$CI->db->update('system_settings', $version_data);

// CREATING ADDONS TABLE
$addons_table_fields = array(
  'id' => array(
    'type' => 'INT',
    'constraint' => 11,
    'unsigned' => TRUE,
    'auto_increment' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'menu_id' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'name' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'price' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  )
);
$CI->dbforge->add_field($addons_table_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('addons', TRUE);


// CREATING VARIANT OPTIONS TABLE
$variant_options_table_fields = array(
  'id' => array(
    'type' => 'INT',
    'constraint' => 11,
    'unsigned' => TRUE,
    'auto_increment' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'menu_id' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'name' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'options' => array(
    'type' => 'LONGTEXT',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  )
);
$CI->dbforge->add_field($variant_options_table_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('variant_options', TRUE);

// CREATING VARIANT TABLE
$variants_table_fields = array(
  'id' => array(
    'type' => 'INT',
    'constraint' => 11,
    'unsigned' => TRUE,
    'auto_increment' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'menu_id' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'variant' => array(
    'type' => 'LONGTEXT',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'price' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  )
);
$CI->dbforge->add_field($variants_table_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('variants', TRUE);


// ADDING NEW COLUMNS IN CART TABLES
$cart_tables_column = array(
  'addons' => array(
    'type' => 'LONGTEXT',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'variant_id' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => null,
    'null' => TRUE
  )
);

$CI->dbforge->add_column('cart', $cart_tables_column);

// ADDING HAS VARIANT COLUMN IN ORDER DETAILS TABLES
$food_menus_additional_columns = array(
  'has_variant' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => 0,
    'null' => FALSE
  ),
  'warnings' => array(
    'type' => 'LONGTEXT',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  )
);

$CI->dbforge->add_column('food_menus', $food_menus_additional_columns);


// ADDING NEW COLUMNS IN ORDER DETAILS TABLES
$order_details_tables_column = array(
  'addons' => array(
    'type' => 'LONGTEXT',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'variant_id' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => null,
    'null' => TRUE
  )
);

$CI->dbforge->add_column('order_details', $order_details_tables_column);

$available_food_menus = $CI->db->get_where('food_menus', ['servings' => 'plate']);
if ($available_food_menus->num_rows()) {
  foreach ($available_food_menus->result_array() as $key => $available_food_menu) {

    // CREATING A VARIANT OPTION AS PLATE
    $variant_options['menu_id'] = $available_food_menu['id'];
    $variant_options['name'] = "plate";
    $variant_options['options'] = "full plate, half plate";
    $CI->db->insert('variant_options', $variant_options);

    $variant_option_id = $CI->db->insert_id();
    // CREATING VARIANTS
    $variant['menu_id'] = $available_food_menu['id'];
    $variant['variant'] = "$variant_option_id-full plate";
    $variant['price'] = get_menu_price($available_food_menu['id'], "full_plate");
    $CI->db->insert('variants', $variant);
    $full_plate_variant_id = $CI->db->insert_id();

    $variant['menu_id'] = $available_food_menu['id'];
    $variant['variant'] = "$variant_option_id-half plate";
    $variant['price'] = get_menu_price($available_food_menu['id'], "half_plate");
    $CI->db->insert('variants', $variant);
    $half_plate_variant_id = $CI->db->insert_id();

    // CHECK IF THIS FOOD IS ADDED TO THE CART
    $cart_items = $CI->db->get_where('cart', ['menu_id' => $available_food_menu['id']]);
    $cart_item_availability = $cart_items->num_rows();
    if ($cart_item_availability > 0) {
      $cart_items = $cart_items->result_array();
    }

    if ($cart_item_availability) {
      foreach ($cart_items as $key => $cart_item) {
        $cart_item_updater['servings'] = 'menu';
        if ($cart_item['servings'] == "full_plate") {
          $cart_item_updater['variant_id'] = $full_plate_variant_id;
        } elseif ($cart_item['servings'] == "half_plate") {
          $cart_item_updater['variant_id'] = $half_plate_variant_id;
        }

        $CI->db->where('id', $cart_item['id']);
        $CI->db->update('cart', $cart_item_updater);
      }
    }

    // CHECK IF THIS FOOD IS ADDED TO THE CART
    $ordered_items = $CI->db->get_where('order_details', ['menu_id' => $available_food_menu['id']]);
    $ordered_item_availability = $ordered_items->num_rows();
    if ($ordered_item_availability > 0) {
      $ordered_items = $ordered_items->result_array();
    }

    if ($ordered_item_availability) {
      foreach ($ordered_items as $key => $ordered_item) {
        $ordered_item_updater['servings'] = 'menu';
        if ($ordered_item['servings'] == "full_plate") {
          $ordered_item_updater['variant_id'] = $full_plate_variant_id;
        } elseif ($ordered_item['servings'] == "half_plate") {
          $ordered_item_updater['variant_id'] = $half_plate_variant_id;
        }

        $CI->db->where('id', $ordered_item['id']);
        $CI->db->update('order_details', $ordered_item_updater);
      }
    }

    // UPDATING FOOD MENU DATA
    $updater['servings'] = "menu";
    $updater['has_discount'] = '{"menu":0}';
    $updater['discounted_price'] = '{"menu":""}';
    $menu_price = get_menu_price($available_food_menu['id'], "half_plate") ? get_menu_price($available_food_menu['id'], "half_plate") : get_menu_price($available_food_menu['id'], "full_plate");
    $updater['price'] = json_encode(["menu" => $menu_price]);
    $updater['has_variant'] = 1;
    $CI->db->where('id', $available_food_menu['id']);
    $CI->db->update('food_menus', $updater);
  }
}


// UPDATING RESTAURANT SCHEDULE
$days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
$available_restaurants = $CI->db->get('restaurants')->result_array();
foreach ($available_restaurants as $key => $available_restaurant) {
  $schedule = json_decode($available_restaurant['schedule'], true);
  foreach ($days as $day) {
    $schedule[$day . '_opening'] = ($schedule[$day . '_opening'] == "closed") ? "closed" : sprintf('%02d', $schedule[$day . '_opening']) . ':00';
    $schedule[$day . '_closing'] = ($schedule[$day . '_closing'] == "closed") ? "closed" : sprintf('%02d', $schedule[$day . '_closing']) . ':00';
  }

  $schedule_updater['schedule'] = json_encode($schedule);
  $CI->db->where('id', $available_restaurant['id']);
  $CI->db->update('restaurants', $schedule_updater);
}
