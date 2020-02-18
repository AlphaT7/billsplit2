<?php

include "init.php";

$data = $_POST[0];

$f_name = $data[f_name];
$l_name = $data[l_name];
$nickname = $data[nickname];
$email = $data[email];

addCustomer($conn, $f_name, $l_name, $nickname, $email);

function addCustomer($conn, $f_name, $l_name, $nickname, $email)
{
    global $handle;

    $sql = "INSERT INTO `customers` (f_name, l_name, nickname, email) VALUES (:f_name,:l_name,:nickname,:email)";
    $handle = $conn->prepare($sql);
    $handle->bindParam('f_name', $f_name, PDO::PARAM_STR);
    $handle->bindParam('l_name', $l_name, PDO::PARAM_STR);
    $handle->bindParam('nickname', $nickname, PDO::PARAM_STR);
    $handle->bindParam('email', $email, PDO::PARAM_STR);
    $handle->execute();

    echo "Customer Added!";

    $handle->closeCursor();
}
