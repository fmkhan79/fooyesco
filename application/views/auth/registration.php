<!DOCTYPE html>
<html lang="en">

<head>
	<title>Sign In to Fooyes | Order Takeaways Online</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Log in to Fooyes and order your favourite dishes from top local takeaways across the UK." />
	<link rel="icon" type="image/png" href="<?php echo base_url('uploads/system/' . get_website_settings('favicon')); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/vendor/bootstrap/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/fonts/iconic/css/material-design-iconic-font.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/toastr/toastr.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/css/util.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/css/main.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auth/css/custom.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/css/font.css'); ?>">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
			<?php if ($role == "customer" || $role == "owner" || $role == "driver") : ?>
				<form action="<?php echo site_url('auth/register'); ?>" method="POST" class="login100-form">
					
					<h1 class="login100-form-title p-b-37">
						<?//php echo get_phrase('sign_up') . ' ' . ucfirst(sanitize($role)); ?>
Signup into Fooyes
					</h1>

	
					<input type="hidden" name="role" value="<?php echo sanitize($role); ?>">
					<div class="wrap-input100 m-b-20">
						<input class="input100" type="text" name="name" placeholder="<?php echo get_phrase('enter_your_name'); ?>" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 m-b-20">
						<input class="input100" type="text" name="email" placeholder="<?php echo get_phrase('enter_your_email'); ?>" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 m-b-25">
						<input class="input100" type="password" name="password" placeholder="<?php echo get_phrase('enter_your_password'); ?>" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 m-b-20">
						<input class="input100" type="text" name="phone" placeholder="<?php echo get_phrase('enter_your_phone_number'); ?>" required>
						<span class="focus-input100"></span>
					</div>

					<!-- <div class="wrap-input100 m-b-20">
						<div class="g-recaptcha mb-2" data-sitekey="<?php echo get_system_settings('recaptcha_sitekey') ?>" required></div>
					</div> -->

					

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							<?php echo get_phrase('register'); ?>
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
Continue with Google
</a> 	
</div>

					<div class="text-center p-t-57 p-b-20">
						<span class="txt1 d-block">
							<a href="<?php echo site_url('auth'); ?>" class="txt2 hov1">
								<?php echo get_phrase('login_page'); ?>?
							</a>
						</span>
						<!-- <span class="txt1">
							<a href="<?php echo site_url('cart'); ?>" class="txt2 hov1">
								<?php echo get_phrase('Go to the cart page'); ?>
							</a>
						</span> -->
					</div>
				</form>
			<?php else : ?>
				<span class="login100-form-title p-b-37">
					<?php echo get_phrase('wait') . '...' . get_phrase('what') . '!'; ?>
					<img src="<?php echo base_url('assets/auth/images/confused.png'); ?>" alt="" class="confused">
				</span>
				<div class="text-center p-b-20">
					<span class="txt1 d-block">
						<a href="<?php echo site_url('auth/roles'); ?>" class="txt2 hov1">
							<?php echo get_phrase('valid_user_roles'); ?>?
						</a>
					</span>
					<!-- <span class="txt1">
						<a href="<?php echo site_url(); ?>" class="txt2 hov1">
							<?php echo get_phrase('Go to cart page'); ?>
						</a>
					</span> -->
				</div>
			<?php endif; ?>
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