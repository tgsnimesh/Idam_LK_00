
<?php session_start(); ?>

<?php require_once("../library/ad-handler.php"); ?>
<?php require_once("../library/img-handler.php"); ?>
<?php require_once("../library/function.php"); ?>

<?php

    
    date_default_timezone_set('Asia/Colombo');
    $now_date_time = date("Y-m-d H:i:s");
    // get user post add details

    //district
    $district = $_POST['district'];
    //city
    $city = $_POST['city'];
    //category
    $category = $_POST['category'];

    // land type
    $agricultural = isset($_POST['agricultural']) ? 1 : 0;
    $residential = isset($_POST['residential']) ? 1 : 0;
    $commercial = isset($_POST['commercial']) ? 1 : 0;
    $other = isset($_POST['other']) ? 1 : 0;

    // beds and baths
    $beds = 0;
    $baths = 0;
    if ($category == 2 || $category == 3) {
        $beds = $_POST['beds'];
        $baths = $_POST['baths'];
    }

    // land info
    $land_size = $_POST['land_size'];
    $unit = $_POST['unit'];

    // size
    $size = 0;
    if ($category == 2 || $category == 3) {
        $size = $_POST['size'];
    }

    // address
    $address = $_POST['address'];

    // title
    $title = $_POST['title'];

    // discription
    $discription = $_POST['discription'];

    // price
    $price = $_POST['price'];

    // is negotiable
    $is_negotiable = isset($_POST['negotiable']) ? 1 : 0;

    // mobile_number
    $mobile_number = $_POST['mobile_number'];

    // is_mobile_hide
    $is_mobile_hide = isset($_POST['hide_mobile_number']) ? 1 : 0;

    // images
    $images = $_FILES;

    // user advert details
    $user_advert_details = [
        "district" => $district, "city" => $city, "category" => $category,
        "agricultural" => $agricultural, "residential" => $residential, "commercial" => $commercial, "other" => $other,
        "beds" => $beds,
        "baths" => $baths,
        "land_size" => $land_size, "unit" => $unit,
        "size" => $size,
        "address" => $address,
        "title" => $title,
        "discription" => $discription,
        "price" => $price,
        "is_negotiable" => $is_negotiable,
        "mobile_number" => $mobile_number,
        "is_mobile_hide" => $is_mobile_hide,
        "post_date_time" => $now_date_time, 
        "bump_up" => $now_date_time,
        "top_ad" => $now_date_time,
        "urgent" => $now_date_time,
        "spotlight" => $now_date_time,
        "featured_date" => $now_date_time
                            ];

    
    // added advert insert id
    $advert_insert_id = 0;
    $advert_target_folder = "../uploads/advert/";

    // insert advert information to the data base and return insert advert id
    $advert_insert_id = add_advert(check_is_login_user(), $user_advert_details);

    // save user advert images
    $img_counter = 1;
    $uplad_file_name;
    foreach ($images as $img_file) {
        if (!$img_file['error']) {
            
            $img_name = $advert_insert_id . "-" . $img_counter . ".jpg";
            move_uploaded_file($img_file['tmp_name'], $advert_target_folder.$img_name);
            $uplad_file_name['img-'.$img_counter] = $img_name;
            $img_counter++;
        } else 
            break;
    }
    // uplad file name save in data base
    $img_insert_id = save_advert_images($advert_insert_id, $uplad_file_name);

    // successfully post add action
    header("location: ../");

?>
