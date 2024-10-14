<table class="table">
    <thead>
        <tr>
            <th><?php echo get_phrase("addons"); ?></th>
            <th><?php echo get_phrase("price"); ?></th>
            <th><?php echo get_phrase('actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $menu_addons = $this->addon_model->get_addons(sanitize($menu_data['id'])); ?>
        <?php if (is_array($menu_addons) && count($menu_addons) > 0) : ?>
            <?php foreach ($menu_addons as $key => $menu_addon) : ?>
                <tr>
                    <td><?php echo sanitize($menu_addon['name']); ?></td>
                    <td>
                        <?php echo currency(sanitize($menu_addon['price'])); ?>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-xs action-dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="showAjaxModal('<?php echo site_url('modal/popup/addons/edit/' . sanitize($menu_data['id']) . '/' . sanitize($menu_addon['id'])); ?>', '<?php echo get_phrase('edit_addon_menu'); ?>')">
                                    <?php echo get_phrase("edit"); ?>
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('addon/addons/delete/' . sanitize($menu_addon['id'])); ?>')"><?php echo get_phrase("delete"); ?></a></li>
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