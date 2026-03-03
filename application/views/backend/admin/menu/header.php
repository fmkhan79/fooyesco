<div class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mt-1 text-dark"><?php echo ucwords($page_title); ?></h4>
                    </div>
                    <div class="col-6">
                        <?php if ($page_name == 'menu/index') : ?>
                            <a href="<?php echo site_url('menu/create'); ?>" 
                               class="btn btn-outline-primary btn-rounded float-right">
                                <?php echo get_phrase("add_new_menu", true); ?>
                            </a>

                            <a href="#" 
                               class="btn btn-outline-success btn-rounded float-right mr-1"
                               data-toggle="modal" 
                               data-target="#priceIncreaseModal">
                                <i class="fas fa-percentage"></i> Increase / Decrease Prices
                            </a>

                            <button type="button" 
                                    class="btn btn-outline-danger btn-rounded float-right mr-1"
                                    data-toggle="modal"
                                    data-target="#duplicateMenuModal">
                                Duplicate Menu
                            </button>

                        <?php elseif ($page_name == 'menu/create') : ?>
                            <a href="<?php echo site_url('menu'); ?>" 
                               class="btn btn-outline-primary btn-rounded float-right">
                                <?php echo get_phrase("back_to_menu", true); ?>
                            </a>

                        <?php elseif ($page_name == 'menu/edit') : ?>
                            <?php
                            $restaurant_id   = $menu_data['restaurant_id'];
                            $restaurant_slug = slugify($menu_data['restaurant_name']);
                            ?>
                            <a href="<?php echo site_url('menu'); ?>" 
                               class="btn btn-outline-primary btn-rounded float-right">
                                <?php echo get_phrase("back_to_menu", true); ?>
                            </a>

                            <a href="<?php echo site_url("site/restaurant/$restaurant_slug/$restaurant_id"); ?>" 
                               class="btn btn-outline-primary btn-rounded float-right mr-1" 
                               target="_blank">
                                <i class="fas fa-external-link-alt"></i> 
                                <?php echo get_phrase("view_in_frontend", true); ?>
                            </a>
                            <a href="#" 
   class="btn btn-outline-danger btn-rounded float-right mr-1"
   data-toggle="modal"
   data-target="#duplicateSingleMenuModal">
    Duplicate This Menu
</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= PRICE UPDATE MODAL ================= -->
<div class="modal fade" id="priceIncreaseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="<?php echo site_url('menu/update_prices'); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Update Menu Prices</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter percentage (%):</label>
                        <input type="number" step="0.01" 
                               class="form-control" 
                               name="percentage"
                               placeholder="10 for +10% or -5 for -5%" 
                               required>
                        <small class="form-text text-muted">
                            Positive = Increase | Negative = Decrease
                        </small>
                        <?php 
                        $last = $this->session->userdata('last_percentage');
                        $last = $last ? $last : 20;
                        ?>
                        <small class="text-danger">Last applied: <?= $last ?>%</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Apply Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= DUPLICATE MENU MODAL ================= -->
<div class="modal fade" id="duplicateMenuModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="<?= site_url('menu/process_duplicate'); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Duplicate Food Menu</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>From Restaurant</label>
                        <select name="from_restaurant" class="form-control" required>
                            <?php foreach($restaurants as $res): ?>
                                <option value="<?= $res['id']; ?>"><?= $res['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>From Domain</label>
                        <select name="from_domain" class="form-control" required>
                            <option value="0">Main Domain</option>
                            <option value="1">Standalone</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>To Restaurant</label>
                        <select name="to_restaurant" class="form-control" required>
                            <?php foreach($restaurants as $res): ?>
                                <option value="<?= $res['id']; ?>"><?= $res['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>To Domain</label>
                        <select name="to_domain" class="form-control" required>
                            <option value="0">Main Domain</option>
                            <option value="1">Standalone</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="duplicateSubmitBtn">Duplicate All Menus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector('#duplicateMenuModal form');
    const button = document.getElementById('duplicateSubmitBtn');

    button.addEventListener('click', function (e) {
        e.preventDefault(); // stop normal submit
        localStorage.removeItem('duplicateReportShown');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will duplicate all menus to selected target.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, duplicate it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // manually submit form
            }
        });

    });

});
</script>

<?php 
if($page_name == 'menu/index' && $this->session->flashdata('duplicate_report')): 
    $report = $this->session->flashdata('duplicate_report');
?>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // Key for localStorage
    const key = 'duplicateReportShown';

    // Check if already shown
    if(localStorage.getItem(key) === 'yes') return;

    Swal.fire({
        title: 'Menu Duplication Report',
        icon: 'success',
        width: 700,
        html: `
            <div style="text-align:left; font-size:14px;">
                <table class="table table-bordered" style="width:100%;">
                    <tr>
                        <th>Source</th>
                        <td><?= $report['from']; ?></td>
                    </tr>
                    <tr>
                        <th>Target</th>
                        <td><?= $report['to']; ?></td>
                    </tr>
                    <tr>
                        <th>Source Total</th>
                        <td><?= $report['source_total']; ?></td>
                    </tr>
                    <tr>
                        <th>Before Duplication</th>
                        <td><?= $report['before']; ?></td>
                    </tr>
                    <tr style="background:#e9f7ef;">
                        <th>Inserted</th>
                        <td><b><?= $report['inserted_menus']; ?></b></td>
                    </tr>
                    <tr style="background:#fdecea;">
                        <th>Skipped</th>
                        <td><b><?= $report['skipped_menus']; ?></b></td>
                    </tr>
                    <tr style="background:#d4edda;">
                        <th>Final Total Menus</th>
                        <td><b><?= $report['after']; ?></b></td>
                    </tr>
                </table>
            </div>
        `,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if(result.isConfirmed){
            // Mark as shown in localStorage
            localStorage.setItem(key, 'yes');
        }
    });

});
</script>

<?php endif; ?>

<!-- ================= DUPLICATE SINGLE MENU MODAL ================= -->
<div class="modal fade" id="duplicateSingleMenuModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="<?= site_url('menu/process_duplicate_single_menu'); ?>">

                <div class="modal-header">
                    <h5 class="modal-title">Duplicate This Menu</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Hidden Menu ID -->
                    <input type="hidden" name="menu_id" value="<?= $menu_data['id']; ?>">

                    <!-- FROM RESTAURANT -->
                    <!-- <div class="form-group">
                        <label>From Restaurant</label>
                        <select name="from_restaurant" class="form-control" required>
                            <?php foreach($restaurants as $res): ?>
                                <option value="<?= $res['id']; ?>" 
                                    <?= ($res['id'] == $menu_data['restaurant_id']) ? 'selected' : ''; ?>>
                                    <?= $res['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->

                    <!-- FROM DOMAIN -->
                    <!-- <div class="form-group">
                        <label>From Domain</label>
                        <select name="from_domain" class="form-control" required>
                            <option value="0" <?= ($menu_data['menu_for_standalone']==0)?'selected':''; ?>>
                                Main Domain
                            </option>
                            <option value="1" <?= ($menu_data['menu_for_standalone']==1)?'selected':''; ?>>
                                Standalone
                            </option>
                        </select>
                    </div> -->

                    <!-- TO RESTAURANT -->
                    <div class="form-group">
                        <label>To Restaurant</label>
                        <select name="to_restaurant" class="form-control" required>
                            <?php foreach($restaurants as $res): ?>
                                <option value="<?= $res['id']; ?>">
                                    <?= $res['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- TO DOMAIN -->
                    <div class="form-group">
                        <label>To Domain</label>
                        <select name="to_domain" class="form-control" required>
                            <option value="0">Main Domain</option>
                            <option value="1">Standalone</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Duplicate Menu
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php 
if($this->session->flashdata('duplicate_report_single')): 
    $report = $this->session->flashdata('duplicate_report_single');
?>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const key = 'duplicateSingleReportShown';

    // Agar pehle show ho chuka hai to dobara na dikhaye
    if(localStorage.getItem(key) === 'yes') return;

    Swal.fire({
        icon: 'success',
        title: 'Success!',
        html: `<b><?= $report['message']; ?></b>`,
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if(result.isConfirmed){
            localStorage.setItem(key, 'yes');
        }
    });

});
</script>

<?php endif; ?>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const singleForm = document.querySelector('#duplicateSingleMenuModal form');

    if(singleForm){
        singleForm.addEventListener('submit', function(){
            localStorage.removeItem('duplicateSingleReportShown');
        });
    }

});
</script>