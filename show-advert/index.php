
<?php session_start(); ?>

<?php $where_from = "show-advert"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../library/ad-handler.php"); ?>
<?php require_once("../library/img-handler.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>
<?php require_once("../library/location-handler.php"); ?>
<?php require_once("../library/category-handler.php"); ?>
<?php require_once("../library/verified-seller-handler.php"); ?>
<?php require_once("../library/favorite-handler.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Show Ad</title>

    <!-- link head php file -->
    <?php require_once("../library/head.php"); ?>

    <!-- link css -->
    <link rel="stylesheet" href="../style/content.css">
    <link rel="stylesheet" href="../style/show-advert.css">
    <link rel="stylesheet" href="../style/footer.css">
    <!-- link css end-->
</head>
<body>
    <header>
        <!-- link navigation bar -->
        <?php require_once("../library/nav.php"); ?>
        <!-- navigation bar end-->
        <!-- link login model -->
        <?php require_once("../login/index.php"); ?>
        <!-- login model end-->
    </header>

    <?php if (!isset($_GET['advert-id'])) {
        page_not_founded_error("Invalid Statement !");
        die("");
    } else {

        if ($_GET['advert-id'] != 0) {

            $user_select_advert = get_adds(1, 0, " AND advert_id={$_GET['advert-id']} ", "advert_id ASC");

            if ($user_select_advert->num_rows)
                $user_select_advert = $user_select_advert->fetch_assoc();
            else {
                
                page_not_founded_error("Ad Not Founded !");
                die("");
            }
        } else {
            
            page_not_founded_error("Ad Not Founded !");
            die(""); 
        } 
    }

    if (check_is_login_user())
        $is_favorite = is_favorite(check_is_login_user(), $user_select_advert['advert_id'])->num_rows;
    else 
        $is_favorite = 0;

    if (isset($_POST['add_or_remove_favorite'])) {
        
        if (!$is_favorite) {

            // add favorite
            add_favorite(check_is_login_user(), $user_select_advert['advert_id']);
            $is_favorite = 1;
        } else {

            // remove favorite
            remove_favorite(check_is_login_user(), $user_select_advert['advert_id']);
            $is_favorite = 0;
        }
        unset($_POST);
        unset($_REQUEST);
    }
    
    $advert_owner_detais = get_login_user($user_select_advert['u_id'])->fetch_assoc();
    $advert_owner_verifed_detais = null;
    

    if ($advert_owner_detais['is_verified_seller']) {
        $advert_owner_verifed_detais = get_verified_seller($user_select_advert['u_id'])->fetch_assoc();
    }

    $advert_iamges_name = get_image_list($user_select_advert['advert_id'])->fetch_assoc();

    $posted_date_time = date("Y M d h:i a", strtotime($user_select_advert['post_date_time']));
    $location = get_location($user_select_advert['dis_id'])->fetch_assoc();
    $sub_location = get_sub_location($user_select_advert['city_id'])->fetch_assoc();

    $ad_category = get_category($user_select_advert['cate_id'])->fetch_assoc();

    ?>
    <main>
        <!-- pagination -->
        <div class="pagination container mt-3">
            <nav class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 text-capitalize">
                    <li class="breadcrumb-item"><a href="../">Home</a></li>
                    <li class="breadcrumb-item"><a href="../">All Ads</a></li>
                    <li class="breadcrumb-item"><a href="../home/?category=<?php echo $ad_category['ct_id']; ?>"><?php echo $ad_category['ct_name']; ?></a></li>
                    <li class="breadcrumb-item"><a href="../home/?category=<?php echo $ad_category['ct_id']; ?>&location=<?php echo $location['d_id']; ?>"><?php echo $ad_category['ct_name'] . " in " . $location['d_name']; ?></a></li>
                    <li class="breadcrumb-item"><a href="../home/?category=<?php echo $ad_category['ct_id']; ?>&location=<?php echo $location['d_id']; ?>"><?php echo $ad_category['ct_name'] . " in " . $sub_location['c_name']; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $ad_category['ct_name'] . " in " . $sub_location['c_name']; ?></li>
                </ol>
            </nav>
        </div>
        <!-- pagination end-->
        <!-- content -->
        <div class="container aria-1 mt-3 mb-2 py-2 px-3 rounded"> 
            <!-- arai-01 -->
            <div class="aria-01 row border-bottom pb-3">
                <div class="col-12 advert-header">
                    <div class="title-aria">
                        <p class="advert-title"><?php echo $user_select_advert['title']; ?></p>
                        <address>Posted on <?php echo $posted_date_time; ?>, <span class="text-capitalize"><?php echo $sub_location['c_name']; ?></span> , <span class="text-capitalize"><?php echo $location['d_name']; ?></span></address>
                    </div>
                    <div class="share-aria">
                        <div class="share-potion">
                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                            <a href="">share</a>
                        </div>
                        <div class="share-potion <?php echo $is_favorite == 1 ? "favorite" : ""; ?>">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <?php if (check_is_login_user()) { ?>
                            <a href="" id="favorite" data-bs-toggle="modal" data-bs-target="#conformAddFavoriteAd"><?php echo $is_favorite == 1 ? "" : "add "; ?>favorite</a>
                            <?php } else { ?>
                            <a href="" id="favorite" aria-current="page" data-bs-toggle="modal" data-bs-target="#login-model">add favorite</a>
                            <?php } ?>
                        </div>
                    </div>
                </div><!-- top advert title -->
                <div class="col-8">
                    <div class="carousel-container">
                        <div id="advert-image-carousel" class="carousel slide carousel advert-image-carousel" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $count = 0;
                                for ($i = 0; $i < 5; $i++) {

                                    if ($advert_iamges_name[("img_".($i+1))]) {
                                ?>
                                <div class="carousel-item <?php echo $count == 0 ? "active" : ""; ?>">
                                    <img src="../uploads/advert/<?php echo $user_select_advert['advert_id']."-".($i+1); ?>.jpg" class="d-block w-100" alt="..." id="main-advert-caro-img" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#advert-iamge-resize-model">
                                    <div class="img-resize-button shadow">
                                        <i class="fa fa-arrows-alt" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#advert-iamge-resize-model"></i>
                                    </div>
                                </div>
                                <?php $count++; } } ?>
                            </div>
                        </div>
                        <?php if ($count != 1) { ?>
                        <div class="caro-indicator row mt-2">
                            <?php
                            $count = 0;
                            for ($i = 0; $i < 5; $i++) { 
                                
                                if ($advert_iamges_name[("img_".($i+1))]) {
                            ?>
                            <img src="../uploads/advert/<?php echo $user_select_advert['advert_id']."-".($i+1); ?>.jpg" class="col-2 <?php echo $count == 0 ? "active" : ""; ?>" data-bs-target="#advert-image-carousel" data-bs-slide-to="<?php echo $count; ?>" aria-label="Slide <?php echo $count; ?>"></img>
                            <?php $count++; } } ?>
                        </div>
                        <?php } ?>
                    </div><!-- advert image carousel -->
                    <div class="advert-information row">
                        <div class="price col-12">
                            <?php if ($user_select_advert['cate_id'] == 1) { ?>
                            <p>Rs. <?php echo number_format($user_select_advert['price'], 0) . ($user_select_advert['is_negotiable'] ?  " pre " . $user_select_advert['unit'] : " total"); ?> <span class="ms-1"><?php echo $user_select_advert['is_negotiable'] ?  "Negotiable" : ""; ?></span></p>
                            <?php } else {?>
                            <p>Rs. <?php echo number_format($user_select_advert['price'], 0) . " /month"; ?> <span class="ms-1"><?php echo $user_select_advert['is_negotiable'] ?  "Negotiable" : ""; ?></span></p>
                            <?php } ?>
                        </div><!-- price -->
                        <div class="sub-details col-12 row">
                            <?php
                            $category = $user_select_advert['cate_id'];

                            $address = $user_select_advert['advert_address'];
                            $beds = $user_select_advert['beds'];
                            $baths = $user_select_advert['baths'];
                            $land_size = $user_select_advert['land_size'];
                            $size = $user_select_advert['size'];
                            $land_type = ($user_select_advert['is_agricultural'] ? "Agricultural, " : "") .
                                         ($user_select_advert['is_residential'] ? "Residential, " : "") . 
                                         ($user_select_advert['is_commercial'] ? "Commercial, " : "") .
                                         ($user_select_advert['is_other'] ? "Other" : "");
                            
                            

                            if ($land_type != "") { ?>
                            <div class="col-6">
                                <p>land type: <span><?php echo $land_type; ?></span></p>
                            </div>
                            <?php } if ($beds) { ?>
                            <div class="col-6">
                                <p>bedrooms: <span><?php echo $beds; ?></span></p>
                            </div>
                            <?php } if ($baths) { ?>
                            <div class="col-6">
                                <p>bathrooms: <span><?php echo $baths; ?></span></p>
                            </div>
                            <?php } if ($land_size) { ?>
                            <div class="col-6">
                                <p>land size: <span><?php echo number_format($land_size, 1, ".", "") . " " . $user_select_advert['unit']; ?></span></p>
                            </div>
                            <?php } if ($size) { ?>
                            <div class="col-6">
                                <p><?php echo ($category == 2) ? "House " : ""; ?>size: <span><?php echo number_format($size, 1, ".", "") . " sqft"; ?></span></p>
                            </div>
                            <?php } ?>
                        </div><!-- sub details -->
                        <div class="col-12 advert-description">
                            <p>Description</p>
                            <pre style="overflow: hidden; padding-bottom: 0.5rem;" class="description-height" id="advert-description"><?php echo $user_select_advert["discription"] ?></pre>
                            <div class="toggle-button">
                                <button type="button" id="btn-toggle-advert-description">Show more</button>
                                <i class="fa fa-angle-down" aria-hidden="true" id="btn-toggle-advert-description-icon"></i>
                            </div>
                        </div><!-- description -->
                    </div><!-- advert information -->
                </div><!-- advert details -->
                <div class="col-4 p-0 pe-2 advert-contact-details" title="<?php echo $advert_owner_verifed_detais ? $advert_owner_verifed_detais['shop_name'] . "\n" . "Member since ".date("Y M d - h : i A", strtotime($advert_owner_verifed_detais['last_online'])) : ""; ?>">
                    <div class="conact-box border rounded">
                        <?php if ($advert_owner_verifed_detais) { ?>
                        <div class="company-detals m-2">
                            <div class="comany-img">
                                <img src="<?php echo $advert_owner_verifed_detais['logo'] ?  "../uploads/seller-shop-logo/" . $advert_owner_verifed_detais['logo'] : "../img/system-default-logo/company-logo.jpg"; ?>" alt="" class="img-fluid">
                            </div>
                            <div class="detals">
                                <p class="name"><?php echo $advert_owner_verifed_detais['shop_name']; ?></p>
                                <div class="badge">
                                    <div class="member-badge">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <p>member</p>
                                    </div>
                                    <div class="verified-seller-badge">
                                        <i class="fa fa-shirtsinbulk" aria-hidden="true"></i>
                                        <p>verified seller</p>
                                    </div>
                                </div>
                                <p class="last-since"><?php echo "Member since ".date("Y M d - h:i a", strtotime($advert_owner_verifed_detais['last_online'])); ?></p>
                                <a href="../seller-shop/?id=<?php echo $advert_owner_verifed_detais['u_id']; ?>" class="member-shop">Visit member's shop</a>
                            </div>
                        </div><!-- company contact details -->
                        <?php } else { ?>
                        <div class="nun-member-name m-2 my-3">
                            <p>For sale By <span><?php echo $advert_owner_detais['f_name'] . " " . $advert_owner_detais['l_name']; ?></span></p>
                        </div><!-- nun member details -->
                        <?php } ?>
                        <hr class="m-0">
                        <div class="contact-number m-2" id="advert-phone-number">
                            <i class="fa fa-phone-square" aria-hidden="true"></i>    
                            <div class="number">
                                <?php if ($user_select_advert['is_mobile_hide']) { ?>
                                <p class="number" id="number"><?php echo substr($user_select_advert['mobile_number'], 0, 3); ?>XXXXXX</p>
                                <p class="notify" id="expand-number-notyfy">Click to show phone number</p>
                                <?php } else { ?>
                                <p class="number" id="number">Call Seller</p>
                                <?php } ?>
                                <div id="expand-number-aria" class="<?php echo $user_select_advert['is_mobile_hide'] ? "d-none" : ""; ?>">
                                    <a href="tel: 077111111" class="btn btn-sm btn-success"><?php echo $user_select_advert['mobile_number'] ?></a>
                                    <?php if ($advert_owner_verifed_detais) { ?>
                                    <a href="tel: 077111111" class="btn btn-sm btn-success d-block mt-2"><?php echo $advert_owner_verifed_detais['phonenumber'] ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div><!-- phone number -->
                        <hr class="m-0">
                        <div class="email m-2">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <p>Email <a href="mailto: "><?php echo $advert_owner_detais['email']; ?></a></p>
                        </div><!-- email -->
                        <hr class="m-0">
                        <div class="chat m-2">
                            <i class="fa fa-comments-o" aria-hidden="true"></i>
                            <p>Chat</p>
                        </div><!-- chat -->
                    </div>
                    <!-- <div class="border-bottom m-0 p-0"></div> -->
                </div><!-- advert contact details -->
            </div>
            <!-- arai-01 end-->
            <!-- aria-02 -->
            <div class="bottom-advert-option my-3">
                <?php if (check_is_login_user()) { ?>
                <button type="button" class="btn btn-warning" id="btn-prmote-ad" onclick="window.open('../promote-ad/?id=<?php echo $user_select_advert['advert_id']; ?>', '_self');"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i>Promote this ad</button>
                <?php } else { ?>
                    <button type="button" class="btn btn-warning" id="btn-prmote-ad" aria-current="page" data-bs-toggle="modal" data-bs-target="#login-model"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i>Promote this ad</button>
                <?php } ?>
                <button type="button" class="btn btn-light ms-4" id="btn-report-ad"><i class="fa fa-ban" aria-hidden="true"></i>Report this ad</button>
            </div>
            <!-- aria-02 end-->
        </div>
        <!-- content end-->
        <!-- sujession ads -->
        <div class="container sujession-ads-aria aria-1 mb-3 py-2 px-3 rounded">

            <?php
            date_default_timezone_set('Asia/Colombo');
            
            // create sujession advert query;
            $adverts;

            if ($advert_owner_verifed_detais) {
                $is_verified_seller_filter = " AND u_id = {$advert_owner_detais['u_id']} ";
            } else {
                $is_verified_seller_filter = "";
            }

            $adverts = get_adds(16, 0, " {$is_verified_seller_filter} AND cate_id = {$ad_category['ct_id']} AND dis_id = {$location['d_id']} AND city_id = {$sub_location['c_id']} ", " post_date_time DESC ");
            if ($adverts->num_rows < 4) {

                $adverts = get_adds(16, 0, " {$is_verified_seller_filter} AND cate_id = {$ad_category['ct_id']} AND dis_id = {$location['d_id']} ", " post_date_time DESC ");
                if ($adverts->num_rows < 4) {

                    $adverts = get_adds(16, 0, " {$is_verified_seller_filter} AND cate_id = {$ad_category['ct_id']} ", " post_date_time DESC ");
                }
            }
            if ($advert_owner_verifed_detais && $adverts->num_rows) {
                $adverts = get_adds(16, 0, " {$is_verified_seller_filter} ", " post_date_time DESC ");
            }
            ?>
            <div class="border-bottom pt-2 pb-2">
                <?php if($advert_owner_verifed_detais) { ?>
                <div class="title">
                    <a href="../seller-shop/?id=<?php echo $advert_owner_verifed_detais['u_id']; ?>">
                        <img src="<?php echo $advert_owner_verifed_detais['logo'] ?  "../uploads/seller-shop-logo/" . $advert_owner_verifed_detais['logo'] : "../img/system-default-logo/company-logo.jpg"; ?>" alt="" class="img-fluid shadow">
                    </a>
                    <p>More ads from</p>
                    <a href="../seller-shop/?id=<?php echo $advert_owner_verifed_detais['u_id']; ?>"><?php echo $advert_owner_verifed_detais['shop_name']; ?></a>
                </div>
                <?php } else { ?>
                <div class="Similar-ads">
                    <p>Similar ads</p>
                </div>
                <?php } ?>
            </div>
            <div class="advert-sujession">
                <button class="suj-caro-prev" type="button" data-bs-target="#advert-sujession-caro" data-bs-slide="prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                <div id="advert-sujession-caro" class="carousel carousel-dark slide mt-3 w-100" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $count = 1;
                        $caro_item_counter = 0;

                        while ($count <= $adverts->num_rows) { ?>

                        <div class="carousel-item <?php echo $count == 1 ? "active" : ""; ?>">
                            <div class="row">
                                <?php 
                                
                                for ($i = 0; $i < 4; $i++) {

                                    $ad = $adverts->fetch_assoc();
                                    if (!$ad) break;

                                    $user_acc = get_login_user($ad['u_id'])->fetch_assoc();

                                    $top_ad_date = new DateTime($ad["top_ad"]); 
                                    $now = new DateTime(date("Y-m-d H:i:s"));
                                    ?>
                                    <div class="ads-list col-6 mb-3">
                                        <div class="ad-item <?php echo $top_ad_date > $now ? "ad-item-up" : ""; ?>" style="<?php echo $top_ad_date > $now ? "" : "border: none;"; ?> min-height: 160px;">
                                            <input type="hidden" value="<?php echo "advert-id=" . $ad['advert_id']; ?>" class="user-ad-item-id">
                                            <div class="img">
                                                <img src="<?php echo "../uploads/advert/".$ad['advert_id']."-"."1.jpg"; ?>" alt="" class="img-fluid pe-2" style="min-width: 140px; height: 100px;">
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

                                                            $pump_up_date = new DateTime($ad['bump_up']);

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
                                    </div>
                                    <?php
                                    $count++;
                                }
                                $caro_item_counter++;
                                ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <button class="suj-caro-next" type="button" data-bs-target="#advert-sujession-caro" data-bs-slide="next"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
            </div>
            <div class="indicators mt-1 text-center">
                <?php for ($i = 0; $i < $caro_item_counter; $i++) { ?>
                <button type="button" data-bs-target="#advert-sujession-caro" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo !$i ? "active" : ""; ?> shadow" aria-current="true" aria-label="Slide <?php echo $i+1; ?>" class="bg-dark"></button>
                <?php } ?>
            </div>
        <!-- sujession ads end-->
        <!-- Confirm add favorites alert model modal -->
        <div class="modal fade" id="conformAddFavoriteAd" tabindex="-1" aria-labelledby="conformAddFavoriteAdLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="conformAddFavoriteAdLabel"><i class="fa fa-star fa-lg text-warning me-2" aria-hidden="true"></i><?php echo $is_favorite == 1 ? "Remove" : "Ad"; ?> Your Favorites</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?php echo $is_favorite == 1 ? "Click on the Remove Favorite button on ad to remove it as a favorite." : "Click on the Add Favorite button on ad to save it as a favorite."; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Not Now</button>
                    <form action="" method="POST">
                        <input type="hidden" name="add_or_remove_favorite" value="ad_or_remove">
                        <button type="submit" class="btn btn-primary btn-sm <?php echo $is_favorite == 1 ? "btn-danger" : "btn-warning"; ?> text-white shadow-sm"><?php echo $is_favorite == 1 ? "Remove" : "Add"; ?> Favorite</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <!-- Confirm add favorites alert model modal end-->
        <!-- Image resize model -->
        <div class="modal fade" id="advert-iamge-resize-model" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="carousel-container carousel-dark">
                    <div id="advert-image-carousel-resize" class="carousel slide carousel advert-image-carousel" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                                $count = 0;
                                for ($i = 0; $i < 5; $i++) {

                                    if ($advert_iamges_name[("img_".($i+1))]) {
                            ?>
                            <div class="carousel-item <?php echo $i == 0 ? "active" : ""; ?>">
                                <img src="../uploads/advert/<?php echo $user_select_advert['advert_id']."-".($i+1); ?>.jpg" class="d-block w-100 img-fluid active" alt="...">
                            </div>
                            <?php $count++; } } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#advert-image-carousel-resize" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#advert-image-carousel-resize" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if ($count != 1) { ?>
                    <div class="caro-indicator row mt-2 w-100">
                        <?php
                            $count = 0;
                            for ($i = 0; $i < 5; $i++) { 
                                
                                if ($advert_iamges_name[("img_".($i+1))]) {
                        ?>
                        <img src="../uploads/advert/<?php echo $user_select_advert['advert_id']."-".($i+1); ?>.jpg" class="col-2 <?php echo $count == 0 ? "active" : ""; ?>" data-bs-target="#advert-image-carousel-resize" data-bs-slide-to="<?php echo $count; ?>" aria-label="Slide <?php echo $count; ?>"></img>
                        <?php $count++; } } } ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Image resize model end-->
    </main>

    <footer>
    <?php require_once("../library/footer.php"); ?>
    </footer>

    <!-- link js file -->
    <script src="../js/function.js"></script>
    <script src="../js/login.js"></script>
    <script src="../js/create-account.js"></script>
    <script src="../js/show-advert.js"></script>
    <!-- link js file end-->

    <?php
    
    openLoginError();
    openCreateAccountError();

    function openLoginError() {

        if (isset($_SESSION['login_error'])) {
    
            if (count($_SESSION['login_error'])) {
                ?>
                <script>
                    showLogin();
                    function showLogin() {
                        var myModalEl = document.querySelector('#login-model');
                        var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
                        modal.show();
                    }
                </script>
                <?php
            }
        }
    }

    function openCreateAccountError() {

        if (isset($_SESSION['create_account_error'])) {
    
            if (count($_SESSION['create_account_error'])) {
                ?>
                <script>
                    showCreateAccount();
                    function showCreateAccount() {
                        var myModalEl = document.querySelector('#create-account-model');
                        var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
                        modal.show();
                    }
                </script>
                <?php
            }
        }
    }
    
?>
</body>
</html>
