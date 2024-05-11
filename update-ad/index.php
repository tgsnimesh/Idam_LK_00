
<?php session_start(); ?>

<?php $where_from = "update-ad"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../library/location-handler.php"); ?>
<?php require_once("../library/category-handler.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>
<?php require_once("../library/ad-handler.php"); ?>
<?php require_once("../library/img-handler.php"); ?>

<?php $user_info = get_login_user(check_is_login_user())->fetch_assoc(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Update Ad</title>

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
    
    $ad = get_adds(1, 0, " AND advert_id = {$_GET['ad']} ", " advert_id ASC ")->fetch_assoc();

    if ($ad['u_id'] != check_is_login_user()) {
        header("location: ../account/?acc=dashboard");
    }

    $ad_img = get_image_list($ad['advert_id'])->fetch_assoc();

    $ad_owner = get_login_user($ad['u_id'])->fetch_assoc();

    // user insert default advert location & category
    $city = $ad['city_id'];
    $dis = $ad['dis_id'];
    $cate = $ad['cate_id'];

    // cange default assign location and category to new user change location & catergory 
    if (isset($_GET['district']))
        $dis = $_GET['district'];

    if (isset($_GET['city']))
        $city = $_GET['city'];

    if (isset($_GET['category']))
        $cate = $_GET['category'];

    // get new or user insert default location & category
    $select_district = get_location($dis)->fetch_assoc();
    $select_city = get_search_sub_locations(" c_id = {$city} ")->fetch_assoc();
    $select_category = get_category($cate)->fetch_assoc(); 
    ?>
    <main>
        <div class="container my-4 p-4 rounded bg-light">
            <!-- top add location bar -->
            <div class="aria-01 border-bottom pb-3">
                <div class="left">
                    <p>Update in the Ad</p>
                </div><!-- title -->
                <div class="right">
                    <div>
                        <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>
                        <p class="text-capitalize"><?php echo $select_district['d_name']; ?></p>
                        <a href="" data-bs-toggle="modal" data-bs-target="#add-district">Change</a>
                        <?php
                            // link district model
                            require_once("../post-add/district.php");
                        ?>
                    </div><!-- change location -->
                    <div>
                        <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>
                        <p class="text-capitalize"><?php echo $select_city['c_name']; ?></p>
                        <a href="" data-bs-toggle="modal" data-bs-target="#add-city">Change</a>
                        <?php
                            // link city model
                            require_once("../post-add/city.php");
                        ?>
                    </div><!-- change sub location -->
                    <div>
                        <i class="fa fa-tag fa-lg" aria-hidden="true"></i>
                        <p class="text-capitalize"><?php echo $select_category['ct_name']; ?></p>
                        <a href="" data-bs-toggle="modal" data-bs-target="#add-category">Change</a>
                        <?php
                            // link category model
                            require_once("../post-add/category.php");
                        ?>
                    </div><!-- change category -->
                </div><!-- change location potion -->
            </div>
            <!-- top add location bar end-->
            <div class="aria-02">
                <div class="top-info">
                    <a href="">See our posting rules</a>
                </div><!-- top info -->
                <div class="post-form row">
                    <form action="../update-ad/update.php" method="POST" enctype="multipart/form-data" class="">
                        <div>
                            <input type="hidden" name="u_id" value="<?php echo $ad['u_id']; ?>">
                            <input type="hidden" name="advert_id" value="<?php echo $ad['advert_id']; ?>">
                            <input type="hidden" name="district" value="<?php echo $select_district['d_id']; ?>">
                            <input type="hidden" name="city" value="<?php echo $select_city['c_id']; ?>">
                            <input type="hidden" name="category" value="<?php echo $select_category['ct_id']; ?>">
                        </div><!-- user select location and ad category -->
                        <div class="col-6 m-auto">
                            <?php if ($select_category['ct_id'] == 1) { ?>
                            <div class="input-item row">
                                    <div class="col-12">
                                        <label class="label">Land Type</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="checkbox" name="agricultural" id="agricultural" class="" value="true" <?php echo $ad['is_agricultural'] == 1 ? "checked" : ""; ?>>
                                        <label for="agricultural" class="d-inline ms-1 checkbox-label">Agricultural</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="checkbox" name="residential" id="residential" class="" value="true" <?php echo $ad['is_residential'] == 1 ? "checked" : ""; ?>>
                                        <label for="residential" class="d-inline ms-1 checkbox-label">Residential</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="checkbox" name="commercial" id="commercial" class="" value="true" <?php echo $ad['is_commercial'] == 1 ? "checked" : ""; ?>>
                                        <label for="commercial" class="d-inline ms-1 checkbox-label">Commercial</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="checkbox" name="other" id="other" class="" value="true" <?php echo $ad['is_other'] == 1 ? "checked" : ""; ?>>
                                        <label for="other" class="d-inline ms-1 checkbox-label">Other</label>
                                    </div>
                                    <label for="" id="land-type-error" class="form-error" value="true"></label>
                            </div><!-- land type -->
                            <?php } ?>
                            <?php if ($select_category['ct_id'] == 2 || $select_category['ct_id'] == 3) { ?>
                                <div class="input-item row mt-4">
                                <div class="col-12">
                                    <label for="beds" class="label">Beds</label>
                                    <select name="beds" id="beds" class="form-control form-control-sm">
                                        <?php for($i = 1; $i <= 10; $i++) { ?>
                                        <option value="<?php echo $i; ?>" <?php echo $ad['beds'] == $i ? "selected" : ""; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                        <option value="10+" <?php echo $ad['beds'] == "10+" ? "selected" : ""; ?>>10+</option>
                                    </select>
                                </div><!-- bed -->
                                <div class="col-12 mt-3">
                                    <label for="baths" class="label">Baths</label>
                                    <select name="baths" id="baths" class="form-control form-control-sm">
                                        <?php for($i = 1; $i <= 10; $i++) { ?>
                                        <option value="<?php echo $i; ?>" <?php echo $ad['baths'] == $i ? "selected" : ""; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                        <option value="10+" <?php echo $ad['baths'] == "10+" ? "selected" : ""; ?>>10+</option>
                                    </select>
                                </div><!-- baths -->
                            </div><!-- beds and baths -->
                            <?php } ?>
                            <div class="input-item row mt-4">
                                <div class="col-6">
                                    <label for="land-size" class="label">Land Size</label>
                                    <input type="number" name="land_size" id="land-size" value="<?php echo $ad['land_size']; ?>" class="form-control form-control-sm" placeholder="Enter land size and select Unit">
                                    <label for="land-size" id="land-size-error" class="form-error"></label>
                                </div>
                                <div class="col-6">
                                    <label for="unit" class="label">Unit</label>
                                    <select name="unit" id="unit" class="form-control form-control-sm">
                                        <option value="perches" <?php echo $ad['unit'] == "perches" ? "selected" : ""; ?>>Perches</option>
                                        <option value="acres" <?php echo $ad['unit'] == "acres" ? "selected" : ""; ?>>Acres</option>
                                    </select>
                                </div>
                            </div><!-- land info -->
                            <?php if ($select_category['ct_id'] == 2 || $select_category['ct_id'] == 3) { ?>
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="size" class="label"><?php echo $select_category['ct_id'] == 2 ? "House size" : "Size"; ?>  (sqft)</label>
                                    <input type="number" name="size" id="size" value="<?php echo $ad['size']; ?>" class="form-control form-control-sm" placeholder="Enter the size of the house.">
                                    <label for="size" id="size-error" class="form-error"></label>
                                </div>
                            </div><!-- size -->
                            <?php } ?>
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="address" class="label">Address (optional)</label>
                                    <input type="text" name="address" id="address" value="<?php echo $ad['advert_address']; ?>" class="form-control form-control-sm" placeholder="Enter the street, house no. and/or post code.">
                                    <label for="address" id="address-error" class="form-error"></label>
                                </div>
                            </div><!-- Address -->
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="title" class="label">Title</label>
                                    <input type="text" name="title" id="title" value="<?php echo $ad['title']; ?>" class="form-control form-control-sm" placeholder="Keep it short !">
                                    <label for="title" id="title-error" class="form-error"></label>
                                </div>
                            </div><!-- Title -->
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="discription" class="label">Discription</label>
                                    <label for="discription" class="label float-end" id="discriptino-counter"><?php echo strlen($ad['discription']); ?>/5000</label>
                                    <textArea name="discription" id="discription" class="form-contol form-contol-sm w-100 p-2" rows=10 placeholder="More details = more responses !"><?php echo $ad['discription']; ?></textArea>
                                    <label for="discription" id="discription-error" class="form-error"></label>
                                </div>
                            </div><!-- Discription -->
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <label for="price" class="label">Rent (Rs) /<?php echo $select_category['ct_id'] == 1 ? "year" : "month"; ?></label>
                                    <input type="number" name="price" id="price" value="<?php echo $ad['price']; ?>" class="form-control form-control-sm" placeholder="Pick an attractive lease rate.">
                                    <label for="price" id="price-error" class="form-error"></label>
                                </div>
                            </div><!-- Price -->
                            <div class="input-item row mt-1">
                                <div class="col-12">
                                    <input type="checkbox" name="negotiable" id="negotiable" value="true" class="mb-2" <?php echo $ad['is_negotiable'] == 1 ? "checked" : ""; ?>>
                                    <label for="negotiable" class="d-inline ms-1 checkbox-label">Negotiable</label>
                                </div>
                            </div><!-- Negotiable -->
                        </div>
                        <div class="border-bottom mt-4"><!-- |border bottom| --></div>
                        <!-- add image -->
                        <div class="col-6 m-auto">
                            <div class="input-item">
                                <p class="sub-title">Update or Delete photos<i class="fa fa-question" aria-hidden="true"></i></p>
                                <div class="image-list">
                                    <div class="d-flex" style="align-items: center;">
                                        <input type="file" name="img_1" id="img-1" class="form-control form-control-sm mt-2">
                                        <p class="m-0 ms-2 text-primary"><?php echo $ad_img['img_1'] ? "Change" : "Add+"; ?></p>
                                    </div>
                                    <div class="d-flex" style="align-items: center;" id="img-container-2">
                                        <input type="file" name="img_2" id="img-2" class="form-control form-control-sm mt-1">
                                        <p class="m-0 ms-2 text-primary"><?php echo $ad_img['img_2'] ? "Change" : "Add+"; ?></p>
                                    </div>     
                                    <div class="d-flex" style="align-items: center;" id="img-container-3">
                                        <input type="file" name="img_3" id="img-3" class="form-control form-control-sm mt-1">
                                        <p class="m-0 ms-2 text-primary"><?php echo $ad_img['img_3'] ? "Change" : "Add+"; ?></p>
                                    </div>         
                                    <div class="d-flex" style="align-items: center;" id="img-container-4">
                                        <input type="file" name="img_4" id="img-4" class="form-control form-control-sm mt-1">
                                        <p class="m-0 ms-2 text-primary"><?php echo $ad_img['img_4'] ? "Change" : "Add+"; ?></p>
                                    </div>        
                                    <div class="d-flex" style="align-items: center;" id="img-container-5">
                                        <input type="file" name="img_5" id="img-5" class="form-control form-control-sm mt-1">
                                        <p class="m-0 ms-2 text-primary"><?php echo $ad_img['img_5'] ? "Change" : "Add+"; ?></p>
                                    </div> 
                                </div>
                                <label for="" id="img-error" class="form-error mt-1"></label>
                                <div class="row">
                                    <div class="col-2 p-0 pe-1">
                                        <img src="<?php echo "../uploads/advert/{$ad_img['img_1']}"; ?>" alt="" id="show-img-1" class="mt-2 img-fluid" style="width:100%; height: 80px; object-fit: cover; object-position: center;" alt="">
                                    </div>
                                    <div class="col-2 p-0 pe-1 position-relative" >
                                        <img src="<?php echo "../uploads/advert/{$ad_img['img_2']}"; ?>" alt="" id="show-img-2" class="mt-2 img-fluid" style="width:100 ; height: 80px; object-fit: cover; object-position: center;" alt="">
                                        <?php if ($ad_img['img_2']) { ?>
                                            <input type="checkbox" name="img_delete_2" id="img-delete-2" class="me-2" style="accent-color: red; width:18px; height: 18px; position: absolute; left: 2px; top: 10px; cursor: pointer;" title="Check to Delete Image.">
                                        <?php  } ?>
                                    </div>
                                    <div class="col-2 p-0 pe-1 position-relative" >
                                        <img src="<?php echo "../uploads/advert/{$ad_img['img_3']}"; ?>" alt="" id="show-img-3" class="mt-2 img-fluid" style="width:100 ; height: 80px; object-fit: cover; object-position: center;" alt="">
                                        <?php if ($ad_img['img_3']) { ?>
                                            <input type="checkbox" name="img_delete_3" id="img-delete-3" class="me-2" style="accent-color: red; width:18px; height: 18px; position: absolute; left: 2px; top: 10px; cursor: pointer;" title="Check to Delete Image.">
                                        <?php  } ?>
                                    </div>
                                    <div class="col-2 p-0 pe-1 position-relative" >
                                        <img src="<?php echo "../uploads/advert/{$ad_img['img_4']}"; ?>" alt="" id="show-img-4" class="mt-2 img-fluid" style="width:100 ; height: 80px; object-fit: cover; object-position: center;" alt="">
                                        <?php if ($ad_img['img_4']) { ?>
                                            <input type="checkbox" name="img_delete_4" id="img-delete-4" class="me-2" style="accent-color: red; width:18px; height: 18px; position: absolute; left: 2px; top: 10px; cursor: pointer;" title="Check to Delete Image.">
                                        <?php  } ?>
                                    </div>
                                    <div class="col-2 p-0 pe-1 position-relative" >
                                        <img src="<?php echo "../uploads/advert/{$ad_img['img_5']}"; ?>" alt="" id="show-img-5" class="mt-2 img-fluid" style="width:100 ; height: 80px; object-fit: cover; object-position: center;" alt="">
                                        <?php if ($ad_img['img_5']) { ?>  
                                            <input type="checkbox" name="img_delete_5" id="img-delete-5" class="me-2" style="accent-color: red; width:18px; height: 18px; position: absolute; left: 2px; top: 10px; cursor: pointer;" title="Check to Delete Image.">
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- add image end-->
                        <div class="border-bottom mt-4"><!-- |border bottom| --></div>
                        <!-- contact delails -->
                        <div class="col-6 m-auto">
                            <div class="input-item row">
                                <p class="sub-title">Update Contact Details</p>
                                <div class="col-6">
                                    <label for="" class="label">Name</label>
                                    <p class="name text-capitalize"><?php echo $ad_owner['f_name'] . " " . $ad_owner['l_name']; ?></p>
                                    <label for="" class="label">E-mail</label>
                                    <p class="email"><?php echo $ad_owner['email']; ?></p>
                                </div><!-- user info (name, email)-->
                            </div>
                            <div class="input-item row mt-1">
                                <div class="col-12 border pt-2 pb-3 px-3 mt-2">
                                    <label for="mobile-number" class="label mb-3">Phone Number</label>
                                    <input type="number" name="mobile_number" id="mobile-number" value="<?php echo $ad['mobile_number'] ?>" class="form-control form-control-sm" placeholder="Enter your phone number here.">
                                    <input type="checkbox" name="hide_mobile_number" id="hide-mobile-number" class="mt-3" value="true" <?php echo $ad['is_mobile_hide'] ? "checked" : ""; ?>>
                                    <label for="hide-mobile-number" class="d-inline ms-1 checkbox-label">Hide Phone Number</label>
                                </div>
                            </div>
                            <label for="mobile-number" id="mobile-number-error" class="form-error"></label><!-- address -->
                        </div>
                        <!-- contact delails end-->
                        <div class="input-item row mb-4">
                            <div class="col-6 m-auto p-0 mt-3 row">
                                <button type="submit" id="btn-update-ad" class="btn btn-success btn-sm p-2 col-5 ms-auto">Update Post</button>
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
    <script src="../js/update.js"></script>
    <script src="../js/function.js"></script>
    <!-- link javascript file end-->
</body>
</html>
