
<?php

if (true) {
    
    if ($where_from == "post-add" || $where_from == "post") {
        if (isset($_GET['category']))
            $cate = $_GET['category'];
        if (isset($_GET['district']))
            $dis = $_GET['district'];
    }
    if ($where_from == "update-ad")
        $dis_in_city = get_all_location_in_sub_locations($dis);

    // get all location (disctrict)
    if (isset($_GET['district']))
        $dis_in_city = get_all_location_in_sub_locations($dis);


?>    
<!-- Modal -->
<div class="modal fade category-model" id="add-city" tabindex="-1" aria-labelledby="add-cityLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <div>
                <h6 class="modal-title" id="add-cityLabel">Select Local Area</h6>
                <p class="mb-0 sub-title">City</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="w-50 text-capitalize">
                <?php if ($where_from == "update-ad") { while (($city = $dis_in_city->fetch_assoc())) {
                if ($where_from == "update-ad") { ?>
                <li class="border-bottom p-0 py-2"><a href="../update-ad/?<?php echo filter_url_manager("city", "")."city=".$city['c_id']; ?>"><?php echo $city['c_name']; ?></a></li>
                <?php } else { ?>
                <li class="border-bottom p-0 py-2"><a href="../post/?<?php echo "category=".$cate."&"."district=".$dis;?>&city=<?php echo $city['c_id']; ?>"><?php echo $city['c_name']; ?></a></li>
                <?php } } } ?>
                <?php if (isset($_GET['district'])) { while (($city = $dis_in_city->fetch_assoc())) {
                if ($where_from == "post-add") { ?>
                <li class="border-bottom p-0 py-2"><a href="../post/?<?php echo "category=".$cate."&"."district=".$dis; ?>&city=<?php echo $city['c_id']; ?>"><?php echo $city['c_name']; ?></a></li>
                <?php
                } else if ($where_from == "post") { ?>
                <li class="border-bottom p-0 py-2"><a href="../post/?<?php echo "category=".$cate."&"."district=".$dis; ?>&city=<?php echo $city['c_id']; ?>"><?php echo $city['c_name']; ?></a></li>
                <?php } } } ?>
            </ul>
        </div>
        </div>
    </div>
</div>

<?php } else {
    $cate = "";
    $dis = "";
} ?>