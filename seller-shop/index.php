
<?php session_start(); ?>

<?php $where_from = "seller-shop"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../library/verified-seller-handler.php"); ?>
<?php require_once("../library/ad-handler.php"); ?>
<?php require_once("../library/location-handler.php"); ?>
<?php require_once("../library/category-handler.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>
<?php require_once("../library/img-handler.php"); ?>
<?php require_once("../library/shop-timing-handler.php"); ?>

<?php

    // Error handling to return home page
    if (!isset($_GET['id']))
        header("location: ../");

    $seller_id = $_GET['id'];
    $verified_seller = get_verified_seller($seller_id);

    // Error handling to return home page
    if (!$verified_seller->num_rows)
        header("location: ../");
    else
        $verified_seller = $verified_seller->fetch_assoc();

    $ad_user = get_login_user($verified_seller['u_id'])->fetch_assoc();
    $timigs = select_timings($verified_seller['u_id'])->fetch_assoc();

    $search_text = "";
    $seller_ads;

    if (isset($_POST['btn_search'])) {

        $search_text = $_POST['search_box'];
        $filter = "AND u_id = {$ad_user['u_id']} AND title LIKE '%{$search_text}%'";
        $seller_ads = get_adds(20, 0, $filter, " post_date_time DESC");
    } else {

        $seller_ads = get_user_post_add($verified_seller['u_id']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $verified_seller['shop_name']; ?></title>

    <!-- link head php file -->
    <?php require_once("../library/head.php"); ?>
    <?php require_once("../library/function.php"); ?>

    <!-- link css -->
    <link rel="stylesheet" href="../style/account.css">
    <link rel="stylesheet" href="../style/content.css">
    <link rel="stylesheet" href="../style/seller-shop.css">
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
    <main>

        <!-- content -->
        <div class="container aria-1 my-3 rounded p-0">
            <!-- image aria -->
            <div class="image-aria">
                <div class="cover-image m-0">
                    <img src="<?php echo $verified_seller['cover_img'] ? "../uploads/seller-shop-cover/" . $verified_seller['cover_img'] : "../img/system-default-image/company-cover-image.jpg"; ?>" alt="" class="img-fluid rounded-top">
                </div>
                <div class="logo-image">
                    <img src="<?php echo $verified_seller['logo'] ? "../uploads/seller-shop-logo/" . $verified_seller['logo'] : "../img/system-default-logo/company-logo.jpg"; ?>" alt="">
                </div>
            </div>
            <!-- image aria end-->
            <!-- shop content -->
            <div class="shop-content px-3 pb-3 row">
                <!-- shop information (left arai) -->
                <div class="shop-information col-4 mt-3">
                    <div class="info-box border rounded sticky-top">
                        <div class="main-info border-bottom">
                            <div class="py-2 px-3">
                                <p class="shop-name"><?php echo $verified_seller['shop_name'] ?></p><!-- Sop Name -->
                                <p class="shop-title"><?php echo $verified_seller['shop_title'] ?></p><!-- Shop Title -->
                                <div class="badge">
                                    <div class="verified-seller-badge">
                                        <i class="fa fa-shirtsinbulk" aria-hidden="true"></i>
                                        <p>verified seller</p>
                                    </div>
                                    <div class="member-badge">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <p>member</p>
                                    </div>
                                </div><!-- Shop membership badges -->
                                <p class="last-online">Member since <?php echo date("d M Y | h:i A", strtotime($verified_seller['last_online'])); ?></p><!-- Seller last online date time -->
                                <a href="<?php echo $verified_seller['website']; ?>" target="_bank"><?php echo $verified_seller['website']; ?></a><!-- Shop wbsite -->
                            </div>
                        </div><!-- main shop information -->
                        <div class="shop-timings border-bottom">
                            <div class="p-3">
                                <div class="today">
                                    <?php
                                        $is_today;
                                        $is_tomorrow;

                                        switch (date("D")){

                                            case "Mon" :
                                                $is_today = "monday";
                                                $is_tomorrow = "tuesday";
                                                break;
                                            case "Tue" :
                                                $is_today = "tuesday";
                                                $is_tomorrow = "wednesday";
                                                break;
                                            case "Wed" :
                                                $is_today = "wednesday";
                                                $is_tomorrow = "thursday";
                                                break;
                                            case "Thu" :
                                                $is_today = "thursday";
                                                $is_tomorrow = "friday";
                                                break;
                                            case "Fri" :
                                                $is_today = "friday";
                                                $is_tomorrow = "saturday";
                                                break;
                                            case "Sat" :
                                                $is_today = "saturday";
                                                $is_tomorrow = "sunday";
                                                break;
                                            default :
                                                $is_today = "sunday";
                                                $is_tomorrow = "monday";
                                                break;
                                            }

                                        $is_open = is_open($timigs[$is_today.'_open'], $timigs[$is_today.'_close'], $timigs[$is_today.'_is_closed']);

                                        function is_open($open, $close, $is_closed) {
                                            $today = date("H:i");
                                            $open = date("H:i", strtotime($open));
                                            $close = date("H:i", strtotime($close));
                                            if ($today >= $open && $today < $close && !$is_closed)
                                                return true;
                                            else 
                                                return false;
                                        }
                                    ?>
                                    <p><span class="<?php echo $is_open ? "open" : "closed"; ?>"><?php echo $is_open ? "Open" : "Closed"; ?></span> <?php echo !$is_open ? "Open " : "Closed "; echo $is_open ? date("h:i a", strtotime($timigs[$is_today.'_close'])) : date("D h:i a", strtotime($timigs[$is_tomorrow.'_open'] . ' + 1 days')); ?></p>
                                </div>
                                <a href="" data-bs-toggle="modal" data-bs-target="#shopTimings">See all timings</a>
                            </div>
                        </div><!-- shop timings -->
                        <div class="phone-number border-bottom">
                            <div class="p-3">
                                <div class="contact-box" id="shop-mobile-contact-box">
                                    <div style="min-width: 35px;">
                                        <i class="fa fa-phone fa-lg" aria-hidden="true"></i>
                                    </div>
                                    <div class="number">
                                        <?php if ($verified_seller['is_hide_phonenumber']) { ?>
                                        <div id="hide-number" class="">
                                            <p class="number"><?php echo substr($verified_seller['phonenumber'], 0, 4); ?>XXXXXX</p>
                                            <p class="noty">Click to show phone number</p>
                                        </div>
                                        <?php } ?>
                                        <div id="number-button" class="show-number <?php echo $verified_seller['is_hide_phonenumber'] ? "d-none" : ""; ?>">
                                            <p class="number mb-1">Call Shop</p>
                                            <a href="tel: <?php echo $verified_seller['phonenumber']; ?>" class="btn btn-success btn-sm"><?php echo $verified_seller['phonenumber']; ?></a>
                                        </div>
                                        <?php ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- shop mobile number -->
                        <div class="shop-email border-bottom">
                            <div class="p-3">
                                <div class="email-box">
                                    <div style="min-width: 35px;">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                    <a href="mailto: <?php echo $verified_seller['email']; ?>">Email</a>
                                </div>
                            </div>
                        </div><!-- shop email -->
                        <div class="shop-address border-bottom">
                            <div class="p-3">
                                <dic class="address-box">
                                    <div style="min-width: 35px;">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    </div>
                                    <p><?php echo $verified_seller['shop_address']; ?></p>
                                </dic>
                            </div>
                        </div><!-- shop address -->
                        <div class="about-shop">
                            <div class="p-3">
                                <div class="about-shop">
                                    <p class="title">About the shop</p>
                                    <div id="about-shop-aria">
                                        <p class="about-text" id="about-shop-text"><?php echo $verified_seller['about_shop'] ?></p>
                                        <p id="btn-shop-more-less" class="btn-shop-more-less">Show more<i id="btn-shop-more-less-icon" class="fa fa-chevron-down ms-2" aria-hidden="true"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- about the shop -->
                    </div>
                </div>
                <!-- shop information (left arai) end-->
                <div class="seller-ads col-8 pt-3">
                    <form action="" method="POST">
                        <div class="search-box">
                            <input type="search" name="search_box" value="<?php echo $search_text; ?>" placeholder="Search ads from <?php echo $verified_seller['shop_name']; ?>">
                            <div class="search-button">
                                <button type="submit" name="btn_search"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form><!-- search box -->
                    <div class="all-ad-bar">
                        <p>All ads from <?php echo substr($verified_seller['shop_name'], 0, 50) . "" . (strlen($verified_seller['shop_name']) > 50 ? "..." : ""); ?> (1-<?php echo number_format($seller_ads->num_rows / 20, 0); ?> of <?php echo $seller_ads->num_rows; ?>)</p>
                    </div><!-- all ads bar -->                    
                    <div class="ads-list mt-3 mb-3">
                        <?php  if (!$seller_ads->num_rows) { ?>
                        <div class="text-center pt-5">
                            <i class="fa fa-inbox" aria-hidden="true" style="font-size: 3em;"></i>
                            <h5>No results found!</h5>
                            <a href="?id=<?php echo $ad_user['u_id']; ?>" class="btn btn-sm btn-success mt-2">Brows all ads</a>
                        </div>
                        <?php }
                        
                        while($ad = $seller_ads->fetch_assoc()) { 
                            
                            $is_top_ad = new DateTime($ad['top_ad']) > new DateTime();
                            $ad_image_list = get_image_list($ad['advert_id'])->fetch_assoc();
                            $ad_location = get_location($ad['dis_id'])->fetch_assoc();
                            $ad_category = get_category($ad['cate_id'])->fetch_assoc();
                        ?>
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
                        <?php } ?>
                    </div>
                    <?php if ($seller_ads->num_rows) { ?>
                    <nav aria-label="" class="mt-5 mb-4">
                        <ul class="pagination justify-content-center">
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
                </div>
            </div>
            <!-- shop content end-->
        </div>
        <!-- content end-->
        <!-- Shop Timings Modal -->
        <div class="modal fade shop-timinigs-model" id="shopTimings" tabindex="-1" aria-labelledby="shopTimingsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shopTimingsLabel">All Timings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php $today_is = date("D"); ?>
                <div class="modal-body">
                    <div class="day row">
                        <div class="col-4">
                            <p class="name <?php echo $today_is == "Mon" ? "active" : "" ?>">Monday</p>
                        </div>
                        <div class="col-8 text-center">
                            <?php if (!$timigs['monday_is_closed']) { ?>   
                            <p class="time-zone <?php echo $today_is == "Mon" ? "active" : "" ?>"><?php echo date("h:i a", strtotime($timigs['monday_open'])); ?> - 
                            <?php echo date("h:i a", strtotime(($timigs['monday_open'] != 0 && $timigs['monday_close'] != 0 ? $timigs['monday_close'] : "23:59"))); ?></p>
                            <?php } else { ?>
                            <p class="time-zone closed">Closed</p>
                            <?php } ?>     
                        </div>
                    </div>
                    <div class="day row">
                        <div class="col-4">
                            <p class="name <?php echo $today_is == "Tue" ? "active" : "" ?>">Tuesday</p>
                        </div>
                        <div class="col-8 text-center">
                            <?php if (!$timigs['tuesday_is_closed']) { ?>   
                            <p class="time-zone <?php echo $today_is == "Tue" ? "active" : "" ?>"><?php echo date("h:i a", strtotime($timigs['tuesday_open'])); ?> - 
                            <?php echo date("h:i a", strtotime(($timigs['tuesday_open'] != 0 && $timigs['tuesday_close'] != 0 ? $timigs['tuesday_close'] : "23:59"))); ?></p>
                            <?php } else { ?>
                            <p class="time-zone closed">Closed</p>
                            <?php } ?>           
                        </div>
                    </div>
                    <div class="day row">
                        <div class="col-4">
                            <p class="name <?php echo $today_is == "Wed" ? "active" : "" ?>">Wednesday</p>
                        </div>
                        <div class="col-8 text-center">
                            <?php if (!$timigs['wednesday_is_closed']) { ?>   
                            <p class="time-zone <?php echo $today_is == "Wed" ? "active" : "" ?>"><?php echo date("h:i a", strtotime($timigs['wednesday_open'])); ?> - 
                            <?php echo date("h:i a", strtotime(($timigs['wednesday_open'] != 0 && $timigs['wednesday_close'] != 0 ? $timigs['wednesday_close'] : "23:59"))); ?></p>
                            <?php } else { ?>
                            <p class="time-zone closed">Closed</p>
                            <?php } ?>           
                        </div>
                    </div>
                    <div class="day row">
                        <div class="col-4">
                            <p class="name <?php echo $today_is == "Thu" ? "active" : "" ?>">Thursday</p>
                        </div>
                        <div class="col-8 text-center">
                            <?php if (!$timigs['thursday_is_closed']) { ?>   
                            <p class="time-zone <?php echo $today_is == "Thu" ? "active" : "" ?>"><?php echo date("h:i a", strtotime($timigs['thursday_open'])); ?> - 
                            <?php echo date("h:i a", strtotime(($timigs['thursday_open'] != 0 && $timigs['thursday_close'] != 0 ? $timigs['thursday_close'] : "23:59"))); ?></p>
                            <?php } else { ?>
                            <p class="time-zone closed">Closed</p>
                            <?php } ?>            
                        </div>
                    </div>
                    <div class="day row">
                        <div class="col-4">
                            <p class="name <?php echo $today_is == "Fri" ? "active" : "" ?>">Friday</p>
                        </div>
                        <div class="col-8 text-center">
                            <?php if (!$timigs['friday_is_closed']) { ?>
                            <p class="time-zone <?php echo $today_is == "Fri" ? "active" : "" ?>"><?php echo date("h:i a", strtotime($timigs['friday_open'])); ?> - 
                            <?php echo date("h:i a", strtotime(($timigs['friday_open'] != 0 && $timigs['friday_close'] != 0 ? $timigs['friday_close'] : "23:59"))); ?></p>
                            <?php } else { ?>
                            <p class="time-zone closed">Closed</p>
                            <?php } ?> 
                        </div>
                    </div>
                    <div class="day row">
                        <div class="col-4">
                            <p class="name <?php echo $today_is == "Sat" ? "active" : "" ?>">Saturday</p>
                        </div>
                        <div class="col-8 text-center">
                            <?php if (!$timigs['saturday_is_closed']) { ?>
                            <p class="time-zone <?php echo $today_is == "Sat" ? "active" : "" ?>"><?php echo date("h:i a", strtotime($timigs['saturday_open'])); ?> - 
                            <?php echo date("h:i a", strtotime(($timigs['saturday_open'] != 0 && $timigs['saturday_close'] != 0 ? $timigs['saturday_close'] : "23:59"))); ?></p>
                            <?php } else { ?>
                            <p class="time-zone closed">Closed</p>
                            <?php } ?>                            
                        </div>
                    </div>
                    <div class="day row">
                        <div class="col-4">
                            <p class="name <?php echo $today_is == "Sun" ? "active" : "" ?>">Sunday</p>
                        </div>
                        <div class="col-8 text-center">
                            <?php if (!$timigs['sunday_is_closed']) { ?>
                            <p class="time-zone <?php echo $today_is == "Sun" ? "active" : "" ?>"><?php echo date("h:i a", strtotime($timigs['sunday_open'])); ?> - 
                            <?php echo date("h:i a", strtotime(($timigs['sunday_open'] != 0 && $timigs['sunday_close'] != 0 ? $timigs['sunday_close'] : "23:59"))); ?></p>
                            <?php } else { ?>
                            <p class="time-zone closed">Closed</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-1">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Ok</button>
                </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
    <?php require_once("../library/footer.php"); ?>
    </footer>

    <!-- link javascript file -->
    <script src="../js/settings.js"></script>
    <script src="../js/function.js"></script>
    <script src="../js/login.js"></script>
    <script src="../js/create-account.js"></script>
    <script src="../js/seller-shop.js"></script>
    <!-- link javascript file end-->

    <!-- account model open -->
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
