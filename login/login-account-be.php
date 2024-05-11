
<?php session_start(); ?>

<?php require_once("../library/db-connector.php"); ?>

<?php

    // get user create account data
    $email = $_POST['email'];
    $pword = $_POST['pword'];
    $where_from = $_POST['where-from'];

    $_SESSION['login_error'] = array();

    clent_side_validation();
    
    if (isset($_SESSION['login_error'])) {

        if (count($_SESSION['login_error'])) {

            set_invalid_data();
            header("location: ../{$where_from}");
        } else {

            if ($login_result = login()) {
                clear_error();
                $_SESSION['login_id'] = $login_result;
                header("location: ../{$where_from}");
            } else {
                set_invalid_data();
                header("location: ../{$where_from}");
            }
        }
    }

    function clent_side_validation() {

        global $email, $pword;

        if (!(strlen(trim($email)) > 10))
            $_SESSION['login_error']['0'] = "E-Mail is invalid !";
        
        if (!(strlen(trim($pword)) >= 8))
            $_SESSION['login_error']['1'] = "Password is invalid !";
    }

    function set_invalid_data() {
        
        global $email, $pword;

        $_SESSION['login'] = array("login_email" => $email, "login_pword" => $pword);
    }

    function clear_error() {
        
        $_SESSION['login_error'] = array();
        $_SESSION['create_account_error'] = array();
        $_SESSION['login'] = null;
        $_SESSION['create_account'] = null;
    }

    function login() {

        global $email, $pword;

        $select_account_query = "SELECT u_id, email, pword FROM user WHERE email = '{$email}' AND is_deleted = 0 LIMIT 1;";

        // get connection
        $conn = get_connection();
        
        if ($rs = $conn->query($select_account_query)) {

            if ($result = $rs->fetch_assoc()) {

                if ($result['pword'] == $pword) {
                    close_connection($conn);
                    return $result['u_id'];
                } else {
                    $_SESSION['login_error']['1'] = "Password is wrong !";
                    close_connection($conn);
                    return false;
                }
            } else {
                $_SESSION['login_error']['0'] = "E-Mail is invalid !";
                close_connection($conn);
                return false;
            }
        }
    }

?>
