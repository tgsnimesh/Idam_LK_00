
<?php session_start(); ?>

<?php $where_from = "post-add"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../library/location-handler.php"); ?>
<?php require_once("../library/category-handler.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>

<?php
    if (!check_is_login_user())
        header("location: ../");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Post Your Add</title>

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

    <main>
        <div class="container my-4 py-2 rounded bg-light add-post-potion">
            <p class="welcome-title">Welcome <?php $user = get_login_user(check_is_login_user())->fetch_assoc(); echo $user['f_name'] . " " . $user['l_name'];  ?>! Let's post an ad.</p>
            <p>Choose any option below</p>
            <div class="sell-something border">
                <div class="d-flex option-title border-bottom">
                    <i class="fa fa-money fa-lg" aria-hidden="true"></i>
                    <p>Sell something</p>
                </div>
                <div class="d-flex potion">
                    <?php
                        $is_open_model = "add-category";
                        
                        if (isset($_GET['district']))
                        $is_open_model = "add-city";
                        else if (isset($_GET['category']))
                        $is_open_model = "add-district";
                        ?>
                    <a href="" data-bs-toggle="modal" data-bs-target="#<?php echo $is_open_model; ?>">Select to post your ad.</a>
                    <i class="fa fa-angle-right fa-lg" aria-hidden="true"></i>
                </div>
            </div>
            <div class="post-info py-4  text-center">
                <a href="" class="border-end border-primary pe-2 me-2">Know your posting allowance</a>
                <a href="">See our posting rules</a>
            </div>
        </div>
        

        <!-- link select category model -->
        <?php require_once("../post-add/category.php"); ?>

        <!-- link select dsitrict model -->
        <?php require_once("../post-add/district.php"); ?>

         <!-- link select dsitrict model -->
        <?php require_once("../post-add/city.php"); ?>
    </main>
    
    <footer class="pt-2">
    <?php require_once("../library/footer.php"); ?>
    </footer>

    <!-- link javascript file -->
    <script src="../js/function.js"></script>
    <script src="../js/post-add.js"></script>
    <!-- link javascript file end-->

    <script>
        <?php
        if (isset($_GET['city'])) {
            ?>
            window.open("post-add.php", "_self");
            <?php
        } else if (isset($_GET['district'])) {
            ?>
            showCity();
            <?php
            $is_open_model = "add-city";
        } else if (isset($_GET['category'])) {
            ?>
            showDistrict();
            <?php
            $is_open_model = "add-district";
        }
    ?>
    </script>
</body>
</html>