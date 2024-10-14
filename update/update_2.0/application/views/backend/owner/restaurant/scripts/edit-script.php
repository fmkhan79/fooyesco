<!-- Select2 -->
<script src="<?php echo base_url('assets/backend/'); ?>plugins/select2/js/select2.full.min.js"></script>

<!-- Tags-Input -->
<script src="<?php echo base_url('assets/backend/'); ?>js/tags-input.js"></script>

<!-- IMAGE UPLOAD WITH PREVIEW -->
<script src="<?php echo base_url('assets/backend/'); ?>js/file-upload-preview.js"></script>

<!-- TIME PICKER -->
<script src="<?php echo base_url('assets/backend/'); ?>js/bootstrap-clockpicker.min.js"></script>

<!-- Initializer -->
<script src="<?php echo base_url('assets/backend/'); ?>js/init.js"></script>

<!-- Custom script for init select2 -->
<script type="text/javascript">
    "use strict";

    // toggle user view while clicking on radio btn
    function toggleUserArea(elem) {

        if (elem.value === "existing") {
            $("#existing_user_area").show();
            $("#new_user_area").hide();
        } else if (elem.value === "new") {
            $("#new_user_area").show();
            $("#existing_user_area").hide();
        }
    }

    // initializing select2
    initSelect2();

    // initializing clockpicker
    initClockPicker();

    // FOR LOADING THE RESTAURANT THUMBNAIL. I'VE DONE THIS FOR AVOIDING INLINE CSS
    initPreviewer(['restaurant_thumbnail_preview']);

    // FOR LOADING THE RESTAURANT GALLERY IMAGE. I'VE DONE THIS FOR AVOIDING INLINE CSS
    for (let i = 1; i <= 6; i++) {
        initPreviewer(['restaurant_gallery_' + i + '_preview']);
    }
</script>