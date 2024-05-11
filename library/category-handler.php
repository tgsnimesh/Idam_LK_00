
<?php require_once("../library/db-connector.php"); ?>

<?php

    function get_all_category() {

        $get_all_category_query = "SELECT * FROM category_type;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_all_category_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }
    function get_search_category($where) {

        $get_all_category_query = "SELECT * FROM category_type WHERE {$where};";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_all_category_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_category($ct_id) {

        $get_category_query = "SELECT * FROM category_type WHERE ct_id = {$ct_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($get_category_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>
