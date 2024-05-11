<?php

    $date = strtotime("+7 day"); 
    echo date('Y-m-d', $date) . "<br>";

    $today = date('Y-m-d') - date("Y-m-d");
    echo $today;

?>