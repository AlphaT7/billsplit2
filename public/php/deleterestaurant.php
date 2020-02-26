<?php

include "init.php";

$data = $_POST;

$id = $data[id];

delRestaurant($conn, $id);

function delRestaurant($conn, $id)
{
    global $handle;

    $sql = "DELETE FROM `restaurants` WHERE id = :id";
    $handle = $conn->prepare($sql);
    $handle->bindParam('id', $id, PDO::PARAM_STR);
    $handle->execute();

    echo "Restaurant Deleted!";

    $handle->closeCursor();
}
