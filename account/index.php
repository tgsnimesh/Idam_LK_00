
<?php session_start(); ?>

<?php $where_from = "account"; ?>

<?php require_once("../library/function.php"); ?>
<?php require_once("../account/account-db-handler.php"); ?>
<?php require_once("../library/ad-handler.php"); ?>
<?php require_once("../library/category-handler.php"); ?>

<?php
    // log out account
    if (isset($_POST['logout'])) {

        remove_account();
    }
    // delete account
    if (isset($_POST['delete_account'])) {

        delete_account(check_is_login_user());
        remove_account();
    }

    // request membership
    $is_success_give_membership;
    if (isset($_POST['requert_membership'])) {
        
        $is_success_give_membership = give_membership(check_is_login_user());
        header("location: ../account/?acc=membership");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Account</title>

    <!-- link head php file -->
    <?php require_once("../library/head.php"); ?>
    <?php require_once("../library/function.php"); ?>

    <!-- link css -->
    <link rel="stylesheet" href="../style/account.css">
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
    </header>

    <?php
        if (!check_is_login_user()) {

            page_not_founded_error("Invalid Statement !");
            die();
        }
        
        // get user select account option 
        if (isset($_GET['acc'])) {

            if ($_GET['acc'])
                $click_option = $_GET['acc'];
            else {

                page_not_founded_error("Invalid Statement !");
                die();
            }
        } else {

            page_not_founded_error("Invalid Statement !");
            die();
        }
    ?>

    <main>
        <!-- my account -->
        <div class="container my-4 rounded bg-light">
            <div class="row p-3">
                <div class="account-option-link col-3">
                    <h4>Account</h4>
                    <a href="?acc=dashboard" class="d-flex border-top <?php echo $click_option == "dashboard" ? "active" : ""; ?>">
                        <p>My Account</p>
                        <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
                    </a>
                    <a href="?acc=membership" class="d-flex border-top <?php echo $click_option == "membership" ? "active" : ""; ?>">
                        <p>My Membership</p>
                        <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
                    </a>
                    <a href="?acc=favorites" class="d-flex border-top <?php echo $click_option == "favorites" ? "active" : ""; ?>">
                        <p>Favorites</p>
                        <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
                    </a>
                    <a href="?acc=settings" class="d-flex border-top <?php echo $click_option == "settings" ? "active" : ""; ?>">
                        <p>Settings</p>
                        <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="account-dis col-9">

                    <!-- account optioin -->
                    <?php
                        
                        switch ($click_option) {
                            case "dashboard" :
                                // set dashboard
                                require_once("../account/dashboard.php");
                                break;
                            case "membership" :
                                // set membership
                                require_once("../account/member-ship.php");
                                break;
                            case "favorites" :
                                // set favorites
                                require_once("../account/favorites.php");
                                break;
                            case "settings" :
                                // set setting
                                require_once("../account/settings.php");
                                break;
                            default :
                                // set dashboard
                                require_once("../account/dashboard.php");
                                break;
                        }
                    ?>
                    <!-- account optioin end-->

                </div>
            </div>
        </div>
        <!-- my account end-->
    </main>

    <footer>
    <?php require_once("../library/footer.php"); ?>
    </footer>

    <!-- link javascript file -->
    <script src="../js/settings.js"></script>
    <script src="../js/function.js"></script>
    <!-- link javascript file end-->
    <script>
        var cChecKBox = document.getElementsByClassName("confirm-delet-ad");
        var btn = document.getElementsByClassName("btn-delete-ad");

        for (let i = 0; i < cChecKBox.length; i++) {
            
            cChecKBox[i].addEventListener("input", () => {

                if (cChecKBox[i].checked)
                    btn[i].disabled = false;
                else
                    btn[i].disabled = true;
            });
        }
    </script>

</body>
</html>
