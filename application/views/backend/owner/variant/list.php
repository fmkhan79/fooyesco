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

<div class="row">
  <div class="col-md-12">
    <?php
    // var_dump($param2);
    $menu_options = $this->variation_model->get_options(sanitize($menu_data['id']));

    // var_dump($menu_options);
    ?>
    <?php if (is_array($menu_options) && count($menu_options) > 0): ?>
      <?php


      foreach ($menu_options as $key => $menu_option):
      ?>
        <div class="form-group">

          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                <b>Variant: <?php echo get_phrase($menu_option['name']); ?></b>
              </div>
              <div style="flex:1; display:flex; justify-content: flex-end; gap:20px;">
                <button style="font-size: 13px;" class="btn btn-success btn-sm">
                  Save Variants
                </button>

                <a href="javascript:void(0)" style="font-size: 13px;" class="btn btn-light btn-sm" onclick="showAjaxModal('<?php echo site_url('modal/popup/variant_groups/create/' . sanitize($menu_data['id']) . '/' . sanitize($menu_option['id'])); ?>', 'Add Variant Group')">
                  Add Variant Group
                </a>


                <button style="font-size: 13px;" data-menu-id="<?php echo $menu_option['menu_id']; ?>"
                  data-variation-id="<?php echo $menu_option['id']; ?>"
                  class="btn btn-sm btn-light duplicate_variant">
                  Duplicate
                </button>




                <button style="font-size: 13px;" data-menu-id="<?php echo $menu_option['menu_id']; ?>"
                  data-variation-id="<?php echo $menu_option['id']; ?>"
                  class="btn btn-light btn-sm add_sub_variant add_variant_item_<?php echo $menu_option['id']; ?>">
                  Add Food Sub Category
                </button>
              </div>

            </div>

            <!-- LEFT ON MKAING THIS VARIANT CARD INSIDE SUBCATTEOGYR -->
            <div class="variants_list variant_<?php echo $menu_option['id']; ?>">
              <div class="card">
                <div class="card-body p-2">

                  <!-- Groups start -->
                  <?php
                  $groups = $menu_data['groups'];

                  foreach ($groups as $group) {
                    // To not show groups in each variant category Like SMALL, MEDIUM 
                    if ($group['variant_options_id'] != $menu_option['id']) continue;

                  ?>
                    <div class="d-flex justify-content-between p-2 flex-column" style="background-color: #f1f1f1;border: 1px solid #ddd;border-radius: 5px;margin-bottom:10px;">
                      <h6 style="font-size: 1.1rem;"><b>Group:</b> <?php echo $group['group_name']; ?></h6>

                      <div id="group-<?php echo $group['id']; ?>" class="groups-item w-100">
                        <div class="sortable">


                        <?php  
                        $flag_variant_list = sanitize($group['id']); 
                        include APPPATH . "views/backend/owner/variant/variant_list.php"; ?>


                        </div>
                      </div>
                    </div>


                  <?php
                  }
                  ?>
                  <br>

                  <div class="sortable">



                    <?php
                    $variant_sub_options = $this->variation_model->get_sub_options(sanitize($menu_option['id']), 0);
                    // var_dump($variant_sub_options);
                    foreach ($variant_sub_options as $key => $variant_sub_option) {
                    ?>
                      <div class="card subvariants_card" id="sub_variant-<?php echo $variant_sub_option["id"] ?>">
                        <div class="card-header d-flex justify-content-between align-items-center variant_sub_option_header" style="background: #f9f9f9 !important;border: #fdc55e 1px solid;"
                          data-toggle="collapse" href="#body-<?php echo $variant_sub_option["id"] ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
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
                            <div class="col flex-1" style="padding-left:10px;">
                              <input type="text" data-variant-sub-id="<?php echo $variant_sub_option["id"] ?>" data-item-name="name"
                                class="form-control variant_sub_cat" placeholder="Food sub Category name"
                                value="<?php echo $variant_sub_option["name"] ?>">
                            </div>

                            <div class="" style="padding-left:20px;    display: flex;align-items: center;/* justify-content: space-evenly; */gap: 10px;">

                              <input type="checkbox" class="variant_sub_cat" data-variant-sub-id="<?php echo $variant_sub_option["id"] ?>" data-item-name="isoptional" <?php if ($variant_sub_option["isoptional"]) {
                                                                                                                                                                          echo "checked";
                                                                                                                                                                        } ?>><label style="margin:0px;color:black;    font-weight: 100; font-size:13px; ">Optional?
                              </label>


                              <button class="btn btn-success btn-sm">Save</button>

                              <button data-menu-id="<?php echo $variant_sub_option["menu_id"] ?>"
                                data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>" class="btn btn-danger btn-sm delete_sub_variant">Delete
                              </button>

                            </div>


                          </div>

                        </div>

                        <div class="card-body collapse" id="body-<?php echo $variant_sub_option["id"] ?>">
                          <h5 class="card-title"> <span class="text-danger"></span></h5>
                          <!--sub_variants  work starts from hear -->
                          <div class="v_var_div" id="sub_variant-<?php echo $variant_sub_option["id"] ?>">
                            <!-- <div class="form-row v_var_row">
                              <div class="col-md-6">
                                <input type="text" data-variant-sub-id="<?php echo $variant_sub_option["id"] ?>" data-item-name="name"
                                  class="form-control variant_sub_cat" placeholder="Food sub Category name"
                                  value="<?php echo $variant_sub_option["name"] ?>">
                              </div>
                              <div class="col-md-4">
                                <label>Is Addons
                                  <input type="checkbox" class="variant_sub_cat" data-variant-sub-id="<?php echo $variant_sub_option["id"] ?>" data-item-name="isoptional" <?php if ($variant_sub_option["isoptional"]) {
                                                                                                                                                                              echo "checked";
                                                                                                                                                                            } ?>>
                                </label>
                                <button data-menu-id="<?php echo $variant_sub_option["menu_id"] ?>"
                                  data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>" class="btn btn-info btn-sm delete_sub_variant">Delete
                                </button>


                              </div>
                              <div class="col-md-2">
                                <button style="float:right" data-menu-id="<?php echo $variant_sub_option["menu_id"] ?>"
                                  data-variation-sub-id="<?php echo $variant_sub_option["id"] ?>" class="btn btn-primary btn-sm add_variant">Add
                                  Food Item
                                </button>

                              </div>
                            </div> -->
                            <div class="v_items variant_items_<?php echo $variant_sub_option["id"]; ?>">

                              <!-- items work start from hear -->
                               
                              <?php
                              $variant_sub_items = $this->variation_model->get_sub_option_items($variant_sub_option["id"]);
                              // var_dump($variant_sub_items);
                              foreach ($variant_sub_items as $key => $variant_sub_item) {
                              ?>

                                <div id="item-<?php echo $variant_sub_item["id"]; ?>" class="input-group mb-3">
                                  <div style="display: flex;flex: 1; width:50%">
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

                  </div>



                </div>
              </div>

            </div>

            <!-- END of new design -->

            <!-- END OF CARD -->
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

<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
<script>

  // let e = document.querySelector(".variant_items_13843");
  // console.log(e);
  // Sortable.create(e, {
   
  //   animation: 100,
  //   group: "variants_list",
  //   onEnd: function(evt) {
  //     // update_sequence_and_groups();
  //   }
  // });

  let v = document.querySelectorAll(".variants_list").forEach(el => {
    el.querySelectorAll(".sortable").forEach(_el => {
      Sortable.create(_el, {

        animation: 100,
        group: "variants_list",
        onEnd: function(evt) {
          update_sequence_and_groups();
        }
      });
    });
  });

  document.querySelectorAll(".groups-item").forEach(el => {

    let _t = new Sortable(el, {
      animation: 100,
      group: "variants_list",
      onEnd: function(evt) {
        update_sequence_and_groups();
      }
    });
  });

  function update_sequence_and_groups() {
    let result = [];

    $(".variant_sub_option_header").each(function(index) {
      result.push({
        id: $(this).attr("href"),
        sequence: index + 1
      });
    });

    $.ajax({
      url: '<?php echo site_url('variation/update_sub_variants_sequence'); ?>',
      type: 'POST',
      data: {
        result: result
      },
      success: function(response) {
        toastr.warning('Variant order has been updated. Updating Groups - Please wait...');
      }
    });


    let Arr = {};
    setTimeout(() => {

      $(".groups-item").each(function() {
        let group_id = this.id.split("-")[1];
        Arr[group_id] = [];

        $(this).find(".card").each(function() {
          if (this.id) {
            let id = this.id.split("-")[1];

            if (id !== undefined) {
              Arr[group_id].push(id);
            }
          }
        });
      });
      $.ajax({
        url: '<?php echo site_url('variation/update_sub_variants_groups'); ?>',
        type: 'POST',
        data: {
          result: Arr
        },
        success: function(response) {
          toastr.success('Variant Groups have been updated');
        }
      });



    }, 1000);

  }
</script>