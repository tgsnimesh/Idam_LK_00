
<?php

    if (isset($_POST['btn_delete_ad'])) {

        // delete ad
        delete_ad($_POST['advert_id']);
    }

    $user_acc = get_login_user(check_is_login_user())->fetch_assoc();

?>

<div class="dashboard">
    <div class="login-name border-bottom">
        <p class=""><?php echo $user_acc["f_name"] . " " . $user_acc['l_name']; ?></p>
    </div>

    <div class="sud-dis">
        <div class="republis-ad-area">
            <a href=""><i class="fa fa-refresh" aria-hidden="true"></i> Republish ads</a>
        </div>
        <!-- ads list -->
        <div class="ads-list mt-3">
            <?php
                // get user post add
                $user_post_adds = get_user_post_add(check_is_login_user());

                while ($ad = $user_post_adds->fetch_assoc()) {

                    $now = new DateTime(date("Y-m-d H:i:s"));
                    $top_ad_date = new DateTime($ad["top_ad"]);

                    if ($top_ad_date > $now) {
                        load_ad_list_item($ad, $user_acc, "");
                    }
                }

                // get user post add
                $user_post_adds = get_user_post_add(check_is_login_user());
                
                while ($ad = $user_post_adds->fetch_assoc()) {

                    $now = new DateTime(date("Y-m-d H:i:s"));
                    $top_ad_date = new DateTime($ad["top_ad"]);

                    if (!($top_ad_date > $now)) {
                        load_ad_list_item($ad, $user_acc, "");
                    }
                } ?>
        </div>
        <?php if (get_user_post_add(check_is_login_user())->num_rows) { ?>
                <nav aria-label="" class="mt-5 mb-4">
                    <ul class="pagination">
                        <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item" aria-current="page">
                        <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav><!-- Pagination -->
            <?php } ?>
        <!-- center aria (adds) -->
        <div class="my-ads">
            <div class="btn-post-ad-aria">
                <?php if (!$user_post_adds->num_rows) { ?>
                <p class="pt-5">You don't have any ads yet</p>
                <?php } ?>
                <p></p>
                <p class="">Click the "Post an ad now!" button to post your ad.</p>
                <button type="button" name="btn-post-add" class="btn btn-warning mb-5" onclick="window.open('../post-add/', '_self');">Post your ad now !</button>
            </div><!-- dont have add -->
            <div class="my-ad-list">
            </div>
        </div>
    </div>
</div>

<?php 

    function load_ad_list_item($ad, $user_acc, $action) { 
        $now = new DateTime(date("Y-m-d H:i:s"));
        $top_ad_date = new DateTime($ad["top_ad"]);    
?>
        <div class="ad-item <?php echo $top_ad_date > $now ? "ad-item-up" : "border"; ?> w-100" title="<?php echo $ad['title']; ?>">
                    <input type="hidden" value="<?php echo "advert-id=" . $ad['advert_id']; ?>" class="user-ad-item-id">
                    <div class="img">
                        <img src="<?php echo "../uploads/advert/".$ad['advert_id']."-"."1.jpg"; ?>" alt="" class="img-fluid">
                    </div>
                    <div class="dis">
                        <p class="title"><?php echo $ad['title']; ?></p>
                        <div class="sub-dis">
                            <p><?php switch($ad['cate_id']) {
                                case 1 :
                                    echo $ad['land_size'] . " " . $ad['unit'];
                                    break;
                                case 2 :
                                case 3 :
                                    echo "Bedrooms : {$ad['beds']} | Bathrooms : {$ad['baths']}";
                                    break;
                                case 4 :
                                    break;
                                case 5 :
                                    break;
                            } ?></p>
                        </div>
                        <div class="badge">
                            <?php if ($user_acc['is_verified_member']) { ?>
                            <div class="member-badge">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <p>member</p>
                            </div>
                            <?php } if ($user_acc['is_verified_seller']) { ?>
                            <div class="verified-seller-badge">
                                <i class="fa fa-shirtsinbulk" aria-hidden="true"></i>
                                <p>verified seller</p>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="address">
                            <address class="text-capitalize">
                                <?php echo get_location($ad['dis_id'])->fetch_assoc()['d_name']; ?>, <span><?php  echo get_category($ad['cate_id'])->fetch_assoc()['ct_name']; ?></span>
                            </address>
                        </div>
                        <div class="price">
                            <?php
                                $price = number_format($ad['price'], 0, ".", ",");
                                $negotiable = "";
                                
                                if ($ad['is_negotiable']) {
                                    switch($ad['cate_id']) {
                                        case 1 :
                                            $negotiable = "pre " . $ad['unit'];
                                            break;
                                        case 2 :
                                        case 3 :
                                            $negotiable = " /month";
                                            break;
                                        case 4 :
                                            break;
                                        case 5 :
                                            break;
                                        }
                                } else {
                                    switch($ad['cate_id']) {
                                        case 1 :
                                            $negotiable = "total " . " price";
                                            break;
                                        case 2 :
                                        case 3 :
                                            $negotiable = "";
                                            break;
                                        case 4 :
                                            break;
                                        case 5 :
                                            break;
                                    }
                                }
                            ?>
                            <p>Rs. <?php echo $price . " " . $negotiable; ?></p>
                        </div>
                        <div class="bottom-right-badge">
                            <div class="time">
                                <p><?php

                                    $now = new DateTime(date("Y-m-d H:i:s"));
                                    $pump_up_date = new DateTime($ad['bump_up']);
                                    $top_ad_date = new DateTime($ad["top_ad"]);

                                    if (!($pump_up_date > $now) && !($top_ad_date > $now)) {

                                        $now = new DateTime(date("Y-m-d H:i:s"));
                                        $posted = new DateTime($ad['post_date_time']);
                                        $posted_is = $now->diff($posted);

                                        if ($posted_is->format("%y")) {

                                            echo $posted_is->format("%y") . " years";
                                        } else if ($posted_is->format("%m")) {

                                            echo $posted_is->format("%m") . " months";
                                        } else if ($posted_is->format("%d")) {

                                            echo $posted_is->format("%d") . " days";
                                        }else if ($posted_is->format("%h")) {

                                            echo $posted_is->format("%h") . " houres";
                                        } else if ($posted_is->format("%i")) {

                                            echo $posted_is->format("%i") . " minutes";
                                        } else {

                                            echo "Just Now";
                                        }
                                    }
                                ?></p>
                            </div>
                            
                            <?php

                            $now = new DateTime(date("Y-m-d H:i:s"));
                            $top_ad_date = new DateTime($ad["top_ad"]);

                            if ($top_ad_date > $now) { ?>
                            <div class="d-flex">
                                <i class="fa fa-500px" aria-hidden="true" style="font-size: 1.6em; color: #B22727;"></i>
                                <p class="" style="color: #B22727; font-size: 0.5em; font-weight: bold; line-height: 1.1em;">TOP<br>ADS<br> *****</p>
                            </div>
                            <?php } ?>
                            <?php

                                $now = new DateTime(date("Y-m-d H:i:s"));
                                $pump_up_date = new DateTime($ad["bump_up"]);

                                if ($pump_up_date > $now) { ?>
                            <div class="d-flex">
                                <p class="" style="font-size: 0.5em; font-weight: bold; color: #F49D1A;">BUMP<br>UP</p>
                                <i class="fa fa-level-up" aria-hidden="true" style="font-size: 1.8em; color: #F49D1A;"></i>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php

                        $now = new DateTime(date("Y-m-d H:i:s"));
                        $featured_date = new DateTime($ad["featured_date"]);

                        if ($featured_date > $now) { ?>
                    <div class="featured-badge">
                        <p>Featured</p>
                    </div>
                    <?php } ?>
                    <?php

                        $now = new DateTime(date("Y-m-d H:i:s"));
                        $urgent_date = new DateTime($ad["urgent"]);

                        if ($urgent_date > $now) { ?>
                    <div class="urgent-badge">
                        <p>Urgent</p>
                    </div>
                    <?php } ?>
        </div><!-- Ad item -->
        <?php if ($action != "delete") { ?>
        <div class="ps-2 mt-1 mb-2 text-end">
            <a href="../update-ad/?<?php echo "ad=".$ad["advert_id"]; ?>" class="update me-3"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
            <a href="" data-bs-toggle="modal" data-bs-target="#deleteAdvert<?php echo $ad['advert_id']; ?>"><i class="fa fa-trash-o fa-lg text-danger" aria-hidden="true"></i></i></a>
        </div>
        <!-- Advert Delete Modal -->
        <div class="modal fade" id="deleteAdvert<?php echo $ad['advert_id']; ?>" tabindex="-1" aria-labelledby="deleteAdvertLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <?php //echo "ad=".$ad["advert_id"]; ?>
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAdvertLabel<?php echo $ad['advert_id']; ?>">Delete Ad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Do you want to delete this ad ?</h5>
                    <div class="ads-list mt-3">
                    <?php load_ad_list_item($ad, $user_acc, "delete"); ?>
                    </div>
                    <div class="mt-3">
                        <input type="checkbox" id="confirm-delet-ad<?php echo $ad['advert_id']; ?>" class="confirm-delet-ad">
                        <label for="confirm-delet-ad<?php echo $ad['advert_id']; ?>">Confirm and Delete this ad.</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Not Now</button>
                    <form action="" method="POST">
                        <input type="hidden" name="advert_id" value="<?php echo $ad['advert_id']; ?>">
                        <button type="submit" name="btn_delete_ad" class="btn btn-danger btn-delete-ad" disabled>Delete</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <!-- Advert Delete Modal end-->
        <?php } ?>
<?php } ?>
