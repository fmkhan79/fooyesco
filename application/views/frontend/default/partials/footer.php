<!--============================= FOOTER =============================-->
<?php $social_links = json_decode(get_website_settings('social_links'), true); ?>
<footer>

    <div class="container">
        <div class="d-md-flex">
            <div class="col-md-4">
                <h3>FooYes</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor </p>
                <ul class="footer-social-links">
                    <li><a href="<?php echo sanitize($social_links['facebook']); ?>"><span
                                class="ti-facebook"></span></a></li>
                    <li><a href="<?php echo sanitize($social_links['twitter']); ?>"><span
                                class="ti-twitter-alt"></span></a></li>
                    <li><a href="<?php echo sanitize($social_links['instagram']); ?>><span class="
                            ti-instagram"></span></a></li>
                </ul>
            </div>
            <div class="col-md-2 about-box">
                <h4>About Us</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo site_url('site/about_us'); ?>">
                            <?php echo site_phrase('about_us'); ?>
                        </a></li>
                    <li><a href="<?php echo site_url('site/privacy_policy'); ?>">
                            <?php echo site_phrase('privacy_policy'); ?>
                        </a></li>
                    <li><a href="<?php echo site_url('site/terms_and_conditions'); ?>">
                            <?php echo site_phrase('terms_and_conditions'); ?>
                        </a></li>
                </ul>
            </div>
            <div class="col-md-2 company-box">
                <h4>Company</h4>
                <ul class="footer-links">
                    <li><a href="#">Partnership</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>Get in touch</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                <form class="d-flex subscribe-form">
                    <input type="text" placeholder="Email" /> <input type="submit" value="Subscribe" />
                </form>
            </div>
        </div>

        <div class="copyright-box text-center">Copyright &copy;
            <?php echo get_system_settings('footer_text'); ?>
        </div>

    </div>

</footer>
<!--============================= FOOTER =============================-->