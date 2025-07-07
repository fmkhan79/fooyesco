 <?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'site';
$route['404_override'] = '';
$route['login'] = 'auth/index';
$route['logout'] = 'auth/logout';
$route['translate_uri_dashes'] = FALSE;
$route['contact_us'] = 'site/contact_us';
$route['about_us'] = 'site/about_us';
$route['privacy-policy'] = 'site/privacy_policy';
$route['terms-and-conditions'] = 'site/terms_and_conditions';
$route['become-a-partner'] = 'site/become_a_partner';
$route['terms-of-use'] = 'site/terms_of_use';

$route['chilli-hut-march'] = 'site/restaurant/chilli-hut-march/3';
$route['commision'] = 'report/sales_summary';
$route['restaurants/popular'] = 'site/restaurants/popular';
$orute['site/restaurants/recent'] = 'site/restaurants/recent';
$route['restaurants/filter?query=&latitude_1=&longitude_1='] = 'site/restaurants/filter?query=&latitude_1=&longitude_1=';
$route['restaurant/pizza-king/13'] = 'site/restaurant/pizza-king/13';
$route['restaurant/the-spice-bank/11'] = 'site/restaurant/the-spice-bank/11';
$route['restaurant/chilli-hut-march/3'] = 'site/restaurant/chilli-hut-march/3';


// $route['check'] = 'orders/check_new_orders';