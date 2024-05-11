
<?php require_once("../library/db-connector.php"); ?>

<?php

    $top_ad = $_POST['top_ad'];
    $spotlight = $_POST['spotlight'];
    $urgent = $_POST['urgent'];
    $bump_up = $_POST['bump_up'];

    $query = "";

    if ($top_ad) {
        $promote_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + {$top_ad} days"));
        $query .= "UPDATE advert SET top_ad = '{$promote_date}' WHERE advert_id = {$_POST['advert_id']}; ";
    }
    if ($spotlight) {
        $promote_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + {$spotlight} days"));
        $query .= "UPDATE advert SET spotlight = '{$promote_date}' WHERE advert_id = {$_POST['advert_id']}; ";
    }
    if ($urgent) {
        $promote_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + {$urgent} days"));
        $query .= "UPDATE advert SET urgent = '{$promote_date}' WHERE advert_id = {$_POST['advert_id']}; ";
    }
    if ($bump_up) {
        $promote_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + {$bump_up} days"));
        $query .= "UPDATE advert SET post_date_time = '{$promote_date}' WHERE advert_id = {$_POST['advert_id']}; ";
    }

    if (promote_ad($query))
        header("location: ../show-advert/?advert-id={$_POST['advert_id']}");

    function promote_ad($query) {

        $promote_query = $query;

        // get connection
        $conn = get_connection();
        if ($conn->multi_query($promote_query)) {
            $affected_rows = $conn->affected_rows;
            close_connection($conn);
            return $affected_rows;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>
