<?php 
$menu_sub_catagory_items = $this->menu_model->get_sub_options($maincatid, $sequence, $subOptionsId, $variantId);
?>

<!-- CSS for FREE badge -->
<style>
.free-badge {
    background: #28a745;
    color: #fff;
    font-size: 12px;
    padding: 2px 8px;
    border-radius: 12px;
    margin-left: 8px;
    font-weight: 600;
}
.addon-warning {
    background: #ffeaea;
    color: #d63031;
    padding: 10px 15px;
    border-radius: 6px;
    margin: 10px 0;
    font-size: 14px;
    text-align: center;
    border: 1px solid #ffb3b3;
}

</style>

<div id="main-catagories">

<?php 


// 
$referenced_sub_categories = [];

foreach($menu_sub_catagory_items as $menu_sub_catagory_item){ 
  if($menu_sub_catagory_item["condition_sub_options_id"] != null){
    $referenced_sub_categories[] = $menu_sub_catagory_item["condition_sub_options_id"];
  }
}



$break = false;
foreach($menu_sub_catagory_items as $menu_sub_catagory_item){ 
  
  if(in_array($menu_sub_catagory_item["id"], $referenced_sub_categories)){
      $break = true;
  }
  if($menu_sub_catagory_item["name"]){

    // Get all items of this sub-category
    $items = $this->menu_model->get_sub_option_items($menu_sub_catagory_item["id"]);

    $isFreeOption = false;
    $firstFreeItemId = null;

    foreach ($items as $it) {
        if ($it["is_free"] == 1) {
            $isFreeOption = true;
            if ($firstFreeItemId === null) {
                $firstFreeItemId = $it["id"];
            }
        }
    }

    /* ================= REQUIRED OPTIONS ================= */
    if($menu_sub_catagory_item["isoptional"] == 0){
?>

<!-- REQUIRED HEADING -->
<div class="d-flex align-items-center justify-content-between p-4 popup-gray-box">
  <div class="d-block">
      <h3 class="p-0 m-0 d-flex justify-content-between align-items-center">
          <span><?php echo $menu_sub_catagory_item["name"]; ?></span>
          <!-- <?php if($isFreeOption){ ?>
              <span class="free-badge">FsREE</span>
          <?php } ?> -->
      </h3>
      <div class="error-msg"></div>
  </div>

  <?php if(!$isFreeOption){ ?>
    <div class="op-rq-box">
        <span>Required</span>
    </div>
  <?php } ?>
</div>

<!-- REQUIRED ITEMS -->
<?php 
foreach($items as $item){ 
  if($item["variant"]){
?>
<div class="d-flex align-items-center p-4 choice-box justify-content-between gray-border">
  
  <div class="label-box">
    <label>

      <?php if(!$isFreeOption){ ?>
        <!-- NORMAL REQUIRED RADIO -->
        <input
          type="radio"
          required
          name="<?php echo $menu_sub_catagory_item["name"]; ?>"
          value="<?php echo $item["id"]; ?>"
          data-item-price="<?php echo $item["price"]; ?>"
          data-sub-variant-id="<?php echo $menu_sub_catagory_item["id"]; ?>"
          data-item-id="<?php echo $item["id"]; ?>"
          class="menuoptions required-item"
          <?php if($break){ ?>
          onclick="loadNextSequence(<?php echo $menu_sub_catagory_item['id']; ?>, <?php echo $item['id']; ?>, <?php echo $menu_sub_catagory_item['sequence'] ?? 'null'; ?> , '<?php echo $menu_sub_catagory_item['variant_option_id']; ?>')"
          <?php  }?>
        />
        
      <?php

       } else { ?>
        <!-- FREE → hidden + auto selected -->
        <input
          type="checkbox"
          checked
          hidden
          name="<?php echo $menu_sub_catagory_item["name"]; ?>"
          value="<?php echo $item["id"]; ?>"
          data-item-price="0"
          data-sub-variant-id="<?php echo $menu_sub_catagory_item["id"]; ?>"
          data-item-id="<?php echo $item["id"]; ?>"
          class="menuoptions required-item"
        />
      <?php } ?>

      <?php echo $item["variant"]; ?>

      <?php if($item["is_free"] == 1){ ?>
        <span class="free-badge">FREE</span>
      <?php } ?>

    </label>
  </div>

  <?php if($item["price"] && $item["is_free"] != 1){ ?>
    <div class="amount-box"><?php echo currency($item["price"]); ?></div>
  <?php } ?>

</div>
<?php } } ?>

<?php } else { ?>

<!-- ================= OPTIONAL OPTIONS ================= -->
       <?php
$name = $menu_sub_catagory_item["name"];
$max_limit = 0;

if (preg_match('/Maximum\s*(\d+)/i', $name, $matches)) {
    $max_limit = $matches[1];
}
// echo $max_limit;
?>
<div class="addon-warning" style="display:none;">
    ⚠ Only <span class="max-number"></span> addons can be selected
</div>
<div class="addons" id="med-addons"  data-max="<?php echo $max_limit; ?>">

  <div class="d-flex align-items-center justify-content-between p-4 popup-gray-box">
    <h3 class="p-0 m-0"><?php echo $menu_sub_catagory_item["name"]; ?></h3>
    <div class="op-rq-box">


      <span><?php echo ($isFreeOption) ? "Free" : "Optional"; ?></span>
    </div>
  </div>

<?php foreach($items as $item){
  // echo "das";
  if($item["variant"]){
?>
<div class="d-flex align-items-center p-4 choice-box justify-content-between gray-border">
  <div class="d-flex align-items-center">
    <input 
      type="checkbox"
      class="menuoptions optional-item"
      data-item-price="<?php echo $item["price"]; ?>"
      data-sub-variant-id="<?php echo $menu_sub_catagory_item["id"]; ?>"
      data-item-id="<?php echo $item["id"]; ?>" />
    <label>
      <?php echo $item["variant"]; ?>
      <?php if($item["is_free"] == 1){ ?>
        <span class="free-badge">FREE</span>
      <?php } ?>
    </label>
  </div>

  <?php if($item["price"] && $item["is_free"] != 1){ ?>
    <div class="amount-box"><?php echo currency($item["price"]); ?></div>
  <?php } ?>
</div>
<?php } } ?>

</div>

<?php } } 

if($break){
    break;
}

} ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener("change", function(e) {

    if (e.target.classList.contains("optional-item")) {

        var parent = e.target.closest(".addons");
        var maxAllowed = parseInt(parent.getAttribute("data-max"));
        var checkedItems = parent.querySelectorAll(".optional-item:checked").length;
        // alert(checkedItems);

        if (checkedItems > maxAllowed && maxAllowed != 0) {
            e.target.checked = false;
            
            Swal.fire({
                toast: true,                 // 👈 toast style (small box)
                position: 'top',             // 👈 upar show hoga
                icon: 'warning',
                title: 'Only ' + maxAllowed + ' free toppings allowed',
                showConfirmButton: false,
                timer: 2000,                 // 👈 2 sec auto close
                timerProgressBar: true,
                background: '#fff5f5',
                iconColor: '#d63031'
            });
        }
    }

});
</script>
