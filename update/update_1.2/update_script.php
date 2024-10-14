<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

// INSERT VERSION NUMBER INSIDE SETTINGS TABLE
$version_updater_sql = "UPDATE `system_settings` SET `value` = '1.2' WHERE `system_settings`.`key` = 'version'";
$CI->db->query($version_updater_sql);

// CHECK IF THE PAYMENT SETTINGS TABLE HAS PAYPAL AND STRIPE ROW IN IT
if (!$this->db->table_exists('payment_settings')) {
  // CREATE PAYMENT TABLE
  $payment_table_sql = "
  CREATE TABLE IF NOT EXISTS `payment` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `order_code` varchar(255) DEFAULT NULL,
    `amount_to_pay` varchar(255) DEFAULT NULL,
    `amount_paid` varchar(255) DEFAULT NULL,
    `payment_method` varchar(255) DEFAULT NULL,
    `identifier` varchar(255) DEFAULT NULL,
    `data` longtext,
    `created_at` int(11) DEFAULT NULL,
    `updated_at` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ";
  $CI->db->query($payment_table_sql);

  // CREATE PAYMENT SETTINGS TABLE
  $payment_settings_table_sql = "
  CREATE TABLE IF NOT EXISTS `payment_settings` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `key` varchar(255) DEFAULT NULL,
      `value` longtext,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ";
  $CI->db->query($payment_settings_table_sql);

  // INSERT DEFAULT DATA INSIDE PAYMENT SETTINGS
  $payment_settings_data_sql = "
  INSERT INTO `payment_settings` (`id`, `key`, `value`)
  VALUES
    (1,'cash_on_delivery','[{\"active\":\"1\"}]'),
    (2,'paypal','[{\"active\":\"1\",\"mode\":\"sandbox\",\"currency\":\"USD\",\"sandbox_client_id\":\"sandbox-client-id\",\"sandbox_secret_key\":\"sandbox-secret-key\",\"production_client_id\":\"production-client-id\",\"production_secret_key\":\"production-secret-key\"}]'),
    (3,'stripe','[{\"active\":\"1\",\"testmode\":\"on\",\"currency\":\"USD\",\"public_key\":\"pk_test_xxxxxxxxxxxxxxxxxxxxxxxx\",\"secret_key\":\"sk_test_xxxxxxxxxxxxxxxxxxxxxxxx\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxxxxx\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxxxxx\"}]');
  ";
  $CI->db->query($payment_settings_data_sql);


  // UPDATE ORDERS PAYMENT DATA INSIDE PAYMENT TABLE
  $orders = $CI->db->get('orders')->result_array();
  foreach ($orders as $order) {
    $updater['order_code'] = $order['code'];
    $updater['amount_to_pay'] = $order['grand_total'];
    $updater['payment_method'] = 'cash_on_delivery';
    $updater['created_at'] = $order['order_placed_at'];
    $updater['data'] = json_encode([]);
    if ($order['order_status'] == "delivered") {
      $updater['amount_paid'] = $order['grand_total'];
    } else {
      $updater['amount_paid'] = 0;
    }
    $CI->db->insert('payment', $updater);
  }
}
