
<aside class="main-sidebar sidebar-dark-danger elevation-4 hold-transition layout-fixed">
    <!-- Brand Logo -->
    <a href="<?php echo site_url('dashboard'); ?>" class="brand-link">
        <img src="<?php echo base_url('uploads/system/' . get_website_settings('backend_logo')); ?>" alt="" class="brand-image">
        <span class="brand-text font-weight-light"><?php echo get_system_settings('system_name'); ?></span>
    </a>

  
    <div class="sidebar">
         
        <div class="">
            <!-- <div class="image">
                <img src="<?php echo base_url('uploads/user/' . sanitize($current_user['thumbnail'])); ?>" class="img-circle" alt="User Image">
            </div>
            
            
            <div class="info">
                <a href="<?php echo site_url('settings/profile'); ?>" class="d-block"><?php echo sanitize($current_user['name']); ?></a>
            </div>
          <div class="info">
    <a href="#">
        <?php
            if ($current_user['role_id'] == 1) {
                echo "(Super Admin)";
            }else{
                echo "(Restaurant Owner)";
            }
        ?>
    </a> -->
</div>
<?php 
// Fetch dynamic categories
$restaurant_categories = $this->category_model->get_categories_by_restaurant_id(3);
?>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

              
                <li class="nav-header" style="color:#2f2f2f;"><?php echo get_phrase("navigation_section", true); ?></li>
                <li class="nav-item">
                    <a href="<?php echo site_url('dashboard'); ?>" style="
    display: flex;
    align-items: center;
        gap: 5px;
" class="nav-link <?php if ($page_name == "dashboard/index") echo 'active'; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            <?php echo get_phrase('Dashboard'); ?>
                        </p>
                    </a>
                </li>


                  
            <?php foreach ($restaurant_categories as $restaurant_category): ?>
    <li class="nav-item">
        <a href="<?php echo site_url('pos/category/' . $restaurant_category['id']); ?>" 
           class="nav-link <?php if ($page_name == 'dashboard/index') echo 'active'; ?>" style="
    display: flex;
    align-items: center;
        gap: 5px;
">
            <i class="nav-icon fas fa-hamburger"></i>
            <p><?php echo htmlspecialchars($restaurant_category['name']); ?></p>
        </a>
    </li>
<?php endforeach; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<script>
    // Disable AdminLTE sidebar state saving
    localStorage.removeItem('adminlte_sidebar_state');

    // Force sidebar to stay expanded on load
    document.body.classList.remove('sidebar-collapse');

     document.addEventListener('DOMContentLoaded', function () {
        // Remove sidebar-mini to prevent hover expand
        document.body.classList.remove('sidebar-mini');

        // Optionally ensure the sidebar stays open
        document.body.classList.remove('sidebar-collapse');

        // Also remove saved state in localStorage if AdminLTE remembers collapse state
        localStorage.removeItem('adminlte_sidebar_state');
    });
</script>
