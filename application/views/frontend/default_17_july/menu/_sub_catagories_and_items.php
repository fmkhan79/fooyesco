
<?php 

$menu_sub_catagory_items = $this->menu_model->get_sub_options($maincatid);

 


 ?>
<!-- One option seletion starts -->
<div class="" id="main-catagories">

<?php
                  foreach($menu_sub_catagory_items as $menu_sub_catagory_item){
// var_dump($menu_sub_catagory_item);
if($menu_sub_catagory_item["name"]){
                    if($menu_sub_catagory_item["isoptional"] == 0){
                  ?>
<div class="d-flex align-items-center justify-content-between p-4 popup-gray-box">
                    <h3 class="p-0 m-0"> <?php echo $menu_sub_catagory_item["name"];  ?></h3>
                    <div class="op-rq-box"><span>Required</span></div>
                  </div>

                 <?php   $items = $this->menu_model->get_sub_option_items($menu_sub_catagory_item["id"]); 
                //  var_dump($items);  ?>
<!--Items starts fron hear  -->
<?php
                  foreach($items as $item){
                    // var_dump($item);
                    if($item["variant"]){
                  ?>
                  <div
                    class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between gray-border">
                    <div class="label-box">
                      <label>
                        <input name="<?php if($option == "menu-option-2"){ echo $option.$menu_sub_catagory_item["name"]; }else{ echo $menu_sub_catagory_item["name"]; }  ?>"   data-item-price="<?php echo $item["price"];  ?>" data-sub-variant-id="<?php echo $menu_sub_catagory_item["id"] ?>"   data-item-id="<?php echo $item["id"];  ?>" class="menuoptions required-item" type="radio" value="<?php echo  $item["id"]; ?>"  />
                        <?php echo $item["variant"];  ?>
                      </label>
                    </div>
                    <?php if($item["price"]){ ?>
                    <div class="amount-box"><?php echo currency($item["price"]);  ?></div>
                    <?php } ?>
                  </div>
                  <?php } } }else{
                  ?>

<!-- One option seletion starts end -->


<div class="addons" id="med-addons">
                    <div class="d-flex align-items-center justify-content-between p-4 popup-gray-box">
                      <h3 class="p-0 m-0"><?php echo $menu_sub_catagory_item["name"];  ?></h3>
                      <div class="op-rq-box">+£ <input type="text" id="grandtotal" disabled /><span>Optional</span>
                      </div>
                    </div>

                    <?php   $items = $this->menu_model->get_sub_option_items($menu_sub_catagory_item["id"]); 
                //  var_dump($items);  ?>
<!--Items starts fron hear  -->
<?php
                  foreach($items as $item){
                    if($item["variant"]){
                  ?>
                    <div
                      class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between gray-border">
                      <div class="d-flex align-items-center">
                        <input type="checkbox" value="10.00" id="cbx1"class="menuoptions optional-item" data-item-price="<?php echo $item["price"];  ?>" data-sub-variant-id="<?php echo $menu_sub_catagory_item["id"] ?>"   data-item-id="<?php echo $item["id"];  ?>" />
                        <label> <?php echo $item["variant"];  ?></label>
                      </div>
                      <?php if($item["price"]){ ?>
                      <div class="amount-box"><?php echo currency($item["price"]);  ?></div>
                      <?php } ?>
                    </div>
                    
                    <?php }  }
                  ?>
                    
                  </div> 

                  <!--Items end fron hear  -->
                  <?php } } 
                  }
                  ?>


                
</div>







                  <!--  
                  optional work for addons 2

                  <div id="lg-addons" class="addons" style="display: none;">
                    <div class="d-flex align-items-center justify-content-between p-4 popup-gray-box">
                      <h3 class="p-0 m-0">Add ons2</h3>
                      <div class="op-rq-box">+£ <input type="text" id="grandtotal2" disabled><span>Optional</span></div>
                    </div>

                    <div
                      class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between gray-border">
                      <div class="d-flex align-items-center">
                        <input type="checkbox" value="10.00" id="cbx1" />
                        <label>Add 1Açai (80g)</label>
                      </div>
                      <div class="amount-box">£10.00</div>
                    </div>
                    <div
                      class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between gray-border">
                      <div class="d-flex align-items-center">
                        <input type="checkbox" value="10.00" id="cbx2" />
                        <label>Large</label>
                      </div>
                      <div class="amount-box">£10.00</div>
                    </div>
                    <div
                      class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between gray-border">
                      <div class="d-flex align-items-center">
                        <input type="checkbox" value="10.00" id="cbx3" />
                        <label>Add 1Açai (80g)</label>
                      </div>
                      <div class="amount-box">£10.00</div>
                    </div>
                    <div
                      class="d-flex align-items-center p-4 choice-box align-items-center justify-content-between gray-border">
                      <div class="d-flex align-items-center">
                        <input type="checkbox" value="10.00" id="cbx4" />
                        <label>Large</label>
                      </div>
                      <div class="amount-box">£10.00</div>
                    </div>
                  </div>
                
                -->