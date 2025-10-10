<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="<?php echo sanitize(get_system_settings('author')); ?>">
<?php
if ($page_name == "restaurant/index") : ?>
    <meta name="keywords" content="<?php echo sanitize($restaurant_details['seo_tags']); ?>" />
    <meta name="description" content="<?php echo sanitize($restaurant_details['seo_description']); ?>" />

<?php elseif ($page_name == "contact_us/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Get in touch with our customer support team. We're here to assist you with orders, deliveries, and account inquiries." />

<?php elseif ($page_name == "about_us/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Learn more about us — our mission, values, and commitment to bringing delicious food from your favorite restaurants straight to your door." />

<?php elseif ($page_name == "privacy_policy/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Read our Privacy Policy to understand how we collect, use, and protect your personal information." />

<?php elseif ($page_name == "terms_and_conditions/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Read our Terms & Conditions outlining our policies on orders, payments, deliveries, and refunds." />

<?php elseif ($page_name == "become_a_partner/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Join us as a restaurant or delivery partner. Expand your reach and grow your business with our platform." />

<?php elseif ($page_name == "terms_of_use/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Review our Terms of Use to understand your rights and responsibilities while using our website and services." />

<?php elseif ($page_name == "solutions/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Explore our business solutions for restaurants, delivery partners, and food service management." />


<?php else : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="<?php echo sanitize(get_system_settings('website_description')); ?>" />
<?php endif; ?>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php 
$restaurant_ids = $this->cart_model->get_restaurant_ids();

if (count($restaurant_ids) > 0) {
    $restaurant_details = $this->restaurant_model->get_by_id($restaurant_ids[0]);
}
$isFooyes = false;
$host = get_subdomain();

if($host === 'fooyes' || $host === 'staging')
    $isFooyes=true;
?>

<?php 
if ($isFooyes): ?>
    <title><?php echo htmlspecialchars($page_title); ?> | <?php echo sanitize(get_system_settings('system_title')); ?></title>
<?php else: 
    $uri = $_SERVER['REQUEST_URI'];

    $title = 'Chilli Hut Fast Food Takeaway in March';
    $description = 'Order delicious fast food in March, Cambridgeshire.';

    if (strpos($uri, '/privacy-policy') !== false) {
        $title = 'Chilli Hut March - Our Privacy Policy';
        $description = 'Read our Privacy Policy to understand how we collect, use, and protect your personal information.';
    } elseif (strpos($uri, '/terms-and-conditions') !== false) {
        $title = 'Chilli Hut March - Our Terms & Conditions';
        $description = 'Read our Terms & Conditions outlining our policies on orders, payments, deliveries, and refunds.';
    } elseif (strpos($uri, '/terms-of-use') !== false) {
        $title = 'Chilli Hut March - Our Terms of Use';
        $description = 'Review our Terms of Use to understand your rights and responsibilities while using our website and services.';
    } elseif (strpos($uri, '/login') !== false) {
        $title = 'Chilli Hut March Login Page';
        $description = 'Login to Chilli Hut March account to view and manage your orders.';
    } elseif (strpos($uri, '/contact-us') !== false) {
        $title = 'Contacts for Chilli Hut March - Cambridgeshire';
        $description = 'Get in touch with our customer support team. We\'re here to assist you with orders, deliveries, and account inquiries.';
    } elseif (strpos($uri, '/auth') !== false) {
        $title = 'Chilli Hut March - Authentication';
        $description = 'Secure login and account authentication page for Chilli Hut March users.';
    }
    elseif (strpos($uri, '/login') !== false) {
        $title = 'Chilli Hut March - Login Page';
        $description = 'login to Chilli Hut March account to view and manage your orders.';
    }
?>
    <title><?php echo $title; ?></title>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>" />
<?php endif; ?>

<link rel="shortcut icon" href="<?php echo base_url('uploads/system/' . get_website_settings('favicon')); ?>">