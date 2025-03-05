<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'site';
$route['404_override'] = '';
$route['login'] = 'auth/index';
$route['logout'] = 'auth/logout';
$route['translate_uri_dashes'] = FALSE;
$route['site/contact-us'] = 'site/contact_us';
$route['site/about-us'] = 'site/about_us';
$route['site/privacy-policy'] = 'site/privacy_policy';
$route['site/terms-and-conditions'] = 'site/terms_and_conditions';
$route['site/become-a-partner'] = 'site/become_a_partner';

// $route['check'] = 'orders/check_new_orders';