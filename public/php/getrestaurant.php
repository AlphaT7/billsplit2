<?php

include "init.php";

// If the $_POST has no name to call, you have to do a json_decode AND json_encode on it. (both)
$id = json_decode(json_encode(($_POST)))->id;

getRestaurant($conn, $id);

function getRestaurant($conn, $id)
{
    global $handle;

    $sql = "SELECT * FROM `restaurants` WHERE id = :id";
    $handle = $conn->prepare($sql);
    $handle->bindParam('id', $id, PDO::PARAM_STR);
    $handle->execute();
    $query_results = $handle->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($query_results);

    $handle->closeCursor();
}
