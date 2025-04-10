NAVIGATION BAR
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>
<style>

/* .fooyes-faq-container {
    max-width: 800px;
    margin: 0 auto;
} */

.fooyes-faq-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 30px;
}

.fooyes-text-red {
    color: #e63946;
}

.fooyes-text-yellow {
    color: #fdc55e;
}

.fooyes-faq-list {
    text-align: left;
}

.fooyes-faq-item {
    background: #f8f8f8;
    border-radius: 12px;
    margin-bottom: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.fooyes-faq-question {
    width: 100%;
    background: none;
    border: none;
    padding: 15px;
    font-weight: 500;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    color: #343a40;
    outline: none;
    transition: background 0.3s ease;
}

.fooyes-faq-question:hover {
    background: #f54748;
    color: #fff;
}

.faq-icon {
    font-size: 1.5rem;
    font-weight: bold;
}

.fooyes-faq-answer {
    font-size:15px ;
    color: #666;
    font-weight:500;
    line-height: 1.5;
    display: none;
}

.fooyes-faq-item.active .fooyes-faq-answer {
    display: block;
    padding:15px;
}
</style>
<!--============================= RESERVE A SEAT =============================-->

<section class="detail-wbox mt-4 mb-2">
    <div class="container bg-white text-dark border border-light">
        <h1 style="font-size:40px; font-weight:600;" class="text-dark"><span class="text-privacy pr-2">About</span><span class="text-policy">Us</span></h1>
        <div class="about-txt  py-md-4" style="background: url(<?php echo base_url("assets/frontend/default/images/about-img.png"); ?>) no-repeat right">

            <div class="row" style="margin-left: 0px;">

                <div class="col-md-6">
                    <p  class="text-new">Welcome to Fooyes – where great food meets convenience! Based in the heart of the UK,
                        Peterborough, we are your go-to solution for satisfying cravings and enjoying delicious meals,
                        anytime, anywhere. Whether you’re at home, at work, or on the go, Fooyes brings your favourite
                        dishes straight to your doorstep with just a few clicks.</p>
                        <h2 class="head-1">Who We Are</h2>
                    <p class="text-new"> Fooyes was born from a simple idea: to connect people with amazing food experiences while
                        supporting local restaurants and takeaways. Our passion for food, combined with our
                        commitment to quality and reliability, drives us to deliver not just meals but moments of joy to
                        your table. We’re a team of food enthusiasts, tech innovators, and customer service champions
                        who believe that everyone deserves access to good food effortlessly.</p>
                </div>
            </div>
        </div>

        <div class="about-bot-txt my-5" style="width:80%;">
            <h3 class="head-1">What We Do</h3>
            <p class="text-new"> From comforting classics to global cuisines, Fooyes partners with a wide variety of restaurants
                and takeaways to cater to every palate and preference. Our easy-to-use platform ensures a
                seamless ordering experience.</p>
            <p class="text-new"> At Fooyes, we’re more than just a delivery app, we’re a community builder. By partnering with
                local businesses, we help them grow and thrive while giving customers access to unique and
                diverse dining options.</p>
        </div>
        <div class="about-bot-txt"  style="width:80%;">
           <h3  class="head-1">Why Choose Us?</h3>
        <ul class="p-0"style="width:80%;">
            <span class="head-1" >Fast & Reliable:</span> <p class="text-new">Timely deliveries you can trust, no matter where you are.</p>
            <span class="head-1">Quality Assurance:</span> <p class="text-new">We handpick our products to ensure the highest standards.</p>
            <span class="head-1">Diverse Options:</span> <p class="text-new">A vast menu from local favourites to top-notch restaurants.</p>
            <span class="head-1">Customer First:</span> <p class="text-new"> Our customers are at the heart of everything we do. From intuitive ordering to responsive support, we’re here for you.</p>
            <span class="head-1">Passion for Food:</span> <p class="text-new"> We love food as much as you do and strive to make every meal special.</p>
            <span class="head-1">Sustainability:</span> <p class="text-new"> We care about the planet. Fooyes is committed to reducing food waste and adopting eco-friendly practices across our operations.</p>
        </ul>
        </div>
        <div class="about-bot-txt my-5"  style="width:80%;">
            <h3  class="head-1">What We Do</h3>
            <p  class="text-new"> Our mission is simple: to deliver outstanding food and take your dining experience to the next
            level.</p>
            <p  class="text-new"> We make mealtime moments effortless and enjoyable while empowering local communities
                through innovative food delivery solutions. At Fooyes, we don’t just deliver food; we deliver
                happiness, one meal at a time.
            </p>
        </div>
        <div class="about-bot-txt my-5"  style="width:80%;">
            <h2  class="head-1">Join Us on the Journey</h2>
            <p  class="text-new"> Join us on our journey to make food more exciting, sustainable, and accessible</p>
            <p  class="text-new"> Hungry for more? Whether you’re a foodie looking to explore new tastes or a restaurant seeking
                a reliable partner, Fooyes is here to make your dining dreams come true. Let’s say “yes” to good
                food together!
            </p>
            <p  class="text-new"> For inquiries or collaborations, feel free to contact us at tel no.</p>
            <p  class="text-new"> Fooyes – Food that says yes!</p>
        </div>
        <section class="fooyes-faq">
    <div class="fooyes-faq-container">
        <h2  class="head-1"> Frequently Asked Questions (FAQs) - Fooyes UK  </h2>
        
        <div class="fooyes-faq-list">
            <div class="fooyes-faq-item">
                <button class="fooyes-faq-question">
                What is Fooyes UK? <span class="faq-icon">+</span>
                </button>
                <div class="fooyes-faq-answer">
                Fooyes UK is a premium food ordering app,we partner with a wide variety of restaurants and
takeaways to cater to every palate and preference. Our easy-to-use platform ensures a
seamless ordering experience.

                </div>
            </div>

            <div class="fooyes-faq-item">
                <button class="fooyes-faq-question">
                How can I place an order?
                <span class="faq-icon">+</span>
                </button>
                <div class="fooyes-faq-answer">
                You can place an order directly through our website. Simply browse our selection, add items to
your cart, and proceed to checkout.

                </div>
            </div>

            <div class="fooyes-faq-item">
                <button class="fooyes-faq-question">
                What payment methods do you accept?
                <span class="faq-icon">+</span>
                </button>
                <div class="fooyes-faq-answer">
                We accept major credit and debit cards, PayPal, and other secure payment options available at
                checkout.
                </div>
            </div>

            <div class="fooyes-faq-item">
                <button class="fooyes-faq-question">
                Can I track my order? <span class="faq-icon">+</span>
                </button>
                <div class="fooyes-faq-answer">
                Yes, once your order is dispatched, you will receive a tracking link via email to monitor your
                delivery status.
                </div>
            </div>
            <div class="fooyes-faq-item">
                <button class="fooyes-faq-question">
                How can I contact customer support? <span class="faq-icon">+</span>
                </button>
                <div class="fooyes-faq-answer">
                You can reach our support team on our website’s contact us form
                </div>
            </div>
            <div class="fooyes-faq-item">
                <button class="fooyes-faq-question">
                Do you offer business partnerships?<span class="faq-icon">+</span>
                </button>
                <div class="fooyes-faq-answer">
    Yes, we collaborate with businesses. Click here to join the Fooyes family.<a href="become-a-partner">Become a partner</a>
</div>
            </div>
        </div>
    </div>
</section>

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
<script>
    document.querySelectorAll(".fooyes-faq-question").forEach(button => {
    button.addEventListener("click", () => {
        const faqItem = button.parentElement;
        faqItem.classList.toggle("active");

        const icon = button.querySelector(".faq-icon");
        icon.textContent = faqItem.classList.contains("active") ? "-" : "+";
    });
});

</script>

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


