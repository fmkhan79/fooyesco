<!--============================= FOOTER =============================-->
<?php $social_links = json_decode(get_website_settings('social_links'), true); ?>
<footer class="main-block dark-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="copyright">
                    <p><a href="<?php echo get_system_settings('footer_link'); ?>" target="_blank">&copy<?php echo get_system_settings('footer_text'); ?></a></p>
                    <ul>
                        <li><a href="<?php echo sanitize($social_links['facebook']); ?>"><span class="ti-facebook"></span></a></li>
                        <li><a href="<?php echo sanitize($social_links['twitter']); ?>"><span class="ti-twitter-alt"></span></a></li>
                        <li><a href="<?php echo sanitize($social_links['instagram']); ?>"><span class="ti-instagram"></span></a></li>
                    </ul>
                    <ul class="footer-page-links">
                        <li><a href="<?php echo site_url('site/about_us'); ?>"><?php echo site_phrase('about_us'); ?></a></li>
                        <li><a href="<?php echo site_url('site/privacy_policy'); ?>"><?php echo site_phrase('privacy_policy'); ?></a></li>
                        <li><a href="<?php echo site_url('site/terms_and_conditions'); ?>"><?php echo site_phrase('terms_and_conditions'); ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="select mt-3">
                <select name="slct" id="slct" onchange="switch_language(this.value)" class="language-selector">
                    <option disabled><?php echo site_phrase('choose_language'); ?></option>
                    <?php $languages = $this->language_model->get_all();
                    foreach ($languages as $key => $language) : ?>
                        <option value="<?php echo sanitize($language['code']); ?>" <?php if ($this->session->userdata('language') == sanitize($language['code'])) echo "selected"; ?>><?php echo sanitize($language['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</footer>
<!--============================= FOOTER =============================-->
