
<?php require_once("../library/db-connector.php"); ?>

<?php

    function save_advert_images($advert_id, $img_array) {

        $insert_img_query = "INSERT INTO advert_img 
            (
                advert_id, img_1, img_2, img_3, img_4, img_5
            ) VALUES (
                {$advert_id},
                '{$img_array['img-1']}',
                '". (isset($img_array['img-2']) ? $img_array['img-2'] : "") ."',
                '". (isset($img_array['img-3']) ? $img_array['img-3'] : "") ."',
                '". (isset($img_array['img-4']) ? $img_array['img-4'] : "") ."',
                '". (isset($img_array['img-5']) ? $img_array['img-5'] : "") ."'
            );";
            
        // get connection
        $conn = get_connection();
        if ($conn->query($insert_img_query)) {
            $insert_id = $conn->insert_id;
            close_connection($conn);
            return $insert_id;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function update_images($advert_id, $counter, $img_name) {
        
        $update_image_query = "UPDATE advert_img SET img_{$counter} = '{$img_name}' WHERE advert_id = {$advert_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($conn->query($update_image_query)) {
            $affected_rows = $conn->affected_rows;
            close_connection($conn);
            return $affected_rows;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

    function get_image_list($advert_id) {
        
        $select_image_lst_query = "SELECT * FROM advert_img WHERE advert_id = {$advert_id} LIMIT 1;";

        // get connection
        $conn = get_connection();
        if ($rs = $conn->query($select_image_lst_query)) {
            close_connection($conn);
            return $rs;
        } else {
            echo "Query Error : " . $conn->error;
        }
    }

?>