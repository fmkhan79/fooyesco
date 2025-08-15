<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>
<!--============================= RESERVE A SEAT =============================-->

<?php 
$host = get_subdomain();
if($host != 'fooyes' || $host != 'staging'):
?>
<section class="detail-wbox mt-4 mb-2">
    <div class="container bg-white text-dark border border-light">
        <h1 style="font-size:40px; font-weight:600;" class="text-dark mb-5"><span class="text-privacy">Terms &</span>  <span class="text-policy">Conditions</span></h1>

        <?= $restaurant_details['terms_conditions'] ?>
    </div>
</section>
<?php else: ?>

<section class="detail-wbox mt-4 mb-2 " >
    <div class="container bg-white text-dark border border-light">

        <h1 style="font-size:40px; font-weight:600;" class="  text-dark"><span class="text-privacy">Terms &</span>  <span class="text-policy">Conditions</span></h1>

        <div class="about-bot-txt my-4"style="font-weight:500;width: 80%;">
            <p style="font-weight:500;color:#666;">Welcome to Fooyes UK! By accessing and using our website, you agree to comply with the following Terms and Conditions. Please read them carefully before using our services.
            </p>

            <span><h3 style=" font-size:20px!important;color: #343a40;">General Information</h3></span>

            <div class="about-bot-txt">
        <ul class="p-0">
            <p style="font-weight:500;color:#666;">These Terms and Conditions govern your use of the Fooyes website and services. By using our platform, you acknowledge and accept these terms in full.</p>
        </ul>
            <span><h3 style="display: inline;font-size:20px;color: #343a40;">Ordering and Payments</h3></span>

            <div class="about-bot-txt">
        <ul class="p-0" >
            <p style="font-weight:500;color:#666;">All orders placed through our website are subject to availability.</p>
            <p style="font-weight:500;color:#666;">Prices listed are in GBP and may be subject to change without prior notice.</p>
            <p style="font-weight:500;color:#666;"> Payment must be made at the time of purchase using our accepted payment methods.</p>
            <p style="font-weight:500;color:#666;">We reserve the right to cancel or refuse orders at our discretion.
            </p>
        </ul>
            <span><h3 style="display: inline;font-size:20px;color: #343a40;">Delivery and Shipping</h3></span>

            <div class="about-bot-txt">
        <ul class="p-0">
        <p  style="font-weight:500;color:#666;">Delivery times are estimated and may vary due to unforeseen circumstances.
        </p>
        <p  style="font-weight:500;color:#666;">Customers must provide accurate delivery information. Fooyes UK is not responsible for orders lost due to incorrect details.</p>
        </ul>
        <span><h3 style="display: inline;font-size:20px;color: #343a40;">Order Cancellation and Amendments</h3></span>

            <div class="about-bot-txt">
        <ul class="p-0">
        <p style="font-weight:500;color:#666;">Once the order has been confirmed and payment taken from your account, you will be unable to cancel your order and will not be eligible for a refund.</p>
        <p style="font-weight:500;color:#666;">To change or cancel your order please contact the Fooyes Customer Support team who will attempt to resolve your request.</p>
        <p style="font-weight:500;color:#666;"> Fooyes will contact the Takeaway on your behalf but cannot guarantee your request will be accepted as food processing may already be underway.</p>
        </ul>
        <span><h3 style="display: inline;font-size:20px;color: #343a40;">Compensation</h3></span>


            <div class="about-bot-txt">
        <ul class="p-0">
        <p style="font-weight:500;color:#666;">If you are unhappy with the quality of any goods or the service provided by the Takeaway and wish to seek any form of compensation, you should contact the Takeaway directly to raise your complaint and, where appropriate, follow the Takeaway's own complaint procedures.</p>
        </ul>
        <span><h3 style="display: inline;font-size:20px;color: #343a40;">Refunds</h3></span>

            <div class="about-bot-txt">
        <ul class="p-0">
        <p style="font-weight:500;color:#666;"> Refunds will be processed within a reasonable timeframe upon approval.</p>
        </ul>
        <span><h3 style="display: inline;font-size:20px;color: #343a40;">Use of Our Website        </h3></span>

            <div class="about-bot-txt">
        <ul class="p-0">
        <p style="font-weight:500;color:#666;">You agree not to misuse our website for fraudulent activities or unlawful purposes.</p>
        <p style="font-weight:500;color:#666;">Unauthorized use of the website may result in legal action.</p>
        <p style="font-weight:500;color:#666;">We reserve the right to update or modify our website without prior notice.</p>
        </ul>
        <span><h3 style="display: inline;font-size:20px;color: #343a40;">Intellectual Property</h3></span>
            <div class="about-bot-txt">
        <ul class="p-0">
        <p style="font-weight:500;color:#666;">All content on the Fooyes UK website, including images, text, and logos, is our property and protected by copyright laws.</p>
        <p style="font-weight:500;color:#666;"> You may not reproduce, distribute, or use any content without prior written consent.</p>
        </ul>
        <span><h3 style="display: inline;font-size:20px;color: #343a40;">Limitation of Liability </h3></span>

            <div class="about-bot-txt">
        <ul class="p-0">
        <p style="font-weight:500;color:#666;">Fooyes UK is not responsible for indirect, incidental, or consequential damages arising
        from the use of our services.
        </p>
        <p style="font-weight:500;color:#666;">We do not guarantee uninterrupted or error-free access to our website.</p>
        </ul>
        <span><h3 style="display: inline;font-size:20px;color: #343a40;">Changes to Terms and Conditions</h3></span>
            <br>

            <div class="about-bot-txt">
        <ul class="p-0">
        <p style="font-weight:500;color:#666;">We reserve the right to update these Terms and Conditions at any time. Continued use
            of our website signifies acceptance of any changes.</p>
        </ul>
        <span><h3 style="display: inline;font-size:20px;color: #343a40;">Contact Us
        </h3></span>


            <div class="about-bot-txt">
        <ul class="p-0">
        <p style="font-weight:500;color:#666;">For any questions regarding these Terms and Conditions, please contact us at (877-67-88-99)</p>
        </ul>
        </div>
        </div>
    </div>
</section>
<?php endif; ?>


<section class="footer-top mt-4">
    <div class="container-fluid">
        <div class="d-md-flex ">
            <div class="col-md-6">
                <h3>It's Now <span class="red">More Easy</span> to <span class="yellow">Order</span> by Our Mobile <span
                        class="red">App</span></h3>
                <p>All you need to do is downlode one of the best delivery apps, make a and most companies are opting
                    for mobile app devlopment for food delivery</p>
                <div class="google-btns">
                    <a href="#" class="goole-play-btn">
                        <img src="<?php echo base_url('assets/frontend/default/images/google-play-icon.png') ?>" />
                    </a>
                    <a href="#">
                        <img src="<?php echo base_url('assets/frontend/default/images/app-store-icon.png') ?>" />
                    </a>
                </div>
            </div>
            <div class="col-md-6 mob-hide">
                <img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/footer-top-img.png') ?>" />
            </div>
        </div>
    </div>
</section>

<!-- <section class="reserve-block">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5><.?php echo site_phrase('terms_and_conditions', true) ?></h5>
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
                        <p><.?php echo get_website_settings('terms_and_conditions'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->