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
    // var_dump($param2);
    $menu_options = $this->variation_model->get_options(sanitize($menu_data['id']));

    // var_dump($menu_options);
    ?>
    <?php if (is_array($menu_options) && count($menu_options) > 0): ?>
     

      <?php

   
      foreach ($menu_options as $key => $menu_option): ?>
        <div class="form-group">
          <div class="form-row cat-main bg-dark rounded">
            <label class="col-sm-6 col-form-label menu_variation_options" for="menu_variation_options">
              <?php echo get_phrase($menu_option['name']); ?><span class="text-danger"></span>
            </label>
            
            <label class="col-sm-2 col-form-label flex-align" >
            <?php if(get_phrase($menu_option['price']) > 0 ){ echo "£".get_phrase($menu_option['price']); } ?>
            </label>
           
            <div class="col-sm-4 flex-align">
              
         
            <button style="margin:2px;font-size: 18px;" data-menu-id="<?php echo $menu_option['menu_id']; ?>"
                data-variation-id="<?php echo $menu_option['id']; ?>"
                class="btn btn-light duplicate_variant">
                Duplicate
              </button>

            <button style="float:right;font-size: 18px;" data-menu-id="<?php echo $menu_option['menu_id']; ?>"
                data-variation-id="<?php echo $menu_option['id']; ?>"
                class="btn btn-warning add_sub_variant add_variant_item_<?php echo $menu_option['id']; ?>">
                Add Food Sub Category
              </button>
              

            </div>
          </div>
          

          <div class="variant_<?php echo $menu_option['id']; ?>">

            <?php
            $variant_sub_options = $this->variation_model->get_sub_options(sanitize($menu_option['id']));
            // var_dump($variant_sub_options);
            foreach ($variant_sub_options as $key => $variant_sub_option) {
              ?>
              <!--sub_variants  work starts from hear -->
              <div class="v_var_div" id="sub_variant-<?php echo $variant_sub_option["id"] ?>">
                <div class="form-row v_var_row">
                  <div class="col-md-6">
                    <input type="text" data-variant-sub-id="<?php echo $variant_sub_option["id"] ?>" data-item-name="name"
                      class="form-control variant_sub_cat" placeholder="Food sub Category name"
                      value="<?php echo $variant_sub_option["name"] ?>">
                  </div>
                  <div class="col-md-4">
                    <label>Is Addons
                  <input type="checkbox"  class="variant_sub_cat"  data-variant-sub-id="<?php echo $variant_sub_option["id"] ?>" data-item-name="isoptional"  <?php if($variant_sub_option["isoptional"]){ echo "checked";} ?> >
                    </label>
                    <button  data-menu-id="<?php echo $variant_sub_option["menu_id"] ?>"
                      data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>" class="btn btn-info btn-sm delete_sub_variant">Delete
                    </button>

                    <!-- <button style="float:right" data-menu-id="<?php echo $variant_sub_option["menu_id"] ?>"
                      data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>" class="btn btn-light btn-sm duplicate_sub_variant">Duplicate
                    </button> -->

                  </div>
                  <div class="col-md-2">
                    <button style="float:right" data-menu-id="<?php echo $variant_sub_option["menu_id"] ?>"
                      data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>" class="btn btn-primary btn-sm add_variant">Add
                      Food Item
                    </button>
                  </div>
                </div>
                <div class="v_items variant_items_<?php echo $variant_sub_option["id"]; ?>">

                  <!-- items work start from hear -->
                  <?php
                  $variant_sub_items = $this->variation_model->get_sub_option_items($variant_sub_option["id"]);
                  // var_dump($variant_sub_items);
                  foreach ($variant_sub_items as $key => $variant_sub_item) {
                    ?>
                    <div id="item-<?php echo $variant_sub_item["id"]; ?>">
                      <div class="form-row item-row">
                        <div class="col">
                          <input type="text" data-item-id="<?php echo $variant_sub_item["id"]; ?>" data-item-name="variant"
                            class="form-control variant_item" placeholder="Food Item Name"
                            value="<?php echo $variant_sub_item["variant"]; ?>">
                        </div>
                        <div class="col">
                          <input type="text" data-item-id="<?php echo $variant_sub_item["id"]; ?>" data-item-name="price"
                            class="form-control variant_item" placeholder="Price"
                            value="<?php echo $variant_sub_item["price"]; ?>">
                        </div>
                        <div class="col">
                          <button class="btn btn-info delete-item" data-item-id="<?php echo $variant_sub_item["id"]; ?>">Delete</button>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <!-- items work end from hear -->
                </div>
              </div>
              <!--sub_variants  work ends from hear -->
            <?php } ?>
          </div>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-info lighten-info text-center">
        <i class="icon fas fa-exclamation-triangle"></i> <strong>
          <?php echo get_phrase('heads_up'); ?>
        </strong>!
        <?php echo get_phrase('add_variant_option_first_to_add_menu_variants'); ?>.
      </div>
    <?php endif; ?>

  </div>
</div>