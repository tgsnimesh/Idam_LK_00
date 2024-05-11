
<?php require_once("../library/db-connector.php"); ?>
<?php require_once("../library/location-handler.php"); ?>

<?php

    function get_login_user($u_id) {

        $login_user_select_query = "SELECT * FROM user WHERE u_id = {$u_id} LIMIT 1;";

        // get conneciton
        $conn = get_connection();
        if ($rs = $conn->query($login_user_select_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function update_user($u_id, $details) {

        $update_user_query = "UPDATE user SET f_name = '{$details['f_name']}', l_name = '{$details['l_name']}', d_id = '{$details['location']}', c_id = '{$details['sub_location']}' WHERE u_id = '{$u_id}' LIMIT 1;";
        
        // get conneciton
        $conn = get_connection();
        if ($rs = $conn->query($update_user_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function change_pword($u_id, $details) {
        
        $update_pword_query = "UPDATE user SET pword = '{$details['confirm_new_pword']}' WHERE u_id = {$u_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($update_pword_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function delete_account($u_id) {
        
        $update_is_deleted_query = "UPDATE user SET is_deleted = 1 WHERE u_id = {$u_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($update_is_deleted_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function give_membership($u_id) {

        $giv_member_ship_query = "UPDATE user SET is_verified_member = 1 WHERE u_id = {$u_id} LIMIT 1";

        // get connection
        $conn = get_connection();
        if ($conn->query($giv_member_ship_query)) {
            $affect_rwos = $conn->affected_rows;
            close_connection($conn);
            return $affect_rwos;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function register_verified_seller($u_id) {

        $update_user_query = "UPDATE user SET is_verified_seller = 1 WHERE u_id = '{$u_id}' LIMIT 1;";
        
        // get conneciton
        $conn = get_connection();
        if ($conn->query($update_user_query)) {
            $affect_rwos = $conn->affected_rows;
            close_connection($conn);
            return $affect_rwos;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>
