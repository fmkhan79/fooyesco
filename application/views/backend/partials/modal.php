<script type="text/javascript">
    function showAjaxModal(url, header) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#scrollable-modal .modal-body').html('<div class="text-center"><img src="<?php echo base_url() . 'assets/backend/img/loader.gif'; ?>" /></div>');
        jQuery('#scrollable-modal .modal-title').html('...');
        // LOADING THE AJAX MODAL
        jQuery('#scrollable-modal').modal('show', {
            backdrop: 'true'
        });

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response) {
                jQuery('#scrollable-modal .modal-body').html(response);
                jQuery('#scrollable-modal .modal-title').html(header);
            }
        });
    }

    function showLargeModal(url, header) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#large-modal .modal-body').html('<div class="text-center mt-200"><img src="<?php echo base_url() . 'assets/global/bg-pattern-light.svg'; ?>" height = "50px" /></div>');
        jQuery('#large-modal .modal-title').html('...');
        // LOADING THE AJAX MODAL
        jQuery('#large-modal').modal('show', {
            backdrop: 'true'
        });

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response) {
                jQuery('#large-modal .modal-body').html(response);
                jQuery('#large-modal .modal-title').html(header);
            }
        });
    }
</script>

<!-- (Large Modal)-->
<div class="modal fade" id="large-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                ...
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Scrollable modal -->
<div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableModalTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ml-2 mr-2">

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal"><?php echo get_phrase("close"); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    function confirm_modal(delete_url) {
        jQuery('#alert-modal').modal('show', {
            backdrop: 'static'
        });
        document.getElementById('update_link').setAttribute('href', delete_url);
    }
</script>

<!-- Info Alert Modal -->
<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-information h1 text-info"></i>
                    <h4 class="mt-2"><?php echo get_phrase("heads_up"); ?>!</h4>
                    <p class="mt-3"><?php echo get_phrase("are_you_sure"); ?>?</p>
                    <button type="button" class="btn btn-info my-2" data-dismiss="modal"><?php echo get_phrase("cancel"); ?></button>
                    <a href="#" id="update_link" class="btn btn-danger my-2"><?php echo get_phrase("continue"); ?></a>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    function showCartModal(url, header) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#cart-modal .modal-body').html('...');
        // LOADING THE AJAX MODAL
        jQuery('#cart-modal').modal('show', {
            backdrop: 'true'
        });

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response) {
                jQuery('#cart-modal .modal-content').html(response);
            }
        });
    }
</script>
<!--CART MODAL WITH AVATAR-->
<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
        <!--Content-->
        <div class="modal-content">

        </div>
    </div>
</div>


<script type="text/javascript">

// add sub catagory 

$(document).on("click",".add_sub_variant",function(){
    var  variation_id =   this.getAttribute("data-variation-id");
    var  menu_id =   this.getAttribute("data-menu-id");
    console.log(variation_id);
    console.log(menu_id);
    
	$.ajax({
			url: '<?php echo site_url('variation/create_sub_vartiation'); ?>',
			type: 'post',
			data: {
				menu_id: menu_id,
                variant_option_id: variation_id,
			},
			success: function(response) {
            //    alert(response);
               newRowAdd =
                '<div id="sub_variant-'+response+'" class="v_var_div"> ' +
                '<div class="form-row v_var_row">'+
                '<div class="col-md-7">'+
                '<input type="text" data-variant-sub-id="'+response+'"  data-item-name="name"  class="form-control variant_sub_cat" placeholder="Fodd sub Category name">'+
                '</div>'+
                '<div class="col-md-3">'+
                '<label>Is Addons'+
                ' <input type="checkbox" class="variant_sub_cat" data-variant-sub-id="'+response+'" data-item-name="isoptional">'+
                '</label>'+
                '<button class="btn btn-info btn-sm delete_sub_variant" data-variation-sub-id="'+response+'" style="float:right" >Delete'+
                '</button>'+
                '</div>'+
                '<div class="col-md-2">'+
                '<button style="float:right" data-menu-id="'+menu_id+'" data-variation-sub-id="'+response+'" class="btn btn-primary btn-sm add_variant">Add Food Item'+ 
                ' </button>'+
                '</div>'+
                '</div>' +
                '<div class="variant_items_'+response+'">'+
                '</div>'+
                '</div>';
                var div = ".variant_"+variation_id;
                console.log(div);
                $(div).append(newRowAdd);
			}
		});
        


    
    // do something  
    // alert("The paragraph was clicked.");
//    alert(this.getAttribute("data-variation-id"));
});




// add 
$(document).on("click",".add_variant",function(){
    var  variation_id =   this.getAttribute("data-variation-sub-id");
    var  menu_id =   this.getAttribute("data-menu-id");
    console.log(variation_id);
    console.log(menu_id);
	$.ajax({
			url: '<?php echo site_url('variation/create_vartiation_item'); ?>',
			type: 'post',
			data: {
				menu_id: menu_id,
                variant_option_id: variation_id,
			},
			success: function(response) {
            //    alert(response);
            console.log("item added",response);

               newRowAdd =
                '<div id="item-'+response+'" > ' +
                '<div class="form-row item-row">'+
    '<div class="col">'+
      '<input type="text" data-item-id="'+response+'"  data-item-name="variant"  class="form-control variant_item" placeholder="Food Item Name">'+
    '</div>'+
    '<div class="col">'+
      '<input type="text" data-item-id="'+response+'" data-item-name="price" class="form-control variant_item" placeholder="Price">'+
    '</div>'+
    '<div class="col">'+
    '<button class="btn btn-info delete-item" data-item-id="'+response+'">Delete</button>'+
    '</div>'+

  '</div>' +
                '</div>';
                var div = ".variant_items_"+variation_id;
                console.log(div);
                $(div).append(newRowAdd);


			}
		});


    
    // do something  
    // alert("The paragraph was clicked.");
//    alert(this.getAttribute("data-variation-id"));
});


$(document).on("change",".variant_item",function(){
    // alert("great its working");
    var variation_item_id =   this.getAttribute("data-item-id");
    var variation_attr_name =   this.getAttribute("data-item-name");
    var variation_attr_value =   $(this).val();
    console.log(variation_attr_value);
    

	$.ajax({
			url: '<?php echo site_url('variation/udpate_vartiation_item'); ?>',
			type: 'post',
			data: {
				variation_item_id: variation_item_id,
                variation_attr_name:variation_attr_name,
                variation_attr_value:variation_attr_value,

			},
			success: function(response) {
				console.log("updated successfully");
			}
		});


});


$(document).on("change",".variant_sub_cat",function(){
    // alert("great its working");
    var variation_item_id =   this.getAttribute("data-variant-sub-id");
    var variation_attr_name =   this.getAttribute("data-item-name");
    var variation_attr_value = 0;
    console.log($(this).is(':checked'));
    if(variation_attr_name == "isoptional"){
        if($(this).is(':checked')){
            variation_attr_value = 1;
        }
    }else{
         variation_attr_value =   $(this).val();
    }
   
    console.log(variation_attr_value);
    

	$.ajax({
			url: '<?php echo site_url('variation/update_sub_vartiation'); ?>',
			type: 'post',
			data: {
				variation_item_id: variation_item_id,
                variation_attr_name:variation_attr_name,
                variation_attr_value:variation_attr_value,

			},
			success: function(response) {
				console.log("updated successfully");
			}
		});


});


$(document).on("click",".delete_sub_variant",function(){
    var data_variation_sub_id =   this.getAttribute("data-variation-sub-id");
    var varint_name = "sub_variant-"+data_variation_sub_id;



    $.ajax({
			url: '<?php echo site_url('variation/delete_sub_vartiation'); ?>',
			type: 'post',
			data: {
				data_variation_sub_id: data_variation_sub_id,
			},
			success: function(response) {
				console.log("Deleted successfully");
                $("#"+varint_name).remove();
			}
		});

    console.log(varint_name);
   
     
    // $(this).remove();

});



$(document).on("click",".delete-item",function(){
    var data_item_id =   this.getAttribute("data-item-id");
    var varint_name = "item-"+data_item_id;



    $.ajax({
			url: '<?php echo site_url('variation/delete_vartiation_item'); ?>',
			type: 'post',
			data: {
				data_item_id: data_item_id,
			},
			success: function(response) {
				console.log("Deleted successfully");
                $("#"+varint_name).remove();
			}
		});

    console.log(varint_name);
   
     
    // $(this).remove();

});

$(document).on("click",".duplicate_variant",function(){
    var data_variation_id =   this.getAttribute("data-variation-id");
    var data_menu_id =   this.getAttribute("data-menu-id");
    // var varint_name = "item-"+data_item_id;

    // console.log("sub vartaion",data_variation_sub_id);

     $.ajax({
	 		url: '<?php echo site_url('variation/duplicate_vartiation_item'); ?>',
	 		type: 'post',
	 		data: {
	 			menu_id: data_menu_id,
                variation_id: data_variation_id,
	 		},
	 		success: function(response) {
                console.log(response);
                $("#variant-list").empty(); 
                $("#variant-list").html(response);
	 			console.log("duplicate successfully");
                 location.reload(true);

                // need to add html again here
	 		}
	 	});

    

});

	</script>

<script>
$(document).ready(function() {
    var submitButton = $("#offers_submit");
    submitButton.prop('disabled', true);
 console.log("promo_code");
    $("#promo_code").on('change', function() {
        var promoCode = $(this).val();
        console.log(promoCode);
        var messageContainer = $("#promo_code_message"); // Add an element to display messages

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('offers/checkUniquePromoCode'); ?>',
            data: { promo_code: promoCode },
            dataType: 'json',
            success: function(response) {
                if (response.isUnique) {
                    showMessage('Promo code is unique!', 'text-success');
                    submitButton.prop('disabled', false);
                } else {
                    showMessage('Promo code already exists. Please choose a different one.', 'text-danger');
                }
            },
            error: function() {
                showMessage('Error checking promo code uniqueness.', 'text-danger');
            }
        });

        // Function to display messages dynamically
        function showMessage(message, className) {
            messageContainer.text(message).removeClass().addClass(className).show();
        }
    });
});
</script>
