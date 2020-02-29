<?php

include "init.php";

getRestaurants($conn);

function getRestaurants($conn)
{

    global $handle;
    $sql = "SELECT `id`, `rname` FROM `restaurants`";
    $handle = $conn->prepare($sql);
    $handle->execute();
    $r_query_results = $handle->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM `menus`";
    $handle = $conn->prepare($sql);
    $handle->execute();
    $m_query_results = $handle->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($r_query_results); $i++) {
        $r_query_results[$i]['_children'] = [];
        for ($j = 0; $j < count($m_query_results); $j++) {
            if ($m_query_results[$j]['restaurant_id'] == $r_query_results[$i][id]) {
                array_push($r_query_results[$i]['_children'], $m_query_results[$j]);
            }
        }
    }

    //print_r($r_query_results);
    echo json_encode($r_query_results);

    $handle->closeCursor();
}
