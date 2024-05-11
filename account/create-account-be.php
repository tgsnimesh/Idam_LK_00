
<?php session_start(); ?>

<?php require_once("../library/db-connector.php"); ?>

<?php

    // get user create account data
    $f_name = $_POST['first_name'];
    $l_name = $_POST['last_name'];
    $email = $_POST['create-email'];
    $pword = $_POST['pword'];
    $where_from = $_POST['where_from'];

    $_SESSION['create_account_error'] = array();
    $_SESSION['create_account'];

    client_side_validation();
    database_validation();

    if (count($_SESSION['create_account_error'])) {
        set_invalid_data();
        header("location: ../{$where_from}/");
    } else {

        clear_error();
        if ($insert_id = create_account()) {

            $_SESSION['login_id'] = $insert_id;
            header("location: ../{$where_from}/");
        }
    } 

    function client_side_validation() {
        
        global $f_name, $l_name, $pword, $email;

        if (!strlen(trim($f_name))) {

            $_SESSION['create_account_error']['0'] = "First Name is invalid !";
        }
        if (!strlen(trim($l_name))) {

            $_SESSION['create_account_error']['1'] = "Last Name is invalid !";
        }
        if (!strlen(trim($email))) {

            $_SESSION['create_account_error']['2'] = "E-Mail is invalid !";
        }
        if (!strlen(trim($pword))) {
            
            $_SESSION['create_account_error']['3'] = "Password is invalid !";
        }
    }

    function database_validation() {

        global $email;

        $select_email_query = "SELECT email from user WHERE email = '{$email}';";

        // get connection
        $conn = get_connection();
        
        if ($rs = $conn->query($select_email_query)) {
            
            if ($rs->fetch_assoc())
                $_SESSION['create_account_error']['2'] = "E-Mail is already exists !";
        }

        close_connection($conn);
    }

    function set_invalid_data() {
        
        global $f_name, $l_name, $email, $pword;

        $_SESSION['create_account'] = array("f_name" => $f_name, "l_name" => $l_name, "email" => $email, "pword" => $pword);
    }

    function clear_error() {
        
        $_SESSION['login_error'] = array();
        $_SESSION['create_account_error'] = array();
        $_SESSION['login'] = null;
        $_SESSION['create_account'] = null;
    }

    function create_account() {
        
        global $f_name, $l_name, $email, $pword, $where_from;

        $create_account_query = "INSERT INTO user 
        (
            f_name, l_name, email, pword, created_dt, is_verified_member
        ) VALUES (
            '{$f_name}', '{$l_name}', '{$email}', '{$pword}', '". date("Y-m-d H:i:s") ."', 0
        );";

        // get connection
        $conn = get_connection();
        
        if ($conn->query($create_account_query) === TRUE) {
            
            $insert_id = $conn->insert_id;
            close_connection($conn);
            return $insert_id;
        } else {
            // header("location: ../{$where_from}/?error=_account_create_error_: {$conn->error}");
            echo $conn->error;
        }
    }

?>
