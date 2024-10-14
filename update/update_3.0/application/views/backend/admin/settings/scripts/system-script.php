<!-- Select2 -->
<script src="<?php echo base_url('assets/backend/'); ?>plugins/select2/js/select2.full.min.js"></script>

<!-- Tags-Input -->
<script src="<?php echo base_url('assets/backend/'); ?>js/tags-input.js"></script>

<!-- Initializer -->
<script src="<?php echo base_url('assets/backend/'); ?>js/init.js"></script>

<!-- Custom script for init select2 -->
<script type="text/javascript">
    "use strict";

    // initializing select2
    initSelect2();


    // UPDATE THE UPDATER NAME IN FILE UPLOAD
    $('#updater_zip').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#updater_zip')[0].files[0].name;
        $("#label_for_updater_zip").text(file);
    });
</script>