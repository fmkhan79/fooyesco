<?php if ($this->session->flashdata('success')): ?>
        <script>
            alert("<?php echo $this->session->flashdata('success'); ?>");
            <?php $this->session->unset_userdata('success') ?>
        </script>
<?php elseif($this->session->flashdata('error')): ?>
        <script>
            alert("<?php echo $this->session->flashdata('error'); ?>");
            <?php $this->session->unset_userdata('error') ?>
        </script>
<?php endif; ?>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo get_phrase("refund_requests_of_restaurant_owners", true); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="refund_requests" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase("order_code"); ?></th>
                                    <th><?php echo get_phrase("restaurant_owner"); ?></th>
                                    <th><?php echo get_phrase("refund_amount"); ?></th>
                                    <th><?php echo get_phrase("Request At"); ?></th>
                                    <th><?php echo get_phrase("action"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($refund_requests as $request): ?>
                                    <tr>
                                        <td>
                                            <?php echo get_phrase($request->order_code); ?>
                                        </td>
                                        <td>
                                            <?php echo get_phrase($request->restaurant_name); ?>
                                        </td>
                                        <td>
                                            <?php echo get_phrase($request->refund_amount); ?>
                                        </td>
                                        <td>
                                            <?php echo date('M-d-Y', strtotime($request->requestedAt)); ?>
                                        </td>
                                        <td>
                                            <?php if($request->status == 0): ?>
                                                <a class="btn btn-rounded btn-outline-primary btn-sm" href="<?php echo site_url('refundrequest/accept_refund_request/' . $request->order_code); ?>">Accept</a>
                                                <a class="btn btn-rounded btn-outline-danger btn-sm" href="<?php echo site_url('refundrequest/reject_refund_request/' . $request->order_code); ?>">Reject</a>
                                            <?php elseif($request->status == 1): ?>
                                                <button disabled="disabled" class="btn btn-rounded btn-outline-success btn-sm">Accepted at <?= date('M d Y', strtotime($request->acceptedAt)) ?></button>
                                            <?php else: ?>
                                                <button disabled="disabled" class="btn btn-rounded btn-outline-danger btn-sm">Rejected at <?= date('M d Y', strtotime($request->rejectedAt)) ?></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

