
<?php session_start(); ?>

<?php $where_from = "home"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../library/ad-handler.php"); ?>
<?php require_once("../library/img-handler.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>
<?php require_once("../library/location-handler.php"); ?>
<?php require_once("../library/category-handler.php"); ?>
<?php require_once("../library/verified-seller-handler.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home</title>

    <!-- link head php file -->
    <?php require_once("../library/head.php"); ?>

    <!-- link css -->
    <link rel="stylesheet" href="../style/content.css">
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
        <div class="container aria-1 my-4 rounded">

            <!-- search abr -->
            <div class="row p-2 border-bottom">
                <div class="select-location col-3 d-flex">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <a href="">Select Location</a>
                </div>
                <div class="property col-3 d-flex">
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <a href="">Property</a>
                </div>
                <div class="search col-6">
                    <form action="" method="post">
                        <input type="search" name="search-text" placeholder="What are you looking for ?" value="<?php echo isset($_POST['search-text']) ? $_POST['search-text'] : ""; ?>">
                        <button type="submit" name="btn-search" class="btn-warning"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
            <!-- search abr end-->

            <!-- add contents -->
            <div class="add-content row">
                <!-- left aria (filter)  -->
                <div class="left-filter col-3 border-end">

                    <!-- top commen filters -->
                    <div class="border-bottom pb-4">
                        <label for="" class="filter-label mt-3">sort result by</label>
                        <div class="dropdown com-filter-1">
                            <button class="btn btn-sm w-100 text-start btn-light border dropdown-toggle text-capitalize" type="button" id="dropdown-sortresultby" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php

                                // update verified seller last online date time
                                if (check_is_login_user()) {

                                    if (get_login_user(check_is_login_user())->fetch_assoc()['is_verified_seller'])
                                        update_last_online(check_is_login_user(), date("Y-m-d H:i:s"));
                                }
                                
                                date_default_timezone_set('Asia/Colombo');

                                $is_sort_value = null;

                                if (isset($_GET['sort'])) {

                                    $is_sort_value = $_GET['sort'];

                                    switch ($_GET['sort']) {
                                        case "date-top":
                                            echo "Date: Newest on top";
                                            break;
                                        case "date-bott":
                                            echo "Date: Oldet on top";
                                            break;
                                        case "price-heigh":
                                            echo "Price: High to low";
                                            break;
                                        case "price-low":
                                            echo "Price: Low to high";
                                            break;
                                    }
                                } else {
                                    
                                    echo "Date: Newest on top";
                                    $is_sort_value = "date-top";
                                }

                                ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdown-sortresultby">
                                <li><a class="dropdown-item <?php echo $is_sort_value == "date-top" ? "active" : ""; ?>" href="?<?php echo filter_url_manager("sort", ""); ?>sort=date-top">Date: Newest on top</a></li>
                                <li><a class="dropdown-item <?php echo $is_sort_value == "date-bott" ? "active" : ""; ?>" href="?<?php echo filter_url_manager("sort", ""); ?>sort=date-bott">Date: Oldet on top</a></li>
                                <li><a class="dropdown-item <?php echo $is_sort_value == "price-heigh" ? "active" : ""; ?>" href="?<?php echo filter_url_manager("sort", ""); ?>sort=price-heigh">Price: High to low</a></li>
                                <li><a class="dropdown-item <?php echo $is_sort_value == "price-low" ? "active" : ""; ?>" href="?<?php echo filter_url_manager("sort", ""); ?>sort=price-low">Price: Low to high</a></li>
                            </ul>
                        </div><!-- FILTER 01 -->
                        <label for="" class="filter-label mt-4">Filter ads by</label>
                        <form action="" class="com-filter-2">
                            <?php
                            
                            $is_urgent = false;
                            if (isset($_GET['urgent'])) {

                                if ($_GET['urgent']) {

                                    $is_urgent = true;
                                } else {
                                    $is_urgent = false;
                                }
                            } else {
                                $is_urgent = false;
                            }
                            $is_featured = false;
                            if (isset($_GET['featured'])) {

                                if ($_GET['featured']) {

                                    $is_featured = true;
                                } else {
                                    $is_featured = false;
                                }
                            } else {
                                $is_featured = false;
                            }

                            ?>
                            <div class="d-flex align-item-center">
                                <input type="checkbox" id="urgent" onclick="urgentClick('<?php echo $is_urgent; ?>');" <?php echo $is_urgent ? "checked" : ""; ?>>
                                <label for="urgent" class="urgent-filter-label ms-1" id="urgent-l" style="font-size: 0.7em;">URGENT</label>
                            </div>
                            <div class="mt-1" class="d-flex align-item-center">
                                <input type="checkbox" id="featured" onclick="featuredClick('<?php echo $is_featured; ?>');" <?php echo $is_featured ? "checked" : ""; ?>>
                                <label for="featured" class="featured-filter-label" id="featured-l" style="font-size: 0.7em;">FEATURED</label>
                            </div>
                        </form><!-- FILTER 02 -->
                        <label for="" class="filter-label mt-3">Type of poster</label>
                        <div class="dropdown com-filter-3">
                            <button class="btn btn-sm w-100 btn-light border text-start dropdown-toggle" type="button" id="dropdown-typeofpoter" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                        
                                $is_type_value = null;

                                if (isset($_GET['type'])) {

                                    $is_type_value = $_GET['type'];

                                    switch ($_GET['type']) {
                                        case "all":
                                            echo "All";
                                            break;
                                        case "member":
                                            echo "Member";
                                            break;
                                        case "non-member":
                                            echo "Non-Member";
                                            break;
                                    }
                                } else {
                                        
                                    echo "All";
                                    $is_type_value = "all";
                                }

                            ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdown-typeofpoter">
                                <li><a class="dropdown-item <?php echo $is_type_value == "all" ? "active" : ""; ?>" href="?<?php echo filter_url_manager("type", ""); ?>type=all">All</a></li>
                                <li><a class="dropdown-item <?php echo $is_type_value == "member" ? "active" : ""; ?>" href="?<?php echo filter_url_manager("type", ""); ?>type=member">Member</a></li>
                                <li><a class="dropdown-item <?php echo $is_type_value == "non-member" ? "active" : ""; ?>" href="?<?php echo filter_url_manager("type", ""); ?>type=non-member">Non-Member</a></li>
                            </ul>
                        </div><!-- FILTER 03 -->
                    </div>
                    <!-- top commen filters end-->
                    <?php

                    $max_loaded_ads_count = 20;

                    // create user filter query
                    $user_filter_query = "";
                    $user_filter_sort_query;

                    if (isset($_POST['btn-search'])) {

                        $have_dis = get_search_locations(" d_name LIKE '%{$_POST['search-text']}%'")->fetch_assoc()['d_id'];
                        $have_city = get_search_sub_locations(" c_name LIKE '%{$_POST['search-text']}%'")->fetch_assoc()['c_id'];
                        $have_cate = get_search_category(" ct_name LIKE '%{$_POST['search-text']}%'")->fetch_assoc()['ct_id'];

                        $user_filter_query = " AND dis_id = '{$have_dis}' OR city_id = '{$have_city}' OR cate_id = '{$have_cate}' OR title LIKE '%{$_POST['search-text']}%' ";
                    }

                    ?>
                    <div class="">
                        <div class="accordion accordion-flush acc-filters mb-2" id="accordionFlushExample">
                            <?php
                            
                            $user_click_category = "";

                            if (isset($_GET['category'])) {
                                $user_filter_query .= " AND cate_id = {$_GET['category']} ";
                                $user_click_category = $_GET['category'];
                            }

                            ?>
                            <!-- category filter -->
                            <div class="accordion-item mt-1 border-bottom">
                                <h2 class="accordion-header" id="flush-headingCategoryFilter">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCategoryFilter" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Category
                                </button>
                                </h2>
                                <div id="flush-collapseCategoryFilter" class="accordion-collapse collapse show" aria-labelledby="flush-headingCategoryFilter" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <a href="?<?php echo filter_url_manager("category", ""); ?>">All Categories</a>
                                        <p style="font-weight: bold;"><i class="fa fa-home fa-lg me-1" aria-hidden="true"></i>Property</p>
                                        <ul class="text-capitalize">
                                            <?php 
                                            
                                            $all_categoty = get_all_category();

                                            while ($category = $all_categoty->fetch_assoc()) {
                                                
                                            ?>
                                            <li>
                                                <a href="?<?php echo filter_url_manager("category", ""); ?>category=<?php echo $category['ct_id']; ?>"
                                                style="<?php echo $user_click_category == $category['ct_id'] ? "font-weight: bold; color: black;" : ""; ?>"><?php echo $category['ct_name']; ?></a> 
                                                <?php echo "(" . get_adds($max_loaded_ads_count, 0, " AND cate_id = {$category['ct_id']}", "advert_id DESC")->num_rows . ")"; ?>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- category filter end-->
                            <?php
                            
                            $user_click_location = "";

                            if (isset($_GET['location'])) {
                                $user_click_location = $_GET['location'];
                            }

                            ?>
                            <!-- location filter -->
                            <div class="accordion-item mt-1 border-bottom">
                                <h2 class="accordion-header" id="flush-headingLocationFilter">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseLocationFilter" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Location
                                </button>
                                </h2>
                                <div id="flush-collapseLocationFilter" class="accordion-collapse collapse" aria-labelledby="flush-headingLocationFilter" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <a style="color: #2c2c2c; font-weight: bold;" href="?<?php echo filter_url_manager("location", ""); ?>" class="all-location">All of Sri Lanka</a>
                                        <ul class="location-list text-capitalize">
                                        <?php 
                                            
                                            $all_locations = get_all_locations();

                                            while ($location = $all_locations->fetch_assoc()) {
                                                
                                                $location_have_ads_count = get_adds("", 0, $user_filter_query . " AND dis_id = {$location['d_id']} ", "advert_id DESC")->num_rows;
                                                
                                                if ($location_have_ads_count) {
                                            ?>
                                            <li>
                                                <a href="?<?php echo filter_url_manager("location", ""); ?>location=<?php echo $location['d_id']; ?>"
                                                style="<?php echo $user_click_location == $location['d_id'] ? "font-weight: bold; color: black;" : ""; ?>"><?php echo $location['d_name']; ?></a>
                                                <?php echo "(" . $location_have_ads_count . ")"; ?>
                                            </li>
                                            <?php } } 
                                            
                                            if (isset($_GET['location'])) {
                                                $user_filter_query .= " AND dis_id = {$_GET['location']} ";
                                            }
                                            
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- location filter end-->
                            <!-- price filter -->
                            <?php
                            
                            if (isset($_GET['category']) || isset($_GET['location'])) {

                                $min_value = "";
                                $max_value = "";

                                if (isset($_GET['min_p']) && isset($_GET['max_p'])) {

                                    $min_value = $_GET['min_p'];
                                    $max_value = $_GET['max_p'];

                                    $user_filter_query .= " AND price > {$_GET['min_p']} AND price < {$_GET['max_p']} ";
                                }

                            ?>
                            <div class="accordion-item mt-1">
                                <h2 class="accordion-header" id="flush-headingPriceFilter">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsePriceFilter" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Price (Rs)
                                </button>
                                </h2>
                                <div id="flush-collapsePriceFilter" class="accordion-collapse collapse" aria-labelledby="flush-headingPriceFilter" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="number" id="min-price" name="min_price" placeholder="Min" value="<?php echo $min_value; ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" id="max-price" name="max_price" placeholder="Max" value="<?php echo $max_value; ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-12">
                                                <button type="button" id="btn-search-price" onclick="searchPrice();" class="btn btn-sm btn-light border mt-3 w-100">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- price filter end-->
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- left aria (filter)  end-->
                <?php

                if (isset($_GET['sort'])) {

                    if ($_GET['sort'] == "date-top") $user_filter_sort_query = "post_date_time DESC";
                    if ($_GET['sort'] == "date-bott") $user_filter_sort_query = "post_date_time ASC";
                    if ($_GET['sort'] == "price-heigh") $user_filter_sort_query = "price DESC";
                    if ($_GET['sort'] == "price-low") $user_filter_sort_query = "price ASC";
                } else {
                    $user_filter_sort_query = "post_date_time DESC";
                }

                if (isset($_GET['urgent'])) {

                    $now = date("Y-m-d H:i:s");
                    if ($_GET['urgent'] == 1) $user_filter_query .= "AND urgent > '{$now}'";
                }
                if (isset($_GET['featured'])) {

                    $now = date("Y-m-d H:i:s");
                    if ($_GET['featured'] == 1) $user_filter_query .= "AND featured_date > '{$now}'";
                }
                ?>
                <!-- center aria (adds) -->
                <div class="add-content col-7 pt-2 ps-3">
                    <?php
                    
                    if (isset($_GET['p']))
                        $last_loading_ad_id = $_GET['p'];
                    else 
                        $last_loading_ad_id = 0;
                    $is_pagination = 1;

                    $ads_counter = 0;
                    $spotlight_counter = 0; 

                    $now = new DateTime(date("Y-m-d H:i:s"));

                    $top_ads = get_adds($max_loaded_ads_count, $last_loading_ad_id, $user_filter_query, $user_filter_sort_query);
                    $normal_ads = get_adds($max_loaded_ads_count, $last_loading_ad_id, $user_filter_query, $user_filter_sort_query);
                    
                    $type = "";
                    
                    if (isset($_GET['type'])) {
                        switch ($_GET['type']) {
                            case "member" :
                                $type = 1;
                                break;
                            case "non-member" :
                                $type = 0;
                                break;
                            case "all" :
                                $type = "";
                                break;
                        }
                    }

                    $spot_light_ads = get_spot_light_ads(date("Y-m-d H:i:s"), $user_filter_query, $user_filter_sort_query, $type, 10);
                    ?>
                    <div class="pagination">
                        <nav class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="?">Home</a></li>
                                <?php 

                                if (!isset($_GET['category']) && !isset($_GET['location'])) { ?>
                                <li class="breadcrumb-item active text-capitalize"><?php echo "All Ads"; ?></li>
                                <?php } else { ?>
                                <li class="breadcrumb-item active text-capitalize"><a href="?"><?php echo "All Ads"; ?></a></li>
                                <?php
                                }

                                if (isset($_GET['category'])) {
                                    if ($_GET['category']) {
                                        $category = get_category($_GET['category'])->fetch_assoc();
                                        if (isset($_GET['location'])) { ?>
                                        <li class="breadcrumb-item text-capitalize"><a href="?category=<?php echo $category["ct_id"]; ?>"><?php echo $category['ct_name']; ?></a></li>
                                        <?php } else { ?>
                                        <li class="breadcrumb-item text-capitalize active"><?php echo $category['ct_name']; ?></li>
                                        <?php } ?>
                                        <?php
                                    }
                                }
                                if (isset($_GET['location'])) {
                                    if ($_GET['location']) {
                                        $location_name = get_location($_GET['location'])->fetch_assoc()['d_name'];
                                        ?>
                                        <li class="breadcrumb-item text-capitalize active"><?php echo $location_name; ?></li>
                                        <?php
                                    }
                                }

                                ?>
                            </ol>
                        </nav>
                    </div><!-- pagination -->

                    <?php if (true) { ?>
                    <div class="category-title">
                        <?php
                        
                        $ads_title_category = "Properties for Rent or Sale";
                        $ads_title_location = "Sri Lanka";

                        if (isset($_GET['category'])){
                            $ads_title_category = get_category($_GET['category'])->fetch_assoc()['ct_name'];
                        }
                        if (isset($_GET['location'])){
                            $ads_title_location = get_location($_GET['location'])->fetch_assoc()['d_name'];
                        }

                        $query_have_all_ads = get_adds($max_loaded_ads_count, $last_loading_ad_id, $user_filter_query, "post_date_time DESC")->num_rows;
                        $all_ads_count = get_all_ads()->num_rows;

                        ?>
                        <h2 class="mb-1 text-capitalize"><?php echo $ads_title_category . " in " . $ads_title_location; ?></h2>
                        <p class="">Showing <?php echo $is_pagination . "-" . number_format(($all_ads_count/($max_loaded_ads_count-1)), 0); ?> of <?php echo $all_ads_count; ?> ads</p>
                    </div><!-- category title -->
                    <?php } ?>          
                    <div class="">
                    <?php if ($spot_light_ads->num_rows) { ?>
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php

                            while ($spot_ad = $spot_light_ads->fetch_assoc()) {
                                
                                $spot_light_imgage = get_image_list($spot_ad['advert_id'])->fetch_assoc()['img_1'];
                                $spot_user = get_login_user($spot_ad['u_id'])->fetch_assoc();

                                $spot_company_name;
                                if ($spot_user['is_verified_seller']) {
                                    // verified seller company name set in company name
                                    $spot_company_name = get_verified_seller($spot_ad['u_id'])->fetch_assoc()['shop_name'];
                                } else {
                                    $spot_company_name = $spot_user['f_name'] . " " . $spot_user['l_name'];
                                }

                                $negotiable;
                                switch($spot_ad['cate_id']) {
                                    case 1 :
                                        $negotiable = $spot_ad['is_negotiable'] ? "pre " . $spot_ad['unit'] : "total" . " price" ;
                                        break;
                                    case 2 :
                                    case 3 :
                                        $negotiable = $spot_ad['is_negotiable'] ? " /month" : "total" ;
                                        break;
                                    case 4 :
                                        break;
                                    case 5 :
                                        break;
                                }
                            ?>
                            <div class="carousel-item user-ad-carosel-item <?php echo $spotlight_counter == 0 ? "active" : ""; ?>">
                                <img style="background-image:linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.7)),url('<?php echo "../uploads/advert/{$spot_light_imgage}";?>');" class="d-block w-100 rounded" alt="">
                                <div class="carousel-caption d-none d-md-block text-start">
                                    <input type="hidden" value="<?php echo filter_url_manager("", "") . "&advert-id=".$spot_ad['advert_id']; ?>" class="user-ad-carosel-item-id">
                                    <p class="company-name"><?php echo $spot_company_name; ?></p>
                                    <h5><?php echo $spot_ad['title']; ?></h5>
                                    <p class="price">Rs. <?php echo number_format($spot_ad['price'], 0, ".", ","); ?> <span><?php echo $negotiable; ?></span></p>
                                    <div class="badge">
                                        <?php if ($spot_user['is_verified_seller']) { ?>
                                        <div class="verified-seller-badge">
                                            <i class="fa fa-shirtsinbulk" aria-hidden="true"></i>
                                            <p>verified seller</p>
                                        </div>
                                        <?php } if ($spot_user['is_verified_member']) { ?>
                                        <div class="member-badge">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <p>member</p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="caro-top-badge">
                                    <i class="fa fa-ravelry" aria-hidden="true"></i>
                                </div> 
                            </div><!-- carousel item -->
                            <?php 
                            
                            $spotlight_counter++; }

                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        </button>
                        </div>
                    </div><!-- ads caroisel -->
                    <?php } ?>         
                    <!-- ads list -->
                    <div class="ads-list mt-3 mb-3">
                        <?php
                        $now = new DateTime(date("Y-m-d H:i:s"));

                        while ($ad = $top_ads->fetch_assoc()) {

                            if ($is_top_ad = (new DateTime($ad['top_ad']) > $now)) {

                                $ad_user = get_login_user($ad['u_id'])->fetch_assoc();

                                if (isset($_GET['type'])) {
                                    switch ($_GET['type']) {
                                        case "member" :
                                            if ($ad_user['is_verified_member']) {
                                                load_list_item($ad, $is_top_ad, $ad_user);
                                                list_item_load_counter();
                                            }
                                            break;
                                        case "non-member" :
                                            if (!($ad_user['is_verified_member'])) {
                                                load_list_item($ad, $is_top_ad, $ad_user);
                                                list_item_load_counter();
                                            }
                                            break;
                                        case "all" :
                                            load_list_item($ad, $is_top_ad, $ad_user);
                                            list_item_load_counter();
                                            break;
                                    }
                                } else {
                                    load_list_item($ad, $is_top_ad, $ad_user);
                                    list_item_load_counter();
                                }
                            } 
                        }
                        while (($ad = $normal_ads->fetch_assoc())) {

                            if (!((new DateTime($ad['top_ad']) > $now))) {

                                $ad_user = get_login_user($ad['u_id'])->fetch_assoc();

                                if (isset($_GET['type'])) {
                                    switch ($_GET['type']) {
                                        case "member" :
                                            if ($ad_user['is_verified_member']) {
                                                load_list_item($ad, false, $ad_user);
                                                list_item_load_counter();
                                            }
                                            break;
                                        case "non-member" :
                                            if (!($ad_user['is_verified_member'])) {
                                                load_list_item($ad, false, $ad_user);
                                                list_item_load_counter();
                                            }
                                            break;
                                        case "all" :
                                            load_list_item($ad, false, $ad_user);
                                            list_item_load_counter();
                                            break;
                                    }
                                } else {
                                    load_list_item($ad, false, $ad_user);
                                    list_item_load_counter();
                                }
                            }

                        }

                        function list_item_load_counter() {

                            global $ads_counter, $ad, $last_loading_ad_id;
                            $ads_counter++;
                            if ($ads_counter == 1)
                                $last_loading_ad_id = $ad['advert_id'];
                        }
                        ?>

                        <?php if (!$ads_counter) { ?>
                        <div class="text-center pt-2">
                            <i class="fa fa-inbox" aria-hidden="true" style="font-size: 3em;"></i>
                            <h5>No results found!</h5>
                            <a href="?" class="btn btn-sm btn-success mt-2">Brows all ads</a>
                        </div>
                        <?php } ?>

                        <?php function load_list_item($ad, $is_top_ad, $ad_user) { 
                        
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
                <!-- center aria (adds) -->
                <?php if ($top_ads->num_rows && $normal_ads->num_rows) { ?>
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
                        <li class="page-item">
                        <a class="page-link" href="#<?php //echo filter_url_manager("p", ""); ?><?php //echo $last_loading_ad_id; ?>" tabindex="-1" aria-disabled="true">Next</a>
                        </li>
                        </li>
                    </ul>
                </nav><!-- Pagination -->
                <?php } ?>
            </div>
            <!-- add contents end-->
            <!-- 3rt party advert ara -->
            <!-- <div class="col-2 pt-2">
                <img src="../img/zxcxz__27_.png" alt="" class="img-fluid">
                <img src="../img/zxcxz__27_.png" alt="" class="img-fluid mt-1">
                <img src="../img/zxcxz__27_.png" alt="" class="img-fluid mt-1">
            </div> -->
            <!-- 3rt party advert ara end -->
        </div>
        <!-- content end-->
    </main>
    <footer>
        <?php require_once("../library/footer.php"); ?>
    </footer>
    <!-- link js file -->
    <script src="../js/function.js"></script>
    <script src="../js/login.js"></script>
    <script src="../js/create-account.js"></script>
    <!-- link js file end-->

    <script>
        function featuredClick(cheked) {

            let featured = document.getElementById("featured");

            if (cheked) {
                window.open("?" + "<?php echo filter_url_manager("featured", ""); ?>" + "featured=0", "_self");
            } else {
                window.open("?" + "<?php echo filter_url_manager("featured", ""); ?>" + "featured=1", "_self");
            }
        }
        function urgentClick(cheked) {

            let featured = document.getElementById("urgent");
            
            if (cheked) {
                window.open("?" + "<?php echo filter_url_manager("urgent", ""); ?>" + "urgent=0", "_self");
            } else {
                window.open("?" + "<?php echo filter_url_manager("urgent", ""); ?>" + "urgent=1", "_self");
            }
        }
        function searchPrice() {

            let min = document.getElementById("min-price");
            let max = document.getElementById("max-price");

            let minPrice = min.value ? min.value : 0;
            let maxPrice = max.value;

            if (maxPrice > 0 && minPrice >= 0)
                window.open("?<?php echo filter_url_manager("min_p", "max_p"); ?>" + "min_p=" + minPrice + "&max_p=" + maxPrice, "_self");

        }
    </script>

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
