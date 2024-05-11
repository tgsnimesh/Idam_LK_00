
<?php require_once("../library/db-connector.php"); ?>

<?php

    function update_advert($advert_id, $advert_details) {

        // get connection
        $conn = get_connection();

        $updaet_advert_query = "UPDATE advert SET 
                    dis_id = {$advert_details['district']}, city_id = {$advert_details['city']}, cate_id = {$advert_details['category']},
                    is_agricultural = {$advert_details['agricultural']}, is_residential = {$advert_details['residential']}, is_commercial = {$advert_details['commercial']}, is_other = {$advert_details['other']},
                    beds = {$advert_details['beds']}, baths = {$advert_details['baths']},
                    land_size = {$advert_details['land_size']}, unit = '{$advert_details['unit']}',
                    advert_address = '{$advert_details['address']}',
                    size = {$advert_details['size']},
                    title = '" . mysqli_real_escape_string($conn, $advert_details['title']) . "',
                    discription = '" . mysqli_real_escape_string($conn, $advert_details['discription']). "',
                    price = {$advert_details['price']},
                    is_negotiable = {$advert_details['is_negotiable']},
                    mobile_number = '{$advert_details['mobile_number']}',
                    is_mobile_hide = {$advert_details['is_mobile_hide']} 
                WHERE advert_id = {$advert_id} LIMIT 1;";

        if ($conn->query($updaet_advert_query)) {
            $affected_rows = $conn->affected_rows;
            close_connection($conn);
            return $affected_rows;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function add_advert($u_id, $advert_details) {

        // get connection
        $conn = get_connection();

        $advert_insert_query = "INSERT INTO advert 
                (   
                    u_id,
                    dis_id, city_id, cate_id,
                    is_agricultural, is_residential, is_commercial, is_other,
                    beds, baths,
                    land_size, unit,
                    advert_address,
                    size,
                    title,
                    discription,
                    price,
                    is_negotiable,
                    mobile_number,
                    is_mobile_hide,
                    post_date_time,
                    bump_up,
                    top_ad,
                    urgent,
                    spotlight,
                    featured_date
                ) VALUES (
                    {$u_id},
                    {$advert_details['district']}, {$advert_details['city']}, {$advert_details['category']},
                    {$advert_details['agricultural']}, {$advert_details['residential']}, {$advert_details['commercial']}, {$advert_details['other']},
                    {$advert_details['beds']}, {$advert_details['baths']},
                    {$advert_details['land_size']}, '{$advert_details['unit']}',
                    '{$advert_details['address']}',
                    {$advert_details['size']},
                    '" . mysqli_real_escape_string($conn, $advert_details['title']) . "',
                    '" . mysqli_real_escape_string($conn, $advert_details['discription']). "',
                    {$advert_details['price']},
                    {$advert_details['is_negotiable']},
                    '{$advert_details['mobile_number']}',
                    {$advert_details['is_mobile_hide']},
                    '{$advert_details['post_date_time']}',
                    '{$advert_details['bump_up']}',
                    '{$advert_details['top_ad']}',
                    '{$advert_details['urgent']}',
                    '{$advert_details['spotlight']}',
                    '{$advert_details['featured_date']}'
                );";

        if ($rs = $conn->query($advert_insert_query)) {
            $insert_id = $conn->insert_id;
            close_connection($conn);
            return $insert_id;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_all_ads() {

        $select_all_query = "SELECT * FROM advert WHERE is_deleted = 0;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($select_all_query)) {
            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_adds($limit, $advert_id, $filters, $sort) {

        $select_ads_query = "SELECT * FROM advert WHERE advert_id > {$advert_id} AND is_deleted = 0 {$filters} ORDER BY {$sort} " . ($limit != "" ? "LIMIT {$limit}" : "") . ";";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($select_ads_query)) {
            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_user_post_add($u_id) {

        $user_post_select_query = "SELECT * FROM advert WHERE u_id = {$u_id} AND is_deleted = 0 ORDER BY post_date_time DESC;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($user_post_select_query)) {
            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_spot_light_ads($now, $filters, $sort, $type, $limit) {

        $select_spot_ad_query = "SELECT * FROM advert INNER JOIN user ON advert.u_id = user.u_id WHERE advert.is_deleted = 0 AND spotlight > '{$now}' {$filters} AND user.is_verified_member LIKE '{$type}%' ORDER BY {$sort} LIMIT {$limit};";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($select_spot_ad_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function delete_ad($advert_id) {

        $delete_advert_quert = "UPDATE advert SET is_deleted = 1 WHERE advert_id = {$advert_id} LIMIT 1";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($delete_advert_quert)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>
