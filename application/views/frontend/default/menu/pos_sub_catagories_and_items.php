<?php 
$menu_sub_catagory_items = $this->menu_model->get_sub_options($maincatid);
?>

<div class="extras-container">

<?php foreach ($menu_sub_catagory_items as $cat): ?>

    <?php 
        $items = $this->menu_model->get_sub_option_items($cat["id"]);
        if (!$items) continue;
    ?>

    <!-- Section Header -->
    <div class="extras-header">
        <h4 class="extras-title"><?= $cat["name"] ?></h4>

        <?php if ($cat["isoptional"] == 0): ?>
            <small class="extras-required">Required</small>
        <?php else: ?>
            <small class="extras-optional">Optional</small>
        <?php endif; ?>
    </div>

    <!-- Items List -->
    <div class="extras-list">

        <?php foreach ($items as $item): ?>
            <?php if (!$item["variant"]) continue; ?>

            <label>

                <div class="extras-left">
                    <?php if ($cat["isoptional"] == 1): ?>
                        <input 
                            type="checkbox"
                            class="menuoptions optional-item"
                            data-item-price="<?= $item["price"] ?>"
                            data-sub-variant-id="<?= $cat["id"] ?>"
                            data-item-id="<?= $item["id"] ?>"
                        >
                    <?php else: ?>
                        <input 
                            type="radio"
                            class="menuoptions required-item"
                            name="option_<?= $cat["id"] ?>"
                            data-item-price="<?= $item["price"] ?>"
                            data-sub-variant-id="<?= $cat["id"] ?>"
                            data-item-id="<?= $item["id"] ?>"
                        >
                    <?php endif; ?>
                    <span  class="extras-item">
                        <?= $item["variant"] ?>
                        
                <?php if ($item["price"] > 0): ?>
                    <small class="extras-price"><?= currency($item["price"]) ?></small>
                <?php else: ?> 
                        <!-- <small style="visibility:hidden">123</small>  -->
                <?php endif; ?>

                    </span>
                </div>

            </label>

        <?php endforeach; ?>
    </div>

<?php endforeach; ?>

</div>

<style>/* -----------------------------
   FULL FIX FOR INLINE ADDONS
   ----------------------------- */

/* override bootstrap label */

.extras-left span{
    height: 100%;
        justify-content: center;
}
.extras-left{
        height: 100%;
    display: flex;
    align-items: center;
    align-content: center;
    justify-content: center;
}
.extras-left input[type="radio"]:checked + span {
    background: #f54748;
    color:white;
}

.extras-left input[type="checkbox"]:checked  + span {
    background: #f54748;
    color:white;
}

input[type="radio"],input[type="checkbox"]{
    display:none;
}

.extras-header{
        display: flex;
    align-items: center;
    justify-content: space-between;
}
.extras-required{
    color:#f54748;
    font-weight: bold;
}
.extras-list {
    display: flex !important;
    flex-wrap: wrap !important; /* allow items to move to next line */
    gap: 10px; /* spacing between items */
}

.extras-list > * {
    flex:1;
    /* flex: 0 0 auto !important; forces each label to take only as much space as needed */
}

.extras-item {
    display: flex !important; /* horizontal alignment */
    flex:1;
    flex-direction:column;
    align-items: center;
    padding: 20px 10px;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 6px;
    white-space: nowrap !important;
    width: auto !important;
    cursor: pointer;
}

.extras-item input {
    margin-right: 6px;
}

.extras-left {
    /* display: inline-flex !important; */
    gap: 5px;
}

.extras-price {
    margin-left: 5px;
    font-weight: bold;
}



</style>