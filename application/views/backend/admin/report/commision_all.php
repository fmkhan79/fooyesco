 <div class="card-header">
     <h3 class="card-title"> 
         <?php echo get_phrase("Order Wise", true); ?> 
        <!-- <small>( <?php echo get_delivery_settings('restaurant_revenue') . '% ' . get_phrase('commission_in_each_order') ?>)</small>  -->
     </h3>
 </div> 

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <!-- <small>View the overall sales summary</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!-- <li class="active"><?php echo $page_title; ?></li> -->
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo get_phrase("commission_list_of_restaurant_owners", true); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="commissions" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase("restaurant_name"); ?></th>
                                    <th><?php echo get_phrase("restaurant_owner"); ?></th>
                                    <th><?php echo get_phrase("Restaurant Commision"); ?></th>
                                    <th><?php echo get_phrase("action"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($restaurant_details as $restaurant): 
                                        // print_r(value: $restaurant);
                                    ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo site_url('site/restaurant/'.$restaurant['slug'].'/'.$restaurant['id']); ?>" target="_blank">
                                            <?php echo $restaurant['name']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('owner/profile/'.$restaurant['owner_id']); ?>">
                                            <?php echo $restaurant['owner_name']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo ($restaurant['commission_res']). "%"; ?>
                                    </td>
                                    <!-- <td>
                                        <?php ; ?>
                                    </td> -->
                                    <td class="text-center">
                                        <button class="btn action-dropdown" data-toggle="dropdown" title="Actions">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="<?php echo site_url('report/details/'.$restaurant['id']); ?>">
                                                    <?php echo get_phrase("details"); ?>
                                                </a>
                                            </li>
                                            <!-- <li>
                                                <a class="dropdown-item" href="javascript:void(0)" 
                                                   onclick="showAjaxModal('<?php echo site_url('modal/popup/report/pay/'.$restaurant['id']); ?>', '<?php echo get_phrase('pay_to_restaurant_owner', true) ?>')">
                                                    <?php echo get_phrase("pay"); ?>
                                                </a>
                                            </li> -->
                                        </ul>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
