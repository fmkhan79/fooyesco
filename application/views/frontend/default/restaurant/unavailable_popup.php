


<?php 


$current_domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
$isFooyes = (strpos($current_domain, 'fooyes') !== false);
$domain =  $isFooyes ? 'fooyes' : 'standalone';

// ONLY SHOW IF UNAVIALBLE
if($restaurant_details['unavailable_on_' . $domain] == 1){

?>
<style>

.custom-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  backdrop-filter: blur(5px);
  
}

.custom-modal-content {
  background: #fff;
  padding: 30px;
  border-radius: 10px;
  width: 400px;
  max-width: 90%;
  text-align: center;
}

.custom-modal-content h3 {
  margin-bottom: 10px;
}

.custom-modal-content p {
  margin-bottom: 20px;
}

.order.col-md-2.d-none.d-md-block,.order.col-md-2.d-md-none {
    opacity: 0.2 !important;
    pointer-events: none !important;
}

</style>

<input type="hidden" id="unavailable_on_<?php echo $domain; ?>" value="<?php echo sanitize($restaurant_details['unavailable_on_' . $domain]); ?>">

<div class="custom-modal" id="unavailableModal">
  <div class="custom-modal-content">
    <h3>Restaurant Unavailable</h3>
    <p><?= $restaurant_details["unavailable_{$domain}_text"] ?></p>
    <a style="background-color: rgb(255, 77, 77);
    border-radius: 38px;border:0px; padding: 10px 30px;color:white" class="btn btn-primary" onclick="deleteModal()">View Menu</a>
  </div>
</div>
<script>
  function deleteModal() {
    const modal = document.getElementById('unavailableModal');

    if (modal) {
      modal.remove(); // removes from DOM
    }

    // restore scroll (if you locked it before)
    document.body.classList.remove('modal-open-custom');
    document.body.style.position = '';
    document.body.style.top = '';
  }
</script>
<?php } ?>