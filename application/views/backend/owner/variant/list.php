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

<div id="condition_errors">

</div>






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
              <div class="">
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
                     
                    $flag_variant_list = 0;  // to show ungrouped items in variant list
                    include APPPATH . "views/backend/owner/variant/variant_list.php"; ?>


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

  document.addEventListener('DOMContentLoaded', function () {
    
    show_condition_miss_errors();

    update_variant_id_dropdowns_for_selected_conditions();


  });

  function saveNewSubCategory() {
    update_sequence_and_groups().then(() => {
      window.location.reload();
    });
  }

  //todo

  function update_variant_id_dropdowns_for_selected_conditions(){
    document.querySelectorAll(".condition-variant-dropdown").forEach(el => {
      
      const subcategoryID = el.previousElementSibling.previousElementSibling.value;
      if(!subcategoryID ) return;
      
      const selectedValue = el.previousElementSibling.previousElementSibling.dataset.variantId;
      const effectedVariationSubID = el.dataset.variationSubId;

      $.ajax({
        url: '<?php echo site_url('variation/fetch_variants'); ?>',
        type: 'POST',
        data: {
          value: subcategoryID,
        },
        success: function(response) {

            let json = JSON.parse(response);
            
            el.innerHTML = '<option selected disabled>Choose...</option>';
            json.forEach(variant => {
              const option = document.createElement('option');
              option.value = variant.id;
              option.textContent = variant.variant;
              if(variant.id == selectedValue){
                option.selected = true;
              }
              el.appendChild(option);
            });
            $(el).attr("disabled", false);
        }
      });
    });
  }

  function show_condition_miss_errors(){
    $.ajax({
        url: '<?php echo site_url('menu/check_for_condition_miss_errors'); ?>',
        type: 'POST',
        data: {
          result: "<?php echo sanitize($menu_data['id']); ?>"
        },
        success: function(response) {
          toastr.success('Variant Groups have been updated');
        }
      });

  }
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

    return new Promise((resolve, reject) => {

      let result = [];

      var sequence = 0;
      var HasCondition = false; 

  let prevConditionGroupId = null;

    $(".variant_sub_option_header").each(function(index) {
        let subConditionValue = $(this).find(".condition-dropdown").val();
        console.log(subConditionValue);

        if (!HasCondition && subConditionValue != null) {
            // Previous item has no condition but this item has condition
            sequence++;
            HasCondition = true;
        } else if (HasCondition && subConditionValue == null) {
            // Previous item has condition but this item has no condition
            sequence++;
            HasCondition = false;
        } else if (HasCondition && subConditionValue != null) {
            // Both previous and current item have condition — check if group changed
            if (subConditionValue !== prevConditionGroupId ) {
                sequence++;
            }
            HasCondition = true;
        } else if (!HasCondition && subConditionValue == null) {
            // Both previous and current item have no condition
            sequence++;
            HasCondition = false;
        }

        prevConditionGroupId = subConditionValue; // Track for next iteration

        result.push({
            id: $(this).attr("href"),
            sequence: sequence
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
            resolve(response);
          },
          error: reject
        });



      }, 1000);

  });

  }

  document.addEventListener('change', function (e) {
    if (e.target.classList.contains('condition-dropdown')) {

      const nextSelect = e.target.nextElementSibling.nextElementSibling;
      $(nextSelect).attr("disabled", true);
      nextSelect.innerHTML = '<option selected>Loading...</option>';

      const selectedValue = e.target.value;
      

      $.ajax({
        url: '<?php echo site_url('variation/fetch_variants'); ?>',
        type: 'POST',
        data: {
          value: selectedValue,
        },
        success: function(response) {

            let json = JSON.parse(response);
            
            nextSelect.innerHTML = '<option selected>Choose...</option>';
            json.forEach(variant => {
              const option = document.createElement('option');
              option.value = variant.id;
              option.textContent = variant.variant;
              nextSelect.appendChild(option);
            });
            $(nextSelect).attr("disabled", false);
        }
      });


     
    }

    if(e.target.classList.contains('condition-variant-dropdown')){

      const subcategoryID = e.target.previousElementSibling.previousElementSibling.value;
      const selectedValue = e.target.value;
      const effectedVariationSubID = e.target.dataset.variationSubId;

      if($(".condition-dropdown")[0] == $(e.target.previousElementSibling.previousElementSibling)[0]){
        toastr.error("Error: Can't add condition to first Sub Category");
        return false;
      }

      update_sequence_and_groups().then(() => {
        debugger;
        $.ajax({
          url: '<?php echo site_url('variation/update_sub_variant_condition'); ?>',
          type: 'POST',
          data: {
            variant_id: selectedValue,
            variation_sub_id: subcategoryID,
            effected_variation_sub_id: effectedVariationSubID,
          },
          success: function(response) {
            response = JSON.parse(response);
            if(response.status == "error"){
              toastr.error(response.message);
            } else {  
            toastr.success('Variant condition has been updated');
          
            }
          }
        });
      })
      
      


    }
  });

</script>