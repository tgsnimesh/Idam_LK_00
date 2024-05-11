
<?php

function check_is_login_user() {
    if (isset($_SESSION['login_id'])) {
        return $_SESSION['login_id'];
    } else {
        return false;
    }
}

function remove_account() {
    setcookie(session_name(), "", time() - 3600, "/");
    $_SESSION['login_id'] = null;
    session_destroy();
    header("location: ../");
}

function filter_url_manager($filter, $filter2) {
                        
    $new_url = "";

    if (count($_GET)) {

        foreach ($_GET as $name => $value) {

            if (!($filter == $name) && !($filter2 == $name)) {
                $new_url .= $name . "=" . $value . "&";
            }
        }
    }

    return $new_url;
}

function page_not_founded_error($error) {

    ?>
    <main class="text-center">
        <h3 class="text-center mb-0 mt-5"><?php echo $error ?></h3>
        <div class="mb-2" style="color: gray; font-size: 2em; font-weight: bold;">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        </div>
        <a href="../" class="btn btn-success btn-sm shadow">Back to home</a>
    </main><!-- page loadning error -->
    <?php
}

?>
