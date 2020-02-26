<?php

include "init.php";

$data = $_POST[0];

$rname = $data[rname];
$city = $data[city];
$phone = $data[phone];
$website = $data[website];

addRestaurant($conn, $rname, $city, $phone, $website);

function addRestaurant($conn, $rname, $city, $phone, $website)
{
    global $handle;

    $sql = "INSERT INTO `restaurants` (rname, city, phone, website) VALUES (:rname,:city,:phone,:website)";
    $handle = $conn->prepare($sql);
    $handle->bindParam(':rname', $rname, PDO::PARAM_STR);
    $handle->bindParam(':city', $city, PDO::PARAM_STR);
    $handle->bindParam(':phone', $phone, PDO::PARAM_STR);
    $handle->bindParam(':website', $website, PDO::PARAM_STR);
    $handle->execute();

    echo "Restaurant Added!";

    $handle->closeCursor();
}
