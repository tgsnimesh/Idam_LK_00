
<?php session_start(); ?>

<?php $where_from = "post"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../library/location-handler.php"); ?>
<?php require_once("../library/category-handler.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Post Ad</title>

    <!-- link head php file -->
    <?php require_once("../library/head.php"); ?>

    <!-- link css -->
    <link rel="stylesheet" href="../style/post-add.css">
    <link rel="stylesheet" href="../style/footer.css">
    <!-- link css end-->
</head>
<body>

    <header>
        <!-- link navigation bar -->
        <?php require_once("../library/nav.php"); ?>
        <!-- navigation bar end-->
    </header>

    <?php

    if (!isset($_GET['district']) || !isset($_GET['city']) || !isset($_GET['category'])) {

        page_not_founded_error("Invalid Statement !");
        die();
    } else if($_GET['district'] == null || $_GET['city'] == null || $_GET['category'] == null) {

        page_not_founded_error("Invalid Statement !");
        die();
    }

    $user_select_location = get_location($_GET['district'])->fetch_assoc();
    $user_select_sub_location = get_sub_location($_GET['city'])->fetch_assoc();
    $user_select_category = get_category($_GET['category'])->fetch_assoc();

    $user_info = get_login_user(check_is_login_user())->fetch_assoc();

    ?>

    <main>
        <div class="container my-4 p-4 rounded bg-light">
            <!-- top add location bar -->
            <div class="aria-01 border-bottom pb-3">
                <div class="left">
                    <p>Fill in the details</p>
                </div><!-- title -->
                <div class="right">
                    <div>
                        <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>
                        <p class="text-capitalize"><?php echo $user_select_location['d_name']; ?></p>
                        <a href="" data-bs-toggle="modal" data-bs-target="#add-district">Change</a>
                        <?php
                            // link district model
                            require_once("../post-add/district.php");
                        ?>
                    </div><!-- change location -->
                    <div>
                        <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>
                        <p class="text-capitalize"><?php echo $user_select_sub_location['c_name']; ?></p>
                        <a href="" data-bs-toggle="modal" data-bs-target="#add-city">Change</a>
                        <?php
                            // link city model
                            require_once("../post-add/city.php");
                        ?>
                    </div><!-- change sub location -->
                    <div>
                        <i class="fa fa-tag fa-lg" aria-hidden="true"></i>
                        <p class="text-capitalize"><?php echo $user_select_category['ct_name']; ?></p>
                        <a href="" data-bs-toggle="modal" data-bs-target="#add-category">Change</a>
                        <?php
                            // link city model
                            require_once("../post-add/category.php");
                        ?>
                    </div><!-- change location -->
                </div><!-- change location potion -->
            </div>
            <!-- top add location bar end-->

            <div class="aria-02">
                <div class="top-info">
                    <a href="">See our posting rules</a>
                </div><!-- top info -->
                <div class="post-form row">
                    <form action="../post/post.php" method="POST" enctype="multipart/form-data" class="">
                        <div>
                            <input type="hidden" name="u_id" value="<?php echo check_is_login_user(); ?>">
                            <input type="hidden" name="district" value="<?php echo $user_select_sub_location['d_id']; ?>">
                            <input type="hidden" name="city" value="<?php echo $user_select_sub_location['c_id']; ?>">
                            <input type="hidden" name="category" value="<?php echo $user_select_category['ct_id']; ?>">
                        </div><!-- user select location and ad category -->
                        <div class="col-6 m-auto">
                            <?php if ($user_select_category['ct_id'] == 1) { ?>
                            <div class="input-item row">
                                    <div class="col-12">
                                        <label class="label">Land Type</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="checkbox" name="agricultural" id="agricultural" class="" value="true">
                                        <label for="agricultural" class="d-inline ms-1 checkbox-label">Agricultural</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="checkbox" name="residential" id="residential" class="" value="true">
                                        <label for="residential" class="d-inline ms-1 checkbox-label">Residential</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="checkbox" name="commercial" id="commercial" class="" value="true">
                                        <label for="commercial" class="d-inline ms-1 checkbox-label">Commercial</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="checkbox" name="other" id="other" class="" value="true">
                                        <label for="other" class="d-inline ms-1 checkbox-label">Other</label>
                                    </div>
                                    <label for="" id="land-type-error" class="form-error" value="true"></label>
                            </div><!-- land type -->
                            <?php } ?>
                            <?php if ($user_select_category['ct_id'] == 2 || $user_select_category['ct_id'] == 3) { ?>
                                <div class="input-item row mt-4">
                                <div class="col-12">
                                    <label for="beds" class="label">Beds</label>
                                    <select name="beds" id="beds" class="form-control form-control-sm">
                                        <?php for($i = 1; $i <= 10; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        <option value="10+">10+</option>
                                    </select>
                                </div><!-- bed -->
                                <div class="col-12 mt-3">
                                    <label for="baths" class="label">Baths</label>
                                    <select name="baths" id="baths" class="form-control form-control-sm">
                                        <?php for($i = 1; $i <= 10; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        <option value="10+">10+</option>
                                    </select>
                                </div><!-- baths -->
                            </div><!-- beds and baths -->
                            <?php } ?>
                            <div class="input-item row mt-4">
                                <div class="col-6">
                                    <label for="land-size" class="label">Land Size</label>
                                    <input type="number" name="land_size" id="land-size" value="" class="form-control form-control-sm" placeholder="Enter land size and select Unit">
                                    <label for="land-size" id="land-size-error" class="form-error"></label>
                                </div>
                                <div class="col-6">
                                    <label for="unit" class="label">Unit</label>
                                    <select name="unit" id="unit" class="form-control form-control-sm">
                                        <option value="perches">Perches</option>
                                        <option value="acres">Acres</option>
                                    </select>
                                </div>
                            </div><!-- land info -->
                            <?php if ($user_select_category['ct_id'] == 2 || $user_select_category['ct_id'] == 3) { ?>
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="size" class="label"><?php echo $user_select_category['ct_id'] == 2 ? "House size" : "Size"; ?>  (sqft)</label>
                                    <input type="number" name="size" id="size" value="" class="form-control form-control-sm" placeholder="Enter the size of the house.">
                                    <label for="size" id="size-error" class="form-error"></label>
                                </div>
                            </div><!-- size -->
                            <?php } ?>
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="address" class="label">Address (optional)</label>
                                    <input type="text" name="address" id="address" value="" class="form-control form-control-sm" placeholder="Enter the street, house no. and/or post code.">
                                    <label for="address" id="address-error" class="form-error"></label>
                                </div>
                            </div><!-- Address -->
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="title" class="label">Title</label>
                                    <input type="text" name="title" id="title" value="" class="form-control form-control-sm" placeholder="Keep it short !">
                                    <label for="title" id="title-error" class="form-error"></label>
                                </div>
                            </div><!-- Title -->
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="discription" class="label">Discription</label>
                                    <label for="discription" class="label float-end" id="discriptino-counter">0/5000</label>
                                    <textArea name="discription" id="discription" class="form-contol form-contol-sm w-100 p-2" rows=5 placeholder="More details = more responses !"></textArea>
                                    <label for="discription" id="discription-error" class="form-error"></label>
                                </div>
                            </div><!-- Discription -->
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="price" class="label">Rent (Rs) /<?php echo $user_select_category == 1 ? "year" : "month"; ?></label>
                                    <input type="number" name="price" id="price" value="" class="form-control form-control-sm" placeholder="Pick an attractive lease rate.">
                                    <label for="price" id="price-error" class="form-error"></label>
                                </div>
                            </div><!-- Price -->
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <input type="checkbox" name="negotiable" id="negotiable" value="true" class="mb-2">
                                    <label for="negotiable" class="d-inline ms-1 checkbox-label">Negotiable</label>
                                </div>
                            </div><!-- Negotiable -->
                        </div>
                        <div class="border-bottom mt-4"></div>
                        <!-- add image -->
                        <div class="col-6 m-auto">
                            <div class="input-item row">
                                <p class="sub-title">Add up to 5 photos<i class="fa fa-question" aria-hidden="true"></i></p>
                                <div class="image-list">
                                    <input type="file" name="img_1" id="img-1" class="form-control form-control-sm mt-2">
                                    <input type="file" name="img_2" id="img-2" hidden class="form-control form-control-sm mt-1">
                                    <input type="file" name="img_3" id="img-3" hidden class="form-control form-control-sm mt-1">
                                    <input type="file" name="img_4" id="img-4" hidden class="form-control form-control-sm mt-1">
                                    <input type="file" name="img_5" id="img-5" hidden class="form-control form-control-sm mt-1">
                                </div>
                                <label for="" id="img-error" class="form-error mt-1"></label>
                                <img src="" alt="" id="select-img" class="mt-2 img-fluid" style="width: 100%; max-height: 300px; object-fit: cover; object-position: center;" alt="">
                            </div>
                        </div>
                        <!-- add image end-->
                        <div class="border-bottom mt-4"></div>
                        <!-- contact delails -->
                        <div class="col-6 m-auto">
                            <div class="input-item row">
                                <p class="sub-title">Contact Details</p>
                                <div class="col-6">
                                    <label for="" class="label">Name</label>
                                    <p class="name text-capitalize"><?php echo $user_info['f_name'] . " " . $user_info['l_name']; ?></p>
                                    <label for="" class="label">E-mail</label>
                                    <p class="email"><?php echo $user_info['email']; ?></p>
                                </div><!-- user info (name, email)-->
                            </div>
                            <div class="input-item row mt-1">
                                <div class="col-12 border pt-2 pb-3 px-3 mt-2">
                                    <label for="mobile-number" class="label mb-3">Phone Number</label>
                                    <input type="number" name="mobile_number" id="mobile-number" value="" class="form-control form-control-sm" placeholder="Enter your phone number here.">
                                    <input type="checkbox" name="hide_mobile_number" id="hide-mobile-number" class="mt-3">
                                    <label for="hide-mobile-number" class="d-inline ms-1 checkbox-label">Hide Phone Number</label>
                                </div>
                            </div>
                            <label for="mobile-number" id="mobile-number-error" class="form-error"></label><!-- address -->
                        </div>
                        <!-- contact delails end-->
                        <div class="input-item row mb-4">
                            <div class="col-6 m-auto p-0 mt-3 row">
                                <button type="submit" id="btn-post-add" class="btn btn-success btn-sm p-2 col-5 ms-auto" disabled>Post Add</button>
                            </div>
                        </div><!-- post add button -->
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>
    <?php require_once("../library/footer.php"); ?>
    </footer>

    <!-- link javascript file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="../js/post.js"></script>
    <!-- link javascript file end-->
</body>
</html>
