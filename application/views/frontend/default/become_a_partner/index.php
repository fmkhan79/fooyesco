<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        /* Original styles retained */
        .contact-info-section {
            margin-bottom: 30px;
        }

        .contact-heading {
                text-align: center;
            font-size: 40px;
            color: #343a40 !important;
        }
        @media (max-width: 450px){
            .contact-heading {
                text-align: center;
            font-size: 28px;
            color: #343a40 !important;
        }
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

        .contact-form-container {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            background-color: #f8f9fa;
        }

        .form-heading {
            font-weight: 500;
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

        /* Ensure the form stays fixed while scrolling */
        .sticky-form {
            position: -webkit-sticky; /* For Safari */
            position: sticky;
            top: 90px; /* Adjust as needed for spacing from top */
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>

    <!-- Partnership Section -->
    <section class="detail-wbox mt-5 mb-2">
        <div class="container bg-white text-dark border border-light">
            <h1 class="contact-heading">
                <span class="text-privacy pr-2">Become</span> A Partner
            </h1>
            <div class="row mt-5">
                <!-- Left Side: Partnership Details -->
                <div class="col-md-6 px-4">
                    <h3 style="font-weight:700;" class="display-5">Partnership Opportunities with Fooyes UK</h3>
                    <p style="font-weight:500; color:#666;">
                        At Fooyes UK, we believe in the power of collaboration and are always looking for strategic partners who share our passion for quality food and innovation. Check below a few benefits your business could gain by working with us.
                    </p>
                    <div class="about-bot-txt my-5">
                        <h3 style="font-size:24px;font-weight:600;">Why Partner with Fooyes UK?</h3>
                        <ul class="">
                            <li><span class="head-b">Market Reach:</span><p style="font-weight:500; color:#666;"> Gain exposure through our growing customer base across Peterborough.</p></li>
                            <li><span class="head-b">Quality Assurance:</span><p style="font-weight:500;color:#666;"> We prioritize excellence, ensuring our partners meet the highest standards.</p></li>
                            <li><span class="head-b">Sustainable Growth:</span><p style="font-weight:500;color:#666;"> We aim to build long-term, mutually beneficial relationships.</p></li>
                            <li><span class="head-b">Innovation and Support:</span><p style="font-weight:500;color:#666;"> Benefit from our expertise, marketing initiatives, and logistical support.</p></li>
                        </ul>
                    </div>
                    <div class="about-bot-txt">
                        <h3 style="font-size:24px;font-weight:600;">Types of Partnerships We Offer</h3>
                        <ul class="">
                            <li><span style="font-size:20px;font-weight:500;">Restaurant and Takeaway Partnerships:</span><p style="font-weight:500;color:#666;"> Use our premium food offerings to enhance your menu and delight your customers.</p></li>
                            <li><span style="font-size:20px;font-weight:500;">How to Get Started:</span><p style="font-weight:500;color:#666;"> Interested in partnering with us? Reach out to our team by sending an inquiry to Contact with details about your business and how we can work together.</p></li>
                        </ul>
                    </div>
                    <div style="padding: 30px 0px; display: flex; justify-content: center;">
                        <p style="font-size: 20px;"><b>Join us in shaping the future of the food industry with Fooyes UK!</b></p>
                    </div>
                </div>

                <!-- Right Side: Contact Form -->
                <div class="col-md-6">
                    <div class="contact-form-container sticky-form">
                        <h5 class="form-heading">Send us a Partnership request</h5>
                        <p class="form-description">
                            <strong style="color:#666!important;font-weight:500;font-size:15px">Please provide your Name, Email, Contact & Message so we will be in touch with you.</strong>
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
            </div>

            <!-- Commented sections retained as in original -->
            <!--
            <div class="row contact-info-section">
                <div class="col-md-6 contact-info-left">
                    <h4 class="contact-heading">Become a Partner</h4>
                    <p class="contact-timing">
                        Monday to Friday: 9AM to 5PM<br>
                        Saturday: 11AM to 5PM<br>
                        Sunday: 12AM to 5PM
                    </p>
                </div>
                <div class="col-md-6 contact-info-right">
                    <ul class="contact-details-list list-unstyled">
                        <li><i class="fas fa-phone-alt contact-icon"></i> <span class="contact-detail-text">Tel: 877-67-88-99</span></li>
                        <li><i class="fas fa-envelope contact-icon"></i> <span class="contact-detail-text">E-Mail: shop@fooyes.com</span></li>
                        <li><i class="fas fa-map-marker-alt contact-icon"></i> <span class="contact-detail-text">20 Margaret St, London, UK</span></li>
                        <li><i class="fas fa-shipping-fast contact-icon"></i> <span class="contact-detail-text">Free standard shipping on all orders.</span></li>
                    </ul>
                </div>
            </div>

            <div class="map-section">
                <h5 class="map-heading">Get In Touch</h5>
                <iframe class="contact-map" 
                        src="https://www.google.com/maps/embed?pb=YOUR_MAP_EMBED_URL"
                        width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="">
                </iframe>
            </div>

            <div class="row general-info-section">
                <div class="col-md-6 general-info-left">
                    <h5 class="general-info-heading">General Information</h5>
                    <p class="general-info-text">Eu dictumst cum at sed euismod condimentum?</p>
                    <p class="general-info-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Trincidunt sed tristique mollis vitae, consequat gravida sagittis.</p>
                    <p class="general-info-text">Magna bibendum est fermentum eros.</p>
                </div>
            </div>
            -->
        </div>
    </section>

    <section class="dt-hide">
        <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png') ?>" />
    </section>

    <section class="footer-top mt-4">
        <div class="container-fluid">
            <div class="d-md-flex">
                <div class="col-md-6">
                    <h3>It’s Now <span class="red">More Easy</span> to <span class="yellow">Order</span> by Our Mobile <span class="red">App</span></h3>
                    <p>All you need to do is download one of the best delivery apps, make a and most companies are opting for mobile app development for food delivery</p>
                    <div class="google-btns">
                        <a href="#" class="goole-play-btn"><img src="<?php echo base_url('assets/frontend/default/images/google-play-icon.png')?>" /></a>
                        <a href="#"><img src="<?php echo base_url('assets/frontend/default/images/app-store-icon.png')?>" /></a>
                    </div>
                </div>
                <div class="col-md-6 mob-hide">
                    <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-top-img.png') ?>" />
                </div>
            </div>
        </div>
    </section>
</body>
</html>