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
$route['site/terms-of-use'] = 'site/terms_of_use';

$route['chilli-hut-march'] = 'site/restaurant/chilli-hut-march/3';
$route['commision'] = 'report/sales_summary';

$route['restaurants/popular'] = 'site/restaurants/popular';
$route['refundrequest'] = 'RefundRequest';
$route['refundrequest/(:any)'] = 'RefundRequest/$1';
$route['refundrequest/(:any)/(:any)'] = 'RefundRequest/$1/$2';
$route['submissions'] = 'submissions';

// $route['check'] = 'orders/check_new_orders';