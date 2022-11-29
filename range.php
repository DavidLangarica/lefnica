<?php
    session_start();

    $category_type = $_SESSION['cat_type'];

    $temp_may = $category_type["Temperatura_ideal_rango_mayor"];
    $temp_min = $category_type["Temperatura_ideal_rango_menor"];
    
    $hum_may = $category_type["Humedad_ideal_rango_mayor"];
    $hum_min = $category_type["Humedad_ideal_rango_menor"];

    $element = array('Tmay'=>$temp_may, 'Tmin'=>$temp_min, 'Hmay'=>$hum_may, 'Hmin'=>$hum_min);

    echo json_encode($element);
?>