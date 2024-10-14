<table class="table">
    <thead>
        <tr>
            <th><?php echo get_phrase("variant"); ?></th>
            <th><?php echo get_phrase("price"); ?></th>
            <th><?php echo get_phrase('actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $menu_variants = $this->variation_model->get_variants(sanitize($menu_data['id'])); ?>
        <?php if (is_array($menu_variants) && count($menu_variants) > 0) : ?>
            <?php foreach ($menu_variants as $key => $menu_variant) : ?>
                <tr>
                    <td>
                        <?php
                        $menu_variant_exploded = explode(',', $menu_variant['variant']);
                        foreach ($menu_variant_exploded as $menu_variant_with_option_id) {
                            $menu_variant_with_option_id_exploded = explode('-', $menu_variant_with_option_id);
                            $menu_variant_option_id = $menu_variant_with_option_id_exploded[0];
                            $menu_variant_option = $this->db->get_where('variant_options', ['id' => $menu_variant_option_id])->row_array();
                            echo '<small><strong>' . sanitize($menu_variant_option['name']) . '</strong> : ' . ucfirst(sanitize($menu_variant_with_option_id_exploded[1])) . '</small><br/> ';
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo currency(sanitize($menu_variant['price'])); ?>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-xs action-dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="showAjaxModal('<?php echo site_url('modal/popup/variant/edit/' . sanitize($menu_data['id']) . '/' . sanitize($menu_variant['id'])); ?>', '<?php echo get_phrase('edit_menu_variant'); ?>')">
                                    <?php echo get_phrase("edit"); ?>
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('variation/variant/delete/' . sanitize($menu_variant['id'])); ?>')"><?php echo get_phrase("delete"); ?></a></li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="3"><?php echo get_phrase('no_data_found'); ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>