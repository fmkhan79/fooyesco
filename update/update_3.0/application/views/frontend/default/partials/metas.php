<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="<?php echo sanitize(get_system_settings('author')); ?>">
<?php
if ($page_name == "restaurant/index") : ?>
    <meta name="keywords" content="<?php echo sanitize($restaurant_details['seo_tags']); ?>" />
    <meta name="description" content="<?php echo sanitize($restaurant_details['seo_description']); ?>" />
<?php else : ?>
    <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
    <meta name="description" content="<?php echo sanitize(get_system_settings('website_description')); ?>" />
<?php endif; ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- PAGE TITLE ARE SAFE. SINCE THEY ARE BEING GENERATED INSIDE THE SYSTEM -->
<title><?php echo htmlspecialchars($page_title); ?> | <?php echo sanitize(get_system_settings('system_title')); ?></title>
<link rel="shortcut icon" href="<?php echo base_url('uploads/system/' . get_website_settings('favicon')); ?>">
