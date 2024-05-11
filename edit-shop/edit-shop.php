
<?php require_once("../library/verified-seller-handler.php"); ?>
<?php require_once("../library/shop-timing-handler.php"); ?>

<?php

    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    $cover_image_name = "";
    $logo_name = "";

    if (isset($_POST['is_delete_cover_image'])) {

        $cover_image_name = "";
    } else if (isset($_FILES['cover_image'])){

        if (!$_FILES['cover_image']['error'])
            $cover_image_name = "c-" . $_POST['u_id'] . ".jpg";
        else
            $cover_image_name = $_POST['cover_image_name'];
    }

    if (isset($_POST['is_delete_logo'])) {

        $logo_name = "";
    } else if (isset($_FILES['company_logo_image'])){

        if (!$_FILES['company_logo_image']['error'])
            $logo_name = "l-" . $_POST['u_id'] . ".jpg";
        else 
            $logo_name = $_POST['company_logo_image_name'];
    }

    $seller_details = array(
        "u_id" => $_POST['u_id'],
        "shop_name" => $_POST['shop_name'],
        "shop_title" => $_POST['shop_title'],
        "website" => $_POST['website'],
        "shop_address" => $_POST['shop_address'],
        "about_shop" => $_POST['about_shop'],
        "phone_number" => $_POST['phone_number'],
        "hide_phone_number" => (isset($_POST['hide_phone_number']) ? 1 : 0),
        "email" => $_POST['email'],
        "cover_image" => $cover_image_name,
        "logo" => $logo_name,
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

    $affecte_rows = update_seller_shop($seller_details['u_id'], $seller_details);
    update_timings($_POST['u_id'], $seller_timings);

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

    // update is verified seller
    header("location: ../account/?acc=membership");

?>
