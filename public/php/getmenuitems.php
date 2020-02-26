<?php

include "init.php";

getMenuItems($conn);

function getMenuItems($conn)
{
    global $handle;
    $sql = "SELECT * FROM `menus`";
    $handle = $conn->prepare($sql);
    $handle->execute();
    $query_results = $handle->fetchAll(PDO::FETCH_BOTH);
    echo json_encode($query_results);

    $handle->closeCursor();
}
