
<?php session_start(); ?>

<?php require_once("../library/ad-handler.php"); ?>
<?php require_once("../library/img-handler.php"); ?>
<?php require_once("../library/function.php"); ?>

<?php

    date_default_timezone_set('Asia/Colombo');
    $now_date_time = date("Y-m-d H:i:s");
    // get user post add details

    // advert id
    $advert_id = $_POST['advert_id']; 

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
        "is_mobile_hide" => $is_mobile_hide
    ];
    
    // added advert insert id
    $advert_target_folder = "../uploads/advert/";

    // update advert information to the data base and return affected advert id
    $affected_rows = update_advert($advert_id, $user_advert_details);

    //save user advert images
    $img_counter = 1;
    $uplad_file_name = "";
    foreach ($images as $img_file) {
        if (!$img_file['error']) {
            
            $img_name = $advert_id . "-" . $img_counter . ".jpg";
            move_uploaded_file($img_file['tmp_name'], $advert_target_folder.$img_name);
            $name = "img_delete_{$img_counter}";
            if (isset($_POST[$name])) {
                $update_img = update_images($advert_id, $img_counter, "");
            } else {
                $uplad_file_name['img-'.$img_counter] = $img_name;
                $update_img = update_images($advert_id, $img_counter, $img_name);
            }
        }
        $img_counter++;
    }

    for ($i = 1; $i <= 5; $i++) {
        $name = "img_delete_{$i}";
        if (isset($_POST[$name])) {
            $update_img = update_images($advert_id, $i, "");
        }
    }

    // successfully post add action
    header("location: ../account/?acc=dashboard&update=true");

?>
