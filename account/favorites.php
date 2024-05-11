
<?php require_once("../library/favorite-handler.php"); ?>
<?php require_once("../library/img-handler.php"); ?>
<?php require_once("../library/favorite-handler.php"); ?>

<?php

    $favorite_list = select_favorite(check_is_login_user());

    if (isset($_POST['remove_favorite'])) {

        remove_favorite(check_is_login_user(), $_POST['remove_favorite']);
        $favorite_list = select_favorite(check_is_login_user());
    } 
    
?>

<div class="favorites pb-5">
    <div class="login-name border-bottom">
        <p class="">Favorites</p>
    </div>
    <?php if (!$favorite_list->num_rows) { ?>
    <div class="dafault-favorite-ads">
        <i class="fa fa-star" aria-hidden="true"></i>
        <p>You haven't marked any ads as favorite yet.<br><br>
        Click on the star symbol on any ad to save it as a favorite.<br><br>
        Start to <a href="../">browse ads</a> to find ads you would like to favorite.</p>
    </div>
    <?php } else {

        while ($favorite_ad = $favorite_list->fetch_assoc()) {
        
            $ad = get_adds(1, 0, " AND advert_id = {$favorite_ad['advert_id']} ", " advert_id ASC ")->fetch_assoc();
            $ad_user = get_login_user($ad['u_id'])->fetch_assoc();
            $is_top_ad = date($ad['top_ad']) > date("Y-m-d H:i:s");

            $ad_image_list = get_image_list($ad['advert_id'])->fetch_assoc();
            $ad_location = get_location($ad['dis_id'])->fetch_assoc();
            $ad_category = get_category($ad['cate_id'])->fetch_assoc();

    ?>
    <div class="ads-list mt-3">
        <div class="mb-1 ad-item user-ad-item <?php echo $is_top_ad ? "ad-item-up" : ""; ?>" title="<?php echo $ad['title'] . "\n" . $ad_location['d_name'] . ", " . $ad_category['ct_name']; ?>">
                            <input type="hidden" value="<?php echo "advert-id=" . $ad['advert_id']; ?>" class="user-ad-item-id">
                            <div class="img pb-3">
                                <img src="<?php echo "../uploads/advert/{$ad_image_list['img_1']}"; ?>" alt="<?php echo $ad['title']; ?>" class="img-fluid">
                            </div>
                            <div class="dis">
                                <p href="" class="title"><?php echo $ad['title']; ?></p>
                                <div class="sub-dis">
                                    <p><?php
                                        switch ($ad['cate_id']) {
                                            case 1 :
                                                echo $ad['land_size'] . " " . $ad['unit'];
                                                break;
                                            case 2 :
                                            case 3 :
                                                echo "Beds : {$ad['beds']} | Baths : {$ad['baths']}";
                                                break;
                                        }
                                    ?></p>
                                </div>
                                <div class="badge">
                                    <?php if ($ad_user['is_verified_member']) { ?>
                                    <div class="member-badge">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <p>member</p>
                                    </div>
                                    <?php } if ($ad_user['is_verified_seller']) { ?>
                                    <div class="verified-seller-badge">
                                        <i class="fa fa-shirtsinbulk" aria-hidden="true"></i>
                                        <p>verified seller</p>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="address">
                                    <address class="text-capitalize" style="color: #7F8487;">
                                        <?php echo $ad_location['d_name'] ?>, <span><?php echo $ad_category['ct_name']; ?></span>
                                    </address>
                                </div>
                                <div class="price">
                                    <?php

                                    $price = number_format($ad['price'], 0, ".", ",");
                                    $negotiable = "";
                                    
                                    switch ($ad['cate_id']) {
                                        case 1 :
                                            $negotiable = $ad['is_negotiable'] ? "pre {$ad['unit']}" : "total";
                                            break;
                                        case 2 :
                                        case 3 :
                                            $negotiable = $ad['is_negotiable'] ? "/month" : "";
                                            break;
                                    }

                                    ?>
                                    <p>Rs. <?php echo $price . " " . $negotiable ?></p>
                                </div>
                                <div class="bottom-right-badge">
                                    <div class="time">
                                        <?php
                                        $now = new DateTime(date("Y-m-d H:i:s"));

                                        $posed_date = new DateTime($ad['post_date_time']);
                                        $top_ad_date = new DateTime($ad["top_ad"]);
                                        $bump_ad_date = new DateTime($ad["bump_up"]);
                                        $featured_date = new DateTime($ad['featured_date']);
                                        $urgent_date = new DateTime($ad['urgent']);

                                        $is_top_ad = $top_ad_date > $now;
                                        $is_bump_up_ad = $bump_ad_date < $posed_date;

                                        $intervel = $posed_date->diff($now);
                                        $posted_is = "";

                                        if (!($is_bump_up_ad || $is_top_ad)) {
                                            if ($y = $intervel->format("%y"))
                                                $posted_is = $y . " years";
                                            else if ($m = $intervel->format("%m"))
                                                $posted_is = $m . " months";
                                            else if ($d = $intervel->format("%d"))
                                                $posted_is = $d . " days";
                                            else if ($m = $intervel->format("%h"))
                                                $posted_is = $m . " hours";
                                            else if ($i = $intervel->format("%i"))
                                                $posted_is = $i . " minutes";
                                            else 
                                                $posted_is = "Just Now";
                                        }

                                        ?>
                                        <p><?php echo $posted_is; ?></p>
                                    </div>
                                    <?php

                                    if ($top_ad_date > $now) { ?>
                                    <div class="d-flex">
                                        <i class="fa fa-500px" aria-hidden="true" style="font-size: 1.6em; color: #B22727;"></i>
                                        <p class="" style="color: #B22727; font-size: 0.5em; font-weight: bold; line-height: 1.1em;">TOP<br>ADS<br> *****</p>
                                    </div>
                                    <?php } else if ($bump_ad_date < $posed_date) { ?>
                                    <div class="d-flex">
                                        <p class="" style="font-size: 0.5em; font-weight: bold; color: #F49D1A;">BUMP<br>UP</p>
                                        <i class="fa fa-level-up" aria-hidden="true" style="font-size: 1.8em; color: #F49D1A;"></i>
                                    </div> 
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if ($featured_date > $now) { ?>
                            <div class="featured-badge">
                                <p>Featured</p>
                            </div>
                            <?php } if ($urgent_date > $now) { ?>
                            <div class="urgent-badge">
                                <p>Urgent</p>
                            </div>
                            <?php } ?>
                        </div><!-- Ad item -->
        </div>
        <div class="remove-favorite text-end">
            <form action="" method="POST">
                <input type="hidden" name="remove_favorite" value="<?php echo $ad['advert_id']; ?>">
                <button type="submit" onclick="return confirm('Do yo want to remove this favorite?');" name="btn_remove_favorite" style="border: none; background-color: transparent; color: #B22727; text-shadow: 1px 1px 2px gray;"><i class="fa fa-minus-square me-1" aria-hidden="true"></i>Remove</button>
            </form>
        </div>
    <?php } } ?>
</div>
