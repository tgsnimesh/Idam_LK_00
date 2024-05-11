
<?php

    $db_server_name = "localhost";
    $db_user_name = "root";
    $db_password = "";
    $db_name = "idamak_lk_1";

    function get_connection() {
        global $db_server_name, $db_user_name, $db_password, $db_name;

        $conn = new mysqli($db_server_name, $db_user_name, $db_password, $db_name);
        
        if ($conn->errno) {
            die("Connection Error : " . $conn->error);
        } else {
            return $conn;
        }
    }

    function close_connection($conn) {
        $conn->close();
    }

?>
