<?php
defined('BASEPATH') or exit('No direct script access allowed');
$route['default_controller'] = 'site';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Specific pages first
$route['GuestCheckout'] = 'GuestCheckout/index';
$route['cart'] = 'cart/index';
$route['dashboard'] = 'dashboard/index';
$route['category'] = 'category/index';
$route['menu'] = 'menu/index';
$route['auth'] = 'auth/index';
$route['user'] = 'user/index';
$route['owner'] = 'owner/index';
$route['orders'] = 'orders/index';
$route['offers'] = 'offers/index';
$route['customer'] = 'customer/index';
$route['cook'] ='cook/index';
$route['cuisine'] = 'cuisine/index';
$route['restaurant'] = 'restaurant/index';
$route['pos'] = 'pos/index';
$route['login'] = 'auth/index';
$route['logout'] = 'auth/logout';
$route['contact-us'] = 'site/contact_us';
$route['solutions'] = 'site/solutions';
$route['about-us'] = 'site/about_us';
$route['privacy-policy'] = 'site/privacy_policy';
$route['terms-and-conditions'] = 'site/terms_and_conditions';
$route['become-a-partner'] = 'site/become_a_partner';
$route['terms-of-use'] = 'site/terms_of_use';
$route['restaurants/recent'] = 'site/restaurants/recent';
$route['restaurants/popular'] = 'site/restaurants/popular';
$route['refundrequest'] = 'RefundRequest';
$route['refundrequest/(:any)'] = 'RefundRequest/$1';
$route['refundrequest/(:any)/(:any)'] = 'RefundRequest/$1/$2';
$route['submissions'] = 'submissions';
$route['customers-info'] = 'CustomersInfo';
$route['customers-info/(:any)'] = 'CustomersInfo/$1';
$route['customers-info/(:any)/(:any)'] = 'CustomersInfo/$1/$2';
$route['promo-code'] = 'PromoCode';
$route['chilli-hut-march'] = 'site/restaurant_by_slug/chillihutmarch';

// "Receive Orders" desktop app JSON API — must stay before the catch-all below,
// otherwise every api/* request gets swallowed by the restaurant-slug route.
$route['api/ping'] = 'api/ping';
$route['api/login'] = 'api/login';
$route['api/logout'] = 'api/logout';
$route['api/dev-token'] = 'api/dev_token';
$route['api/orders'] = 'api/orders';
$route['api/orders/(:any)/status'] = 'api/order_status/$1';
$route['api/orders/(:any)/cancel'] = 'api/order_cancel/$1';
$route['api/orders/(:any)/receipt'] = 'api/order_receipt/$1';
$route['api/orders/(:any)/request-refund'] = 'api/order_request_refund/$1';
$route['api/orders/(:any)'] = 'api/order_detail/$1';
$route['api/stats'] = 'api/stats';
$route['api/stats/breakdown'] = 'api/stats_breakdown';
$route['api/restaurant/status'] = 'api/restaurant_status';
$route['api/restaurant/hours'] = 'api/restaurant_hours';
$route['api/refunds'] = 'api/refunds';

$route['(:any)'] = 'site/restaurant_by_slug/$1';
$route['subcategory/create/(:num)'] = 'SubCategory/create/$1';
$route['subcategory/create'] = 'SubCategory/create';
$route['subcategory/store'] = 'SubCategory/store';

// Catch-all route for **restaurant slugs only**
// $route['(:any)'] = 'site/show_restaurant/$1';