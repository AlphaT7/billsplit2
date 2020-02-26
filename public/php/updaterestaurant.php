<?php

include "init.php";

$data = json_decode(json_encode($_POST))[0];

$id = $data->id;
$rname = $data->rname;
$phone = $data->phone;
$website = $data->website;
$city = $data->city;

updateRestaurant($conn, $id, $rname, $phone, $website, $city);

function updateRestaurant($conn, $id, $rname, $phone, $website, $city)
{
    global $handle;
    $sql = "UPDATE `restaurants` SET rname = :rname, phone = :phone, website = :website, city = :city WHERE id = :id";
    $handle = $conn->prepare($sql);
    $handle->bindParam(':id', $id, PDO::PARAM_STR);
    $handle->bindParam(':rname', $rname, PDO::PARAM_STR);
    $handle->bindParam(':phone', $phone, PDO::PARAM_STR);
    $handle->bindParam(':website', $website, PDO::PARAM_STR);
    $handle->bindParam(':city', $city, PDO::PARAM_STR);
    $handle->execute();

    echo "Update Successfull!";

    echo "Restaurant Updated!";

    $handle->closeCursor();
}
