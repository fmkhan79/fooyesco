<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

// INSERT VERSION NUMBER INSIDE SETTINGS TABLE
$version_data = array('value' => '3.0');
$CI->db->where('key', 'version');
$CI->db->update('system_settings', $version_data);

// CREATE ORDER SETTINGS TABLE
$order_settings_table_sql = "
CREATE TABLE IF NOT EXISTS `order_settings` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `key` varchar(255) DEFAULT NULL,
    `value` longtext,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$CI->db->query($order_settings_table_sql);

// INSERTING INTO ORDER SETTINGS TABLE
if ($CI->db->get('order_settings')->num_rows() > 0) {
  $CI->db->empty_table('order_settings');
}
$multi_restaurant_order = array('key' => 'multi_restaurant_order', 'value' => 1);
$CI->db->insert('order_settings', $multi_restaurant_order);
$auto_approve_order = array('key' => 'auto_approve_order', 'value' => 0);
$CI->db->insert('order_settings', $auto_approve_order);
$auto_assign_driver = array('key' => 'auto_assign_driver', 'value' => 0);
$CI->db->insert('order_settings', $auto_assign_driver);
$pickup_order = array('key' => 'pickup_order', 'value' => 0);
$CI->db->insert('order_settings', $pickup_order);
$owner_order_processing = array('key' => 'owner_order_processing', 'value' => 0);
$CI->db->insert('order_settings', $owner_order_processing);

// CREATING INGREDIENT TABLE
$ingredients_table_fields = array(
  'id' => array(
    'type' => 'INT',
    'constraint' => 11,
    'unsigned' => TRUE,
    'auto_increment' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'ingredient_name' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'restaurant_id' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'unit' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'unit_price' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  )
);
$CI->dbforge->add_field($ingredients_table_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('ingredients', TRUE);


// CREATING MENU INGREDIENTS TABLE
$menu_ingredients_table_fields = array(
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
  'ingredient_id' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'quantity_added' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'ingredient_amount' => array(
    'type' => 'LONGTEXT',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  )
);
$CI->dbforge->add_field($menu_ingredients_table_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('menu_ingredients', TRUE);

// CREATING COOKS TABLE
$cooks_table_fields = array(
  'id' => array(
    'type' => 'INT',
    'constraint' => 11,
    'unsigned' => TRUE,
    'auto_increment' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'user_id' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'address' => array(
    'type' => 'LONGTEXT',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  ),
  'restaurant_id' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  )
);
$CI->dbforge->add_field($cooks_table_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('cooks', TRUE);


// INSERT COOK ROLE INSIDE ROLES TABLE
$cook_role = array('type' => 'cook');
$CI->db->insert('role', $cook_role);

// ADDING ORDER TYPE COLUMNS IN ORDERS TABLE
$order_table_column = array(
  'order_type' => array(
    'type' => 'VARCHAR',
    'constraint' => '255',
    'default' => null,
    'null' => TRUE,
    'collation' => 'utf8_unicode_ci'
  )
);

$CI->dbforge->add_column('orders', $order_table_column);

// ADDING SUPPORT PICKUP ORDER INSIDE RESTAURANT TABLE
$restaurants_additional_columns = array(
  'support_pickup_order' => array(
    'type' => 'INT',
    'constraint' => '11',
    'default' => 0,
    'null' => FALSE
  )
);

$CI->dbforge->add_column('restaurants', $restaurants_additional_columns);

// RUNNING A QUERY FOR DROPPING FOREING KEY FROM CART TABLE. SO THAT USER CAN ADD TO THE CART WITHOUT EVEN LOGGED IN.
$CI->db->query("ALTER TABLE cart DROP FOREIGN KEY cart_ibfk_1");
