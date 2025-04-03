<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<!--============================= RESERVE A SEAT =============================-->
<style>

/* Contact Info Section */
.contact-info-section {
    margin-bottom: 30px;
}

.contact-heading {
    font-weight: bold;
    display: flex;
    justify-content: center;
    font-size: 30px;
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
</style>



<section class="detail-wbox mt-4 mb-2">
    <div class="container bg-white text-dark border border-light">
    <h4 class="contact-heading">Become a Partner</h4>
    <div class="about-bot-txt my-5">
            <h3>Partnership Opportunities with Fooyes UK
            </h3>
            <p> At Fooyes UK, we believe in the power of collaboration and are always looking for strategic
partners who share our passion for quality food and innovation. Check below a few benefits
your business could gain by working with us.</p>
        </div>
        <div style="display: flex; justify-content: center;">
    <div class="col-md-8 contact-form-container bg-light">
            <h5 class="form-heading">Send us a Partnership request</h5>
            <p class="form-description">
                <strong>Please provide your Name, Email, Contact & Meassage so we will be in touch with you.</strong><br>
            </p>
            <form class="contact-form">
            <div class="form-group d-flex" style="gap:20px">
    <input type="text" class="form-control contact-form-input" placeholder="First Name" style="width: 50%;">
    <input type="text" class="form-control contact-form-input" placeholder="Last Name" style="width: 50%;">
</div>
<div class="form-group">
    <input type="email" class="form-control contact-form-input" placeholder="Email">
</div>
<div class="form-group">
    <input type="tel" class="form-control contact-form-input" placeholder="Phone Number">
</div>

                <div class="form-group">
                    <input type="text" class="form-control contact-form-input" placeholder="Subject">
                </div>
                <div class="form-group">
                    <textarea class="form-control contact-form-textarea" rows="4" placeholder="Type Your Message"></textarea>
                </div>
                <button type="submit" class="btn contact-form-submit-btn">Submit</button>
            </form>
        </div>
        </div>
        <div class="about-bot-txt my-5">
           <h3>Why Partner with Fooyes UK?</h3>
        <ul style="gap: 10px; display: grid;">
            <li> <b>Market Reach: </b>Gain exposure through our growing customer base across Peterborough.</li>
            <li> <b>Quality Assurance:</b>  We prioritize excellence, ensuring our partners meet the highest standards.</li>
            <li> <b>Sustainable Growth:</b> We aim to build long-term, mutually beneficial relationships.</li>
            <li> <b>Innovation and Support:</b> Benefit from our expertise, marketing initiatives, and logistical support.</li>
        </ul>
        </div>
        <div class="about-bot-txt">
           <h3>Types of Partnerships We Offer</h3>
        <ul style="gap: 10px; display: grid;">
            <li> <b>Restaurant and Takeaway Partnerships: </b>Use our premium food offerings to enhance your menu and delight your customers.</li>
        </ul>
        </div>
        <div class="about-bot-txt">
           <h3>How to Get Started</h3>
        <ul style="gap: 10px; display: grid;">
            <li> Interested in partnering with us? Reach out to our team by sending an inquiry to [ Contact ] with details about your business and how we can work together.</li>
        </ul>
        </div>
        <div style="padding: 30px 0px; display: flex; justify-content: center;">
        <p style="font-size: 30px;"><b>Join us in shaping the future of the food industry with Fooyes UK!</b></p>
        </div>
    <div class="row contact-info-section">
        <!-- <div class="col-md-6 contact-info-left">
            <h4 class="contact-heading">Become a Partner</h4>
            <p class="contact-timing">
                Monday to Friday: 9AM to 5PM<br>
                Saturday: 11AM to 5PM<br>
                Sunday: 12AM to 5PM
            </p>
        </div> -->
        <!-- <div class="col-md-6 contact-info-right">
            <ul class="contact-details-list list-unstyled">
                <li><i class="fas fa-phone-alt contact-icon"></i> <span class="contact-detail-text">Tel: 877-67-88-99</span></li>
                <li><i class="fas fa-envelope contact-icon"></i> <span class="contact-detail-text">E-Mail: shop@fooyes.com</span></li>
                <li><i class="fas fa-map-marker-alt contact-icon"></i> <span class="contact-detail-text">20 Margaret St, London, UK</span></li>
                <li><i class="fas fa-shipping-fast contact-icon"></i> <span class="contact-detail-text">Free standard shipping on all orders.</span></li>
            </ul>
        </div> -->
    </div>

    <!-- Map -->
    <!-- <div class="map-section">
        <h5 class="map-heading">Get In Touch</h5>
        <iframe class="contact-map" 
                src="https://www.google.com/maps/embed?pb=YOUR_MAP_EMBED_URL"
                width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="">
        </iframe>
    </div> -->

    <!-- General Information and Contact Form -->
   
    <div class="row general-info-section">
        <!-- <div class="col-md-6 general-info-left">
            <h5 class="general-info-heading">General Information</h5>
            <p class="general-info-text">Eu dictumst cum at sed euismod condimentum?</p>
            <p class="general-info-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Trincidunt sed tristique mollis vitae, consequat gravida sagittis.</p>
            <p class="general-info-text">Magna bibendum est fermentum eros.</p>
        </div> -->


    </div>
        <!-- <h4 class="mt-5 mb-5 text-dark"><?php echo site_phrase('contact_us', true) ?></h4>
        <div class="about-txt my-4 py-md-4" style="background: url(<?php echo base_url("assets/frontend/default/images/about-img.png"); ?>) no-repeat right">
            <div class="row">
                <div class="col-md-6">
                    <p >This is a type of resturent which typically serves food and drink, in addition to light
                        refreshments such as baked goods or snacks. The term comes frome the rench word meaning food Are
                        you hungry? Did you have a long and stressful day? Interested in getting a cheesy pizza
                        delivered to your office or looking to avoid the weekly shop? Then Pakistan is the right
                        destination for you! offers you a long and detailed list of the best restaurants and shops near
                        you to help make your everyday easier.</p>
                    <p> Our online food delivery service has it all, whether you fancy Indian, Pakistani or Afghan
                        cuisine, Pakistan has over 15,000 restaurants available in top cities like Islamabad, Lahore,
                        Rawalpindi, and Karachi. Did you know you can order your groceries and more from , too? Check
                        out shops for favourite partners like Al-Fatah, Greenvalley and more. Sit back and relax – let
                        Pakistan take the pressure off your shoulders.</p>
                </div>
            </div>
        </div>

        <div class="about-bot-txt my-5">
            <p>This is a type of resturent which typically serves food and drink, in addition to light refreshments such
                as baked goods or snacks. The term comes frome the rench word meaning food Are you hungry? Did you have
                a long and stressful day? Interested in getting a cheesy pizza delivered to your office or looking to
                avoid the weekly shop? Then Pakistan is the right destination for you! offers you a long and detailed
                list of the best restaurants and shops near you to help make your everyday easier.</p>
            <p> Our online food delivery service has it all, whether you fancy Indian, Pakistani or Afghan cuisine,
                Pakistan has over 15,000 restaurants available in top cities like Islamabad, Lahore, Rawalpindi, and
                Karachi. Did you know you can order your groceries and more from , too? Check out shops for favourite
                partners like Al-Fatah, Greenvalley and more. Sit back and relax, let Pakistan take the pressure off
                your shoulders.</p>
        </div>

        <ul>
            <li>This is a type of resturent which typically serves food and drink, in addition to light refreshments
                such as baked goods or snacks. The term comes frome the rench word meaning food Are you hungry? Did you
                have a long and stressful</li>
            <li>Our online food delivery service has it all, whether you fancy Indian, Pakistani or Afghan cuisine,
                Pakistan has over 15,000 restaurants available in top cities like Islamabad, Lahore, Rawalpindi, and
                Karachi. Did you know you can order your groceries and more from , too?</li>
            <li>Check out shops for favourite partners like Al-Fatah, Greenvalley and more. Sit back and relax, let
                Pakistan take the pressure off your shoulders.</li>
        </ul> -->
    </div>
</section>

<section class="dt-hide">
    <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png') ?>" />
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
                <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-top-img.png') ?>" />
            </div>
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


