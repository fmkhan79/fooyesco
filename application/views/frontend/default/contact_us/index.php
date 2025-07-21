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

</style>



<section class="detail-wbox mt-4 mb-2">
    <div class="container bg-white text-dark border border-light">
    <div class="row contact-info-section">
        <div class="col-md-6 contact-info-left">
            <h4 class="contact-heading">Contact Us</h4>
            <p class="contact-timing">
                Monday to Friday: 9AM to 5PM<br>
                Saturday: 11AM to 5PM<br>
                Sunday: 12AM to 5PM
            </p>
        </div>
        <div class="col-md-6 contact-info-right">
            <ul class="contact-details-list list-unstyled">

                <li><i class="fab fa-whatsapp contact-icon"></i> <a href="https://wa.me/+4407438797814" target="_blank" class="contact-detail-text text-dark"> 07438797814</a></li>
                <li><i class="fas fa-envelope contact-icon"></i> <a href="mailto:support@fooyes.co.uk" class="contact-detail-text text-dark">support@fooyes.co.uk</a></li>
                <li><i class="fas fa-map-marker-alt contact-icon"></i> <span class="contact-detail-text">110 Eastern Ave, Peterborough PE1 4PW, UK</span></li>
                <!-- <li><i class="fas fa-shipping-fast contact-icon"></i> <span class="contact-detail-text">Free standard shipping on all orders.</span></li> -->

            </ul>
        </div>
    </div>

    <!-- Map -->
    <div class="map-section">
        <h5 class="map-heading">Get In Touch</h5>
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2423.6450253615!2d-0.22366232387648655!3d52.59411083074067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4877f0eac6b349d7%3A0x3b82c9a230faee40!2s110%20Eastern%20Ave%2C%20Peterborough%20PE1%204PW%2C%20UK!5e0!3m2!1sen!2s!4v1751540971911!5m2!1sen!2s" 
            width="100%" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <!-- General Information and Contact Form -->
    <div class="row general-info-section">
        <div class="col-md-6 general-info-left">
            <h5 class="general-info-heading">General Information</h5>
            <p class="general-info-text">Have questions about our menu, services, or ingredients?</p>
            <p class="general-info-text">We’re here to help! Whether it's about orders, catering, or dietary preferences, we’ve got you covered.</p>
            <p class="general-info-text">Feel free to reach out, and we’ll get back to you as soon as possible</p>
        </div>

        <div class="col-md-6 contact-form-container bg-light">
            <h5 class="form-heading">Ask a Question</h5>
            <p class="form-description">
                <strong>Got a question? Let’s talk!</strong><br>
                Drop us a message, and our team will be happy to assist you.
            </p>
            <form class="contact-form" action="<?php echo site_url('submissions/submit'); ?>" method="post">
                <div class="form-group">
                    <input type="text" name="name" class="form-control contact-form-input" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control contact-form-input" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="subject" class="form-control contact-form-input" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <textarea name="message" class="form-control contact-form-textarea" rows="4" placeholder="Type Your Message" required></textarea>
                </div>
                <button type="submit" class="btn contact-form-submit-btn">Submit</button>
            </form>
        </div>
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


