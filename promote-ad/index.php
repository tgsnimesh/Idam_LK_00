
<?php session_start(); ?>

<?php $where_from = "promote-advert"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../library/ad-handler.php"); ?>
<?php require_once("../library/img-handler.php"); ?>
<?php require_once("../library/location-handler.php"); ?>
<?php require_once("../library/category-handler.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>

<?php

    $ad = get_adds(1, 0, " AND advert_id = {$_GET['id']}", " advert_id ASC ")->fetch_assoc();
                        
    $is_top_ad = (new DateTime($ad['top_ad'])) > new DateTime();
    $ad_user = get_login_user($ad['u_id'])->fetch_assoc();

    $ad_image_list = get_image_list($ad['advert_id'])->fetch_assoc();
    $ad_location = get_location($ad['dis_id'])->fetch_assoc();
    $ad_category = get_category($ad['cate_id'])->fetch_assoc();

    // if (!check_is_login_user())
    //     header("location: ../show-advert/?advert-id={$_GET['id']}");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Promote Ad</title>

    <!-- link head php file -->
    <?php require_once("../library/head.php"); ?>

    <!-- link css -->
    <link rel="stylesheet" href="../style/content.css">
    <link rel="stylesheet" href="../style/footer.css">
    <link rel="stylesheet" href="../style/promote-ad.css">
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
        <div class="container aria-1 my-4 rounded py-4 px-4">
            <div class="row">
                <!-- ad promote option select aria -->
                <div class="promote-option-aria col-7 border-end">
                    <div class="header">
                        <p class="title">Make your ad stand out!</p>
                        <p class="des">Get up to 10 times more responses by applying Ad Promotions.<br>Select one or more options.</p>
                    </div>
                    <div class="option-list shadow-sm">
                        <?php if (!$is_top_ad) { ?>
                        <div class="options-box border-bottom p-3 rounded-top">
                            <div class="option-item">
                                <div class="icon">
                                    <div class="d-flex">
                                        <i class="fa fa-500px" aria-hidden="true" style="font-size: 1.6em; color: #B22727;"></i>
                                        <p class="" style="color: #B22727; font-size: 0.5em; font-weight: bold; line-height: 1.1em;">TOP<br>ADS<br> *****</p>
                                    </div>
                                </div>
                                <div class="option-des">
                                    <p class="title">Top Ad</p>
                                    <p>Get a fresh start every day and get up to 10 times more responses!<a href="">Learn more</a></p>
                                </div>
                                <div class="optino-price">
                                    <div class="price" id="price-top-ad">From Rs 3,900</div>
                                    <button type="button" id="btn-change-top-ad" class="btn-days-label d-none" data-bs-toggle="modal" data-bs-target="#topAdOptionModel">7 days</button>
                                    <i class="fa fa-plus-circle" aria-hidden="true" id="btn-add-top-ad" data-bs-toggle="modal" data-bs-target="#topAdOptionModel"></i>
                                    <i class="fa fa-minus-circle text-danger d-none" id="btn-remove-top-ad"></i>
                                </div>
                            </div>
                        </div><!-- Promote Top Ad -->
                        <?php } ?>
                        <?php if (!(new DateTime($ad['spotlight']) > new DateTime())) { ?>
                        <div class="options-box border-bottom p-3">
                            <div class="option-item">
                                <div class="icon">
                                    <div class="caro-top-bad">
                                        <i class="fa fa-ravelry" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="option-des">
                                    <p class="title">Spotlight</p>
                                    <p>Boost sales by showing your ad in this premium slot.<a href="">Learn more</a></p>
                                </div>
                                <div class="optino-price">
                                    <div class="price" id="price-spotlight">From Rs 16,500</div>
                                    <button type="button" id="btn-change-spotlight" class="btn-days-label d-none" data-bs-toggle="modal" data-bs-target="#spotlightModel">7 days</button>
                                    <i class="fa fa-plus-circle" aria-hidden="true" id="btn-add-spotlight" data-bs-toggle="modal" data-bs-target="#spotlightModel"></i>
                                    <i class="fa fa-minus-circle text-danger d-none" id="btn-remove-spotlight"></i>
                                </div>
                            </div>
                        </div><!-- Promote Spotlight Ad -->
                        <?php } ?>
                        <div class="options-box border-bottom p-3">
                            <div class="option-item">
                                <div class="icon">
                                    <div class="urgent-bad">
                                        <p>Urgent</p>
                                    </div>
                                </div>
                                <div class="option-des">
                                    <p class="title">Urgent</p>
                                    <p>Stand out from the rest by showing a bright red marker on the ad!<a href="">Learn more</a></p>
                                </div>
                                <div class="optino-price">
                                    <div class="price" id="price-urgent">From Rs 1,600</div>
                                    <button type="button" id="btn-change-urgent" class="btn-days-label d-none" data-bs-toggle="modal" data-bs-target="#urgentModel">7 days</button>
                                    <i class="fa fa-plus-circle" aria-hidden="true" id="btn-add-urgent" data-bs-toggle="modal" data-bs-target="#urgentModel"></i>
                                    <i class="fa fa-minus-circle text-danger d-none" id="btn-remove-urgent"></i>
                                </div>
                            </div>
                        </div><!-- Promote Urgent Ad -->
                        <div class="options-box rounded-bottom p-3">
                            <div class="option-item">
                                <div class="icon">
                                    <div class="d-flex">
                                        <p class="" style="font-size: 0.5em; font-weight: bold; color: #F49D1A;">BUMP<br>UP</p>
                                        <i class="fa fa-level-up" aria-hidden="true" style="font-size: 1.8em; color: #F49D1A;"></i>
                                    </div> 
                                </div>
                                <div class="option-des">
                                    <p class="title">Bump Up</p>
                                    <p>Get a fresh start every day and get up to 10 times more responses!<a href="">Learn more</a></p>
                                </div>
                                <div class="optino-price">
                                    <div class="price" id="price-bumpup">From Rs 3,900</div>
                                    <button type="button" id="btn-change-bumpup" class="btn-days-label d-none" data-bs-toggle="modal" data-bs-target="#bumpUpModel">7 days</button>
                                    <i class="fa fa-plus-circle" aria-hidden="true" id="btn-add-bumpup" data-bs-toggle="modal" data-bs-target="#bumpUpModel"></i>
                                    <i class="fa fa-minus-circle text-danger d-none" id="btn-remove-bumpup"></i>
                                </div>
                            </div>
                        </div><!-- Promote Bump up Ad -->
                    </div>
                </div>
                <!-- ad promote option select aria end-->
                <!-- right promote ad details -->
                <div class="promotead-detalis col-5 ps-4">
                    <div class="promote-ad">
                        <div class="ads-list mt-3 mb-3">
                            <div class="mb-1 ad-item user-ad-item <?php echo $is_top_ad ? "ad-item-up" : "border"; ?>" title="<?php echo $ad['title'] . "\n" . $ad_location['d_name'] . ", " . $ad_category['ct_name']; ?>">
                                <input type="hidden" value="<?php echo "advert-id=" . $ad['advert_id']; ?>" class="user-ad-item-id">
                                <div class="img pb-3">
                                    <img src="<?php echo "../uploads/advert/{$ad_image_list['img_1']}"; ?>" alt="<?php echo $ad['title']; ?>" class="" style="max-width: 100px; height: 70px;">
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
                    </div><!-- promote ad aria -->
                    <div id="summery-box" class="d-none">
                        <div class="payment-box px-3 py-2 rounded shadow-sm">
                            <div class="title">
                                <p>Payment summary</p>
                            </div>
                            <div class="payment-summary-box pb-1 border-bottom">
                                <div class="summary d-none" id="top-add-summery">
                                    <p class="option">Top Ad (<span id="top-add-summery-days">7</span> days)</p>
                                    <p class="price">Rs <span id="top-add-summery-price">3,300</span></p>
                                </div>
                                <div class="summary d-none" id="spotlight-summery">
                                    <p class="option">Spotlight (<span id="spotlight-summery-days">7</span> days)</p>
                                    <p class="price">Rs <span id="spotlight-summery-price">5,700</span></p>
                                </div>
                                <div class="summary d-none" id="urgent-summery">
                                    <p class="option">Urgent (<span id="urgent-summery-days">7</span> days)</p>
                                    <p class="price">Rs <span id="urgent-summery-price">3,300</span></p>
                                </div>
                                <div class="summary d-none" id="bumpup-summery">
                                    <p class="option">Bump Up (<span id="bumpup-summery-days">7</span> days)</p>
                                    <p class="price">Rs <span id="bumpup-summery-price">3,300</span></p>
                                </div>
                            </div>
                            <div class="total-amount-box py-2">
                                <p class="text">Total amount</p>
                                <p class="amount" id="total-amount">Rs 33,600</p>
                            </div>
                        </div>
                        <div class="btn-payment mt-3">
                            <form action="../promote-ad/promote-ad.php" method="POST">
                                <input type="hidden" id="" name="advert_id" value="<?php echo $_GET['id']; ?>">
                                <input type="hidden" id="top-ad-value" name="top_ad" value="0">
                                <input type="hidden" id="spotlight-value" name="spotlight" value="0">
                                <input type="hidden" id="urgent-value" name="urgent" value="0">
                                <input type="hidden" id="bumpup-value" name="bump_up" value="0">
                                <button type="submit" name="payment" class="btn btn-success btn-sm shadow-sm w-100">Continue</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- right promote ad details end-->
            </div>
        </div>
        <!-- Top Add Modal -->
        <div class="modal fade" id="topAdOptionModel" tabindex="-1" aria-labelledby="topAdOptionModelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="title">
                        <div class="d-flex">
                            <i class="fa fa-500px" aria-hidden="true" style="font-size: 1.6em; color: #B22727;"></i>
                            <p class="" style="color: #B22727; font-size: 0.5em; font-weight: bold; line-height: 1.1em;">TOP<br>ADS<br> *****</p>
                            <p class="text mb-0">Top Ads</p>
                        </div>
                        <p class="des mb-0">Get a fresh start every day and get up to 10 times more responses!<a href="">Learn more</a></p>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3 mt-2">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" id="top-ad-3" name="top_ad" value="true" checked>
                                <label for="top-ad-3">3 days</label>
                            </div>
                            <p class="price">Rs 3,900</p>
                        </div>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" id="top-ad-7" name="top_ad" value="true">
                                <label for="top-ad-7">7 days</label>
                            </div>
                            <p class="price">Rs 5,700</p>
                        </div>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" id="top-ad-15" name="top_ad" value="true">
                                <label for="top-ad-15">15 days</label>
                            </div>
                            <p class="price">Rs 8,100</p>
                        </div>
                    </div>
                    <div class="btn-select">
                        <button type="butoon" id="btn-promote-top-ad" class="btn btn-success btn-sm shadow-sm w-100 mt-4" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Spotlight Modal -->
        <div class="modal fade" id="spotlightModel" tabindex="-1" aria-labelledby="spotlightModelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="title">
                        <div class="d-flex">
                            <div class="caro-top-bad mb-2">
                                <i class="fa fa-ravelry" aria-hidden="true"></i>
                            </div>
                            <p class="text mb-0">Spotlight</p>
                        </div>
                        <p class="des mb-0">Boost sales by showing your ad in this premium slot.<a href="">Learn more</a></p>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3 mt-2">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" id="spotlight-3" name="spotlight" value="true" checked>
                                <label for="spotlight-3">3 days</label>
                            </div>
                            <p class="price">Rs 16,500</p>
                        </div>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" id="spotlight-7" name="spotlight" value="true">
                                <label for="spotlight-7">7 days</label>
                            </div>
                            <p class="price">Rs 22,300</p>
                        </div>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" id="spotlight-15" name="spotlight" value="true">
                                <label for="spotlight-15">15 days</label>
                            </div>
                            <p class="price">Rs 29,700</p>
                        </div>
                    </div>
                    <div class="btn-select">
                        <button type="butoon" id="btn-promote-spotlight" class="btn btn-success btn-sm shadow-sm w-100 mt-4" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Urgent Modal -->
        <div class="modal fade" id="urgentModel" tabindex="-1" aria-labelledby="urgentModelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="title">
                        <div class="d-flex">
                            <div class="urgent-bad mb-2">
                                <p>Urgent</p>
                            </div>
                            <p class="text mb-0">Urgent</p>
                        </div>
                        <p class="des mb-0">Stand out from the rest by showing a bright red marker on the ad!<a href="">Learn more</a></p>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3 mt-2">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" name="urgent" id="urgent-3" value="true" checked>
                                <label for="urgent-3" >3 days</label>
                            </div>
                            <p class="price">Rs 1,600</p>
                        </div>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" name="urgent" id="urgent-7" value="true">
                                <label for="urgent-7" >7 days</label>
                            </div>
                            <p class="price">Rs 2,300</p>
                        </div>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" name="urgent" id="urgent-15" value="true">
                                <label for="urgent-15" >15 days</label>
                            </div>
                            <p class="price">Rs 3,200</p>
                        </div>
                    </div>
                    <div class="btn-select">
                        <button type="butoon" id="btn-promote-urgent" class="btn btn-success btn-sm shadow-sm w-100 mt-4" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Bump Up Modal -->
        <div class="modal fade" id="bumpUpModel" tabindex="-1" aria-labelledby="bumpUpModelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="title">
                        <div class="d-flex">
                            <div class="d-flex">
                                <p class="" style="font-size: 0.5em; font-weight: bold; color: #F49D1A;">BUMP<br>UP</p>
                                <i class="fa fa-level-up" aria-hidden="true" style="font-size: 1.8em; color: #F49D1A;"></i>
                            </div> 
                            <p class="text mb-0">Bump Up</p>
                        </div>
                        <p class="des mb-0">Get a fresh start every day and get up to 10 times more responses!<a href="">Learn more</a></p>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3 mt-2">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" name="bumpup" id="bumpup-3" value="true" checked>
                                <label for="bumpup-3">3 days</label>
                            </div>
                            <p class="price">Rs 3,900</p>
                        </div>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" name="bumpup" id="bumpup-7" value="true">
                                <label for="bumpup-7">7 days</label>
                            </div>
                            <p class="price">Rs 5,700</p>
                        </div>
                    </div>
                    <div class="promote-days-option border-bottom pt-2 pb-3">
                        <div class="option">
                            <div class="radio">
                                <input type="radio" name="bumpup" id="bumpup-15" value="true">
                                <label for="bumpup-15">15 days</label>
                            </div>
                            <p class="price">Rs 8,100</p>
                        </div>
                    </div>
                    <div class="btn-select">
                        <button type="butoon" id="btn-promote-bumpup" class="btn btn-success btn-sm shadow-sm w-100 mt-4" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
    <?php require_once("../library/footer.php"); ?>
    </footer>

    <!-- link js file -->
    <script src="../js/promote-ad.js"></script>
    <script src="../js/function.js"></script>
    <script src="../js/login.js"></script>
    <script src="../js/create-account.js"></script>
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
