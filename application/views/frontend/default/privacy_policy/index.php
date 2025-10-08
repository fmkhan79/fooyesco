<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>

<?php 
$host = get_subdomain();
if($host != 'fooyes' && $host != 'staging'){
?>
<section class="detail-wbox mt-4 mb-2">
    <div class="container bg-white text-dark border border-light">
        <h1 style="font-size:40px; font-weight:600;" class="text-dark mb-5"><span class="text-privacy">Privacy</span>  <span class="text-policy">Policy</span></h1>

        <?php if (!empty($restaurant_details) && isset($restaurant_details['privacy_policy'])): ?>
            <?= $restaurant_details['privacy_policy'] ?>
        <?php endif; ?>
    </div>
</section>

<?php }else{ ?>
    <section class="detail-wbox mt-5 mb-2">
    <div class="container bg-white text-dark border border-light">

        <h1 style="font-size:40px; font-weight:600;" class="text-dark"><span class="text-privacy">Privacy</span>  <span class="text-policy">Policy</span></h1>

        <div class="about-bot-txt my-4" style=" width: 80%;">
            <p><span class="txt-fo" style="font-weight:500;">At Fooyes UK,</span><p style="color: #666;font-weight:500;font-size:15px; " > we value your privacy and are committed to protecting your personal data. ThisPrivacy Policy outlines how we collect, use, store, and safeguard your information when you visit our website or interact with our services.</p>
            <div class="txt-up-fo pb-3" >Information We Collect </div>
            <div class="text-fo pb-2"style="font-size:15px;" >We may collect and process the following types of personal data:</div>
            <div class="about-bot-txt">
        <ul class="p-0" >
             <p class="head-1" >Personal Information: </p ><p style="font-weight:500;font-size:15px;color:#666;"> Name, email address, phone number, and delivery address.</p>
             <p class="head-1" >Payment Information: </p ><p  style="font-weight:500;font-size:15px;color:#666;"> Billing details and payment method (processed securely through third-party providers).</p>
             <p class="head-1" >Usage Data: </p ><p  style="font-weight:500;font-size:15px;color:#666;color:#666;">Information about how you use our website, including browsing history and preferences.</p>
             <p class="head-1" >Cookies and Tracking Technologies: </p ><p  style="font-weight:500;font-size:15px;color:#666;">  To improve user experience and analyze website traffic.</p>
            <!-- <li> <p class="head-1" >Personal Information: </p ><p> Name, email address, phone number, and delivery address.</p></li > -->
            <!-- <li> <b>Payment Information:</b>  Billing details and payment method (processed securely through third-party providers).</li> -->
            <!-- <li> <b>Usage Data:</b> Information about how you use our website, including browsing history and preferences.</li> -->
            <!-- <li> <b> Cookies and Tracking Technologies:</b> To improve user experience and analyze website traffic.</li> -->
        </ul>
            <!-- <span><h3 style="display: inline;">2. How We Use Your Information <span>We use your personal data for the following purposes:
            </span></h3></span> -->
            <span class="txt-up-fo">How We Use Your Information </span> 

            <span class="text-fo" style="font-weight:500;font-size:15px;" >We use your personal data for the following purposes:</span >

            <div class="about-bot-txt">
        <ul  class=" p-0" >
        <p class="head-1" ><p style="font-weight:500;color:#666;"> To process and fulfill orders</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> To communicate with you about your purchases and provide customer support.</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> To send promotional offers and marketing communications (with your consent).</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> To comply with legal obligations and prevent fraudulent activity.</p>
            <!-- <li>To process and fulfill orders</li> -->
            <!-- <li>To communicate with you about your purchases and provide customer support.</li>
            <li>To improve our website, products, and services</li>
            <li>To send promotional offers and marketing communications (with your consent).</li>
            <li>To comply with legal obligations and prevent fraudulent activity.</li> -->
        </ul>
            <span class="txt-up-fo">Data Sharing and Security </span> 

            <div class="about-bot-txt">
        <ul  class=" p-0">
        <p class="head-1" ><p style="font-weight:500;color:#666;"> We do not sell or rent your personal data to third parties</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> Your information may be shared with trusted service providers (e.g., payment processors and delivery services) for operational purposes.</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> We implement strict security measures to protect your data from unauthorized access or breaches</p>
            <!-- <li>We do not sell or rent your personal data to third parties</li>
            <li>Your information may be shared with trusted service providers (e.g., payment processors and delivery services) for operational purposes.</li>
            <li>We implement strict security measures to protect your data from unauthorized access or breaches</li> -->
        </ul>
        <span class="txt-up-fo">Your Rights  </span> <span class="red-fo" >You have the right to:</span >
        <!-- <span><h3 style="display: inline;">4. Your Rights <span style="font-weight:300; font-size:30px;">You have the right to:
            </span></h3></span> -->
            <div class="about-bot-txt">
        <ul  class=" p-0">
        <p class="head-1" ><p style="font-weight:500;color:#666;"> Access, update, or delete your personal information.</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> Opt-out of marketing communications at any time.</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> Request details about the data we hold about you.</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> To send promotional offers and marketing communications (with your consent).</p>
        <p class="head-1" ><p style="font-weight:500;color:#666;"> Lodge a complaint with a data protection authority if you believe your rights have been violated.</p>
            <!-- <li>Access, update, or delete your personal information.</li>
            <li>Opt-out of marketing communications at any time.</li>
            <li> Request details about the data we hold about you.</li>
            <li>To send promotional offers and marketing communications (with your consent).</li>
            <li>Lodge a complaint with a data protection authority if you believe your rights have been violated.</li> -->
        </ul>
        <span class="txt-up-fo">Cookies Policy </span> 
            <div class="about-bot-txt">
        <ul  class=" p-0">
        <p class="head-1" ><p style="font-weight:500;color:#666;"> We use cookies to enhance your browsing experience. You can manage your cookie
        preferences through your browser settings.</p>

            <!-- <li >We use cookies to enhance your browsing experience. You can manage your cookie
            preferences through your browser settings.</li> -->
        </ul>
        <span class="txt-up-fo">Updates to This Policy </span>
            <br>
            <div class="about-bot-txt">
        <ul  class="p-0">
        <p class="head-1" ><p style="font-weight:500;color:#666;"> We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated effective date.</p>
        </ul>
        <span class="txt-up-fo"> Contact Us</></span>
            <div class="about-bot-txt">
        <ul  class=" p-0">
            <p class="head-1"><p style="font-weight:500;color:#666;"> If you have any questions about our Privacy Policy or how we handle your data, please
            contact us at Contact Information].
            <!-- <li>If you have any questions about our Privacy Policy or how we handle your data, please
            contact us at Contact Information].</li> -->
        </ul>
        </div>
        </div>
    </div>
</section>

<?php } ?>
<section class="dt-hide">
    <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png') ?>"/>
</section>

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
                <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-top-img.png') ?>" />
            </div>
        </div>
    </div>
</section>

<!--============================= RESERVE A SEAT =============================-->
<!-- <section class="reserve-block">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5><.?php echo site_phrase('privacy_policy', true) ?></h5>
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
                        <p><.?php echo get_website_settings('privacy_policy'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->