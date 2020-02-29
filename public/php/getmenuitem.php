<?php

include "init.php";

$iid = json_decode(json_encode(($_POST)))->iid;
getMenuItem($conn, $iid);

function getMenuItem($conn, $iid)
{
    global $handle;
    $sql = "SELECT * FROM `menus` WHERE iid = :iid";
    $handle = $conn->prepare($sql);
    $handle->bindParam(':iid', $iid, PDO::PARAM_STR);
    $handle->execute();
    $query_results = $handle->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($query_results);

    $handle->closeCursor();
}
