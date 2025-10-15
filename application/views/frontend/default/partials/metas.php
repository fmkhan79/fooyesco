<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="<?php echo sanitize(get_system_settings('author')); ?>">

<?php
if ($page_name == "restaurant/index") : ?>
    <!-- <meta name="keywordss" content="<?php echo sanitize($restaurant_details['seo_tags']); ?>" />
    <meta name="description" content="<?php echo sanitize($restaurant_details['seo_description']); ?>" /> -->

<?php elseif ($page_name == "contact_us/index") : ?>
    <meta name="keywordss" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Get in touch with our customer support team. We're here to assist you with orders, deliveries, and account inquiries." />

<?php elseif ($page_name == "home/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Order food online from your favourite local takeaways across the UK with Fooyes — easy, fast, and delicious." />

<?php elseif ($page_name == "about_us/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Learn about Fooyes — the UK platform that connects you with the best local takeaways and restaurants." />

<?php elseif ($page_name == "privacy_policy/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Read our Privacy Policy to understand how we collect, use, and protect your personal information." />

<?php elseif ($page_name == "terms_and_conditions/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Read our Terms & Conditions outlining our policies on orders, payments, deliveries, and refunds." />

<?php elseif ($page_name == "become_a_partner/index") : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="Enjoy fast, easy online food delivery from your favourite UK restaurants using Fooyes." />

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
   $uri = $_SERVER['REQUEST_URI'];
    $host = $_SERVER['HTTP_HOST'];
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $canonical_url = $scheme . '://' . $host . $uri;
    $canonical_url = strtok($canonical_url, '?'); // Remove query strings

    ?>
    
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>" />
    
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
if ($page_name == "home/index"): ?>
   <title>Order Food Online Across the UK | Fooyes</title>
 <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Fooyes",
  "alternateName": "fooyesuk",
  "url": "https://www.fooyes.co.uk/",
  "logo": "https://www.fooyes.co.uk/uploads/system/VJMkY4SgTdEnL35HtR9GUPD.png"
}
</script>

<?php elseif ($page_name == "about_us/index") : ?>
    <title>About Fooyes | Your UK Food Delivery Partner</title>
<?php elseif ($page_name == "contact_us/index") : ?>
    <title>Contact Fooyes | Your UK Food Delivery Partner</title>
<?php elseif ($page_name == "privacy_policy/index") : ?>
    <title>Privacy Policy Fooyes | Your UK Food Delivery Partner</title>
<?php elseif ($page_name == "terms_and_conditions/index") : ?>
    <title>Terms and Conditions Fooyes | Your UK Food Delivery Partner</title>
<?php elseif ($page_name == "become_a_partner/index") : ?>
    <title>Become A Partner Fooyes | Your UK Food Delivery Partner</title>
<?php elseif ($page_name == "terms_of_use/index") : ?>
    <title>Terms Of Use Fooyes | Your UK Food Delivery Partner</title>
<?php elseif ($page_name == "solutions/index") : ?>
    <title>Solutions Fooyes | Your UK Food Delivery Partner</title>
<?php elseif ($isFooyes) : ?>
    <title><?php echo htmlspecialchars($page_title); ?> | <?php echo sanitize(get_system_settings('system_title')); ?></title>

<?php else: 
    $uri = $_SERVER['REQUEST_URI'];
    $host = $_SERVER['HTTP_HOST'];
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $canonical_url = $scheme . '://' . $host . $uri;
    $canonical_url = strtok($canonical_url, '?'); // Remove query strings
    
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
        $canonical_url = 'https://www.chilli-hut-march.co.uk/login';
    } elseif (strpos($uri, '/contact-us') !== false) {
        $title = 'Contacts for Chilli Hut March - Cambridgeshire';
        $description = 'Get in touch with our customer support team. We\'re here to assist you with orders, deliveries, and account inquiries.';
    } elseif (strpos($uri, '/auth') !== false) {
        $title = 'Chilli Hut March - Authentication';
        $description = 'Secure login and account authentication page for Chilli Hut March users.';
    }

?>


    <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>" />
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>" />
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Chilli Hut March",
  "alternateName": "chillihut",
  "url": "https://www.chilli-hut-march.co.uk/",
  "logo": "https://www.chilli-hut-march.co.uk/uploads/system/VJMkY4SgTdEnL35HtR9GUPD.png",
  "sameAs": "https://www.facebook.com/profile.php?id=61577144177609&_rdc=1&_rdr"
}
</script>
<?php endif; ?>


<link rel="shortcut icon" href="<?php echo base_url('uploads/system/' . get_website_settings('favicon')); ?>">


