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
    let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
<!--============================= FOOTER =============================-->