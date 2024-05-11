
<?php require_once("../library/db-connector.php"); ?>

<?php

    function get_all_locations() {

        $get_all_location_query = "SELECT * FROM dsitrict ORDER BY d_name ASC;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_all_location_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_search_locations($where) {

        $get_search_location_query = "SELECT * FROM dsitrict WHERE {$where} ORDER BY d_name ASC;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_search_location_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }
    function get_search_sub_locations($where) {

        $get_search_location_query = "SELECT * FROM city WHERE {$where} ORDER BY c_name ASC;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_search_location_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_all_location_in_sub_locations($location_id) {

        $get_all_sub_location_query = "SELECT * FROM city WHERE d_id = {$location_id} ORDER BY c_name ASC;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_all_sub_location_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_all_sub_locations() {

        $get_all_sub_location_query = "SELECT * FROM city ORDER BY c_name ASC;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_all_sub_location_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_location($d_id) {

        $get_location_query = "SELECT * FROM dsitrict WHERE d_id = {$d_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_location_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_sub_location($c_id) {

        $get_sub_location_query = "SELECT * FROM city WHERE c_id = {$c_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_sub_location_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>
