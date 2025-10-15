<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    $isFooyes = false;
    $host = get_subdomain();
    if ($host === 'fooyes' || $host === 'staging') {
        $isFooyes = true;
    }
    ?>

    <?php if ($isFooyes): ?>
        <!-- Fooyes Meta -->
        <title>Sign In to Fooyes | Order Takeaways Online</title>
        <meta name="description" content="Log in to Fooyes and order your favourite dishes from top local takeaways across the UK." />
        <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
		<?php
   $uri = $_SERVER['REQUEST_URI'];
    $host = $_SERVER['HTTP_HOST'];
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $canonical_url = $scheme . '://' . $host . $uri;
    $canonical_url = strtok($canonical_url, '?'); // Remove query strings

    ?>
    
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>" />
    
    <?php else: ?>
        <!-- Chilli Hut March Meta -->
        <title>Chilli Hut March - Login Page</title>
        <meta name="description" content="Login to Chilli Hut March account to view and manage your orders." />
        <meta name="keywords" content="<?php echo sanitize(get_system_settings('website_keywords')); ?>" />
		<?php
   $uri = $_SERVER['REQUEST_URI'];
    $host = $_SERVER['HTTP_HOST'];
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $canonical_url = $scheme . '://' . $host . $uri;
    $canonical_url = strtok($canonical_url, '?'); // Remove query strings

    ?>
    
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>" />
    
    <?php endif; ?>

    <!-- Common Meta & Styles -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?php echo base_url('uploads/system/' . get_website_settings('favicon')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/fonts/iconic/css/material-design-iconic-font.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/toastr/toastr.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/css/util.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/css/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/css/custom.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/css/font.css'); ?>">

</head>


<body>
	<div class="container-login100">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<div class="text-center">
				<img src="<?php echo base_url('uploads/system/' . get_website_settings('website_logo')); ?>" class="auth-logo" alt="">
			</div>
			<?php if ($this->session->flashdata('error_message')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error_message'); ?>
    </div>
<?php endif; ?>
			<form action="<?php echo site_url('auth/validate'); ?>" method="POST" class="login100-form">
				<h1 class="login100-form-title p-b-37">
					<?//php echo get_phrase('sign_in'); ?>Sign In to Fooyes
				</h1>

				<div class="wrap-input100 m-b-20">
					<input class="input100" type="text" name="email" placeholder="<?php echo get_phrase('enter_your_email'); ?>" id="login-email">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 m-b-25">
					<input class="input100" type="password" name="password" placeholder="<?php echo get_phrase('enter_your_password'); ?>" id="login-pass">
					<span class="focus-input100"></span>
				</div>
				<div class="container-login100-form-btn">
					<button class="login100-form-btn">
						<?php echo get_phrase('sign_in'); ?>
					</button>
				</div>
				<div class="container-login100-form-btn">

				<a href="<?php echo site_url('auth/google_login'); ?>" class="btn btn-danger mt-2" style="color: #FFF;
display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex
;
    justify-content: center;
    align-items: center;
    padding: 0 16px;
    min-width: 160px;
    height: 50px;
    background-color: #f54748;
    border-radius: 25px;
    font-family: SourceSansPro-SemiBold;
    font-size: 14px;
    color: #fff;
    line-height: 1.2;
    text-transform: uppercase;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
    box-shadow: 0 10px 30px 0px rgba(189, 89, 212, 0.5)!important;
    -moz-box-shadow: 0 10px 30px 0px rgba(189, 89, 212, 0.5);
    -webkit-box-shadow: 0 10px 30px 0px rgba(189, 89, 212, 0.5);
    -o-box-shadow: 0 10px 30px 0px rgba(189, 89, 212, 0.5);
    -ms-box-shadow: 0 10px 30px 0px rgba(189, 89, 212, 0.5);
	">
    Login with Google
</a> 	
</div>


				<div class="text-center p-t-57 p-b-20">
					<span class="txt1 d-block">
						<a href="<?php echo site_url('auth/forget_password'); ?>" class="txt2 hov1">
							<?php echo get_phrase('forget_password'); ?>?
						</a>
					</span>
					<span class="txt1 d-block">
						<a href="<?php echo site_url('auth/roles'); ?>" class="txt2 hov1">
							<?php echo get_phrase('do_not_have_an_account'); ?>?
						</a>
					</span>
					<span class="txt1">
						<a href="<?php echo site_url(); ?>" class="txt2 hov1">
							<?php echo get_phrase('get_back_to_the_homepage'); ?>
						</a>
					</span>
				</div>
			</form>
		</div>
	</div>
	<script src="<?php echo base_url('assets/auth/vendor/jquery/jquery-3.2.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/auth/vendor/bootstrap/js/popper.js'); ?>"></script>
	<script src="<?php echo base_url('assets/auth/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/global/toastr/toastr.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/auth/js/main.js'); ?>"></script>
	<!-- Initialize common scripts for frontend and backend here -->
	<?php include APPPATH . "views/common/script.php"; ?>
</body>

</html>
