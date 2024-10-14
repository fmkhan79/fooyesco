<?php 

function getDaysString($offer) {
    $days = [];

    if ($offer['monday']) $days[] = "Monday";
    if ($offer['tuesday']) $days[] = "Tuesday";
    if ($offer['wednesday']) $days[] = "Wednesday";
    if ($offer['thursday']) $days[] = "Thursday";
    if ($offer['friday']) $days[] = "Friday";
    if ($offer['saturday']) $days[] = "Saturday";
    if ($offer['sunday']) $days[] = "Sunday";

    return implode(', ', $days);
}
?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Offers List</div>
            <div class="" style="float:right">
                <button type="button" class="btn btn-primary m-3 float-right" data-toggle="modal"
                    data-target="#offerModal">
                    Create New Offer
                </button>
            </div>
        </div>
    </div>
</div>
<?php if (count($orders)) : ?>
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?php echo get_phrase("list_of_orders", true); ?>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="offers" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase("title"); ?></th>
                            <th><?php echo get_phrase("promo_code"); ?></th>
                            <th><?php echo get_phrase("start_date"); ?></th>
                            <th><?php echo get_phrase("end_date"); ?></th>
                            <th><?php echo get_phrase("days"); ?></th>
                            <th><?php echo get_phrase("amout_limit"); ?></th>
                            <th><?php echo get_phrase("discount_percentage"); ?></th>
                            <th><?php echo get_phrase("action"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $offer) : ?>
                        <tr>
                            <td><?php echo sanitize($offer['title']); ?></td>
                            <td><?php echo sanitize($offer['promo_code']); ?></td>
                            <td><?php echo sanitize($offer['start_date']); ?></td>
                            <td><?php echo sanitize($offer['end_date']); ?></td>
                            <td><?php $daysString = getDaysString($offer); echo $daysString;  ?></td>
                            <td><?php echo sanitize($offer['amount_limit']); ?></td>
                            <td><?php echo sanitize($offer['discount_percentage']); ?></td>
                            <td class="text-center">
                                <a href="javascript:void(0)"
                                    onclick="confirm_modal('<?php echo site_url('offers/delete/' . sanitize($offer['id'])); ?>')"
                                    class="btn btn-rounded btn-outline-primary btn-sm mt-2 edit-offer-btn"
                                    data-offer-id="<?php echo sanitize($offer['id']); ?>">
                                    <?php echo get_phrase('delete'); ?>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?php echo get_phrase("title"); ?></th>
                            <th><?php echo get_phrase("promo_code"); ?></th>
                            <th><?php echo get_phrase("start_date"); ?></th>
                            <th><?php echo get_phrase("end_date"); ?></th>
                            <th><?php echo get_phrase("days"); ?></th>
                            <th><?php echo get_phrase("amout_limit"); ?></th>
                            <th><?php echo get_phrase("discount_percentage"); ?></th>
                            <th><?php echo get_phrase("action"); ?></th>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (!count($orders)) : ?>
<?php isEmpty(); ?>
<?php endif; ?>


<div class="modal fade" id="offerModal" tabindex="-1" role="dialog" aria-labelledby="offerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="offerModalLabel">Set Offer Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo base_url('offers/save_offer'); ?>">

                    <!--Title Field -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <!--Promo Code Field -->
                    <div class="form-group">
                        <label for="promo_code">Promo Code</label>
                        <input type="text" pattern="^\S+$" title="No spaces allowed for offers i.e OFF10"
                            class="form-control" id="promo_code" name="promo_code" required>
                        <span id="promo_code_message"></span> <!-- Container for messages -->
                    </div>
                    <!-- Start Date Field -->
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <!-- End Date Field -->
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <!-- Weekdays Checkbox Group -->
                    <div class="form-group">
                        <label>Active Days</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="active_days[]" value="monday">
                            <label class="form-check-label">Monday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="active_days[]" value="tuesday">
                            <label class="form-check-label">Tuesday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="active_days[]" value="wednesday">
                            <label class="form-check-label">Wednesday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="active_days[]" value="thursday">
                            <label class="form-check-label">Thursday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="active_days[]" value="friday">
                            <label class="form-check-label">Friday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="active_days[]" value="saturday">
                            <label class="form-check-label">Saturday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="active_days[]" value="sunday">
                            <label class="form-check-label">Sunday</label>
                        </div>
                    </div>

                    <!-- Amount Limit Field -->
                    <div class="form-group">
                        <label for="amount_limit">Amount Limit</label>
                        <input type="number" class="form-control" id="amount_limit" name="amount_limit"
                            placeholder="Enter amount limit" required>
                    </div>

                    <!-- Discount Percentage Field -->
                    <div class="form-group">
                        <label for="discount_percentage">Discount Percentage</label>
                        <input type="number" class="form-control" id="discount_percentage" name="discount_percentage"
                            placeholder="Enter discount percentage" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="offers_submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>