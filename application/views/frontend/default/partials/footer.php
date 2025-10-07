<!--============================= FOOTER =============================-->
<?php 

$isFooyes = false;
$host = get_subdomain();

if($host === 'fooyes' || $host === 'staging')
    $isFooyes=true;
?>

<?php $social_links = json_decode(get_website_settings('social_links'), true); ?>
<footer>

    <div class="container"style="max-width: 1045px!important">
        <div class="d-md-flex">
            <div class="col-md-4">
                <?php
                    $host = get_subdomain();
                    if($host != 'fooyes' && $host != 'staging'){
                ?>
                <h5 style="font-weight: 800; color: #343a40; font-size:16px;">Powered By</h5>
                <?php }?>
                <!-- <h3>FooYes</h3> -->
                 <?php if($isFooyes): ?>
                       <img width="80px"  src="<?php echo base_url('uploads/system/VJMkY4SgTdEnL35HtR9GUPD.png'); ?>"
                                class="system-icon mb-3">
                                <?php else: ?>
                                    <img width="80px" src="<?php echo base_url('uploads/system/VJMkY4SgTdEnL35HtR9GUPD.png'); ?>"
                                class="system-icon mb-3">
                                <?php endif; ?>


                <p>Bringing you the best flavors with fresh ingredients and passion. </p>
                <ul class="footer-social-links">
                    <li><a href="<?php echo sanitize($social_links['facebook']); ?>"><span
                                class="ti-facebook"></span></a></li>
                    <li><a href="<?php echo sanitize($social_links['twitter']); ?>"><span
                                class="ti-twitter-alt"></span></a></li>
                    <li><a href="<?php echo sanitize($social_links['instagram']); ?>"><span class="ti-instagram"></span></a></li>
                </ul>
            </div>
            <div class="col-md-2 about-box">
                <h4>About Us</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo site_url('contact-us'); ?>">
                            <?php echo site_phrase('contact_us'); ?>
                        </a></li>
                    <?php
                        $host = get_subdomain();
                        if($host == 'fooyes' || $host == 'staging'){
                    ?>
                    <li><a href="<?php echo site_url('about-us'); ?>">
                            <?php echo site_phrase('about_us'); ?>
                        </a></li>
                    <?php }?>
                      <?php if($isFooyes): ?>
                    <li><a href="<?php echo site_url('privacy-policy'); ?>">
                            <?php echo site_phrase('privacy_policy'); ?>
                        </a></li>
                    <li><a href="<?php echo site_url('terms-and-conditions'); ?>">
                            <?php echo site_phrase('terms_and_conditions'); ?>
                        </a></li>
                          <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-2 company-box">
                <h4>Company</h4>
                <ul class="footer-links">
                 <?php
                    $host = get_subdomain();
                    if($host == 'fooyes' || $host == 'staging'){
                ?>
                <li><a href="<?php echo site_url('become-a-partner'); ?>">
                            <?php echo site_phrase('become_a_partner'); ?>
                        </a></li>
                <?php }?>
                <li><a href="<?php echo site_url('terms-of-use'); ?>">
                            <?php echo site_phrase('terms_of_use'); ?>
                        </a></li>
                        <?php if($isFooyes): ?>
                <li><a href="<?php echo site_url('solutions'); ?>">
                            <?php echo site_phrase('solutions'); ?>
                        </a></li>
                        <?php endif; ?>
                            <?php if(!$isFooyes): ?>
                <li><a href="<?php echo site_url('privacy-policy'); ?>">
                            <?php echo site_phrase('privacy_policy'); ?>
                        </a></li>
                    <li><a href="<?php echo site_url('terms-and-conditions'); ?>">
                            <?php echo site_phrase('terms_and_conditions'); ?>
                        </a></li>
                        <?php endif; ?> 


                </ul>
            </div>
            <div class="col-md-4">
                <h4>Get in touch</h4>
                <p>Stay updated with our latest recipes, offers, and news.</p>
                <form class="d-flex subscribe-form">
                    <input type="text" placeholder="Email" /> <input type="submit" value="Subscribe" />
                </form>
            </div>
        </div>

        <center>
        <button 
  type="button" 
  class="btn btn-danger mt-4 btn-floating btn-lg" 
  id="btn-back-to-top">
  <i class="fas fa-arrow-up"></i>
</button>
</center>

        <div class="copyright-box text-center">Copyright &copy;
            <?php echo get_system_settings('footer_text'); ?>
        </div>


    </div>

</footer>


<script>
    let mybutton2 = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    mybutton2.style.display = "block";
  } else {
    mybutton2.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton2.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

</script>

<!--============================= FOOTER =============================-->