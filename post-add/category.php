
<?php

    // get all location (disctrict)
    $all_category_type = get_all_category();

    if ($where_from == "post") {
        $city = $_GET['city'];
        $dis = $_GET['district'];
    }

?>

<!-- Modal -->
<div class="modal fade category-model" id="add-category" tabindex="-1" aria-labelledby="add-categoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="add-categoryLabel">Select a category</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="w-50 text-capitalize">
                <?php while ($category_type = $all_category_type->fetch_assoc()) {
                if ($where_from == "post-add") {?>
                <li class="border-bottom"><a href="../post-add/?category=<?php echo $category_type['ct_id']; ?>" onclick=""><?php echo $category_type['ct_name']; ?></a></li>
                <?php
                } else if ($where_from == "post") { ?>
                <li class="border-bottom p-0 py-2"><a href="../post/?<?php echo "city=".$city."&"."district=".$dis;?>&category=<?php echo $category_type['ct_id']; ?>"><?php echo $category_type['ct_name']; ?></a></li>
                <?php } else { ?>
                <li class="border-bottom p-0 py-2"><a href="../update-ad/?<?php echo filter_url_manager("category", "")."category=".$category_type['ct_id'] ?>"><?php echo $category_type['ct_name']; ?></a></li>
                <?php } } ?>
            </ul>
        </div>
        </div>
    </div>
</div>
