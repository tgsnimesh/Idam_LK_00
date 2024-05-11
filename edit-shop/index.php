
<?php session_start(); ?>

<?php $where_from = "request_seller"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>
<?php require_once("../library/location-handler.php"); ?>
<?php require_once("../library/verified-seller-handler.php"); ?>
<?php require_once("../library/shop-timing-handler.php"); ?>

<?php
    if (!check_is_login_user()) {

        header("location: ../");
    }
    if (isset($_GET['id'])) {

        if (check_is_login_user() == $_GET['id']) {

            $seller = get_verified_seller($_GET['id'])->fetch_assoc();
            $timigs = select_timings($seller['u_id'])->fetch_assoc();
        }else {

            header("location: ?id=" . check_is_login_user());
        }
    } else {

        header("location: ?id=" . check_is_login_user());
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Shop</title>

    <!-- link head php file -->
    <?php require_once("../library/head.php"); ?>

    <!-- link css -->
    <link rel="stylesheet" href="../style/content.css">
    <link rel="stylesheet" href="../style/membership.css">
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
        <div class="container aria-1 my-4 rounded">
            <form action="edit-shop.php" enctype="multipart/form-data" method="POST">
                <div class="company-image-aria">
                    <div class="cover-image">
                        <img src="../<?php echo $seller['cover_img'] ? "uploads/seller-shop-cover/" . $seller['cover_img'] : "img/system-default-image/company-cover-image.jpg"; ?>" alt="" id="cover-image" class="img-fluid py-2 img-fluid">
                    </div>
                    <div class="company-logo">
                        <img src="../<?php echo $seller['logo'] ? "uploads/seller-shop-logo/" . $seller['logo'] : "img/system-default-logo/company-logo.jpg"; ?>" alt="" id="logo-image" class="img-fluid py-2">
                    </div>
                    <div class="company-image-input-aria py-2">
                        <label for="" class="mt-2">Update shop cover image</label>
                        <input type="file" name="cover_image" id="cover-img-file" class=" form-control form-control-sm shadow">
                        <input type="hidden" name="cover_image_name" value="<?php echo $seller['cover_img']; ?>">
                        <?php if ($seller['cover_img']) { ?>
                        <div class="d-flex align-items-center text-danger">
                            <input type="checkbox" id="delete_cover_image" name="is_delete_cover_image" value="true" class="mt-1 me-1" style="accent-color: red;">
                            <label for="delete_cover_image" style="text-shadow: none;">delete cover image</label>
                        </div>
                        <?php } ?>
                        <label for="" id="c-image-error" class="input-error cover-image-error shadow-none"></label>
                        <label for="" class="mt-2">Update shop logo</label>
                        <input type="file" name="company_logo_image" id="logo-file" class="form-control form-control-sm shadow">
                        <input type="hidden" name="company_logo_image_name" value="<?php echo $seller['logo']; ?>">
                        <?php if ($seller['logo']) { ?>
                        <div class="d-flex align-items-center text-danger">
                            <input type="checkbox" id="delete_logo" name="is_delete_logo" value="true" class="mt-1 me-1" style="accent-color: red;">
                            <label for="delete_logo" style="text-shadow: none;">delete logo</label>
                        </div>
                        <?php } ?>
                        <label for="" id="l-image-error" class="input-error logo-image-error shadow-none"></label>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-6 m-auto shop-details">
                            <input type="hidden" name="u_id" value="<?php echo check_is_login_user(); ?>">
                            <p class="title">Fill in Details & Register your shop</p>
                            <div class="shop-name mt-3">
                                <div class="input-item">
                                    <label for="shop-name" class="input-item-label">Shop name</label>
                                    <input type="text" name="shop_name" id="shop-name" class="form-control form-control-sm" placeholder="Enter your shop name here" value="<?php echo $seller['shop_name']; ?>">
                                    <label for="shop-name" id="shop-name-error" class="input-error"></label>
                                </div>
                            </div><!-- Shop Name -->
                            <div class="shop-title">
                                <div class="input-item">
                                    <label for="shop-title" class="input-item-label">Shop title</label>
                                    <input type="text" name="shop_title" id="shop-title" class="form-control form-control-sm" placeholder="Enter your short shop title" value="<?php echo $seller['shop_title']; ?>">
                                    <label for="shop-title" id="shop-title-error" class="input-error"></label>
                                </div>
                            </div><!-- Shop title -->
                            <div class="website">
                                <div class="input-item">
                                    <label for="website" class="input-item-label">Website (URL)</label>
                                    <input type="text" name="website" id="website" class="form-control form-control-sm" placeholder="Enter your shop website URL here" value="<?php echo $seller['website']; ?>">
                                    <label for="website" id="website-error" class="input-error"></label>
                                </div>
                            </div><!-- Shop website ( url ) -->
                            <div class="shop-address">
                                <div class="input-item">
                                    <label for="shop-address" class="input-item-label">Shop address</label>
                                    <input type="text" name="shop_address" id="shop-address" class="form-control form-control-sm" placeholder="Enter your company address here" value="<?php echo $seller['shop_address']; ?>">
                                    <label for="shop-address" id="shop-address-error" class="input-error"></label>
                                </div>
                            </div><!-- Shop address -->
                            <div class="sbout-shop">
                                <div class="input-item">
                                    <label for="shop-address" class="input-item-label">About the shop</label>
                                    <textarea name="about_shop" id="about-shop" rows="6" class="form-control form-control-sm w-100" placeholder="Enter here about your shop"><?php echo $seller['about_shop']; ?></textarea>
                                    <label for="shop-address" id="about-shop-error" class="input-error"></label>
                                </div>
                            </div><!-- About shop -->
                            <div class="shop-timings">
                                <div class="border p-3 input-item">
                                    <p class="contact-label mb-1">Shop Timings</p>
                                    <p class="notice">Setup your shop open & close timings.</p>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#shopTimingsModel"><i class="fa fa-calendar" aria-hidden="true"></i>Setup</a>
                                </div>
                            </div><!-- Shop timings -->
                            <div class="input-item">
                                <div class="border pt-2 pb-3 px-3 mt-4">
                                    <label for="phone-number" class="contact-label mb-2">Phone Number</label>
                                    <input type="number" name="phone_number" id="phone-number" value="<?php echo $seller['phonenumber']; ?>" class="form-control form-control-sm" placeholder="Enter your phone number here">
                                    <input type="checkbox" name="hide_phone_number" id="hide-phone-number" value="true" class="mt-3" <?php echo $seller['is_hide_phonenumber'] ? "checked" : ""; ?>>
                                    <label for="hide-phone-number" class="d-inline ms-1 checkbox-label">Hide Phone Number</label>
                                </div>
                                <label for="phone-number" id="phone-number-error" class="input-error"></label>
                            </div><!-- Shop phone number -->
                            <div class="input-item">
                                <div class="border pt-2 pb-3 px-3 mt-2">
                                    <label for="email" class="contact-label mb-2">E-Mail</label>
                                    <input type="email" name="email" id="shop-email" value="<?php echo $seller['email']; ?>" class="form-control form-control-sm" placeholder="Enter your email">
                                </div>
                                <label for="email" id="shop-email-error" class="input-error"></label>
                            </div><!-- Shop email -->
                            <div class="submit-button text-end mt-2 mb-5">
                                <button type="submit" id="btn-regiser-shop" class="btn btn-success btn-sm px-3 me-auto">Change & Save Your Shop</button>
                            </div>
                            <!-- Shop timings model -->
                            <div class="modal fade shop-timings-model" id="shopTimingsModel" tabindex="-1" aria-labelledby="shopTimingsModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="shopTimingsModelLabel">Set shop Open & Close timings.</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="timings-box">
                                                <div class="day">
                                                    <p class="day-name"></p>
                                                    <input type="text" value="Open" disabled class="text-center day-input form-control form-control-sm">
                                                    <input type="text" value="Close" disabled class="text-center day-input form-control form-control-sm">
                                                </div>
                                                <div class="day mt-1">
                                                    <p class="day-name">Monday</p>
                                                    <input type="time" name="monday_open" class="day-input form-control form-control-sm" value="<?php echo $timigs['monday_open']; ?>">
                                                    <input type="time" name="monday_close" class="day-input form-control form-control-sm" value="<?php echo ($timigs['monday_open'] != 0 && $timigs['monday_close'] != 0 ? $timigs['monday_close'] : "23:59"); ?>">
                                                    <input type="checkbox" name="monday_is_close" class="ms-2" value="true" <?php echo $timigs['monday_is_closed'] ? "checked" : ""; ?>>
                                                </div>
                                                <div class="day mt-2">
                                                    <p class="day-name">Tuesday</p>
                                                    <input type="time" name="tuesday_open" class="day-input form-control form-control-sm" value="<?php echo $timigs['tuesday_open']; ?>">
                                                    <input type="time" name="tuesday_close" class="day-input form-control form-control-sm" value="<?php echo ($timigs['tuesday_open'] != 0 && $timigs['tuesday_close'] != 0 ? $timigs['tuesday_close'] : "23:59"); ?>">
                                                    <input type="checkbox" name="tuesday_is_close" class="ms-2" value="true" <?php echo $timigs['tuesday_is_closed'] ? "checked" : ""; ?>>
                                                </div>
                                                <div class="day mt-2">
                                                    <p class="day-name">Wednesday</p>
                                                    <input type="time" name="wednesday_open" class="day-input form-control form-control-sm" value="<?php echo $timigs['wednesday_open']; ?>">
                                                    <input type="time" name="wednesday_close" class="day-input form-control form-control-sm" value="<?php echo ($timigs['wednesday_open'] != 0 && $timigs['wednesday_close'] != 0 ? $timigs['wednesday_close'] : "23:59"); ?>">
                                                    <input type="checkbox" name="wednesday_is_close" class="ms-2" value="true" <?php echo $timigs['wednesday_is_closed'] ? "checked" : ""; ?>>
                                                </div>
                                                <div class="day mt-2">
                                                    <p class="day-name">Thursday</p>
                                                    <input type="time" name="thursday_open" class="day-input form-control form-control-sm" value="<?php echo $timigs['thursday_open']; ?>">
                                                    <input type="time" name="thursday_close" class="day-input form-control form-control-sm" value="<?php echo ($timigs['thursday_open'] != 0 && $timigs['thursday_close'] != 0 ? $timigs['thursday_close'] : "23:59"); ?>">
                                                    <input type="checkbox" name="thursday_is_close" class="ms-2" value="true" <?php echo $timigs['thursday_is_closed'] ? "checked" : ""; ?>>
                                                </div>
                                                <div class="day mt-2">
                                                    <p class="day-name">Friday</p>
                                                    <input type="time" name="friday_open" class="day-input form-control form-control-sm" value="<?php echo $timigs['friday_open']; ?>">
                                                    <input type="time" name="friday_close" class="day-input form-control form-control-sm" value="<?php echo ($timigs['friday_open'] != 0 && $timigs['friday_close'] != 0 ? $timigs['friday_close'] : "23:59"); ?>">
                                                    <input type="checkbox" name="friday_is_close" class="ms-2" value="true" <?php echo $timigs['friday_is_closed'] ? "checked" : ""; ?>>
                                                </div>
                                                <div class="day mt-2">
                                                    <p class="day-name">Saturday</p>
                                                    <input type="time" name="saturday_open" class="day-input form-control form-control-sm" value="<?php echo $timigs['saturday_open']; ?>">
                                                    <input type="time" name="saturday_close" class="day-input form-control form-control-sm" value="<?php echo ($timigs['saturday_open'] != 0 && $timigs['saturday_close'] != 0 ? $timigs['saturday_close'] : "23:59"); ?>">
                                                    <input type="checkbox" name="saturday_is_close" class="ms-2" value="true" <?php echo $timigs['saturday_is_closed'] ? "checked" : ""; ?>>
                                                </div>
                                                <div class="day mt-2">
                                                    <p class="day-name">Sunday</p>
                                                    <input type="time" name="sunday_open" class="day-input form-control form-control-sm" value="<?php echo $timigs['sunday_open']; ?>">
                                                    <input type="time" name="sunday_close" class="day-input form-control form-control-sm" value="<?php echo ($timigs['sunday_open'] != 0 && $timigs['sunday_close'] != 0 ? $timigs['sunday_close'] : "23:59"); ?>">
                                                    <input type="checkbox" name="sunday_is_closed" class="ms-2" value="true" <?php echo $timigs['sunday_is_closed'] ? "checked" : ""; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer p-0 m-0">
                                            <button type="button" class="btn btn-primary btn-sm mx-3 my-2 px-3" data-bs-dismiss="modal">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Shop timings model end-->
                    </div>
                </div>
            </form>
        </div>
    </main>
    <footer>
    <?php require_once("../library/footer.php"); ?>
    </footer>

    <!-- link js file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="../js/function.js"></script>
    <script src="../js/edit-seller.js"></script>
    <!-- link js file end-->
</body>
</html>
