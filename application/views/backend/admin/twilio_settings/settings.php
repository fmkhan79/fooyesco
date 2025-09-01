<?php 
$success = $this->session->flashdata('success');
$error   = $this->session->flashdata('error');
?>
<!-- Twilio Settings Update -->
<style>
    code {
        color:rgb(117, 32, 32) !important;
    }
</style>

<section class="content">
    <div class="container-fluid">

        <!-- Twilio Settings Form -->
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                 <!-- Flash Messages -->
               <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show auto-hide">
        <i class="icon fas fa-check-circle"></i>
        <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php $this->session->unset_userdata('success'); ?>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show auto-hide">
        <i class="icon fas fa-exclamation-triangle"></i>
        <?php echo $error; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php $this->session->unset_userdata('error'); ?>
<?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="nav-icon fas fa-cog"></i> 
                            <?php echo get_phrase("twilio_settings", true); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo site_url('twilio-setting/save_twilio_settings'); ?>" method="post">

                            <div class="form-group">
                                <label for="account_sid">Twilio SID</label>
                                <input type="text" class="form-control" id="account_sid" name="twilio_sid"
                                    value="<?php echo isset($settings->twilio_sid) ? $settings->twilio_sid : ''; ?>"
                                    placeholder="Enter Twilio Account SID" required>
                            </div>

                            <div class="form-group">
                                <label for="auth_token">Twilio Token</label>
                                <input type="text" class="form-control" id="auth_token" name="twilio_token"
                                    value="<?php echo isset($settings->twilio_token) ? $settings->twilio_token : ''; ?>"
                                    placeholder="Enter Twilio Auth Token" required>
                            </div>

                            <div class="form-group">
                                <label for="twilio_number">Twilio Number</label>
                                <input type="text" class="form-control" id="twilio_number" name="twilio_phone"
                                    value="<?php echo isset($settings->twilio_phone) ? $settings->twilio_phone : ''; ?>"
                                    placeholder="Enter Twilio Phone Number" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
