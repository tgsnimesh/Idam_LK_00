
<?php

    // get all location (disctrict)
    $all_district = get_all_locations();

    if (isset($_GET['category']) || $where_from == "post-add") {
        if (isset($_GET['category']))
            $cate = $_GET['category'];
    } else if ($where_from == "post") {
        $city = $_GET['city'];
    } else {
        $city = "";
        $cate = "";
    }

?>

<!-- Modal -->
<div class="modal fade category-model" id="add-district" tabindex="-1" aria-labelledby="add-districtLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <div>
                <h6 class="modal-title" id="add-districtLabel">Select Division</h6>
                <p class="mb-0 sub-title">Districts</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="w-50 text-capitalize">
                <?php while ($district = $all_district->fetch_assoc()) {
                if ($where_from == "post-add") { ?>
                <li class="border-bottom p-0 py-2"><a href="../post-add/?<?php echo "category=".$cate;?>&district=<?php echo $district['d_id']; ?>" onclick=""><?php echo $district['d_name']; ?></a></li>
                <?php
                } else if ($where_from == "post") { ?>
                <li class="border-bottom p-0 py-2"><a href="../post/?<?php echo "category=".$_GET['category']."&city=".$_GET['city'];?>&district=<?php echo $district['d_id']; ?>" onclick=""><?php echo $district['d_name']; ?></a></li>
                <?php } else if ($where_from = "update-ad") { ?>
                    <li class="border-bottom p-0 py-2"><a href="../update-ad/?<?php echo filter_url_manager("district", "")."district=".$district['d_id']; ?>" onclick=""><?php echo $district['d_name']; ?></a></li>
                <?php } } ?>
            </ul>
        </div>
        </div>
    </div>
</div>
