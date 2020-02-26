<?php

include "init.php";

getRestaurants($conn);

function getRestaurants($conn)
{

    global $handle;
    $sql = "SELECT `id`, `rname` FROM `restaurants`";
    $handle = $conn->prepare($sql);
    $handle->execute();
    $arr = $handle->fetchAll(PDO::FETCH_ASSOC);
    //print_r($query_results);
    //echo json_encode($query_results);

    $r_query_results = [];

    for ($i = 0; $i <= count($arr); $x++) {
        array_push($r_query_results, $arr[i]);
    }
/*
$sql = "SELECT * FROM `menus`";
$handle = $conn->prepare($sql);
$handle->execute();
$m_query_results = $handle->fetchAll(PDO::FETCH_ASSOC);
//print_r($query_results);
//echo json_encode($query_results);
 */
    // $r_query_results[0]->_children = "test";

    print_r($arr);
    print_r($r_query_results);

    echo "test";

    $handle->closeCursor();
}
