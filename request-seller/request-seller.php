
<?php require_once("../library/verified-seller-handler.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>
<?php require_once("../library/shop-timing-handler.php"); ?>

<?php
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
    echo "</pre>";
    
    $cover_image_name = "";
    $logo_name = "";

    $now = date("Y-m-d H:i:s");

    if (isset($_FILES['cover_image'])) {

        if (!$_FILES['cover_image']['error'])
            $cover_image_name = "c-" . $_POST['u_id'] . ".jpg";
    }

    if (isset($_FILES['company_logo_image'])) {

        if (!$_FILES['company_logo_image']['error'])
            $logo_name = "l-" . $_POST['u_id'] . ".jpg";
    }

    $seller_details = array(
        "u_id" => $_POST['u_id'],
        "shop_name" => $_POST['shop_name'],
        "shop_title" => $_POST['shop_title'],
        "website" => $_POST['website'],
        "shop_address" => $_POST['shop_address'],
        "about_shop" => $_POST['about_shop'],
        "phone_number" => $_POST['phone_number'],
        "hide_phone_number" => isset($_POST['hide_phone_number']),
        "email" => $_POST['email'],
        "cover_image" => $cover_image_name,
        "logo" => $logo_name,
        "created_dt" => $now
    );

    $seller_timings = array(
        "monday_open" => $_POST['monday_open'],
        "monday_close" => $_POST['monday_close'],
        "monday_is_close" => (isset($_POST['monday_is_close'])) ? 1 : 0,
        "tuesday_open" => $_POST['tuesday_open'],
        "tuesday_close" => $_POST['tuesday_close'],
        "tuesday_is_close" => (isset($_POST['tuesday_is_close'])) ? 1 : 0,
        "wednesday_open" => $_POST['wednesday_open'],
        "wednesday_close" => $_POST['wednesday_close'],
        "wednesday_is_close" => (isset($_POST['wednesday_is_close'])) ? 1 : 0,
        "thursday_open" => $_POST['thursday_open'],
        "thursday_close" => $_POST['thursday_close'],
        "thursday_is_close" => (isset($_POST['thursday_is_close'])) ? 1 : 0,
        "friday_open" => $_POST['friday_open'],
        "friday_close" => $_POST['friday_close'],
        "friday_is_close" => (isset($_POST['friday_is_close'])) ? 1 : 0,
        "saturday_open" => $_POST['saturday_open'],
        "saturday_close" => $_POST['saturday_close'],
        "saturday_is_close" => (isset($_POST['saturday_is_close'])) ? 1 : 0,
        "sunday_open" => $_POST['sunday_open'],
        "sunday_close" => $_POST['sunday_close'],
        "sunday_is_closed" => (isset($_POST['sunday_is_closed'])) ? 1 : 0 
    );

    $insert_verified_seller_id = regiser_seller($seller_details);

    set_timings($seller_details['u_id'], $seller_timings);

    if ($insert_verified_seller_id) {

        $root_cover_image_location = "../uploads/seller-shop-cover/";
        $root_logo_location = "../uploads/seller-shop-logo/";

        if (isset($_FILES['cover_image'])) {

            if (!$_FILES['cover_image']['error'])
                move_uploaded_file($_FILES['cover_image']['tmp_name'], ($root_cover_image_location.$cover_image_name));
        }
        if (isset($_FILES['company_logo_image'])) {
            
            if (!$_FILES['company_logo_image']['error'])
                move_uploaded_file($_FILES['company_logo_image']['tmp_name'], ($root_logo_location.$logo_name));
        }
    }

    // updatea is verified seller
    if (register_verified_seller($_POST['u_id']))
        header("location: ../account/?acc=membership");

?>