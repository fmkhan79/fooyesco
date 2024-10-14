<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12" >
            <form method="POST" action="<?php echo site_url('offers/banner'); ?>">
            <!-- Heading Field -->
            <div class="form-group">
                <label for="heading">Heading</label>
                <input type="text" class="form-control" id="heading" name="heading" placeholder="Enter heading" value="<?php echo $heading; ?>">
            </div>

            <!-- Description Field -->
            <div class="form-group">
                <label for="description">Offer Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"><?php echo $description; ?></textarea>
            </div>

            <!-- CTA Link Field -->
            <div class="form-group">
                <label for="ctaLink">CTA (Restaurant Link)</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="ctaLink" name="ctaLink" placeholder="Enter CTA link" value="<?php echo $ctaLink; ?>">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>