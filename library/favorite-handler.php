
<?php require_once("../library/db-connector.php"); ?>

<?php

    function is_favorite($u_id, $advert_id) {

        $is_check_favorite_query = "SELECT * FROM favorite WHERE u_id = {$u_id} AND advert_id = {$advert_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($is_check_favorite_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function add_favorite($u_id, $advert_id) {

        $add_favorite_query = "INSERT INTO favorite (u_id, advert_id) VALUES ({$u_id}, {$advert_id});";

        // get connection
        $conn = get_connection();
        if ($conn->query($add_favorite_query)) {
            
            $insert_id = $conn->insert_id;
            close_connection($conn);
            return $insert_id;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }
    function remove_favorite($u_id, $advert_id) {

        $remove_favorite_query = "DELETE FROM favorite WHERE u_id = {$u_id} AND advert_id = {$advert_id};";

        // get connection
        $conn = get_connection();
        if ($conn->query($remove_favorite_query)) {
            
            $affected_rows = $conn->affected_rows;
            close_connection($conn);
            return $affected_rows;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function select_favorite($u_id) {

        $remove_favorite_query = "SELECT * FROM favorite WHERE u_id = {$u_id};";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($remove_favorite_query)) {
            
            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>