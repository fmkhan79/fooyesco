
                          <?php
                          $variant_sub_options = $this->variation_model->get_sub_options(sanitize($menu_option['id']), $flag_variant_list);
                          $sub_options_for_condition = array_column($variant_sub_options, 'name', 'id');
                          // var_dump($variant_sub_options);
                          foreach ($variant_sub_options as $key => $variant_sub_option) {
                          ?>
                          <!-- This is currently working -->
                            <div class="card subvariants_card" id="sub_variant-<?php echo $variant_sub_option["id"] ?>">
                              <div class="card-header  variant_sub_option_header" href="#body-<?php echo $variant_sub_option["id"] ?>" style="background: #f9f9f9 !important;border: #fdc55e 1px solid;"
                                >
                                <div class="row w-100">

                                  <div class="col flex-grow-0" style="padding: 0px;display: flex;justify-content: center;align-items: center;opacity: 0.7;">
                                    <svg fill="#000000" width="20PX" height="20PX" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                      <g transform="matrix(1,0,0,1,-1088,-320)">
                                        <rect id="Icons" x="0" y="0" width="1280" height="800" style="fill:none;" />
                                        <g id="Icons1" serif:id="Icons">
                                          <g id="Strike">
                                          </g>
                                          <g id="H1">
                                          </g>
                                          <g id="H2">
                                          </g>
                                          <g id="H3">
                                          </g>
                                          <g id="list-ul">
                                          </g>
                                          <g id="hamburger-1">
                                          </g>
                                          <g id="hamburger-2">
                                          </g>
                                          <g id="list-ol">
                                          </g>
                                          <g id="list-task">
                                          </g>
                                          <g id="trash">
                                          </g>
                                          <g id="vertical-menu">
                                          </g>
                                          <g id="horizontal-menu">
                                          </g>
                                          <g id="sidebar-2">
                                          </g>
                                          <g id="Pen">
                                          </g>
                                          <g id="Pen1" serif:id="Pen">
                                          </g>
                                          <g id="clock">
                                          </g>
                                          <g id="external-link">
                                          </g>
                                          <g id="hr">
                                          </g>
                                          <g id="info">
                                          </g>
                                          <g id="warning">
                                          </g>
                                          <g id="plus-circle">
                                          </g>
                                          <g id="minus-circle">
                                          </g>
                                          <g>
                                            <g id="caret-down" transform="matrix(0.522955,0.522955,-0.525161,0.525161,1082.79,109.448)">
                                              <path d="M288,216L256,216L256,212L284,212L284,184L288,184L288,216Z" style="fill-rule:nonzero;" />
                                            </g>
                                            <g id="caret-down1" serif:id="caret-down" transform="matrix(-0.522955,-0.522955,0.525161,-0.525161,1157.21,594.552)">
                                              <path d="M288,216L256,216L256,212L284,212L284,184L288,184L288,216Z" style="fill-rule:nonzero;" />
                                            </g>
                                          </g>
                                          <g id="vue">
                                          </g>
                                          <g id="cog">
                                          </g>
                                          <g id="logo">
                                          </g>
                                          <g id="radio-check">
                                          </g>
                                          <g id="eye-slash">
                                          </g>
                                          <g id="eye">
                                          </g>
                                          <g id="toggle-off">
                                          </g>
                                          <g id="shredder">
                                          </g>
                                          <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]">
                                          </g>
                                          <g id="react">
                                          </g>
                                          <g id="check-selected">
                                          </g>
                                          <g id="turn-off">
                                          </g>
                                          <g id="code-block">
                                          </g>
                                          <g id="user">
                                          </g>
                                          <g id="coffee-bean">
                                          </g>
                                          <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,785.021,-208.975)">
                                            <g id="coffee-beans">
                                              <g id="coffee-bean1" serif:id="coffee-bean">
                                              </g>
                                            </g>
                                          </g>
                                          <g id="coffee-bean-filled">
                                          </g>
                                          <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,913.062,-208.975)">
                                            <g id="coffee-beans-filled">
                                              <g id="coffee-bean2" serif:id="coffee-bean">
                                              </g>
                                            </g>
                                          </g>
                                          <g id="clipboard">
                                          </g>
                                          <g transform="matrix(1,0,0,1,128.011,1.35415)">
                                            <g id="clipboard-paste">
                                            </g>
                                          </g>
                                          <g id="clipboard-copy">
                                          </g>
                                          <g id="Layer1">
                                          </g>
                                        </g>
                                      </g>
                                    </svg>
                                  </div>
                                  <div class="col-7" style="padding-left:10px;">
                                    <input type="text" data-variant-sub-id="<?php echo $variant_sub_option["id"] ?>" data-item-name="name"
                                      class="form-control variant_sub_cat" placeholder="Food sub Category name"
                                      value="<?php echo $variant_sub_option["name"] ?>">
                                  </div>

                                  <div class="col" style="align-items: center;display: flex;justify-content: space-between;gap: 10px;">

                                      <div>
                                    <input type="checkbox" class="variant_sub_cat" data-variant-sub-id="<?php echo $variant_sub_option["id"] ?>" data-item-name="isoptional" <?php if ($variant_sub_option["isoptional"]) {
                                                                                                                                                                                echo "checked";
                                                                                                                                                                              } ?>>&nbsp;&nbsp;&nbsp;<label style="margin:0px;color:black;    font-weight: 100; font-size:13px; ">Optional?</label>
                                      </div>


                                    <button class="btn btn-info btn-sm" data-toggle="collapse" href="#body-<?php echo $variant_sub_option["id"] ?>" role="button" aria-expanded="false" aria-controls="collapseExample">Variant Options</button>

                                    <button class="btn btn-info btn-sm" data-toggle="collapse" href="#conditions-<?php echo $variant_sub_option["id"] ?>" role="button" aria-expanded="false" aria-controls="collapseExample">Conditions</button>

                                    <button class="btn btn-success btn-sm">Save</button>

                                    <button data-menu-id="<?php echo $variant_sub_option["menu_id"] ?>"
                                      data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>" class="btn btn-danger btn-sm delete_sub_variant">Delete
                                    </button>

                                  </div>


                                </div>
                                <div class="row w-100">
                                 
                                  <div class="col font-dark collapse <?php echo (isset($variant_sub_option["condition_variant_id"]) && !empty($variant_sub_option["condition_variant_id"])) ? 'show' : ''; ?>" style="padding-left:10px;color:black;" id="conditions-<?php echo $variant_sub_option["id"] ?>">
                                  <hr class="w-100">
                                    <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <label class="input-group-text" for="inputGroupSelect01"> <label style="margin:0px;color:black;    font-weight: 100; font-size:13px; ">Show When:</label></label>
                                    </div>
                                    <select class="custom-select condition-dropdown" data-variant-id="<?php echo $variant_sub_option["condition_variant_id"] ?>">
                                      <option disabled selected>Choose...</option>
                                      
                                      <?php 

                                      foreach($sub_options_for_condition as $id => $name){
                                        if($name == "" || $name == null) continue;
                                        
                                        echo '<option value="'.$id.'" '. ($id == $variant_sub_option["condition_sub_options_id"] ? "selected" : "") .'>'.$name.'</option>';
                                      }
                                      ?>
                                    </select>
                                    <div class="input-group-prepend">
                                      <label class="input-group-text" for="inputGroupSelect01"> <label style="margin:0px;color:black;    font-weight: 100; font-size:13px; ">Is</label></label>
                                    </div>
                                    <select class="custom-select condition-variant-dropdown" data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>">
                                      <option disabled selected>Choose...</option>
                                    </select>
                                  </div>
                                  </div>

                                </div>

                              </div>

                              <div class="card-body collapse" id="body-<?php echo $variant_sub_option["id"] ?>">
                                <h5 class="card-title"> <span class="text-danger"></span></h5>
                                <!--sub_variants  work starts from hear -->
                                <div class="v_var_div" id="sub_variant-<?php echo $variant_sub_option["id"] ?>">
                                 
                                  <div class="v_items variant_items_<?php echo $variant_sub_option["id"]; ?>">

                                    <!-- items work start from hear -->
                                    <?php
                                    $variant_sub_items = $this->variation_model->get_sub_option_items($variant_sub_option["id"]);
                                    // var_dump($variant_sub_items);
                                    foreach ($variant_sub_items as $key => $variant_sub_item) {
                                    ?>

                                      <div id="item-<?php echo $variant_sub_item["id"]; ?>" class="input-group mb-3">
                                        <div style="display: flex;flex: 1;">
                                          <input type="text" data-item-id="<?php echo $variant_sub_item["id"]; ?>" data-item-name="variant"
                                            class="form-control variant_item" placeholder="Food Item Name"
                                            value="<?php echo $variant_sub_item["variant"]; ?>" style="height:100%;border-radius: 0;border-right-color: transparent;">

                                          <input type="text" data-item-id="<?php echo $variant_sub_item["id"]; ?>" data-item-name="price"
                                            class="form-control variant_item" placeholder="Price"
                                            value="<?php echo $variant_sub_item["price"]; ?>" style="height:100%;border-radius: 0;border-right-color: transparent;">
                                        </div>
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            <label style="font-size:14px;margin:0px;">
                                              Free with deal
                                              <input type="checkbox"
                                                class="variant_item"
                                                data-item-id="<?php echo $variant_sub_item["id"]; ?>"
                                                data-item-name="is_free"
                                                <?php if (!empty($variant_sub_item["is_free"])) echo "checked"; ?>>
                                            </label>
                                          </div>
                                        </div>
                                        <div class="input-group-prepend">
                                          <div class="input-group-text" style="display:flex;gap:5px;">
                                            <button class="btn btn-success btn-sm">Save</button>

                                            <button class="btn btn-danger btn-sm delete-item" data-item-id="<?php echo $variant_sub_item["id"]; ?>">Delete</button>
                                          </div>
                                        </div>
                                      </div>

                                    <?php } ?>


                                    <!-- items work end from hear -->
                                  </div>

                                  <div class="d-flex justify-content-center align-items-center">
                                    <button style="float:right" data-menu-id="<?php echo $variant_sub_option["menu_id"] ?>"
                                      data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>" class="btn btn-success btn-md add_variant">Add
                                      Food Item
                                    </button>
                                  </div>
                                </div>
                              </div>


                            </div>
                            <!--sub_variants  work ends from hear -->
                          <?php } ?>