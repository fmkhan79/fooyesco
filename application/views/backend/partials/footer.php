<footer class="main-footer <?php if ($page_name == 'pos/index') echo 'd-none'; ?>">
    <strong>&copy <a href="<?php echo sanitize(get_system_settings('footer_link')); ?>"><?php echo sanitize(get_system_settings('footer_text')); ?></a></strong>
    <div class="float-right d-none d-sm-inline-block">
        <b><?php echo get_phrase('version'); ?></b> <?php echo sanitize(get_system_settings('version')); ?>
    </div>
</footer>
