<style>
  .v_items {
    padding-top: 5px;
  }

  .v_var_div {
    padding-top: 5px;

  }

  .v_var_row {
    padding: 10px;
    background-color: #FDC55E;
    border-radius: 8px;
    display: flex;
    align-items: center;
  }

  .item-row {
    padding: 10px;
  }

  .menu_variation_options {
    font-size: 30px;
  }

  .flex-align {
    display: flex;
    align-items: center;
  }
</style>

<!-- <div class="row"> -->
  <?php    /*
$menu_variant_options = $this->variation_model->get_variant_options(sanitize($menu_data['id'])); 
   //  var_dump($menu_variant_options); 
    foreach ($menu_variant_options as $key => $menu_variant_option){ 
    ?>
<div class="col-md-12" >
<div class="panel-group" id="accordion">
<div class="panel panel-default">
 <div class="panel-heading">
   <h4 class="panel-title">
     <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo  $menu_variant_option["id"];?>"><?php echo  $menu_variant_option["name"];?></a>
   </h4>
 </div>
 <div id="collapse<?php echo  $menu_variant_option["id"];?>" class="panel-collapse collapse in">
   <div class="panel-body">
   <ul class="list-group list-group-flush">
   <?php 
       //  var_dump($menu_variant_option['id']); 
       $menu_variant_options_items = $this->variation_model->get_variant_options_items($menu_variant_option['id']);
       // var_dump($menu_variant_options_items); 
       foreach ($menu_variant_options_items as $key => $menu_variant_options_item){
       ?>
<li class="list-group-item">  <?php echo  $menu_variant_options_item["variant"];?></li>
       <?php } ?>
       </ul>    
</div>
 </div>
</div>
</div>
</div>

<?php } */?>
<!-- </div> -->
<div class="row">
  <div class="col-md-12 p-4">

<?php
$menu_options = $this->variation_model->get_options($menu_data['id']);
?>

<?php if (!empty($menu_options)): ?>
<?php foreach ($menu_options as $menu_option): ?>

<div class="form-group">

  <!-- MAIN VARIANT -->
  <div class="form-row bg-dark text-white p-2 rounded">
    <div class="col-md-6">
      <?= $menu_option['name']; ?>
    </div>

    <div class="col-md-2">
      <?php if ($menu_option['price'] > 0) echo '£'.$menu_option['price']; ?>
    </div>

    <div class="col-md-4 text-right">
      <button class="btn btn-info btn-sm add_variant">Save Variants</button>

      <!-- SINGLE MAIN FREE ITEM BUTTON -->
      <button
        type="button"
        class="btn btn-success btn-sm add_free_item_main"
        data-menu-id="<?= $menu_option['id']; ?>">
        Add Free Item
      </button>

      <button
        class="btn btn-warning btn-sm add_sub_variant"
        data-variation-id="<?= $menu_option['id']; ?>">
        Add Food Sub Category
      </button>
    </div>
  </div>

  <!-- SUB VARIANTS -->
  <div class="variant_<?= $menu_option['id']; ?> mt-3">

<?php
$sub_variants = $this->variation_model->get_sub_options($menu_option['id']);
foreach ($sub_variants as $sub):
?>

<div class="border p-2 mb-3">

  <div class="form-row align-items-center">

    <div class="col-md-6">
      <input type="text"
        class="form-control variant_sub_cat"
        data-variant-sub-id="<?= $sub['id']; ?>"
        data-item-name="name"
        value="<?= $sub['name']; ?>"
        placeholder="Food Sub Category Name">
    </div>

    <div class="col-md-2">
      <label>
        Is Addons
        <input type="checkbox"
          class="variant_sub_cat"
          data-variant-sub-id="<?= $sub['id']; ?>"
          data-item-name="isoptional"
          <?= $sub['isoptional'] ? 'checked' : ''; ?>>
      </label>
    </div>

    <div class="col-md-4 text-right">
      <!-- NORMAL ITEM BUTTON -->
      <button
        class="btn btn-primary btn-sm add_variant"
        data-variation-sub-id="<?= $sub['id']; ?>">
        Add Food Item
      </button>
    </div>
  </div>

  <!-- NORMAL ITEMS CONTAINER -->
  <div class="variant_items_<?= $sub['id']; ?> mt-2">

<?php
$items = $this->variation_model->get_sub_option_items($sub['id']);
foreach ($items as $item):
if ($item['is_free']) continue;
?>

<div class="form-row mb-2">
  <div class="col">
    <input type="text"
      class="form-control variant_item"
      data-item-id="<?= $item['id']; ?>"
      data-item-name="variant"
      value="<?= $item['variant']; ?>">
  </div>

  <div class="col">
    <input type="text"
      class="form-control variant_item"
      data-item-id="<?= $item['id']; ?>"
      data-item-name="price"
      value="<?= $item['price']; ?>">
  </div>

  <div class="col">
    <button class="btn btn-danger delete-item"
      data-item-id="<?= $item['id']; ?>">Delete</button>
  </div>
</div>

<?php endforeach; ?>

  </div>
</div>

<?php endforeach; ?>
  </div>

  <!-- SINGLE FREE ITEM CONTAINER AT LAST -->
  <div class="free_items_container_<?= $menu_option['id']; ?> mt-3" style="display:none;">
    <h6 class="text-success">Free Items</h6>
  </div>

</div>

<?php endforeach; ?>
<?php endif; ?>

  </div>
</div>

<!-- FREE ITEM TEMPLATE -->
<template id="free-item-template">
  <div class="form-row mb-2 free-item-row">
    <div class="col">
      <input type="text"
        class="form-control variant_item"
        data-item-name="variant"
        placeholder="Free Item Name">
    </div>

    <div class="col">
      <input type="text"
        class="form-control variant_item"
        data-item-name="price"
        value="0"
        readonly>
    </div>

    <div class="col">
      <input type="hidden"
        class="variant_item"
        data-item-name="is_free"
        value="1">

      <button type="button"
        class="btn btn-danger remove-free-item">
        Delete
      </button>
    </div>
  </div>
</template>

<script>
document.addEventListener('click', function (e) {

  // SINGLE MAIN ADD FREE ITEM BUTTON CLICK
  if (e.target.classList.contains('add_free_item_main')) {
    e.preventDefault();

    let menuId = e.target.getAttribute('data-menu-id');
    let container = document.querySelector('.free_items_container_' + menuId);
    let template = document.getElementById('free-item-template');

    if (!container || !template) return;

    container.style.display = 'block';
    container.appendChild(template.content.cloneNode(true));
  }

  // REMOVE FREE ITEM
  if (e.target.classList.contains('remove-free-item')) {
    e.preventDefault();
    let row = e.target.closest('.free-item-row');
    if (row) row.remove();
  }

});
</script>

