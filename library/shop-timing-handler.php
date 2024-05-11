
<?php require_once("../library/db-connector.php"); ?>

<?php

    function set_timings($u_id, $shop_timings) {

        $insert_timings_query = "INSERT INTO shop_timings SET
                u_id = {$u_id},
                monday_open = '{$shop_timings['monday_open']}', 
                monday_close = '{$shop_timings['monday_close']}', 
                monday_is_closed = {$shop_timings['monday_is_close']}, 
                tuesday_open = '{$shop_timings['tuesday_open']}', 
                tuesday_close = '{$shop_timings['tuesday_close']}', 
                tuesday_is_closed = {$shop_timings['tuesday_is_close']}, 
                wednesday_open = '{$shop_timings['wednesday_open']}', 
                wednesday_close = '{$shop_timings['wednesday_close']}', 
                wednesday_is_closed = {$shop_timings['wednesday_is_close']}, 
                thursday_open = '{$shop_timings['thursday_open']}', 
                thursday_close = '{$shop_timings['thursday_close']}', 
                thursday_is_closed = {$shop_timings['thursday_is_close']}, 
                friday_open = '{$shop_timings['friday_open']}', 
                friday_close = '{$shop_timings['friday_close']}', 
                friday_is_closed = {$shop_timings['friday_is_close']}, 
                saturday_open = '{$shop_timings['saturday_open']}', 
                saturday_close = '{$shop_timings['saturday_close']}', 
                saturday_is_closed = {$shop_timings['saturday_is_close']}, 
                sunday_open = '{$shop_timings['sunday_open']}', 
                sunday_close = '{$shop_timings['sunday_close']}', 
                sunday_is_closed = {$shop_timings['sunday_is_closed']}
            ;";

        // get connection
        $conn = get_connection();
        if ($conn->query($insert_timings_query)) {
            $insert_id = $conn->insert_id;
            close_connection($conn);
            return $insert_id;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function update_timings($u_id, $shop_timings) {

        $update_timings_query = "UPDATE shop_timings SET
                monday_open = '{$shop_timings['monday_open']}', 
                monday_close = '{$shop_timings['monday_close']}', 
                monday_is_closed = {$shop_timings['monday_is_close']}, 
                tuesday_open = '{$shop_timings['tuesday_open']}', 
                tuesday_close = '{$shop_timings['tuesday_close']}', 
                tuesday_is_closed = {$shop_timings['tuesday_is_close']}, 
                wednesday_open = '{$shop_timings['wednesday_open']}', 
                wednesday_close = '{$shop_timings['wednesday_close']}', 
                wednesday_is_closed = {$shop_timings['wednesday_is_close']}, 
                thursday_open = '{$shop_timings['thursday_open']}', 
                thursday_close = '{$shop_timings['thursday_close']}', 
                thursday_is_closed = {$shop_timings['thursday_is_close']}, 
                friday_open = '{$shop_timings['friday_open']}', 
                friday_close = '{$shop_timings['friday_close']}', 
                friday_is_closed = {$shop_timings['friday_is_close']}, 
                saturday_open = '{$shop_timings['saturday_open']}', 
                saturday_close = '{$shop_timings['saturday_close']}', 
                saturday_is_closed = {$shop_timings['saturday_is_close']}, 
                sunday_open = '{$shop_timings['sunday_open']}', 
                sunday_close = '{$shop_timings['sunday_close']}', 
                sunday_is_closed = {$shop_timings['sunday_is_closed']}
            WHERE u_id = {$u_id};";

        // get connection
        $conn = get_connection();
        if ($conn->query($update_timings_query)) {
            $affected_rows = $conn->affected_rows;

            close_connection($conn);
            return $affected_rows;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function select_timings($u_id) {

        $selerct_timings_query = "SELECT * FROM shop_timings WHERE u_id = {$u_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($selerct_timings_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>