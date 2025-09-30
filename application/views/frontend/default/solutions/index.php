<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; 

// echo '<pre>';
// print_r($restaurant);
// echo '</pre>';
// die();
?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
 
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<!--============================= RESERVE A SEAT =============================-->
<style>
.main-banner{ margin: 30px 0;}
    .main-banner h5{color: #191919;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;}

    .main-banner h1{color: #191919;
        font-size: 50px;
        font-style: normal;
        font-weight: 900; margin-bottom: 20px;}
.svg-devider-box{ margin: 15px 0 20px;}
.main-banner .text-danger{color:#F54748!important;}
.main-banner h1 .text-warning{color:#FDC55E!important; position: relative;}
.main-banner h1 .text-warning::after{content: ""; position: absolute; background: no-repeat; width: 257px; height: 9px; left: 10px; bottom: -10px;}
/* Contact Info Section */
.contact-info-section {
    margin-bottom: 30px;
}

.contact-heading {
    font-weight: bold;
}

.contact-details-list {
    padding: 0;
}

.contact-icon {
    color: red;
    margin-right: 10px;
}

.contact-detail-text {
    font-size: 16px;
}

.contact-timing {
    font-size: 16px;
    color: #666;
}

/* Map Section */
.map-section {
    margin-bottom: 30px;
}
.map-section iframe{
    border-radius: 15px !important;
}

.map-heading {
    font-weight: bold;
    margin-bottom: 15px;
}

.contact-map {
    border-radius: 10px;
}

/* General Info Section */
.general-info-section {
    margin-top: 30px;
}

.general-info-heading {
    font-weight: bold;
}

.general-info-text {
    font-size: 16px;
    color: #555;
}

/* Contact Form */
.contact-form-container {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}

.form-heading {
    font-weight: bold;
}

.form-description {
    font-size: 14px;
    color: #444;
}

.contact-form-input,
.contact-form-textarea {
    border-radius: 5px;
}

.contact-form-submit-btn {
    background-color: red;
    color: #fff;
    border-radius: 5px;
    padding: 10px 20px;
    font-weight: bold;
    width: 100%;
    transition: 0.3s;
}

.contact-form-submit-btn:hover {
    background-color: #c00;
}
.map-container {
    position: relative;
    width: 100%;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio (adjust as needed) */
    height: 0;
    overflow: hidden;
}

.map-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

.fa-whatsapp{
    font-weight: bold !important;
    font-size: 17px;
}
.contact-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: #F54748; /* Red background */
    color: #ffffff; /* White icon */
    border-radius: 50%; /* Circular shape */
    font-size: 20px; /* Adjust icon size */
    margin-right: 10px; /* Space between icon and text */
    vertical-align: middle;
    padding: 10px 18px;
}

.contact-details-list li {
    display: flex;
    align-items: center;
    margin-bottom: 15px; /* Space between list items */
}

.contact-detail-text {
    font-size: 16px;
}

@media (max-width: 768px) {
    .navbar{
        display: block !important;
    }
    .before-footer::before {
  display: none !important;
}
}
.multi-service-box{ background: no-repeat top left;color:#191919;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal; padding: 35px 0 150px;}
.multi-service-box h3{color: #000;
    font-size: 48px;
    font-style: normal;
    font-weight: 700; padding: 0; margin: 0 0 21px;}


    
</style>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php
// $siteKey = '';
// $secretKey = '';
// foreach ($reCaptcha as $row) {
//     if ($row->key == 'recaptcha_sitekey') {
//         $siteKey = $row->value;
//     } elseif ($row->key == 'recaptcha_secretkey') {
//         $secretKey = $row->value;
//     }
// }
// print_r($siteKey);
// die();
?>


<!-- SLIDER -->
<section class="main-banner d-flex align-items-center mt-0 mt-md-4" >
    <div class="container my-5" style="max-width: 1000px!important">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-5 pl-3 pl-md-0 mt-0 pt-0 mt-md-5 pt-md-5" >
                        <div class="slider-content_wrap">
                           
                            <div>

                      
                            <h1>We're
                                <span class="text-danger">The</span> Best
                                <span class="text-danger">POS</span> Provider.
                         
                            </h1>
                         
                            </div>
                      

                        <!-- for mobile  -->
                  

                    <!-- end for mobile  -->


                     <!-- start for desktop -->
                    <div class="banner-form-box d-md-block d-flex  flex-column">
                    <h5 class="text-dark font-weight-light pt-md-0 " style="font-size:18px;">
                               We’re the best POS provider, delivering fast, secure, and reliable solutions to help your business grow.
                            </h5>
                      
                            <a  href="<?php echo site_url('become-a-partner'); ?>" class="btn btn-danger banner-btn"style="
                            color: #FFF;
                            width: 40%;
    font-size: 14px;
    font-style: normal;
    font-weight: 600;
    line-height: 100%;
    letter-spacing: 0.16px;
    border-radius: 41px;
    padding: 13px;
    vertical-align: sub;
    margin-right: 5px;
    background: #F54748 !important;
    border-color: #F54748 !important;"
                               >
                               
                                            <?php echo site_phrase(ucwords('book_a_demo', true)); ?>
                               
</a>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-7 text-md-right">
                    <!-- add ? <.?.php -->
                    <img class="img-fluid"
                        src="<?php echo base_url('assets/frontend/default/images/hero-img.png') ?>" />
                </div>
                
            </div>
            
        </div>
        
    </div>
    
    </div>
</section>
<!--// SLIDER -->

<section class="multi-service-box" style="padding-bottom:0px; margin-bottom: 50px;">
    <div class="container" style="max-width: 1000px!important pl-0!important">
        <div class="d-md-flex align-items-center">
            <div class="col-md-5"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/mult-service.png') ?>"></div>
            <div class="col-md-7">
                <h3>All in one <span class="red">POS</span> system</h3>
                <p>This is a type of resturent which typically serves food and drink, in addition to light refreshments
                    such as
                    baked goods or snacks. The term comes frome the rench word meaning food</p>
                <div class="row multi-service-list mt-4 mb-3">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/online-order-icon.png') ?>" />
                        Online Order</div>
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/24-7-icon.png') ?>" /> 24/7 Service
                    </div>
                </div>
                <div class="row multi-service-list mb-3 ">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Pre-Reservation
                    </div>
                    <div class="col-lg-5 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Oragonized
                        Foodhut Place</div>
                </div>
                <div class="row multi-service-list mb-3 ">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Super Chef
                    </div>
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Clean Kitchen
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<section class="dt-hide">
    <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-top.png') ?>" />
</section>                                                                                                                  

<section class="footer-top mt-4">
    <div class="container-fluid">
        <div class="d-md-flex ">
            <div class="col-md-6">
                <h3>It’s Now <span class="red">More Easy</span> to <span class="yellow">Order</span> by Our Mobile <span
                        class="red">App</span></h3>
                <p>All you need to do is downlode one of the best delivery apps, make a and most companies are opting
                    for mobile app devlopment for food delivery</p>
                <div class="google-btns"><a href="#" class="goole-play-btn"><img src="<?php echo base_url('assets/frontend/default/images/google-play-icon.png')?>" /></a> 
                    <a href="#">
                        <img src="<?php echo base_url('assets/frontend/default/images/app-store-icon.png')?>" />
                    </a>
                </div>
            </div>
            <div class="col-md-6 mob-hide">
                <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-top.png') ?>" />
            </div>
        </div>
    </div>
</section>

<section class="dt-hide d-none"><img class="img-fluid"
        src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png') ?>" /></section>
<section class="before-footer mt-4">
    <div class="container" style="max-width: 1000px!important">
        <div class="d-md-flex ">
            <div class="col-md-6">
                <h3>Join the <span class="red">Fooyes</span> Community </span></h3>
                <p>Follow us on social media and sign up for exclusive offers, new menu launches, and foodie events.</p>
                <p><i class="fas fa-map-marker-alt fooyes-icon"></i> <strong>Find Us:</strong> 110 Eastern Ave, Peterborough PE1 4PW, UK</p>
    <p><i class="fas fa-phone-alt fooyes-icon"></i> <strong>Contact Us:</strong> <a href="tel:+447438797814" style="color:#191919">+44-7438797814</a></p>
    <p><i class="fas fa-envelope fooyes-icon"></i> <strong>Email:</strong> <a href="mailto:support@fooyes.co.uk" style="color:#191919">support@fooyes.co.uk</a></p>
    <p style="font-size:18px"> <b>Delicious moments start here. Welcome to Fooyes UK!</b></p>
            </div>
            <div class="col-md-6 mob-hide"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/footer-top.png') ?>" /></div>
        </div>
    </div>
</section>

<!-- <section class="reserve-block">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5><.?php echo site_phrase('about_us', true) ?></h5>
            </div>
        </div>
    </div>
</section> -->
<!--//END RESERVE A SEAT -->
<!--============================= BOOKING DETAILS =============================-->
<!-- <section class="light-bg booking-details_wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 responsive-wrap">
                <div class="booking-checkbox_wrap">
                    <div class="booking-checkbox">
                        <p><.?php echo get_website_settings('about_us'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="multi-service-box" style="padding-bottom:0px; margin-bottom: 50px;">
    <div class="container" style="max-width: 1000px!important pl-0!important">
        <div class="d-md-flex align-items-center">
            <div class="col-md-5"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/mult-service.png') ?>"></div>
            <div class="col-md-7">
                <h3>All in one <span class="red">POS</span> system</h3>
                <p>This is a type of resturent which typically serves food and drink, in addition to light refreshments
                    such as
                    baked goods or snacks. The term comes frome the rench word meaning food</p>
                <div class="row multi-service-list mt-4 mb-3">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/online-order-icon.png') ?>" />
                        Online Order</div>
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/24-7-icon.png') ?>" /> 24/7 Service
                    </div>
                </div>
                <div class="row multi-service-list mb-3 ">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Pre-Reservation
                    </div>
                    <div class="col-lg-5 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Oragonized
                        Foodhut Place</div>
                </div>
                <div class="row multi-service-list mb-3 ">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Super Chef
                    </div>
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Clean Kitchen
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
