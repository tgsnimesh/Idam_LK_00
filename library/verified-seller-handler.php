
<?php require_once("../library/db-connector.php"); ?>

<?php

    function regiser_seller($seller_detalils) {

        $insert_seller = "INSERT INTO verified_seller 
            (
                u_id, shop_name, shop_title, website, shop_address, about_shop, phonenumber, is_hide_phonenumber, email, cover_img, logo, created_dt
            ) VALUES (
                {$seller_detalils['u_id']},
                '{$seller_detalils['shop_name']}',
                '{$seller_detalils['shop_title']}',
                '{$seller_detalils['website']}',
                '{$seller_detalils['shop_address']}',
                '{$seller_detalils['about_shop']}',
                '{$seller_detalils['phone_number']}',
                {$seller_detalils['hide_phone_number']},
                '{$seller_detalils['email']}',
                '{$seller_detalils['cover_image']}',
                '{$seller_detalils['logo']}',
                '{$seller_detalils['created_dt']}'
            );";

        // get connection
        $conn = get_connection();
        if ($conn->query($insert_seller)) {
            $insert_id = $conn->insert_id;
            close_connection($conn);
            return $insert_id;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function update_seller_shop($seller_id, $seller_data) {

        $update_seller_shop_query = "UPDATE verified_seller SET 
                    shop_name = '{$seller_data['shop_name']}', 
                    shop_title = '{$seller_data['shop_title']}', 
                    website = '{$seller_data['website']}', 
                    shop_address = '{$seller_data['shop_address']}', 
                    about_shop = '{$seller_data['about_shop']}', 
                    phonenumber = '{$seller_data['phone_number']}', 
                    is_hide_phonenumber = {$seller_data['hide_phone_number']}, 
                    email = '{$seller_data['email']}', 
                    cover_img = '{$seller_data['cover_image']}', 
                    logo = '{$seller_data['logo']}'
                    WHERE u_id = {$seller_id};";
        // get connection
        $conn = get_connection();
        if ($conn->query($update_seller_shop_query)) {
            $affected_rows = $conn->affected_rows;
            close_connection($conn);
            return $affected_rows;
        } else {
            echo "Query Error : " . $conn->error;
        }   
    }


    function get_verified_seller($u_id) {

        $select_seller_query = "SELECT * FROM verified_seller WHERE u_id = {$u_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($select_seller_query)) {

            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function update_last_online($u_id, $now) {

        $update_seller_last_online_query = "UPDATE verified_seller SET last_online = '{$now}' WHERE u_id = {$u_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($update_seller_last_online_query)) {
            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>
