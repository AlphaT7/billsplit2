<?php

include "init.php";

$data = json_decode(json_encode($_POST))[0];

$id = $data->id;
$f_name = $data->f_name;
$l_name = $data->l_name;
$nickname = $data->nickname;
$email = $data->email;

updateCustomer($conn, $id, $f_name, $l_name, $nickname, $email);

function updateCustomer($conn, $id, $f_name, $l_name, $nickname, $email)
{
    global $handle;

    $sql = "UPDATE `customers` SET f_name = :f_name, l_name = :l_name, nickname = :nickname, email = :email WHERE id = :id";
    $handle = $conn->prepare($sql);
    $handle->bindParam('id', $id, PDO::PARAM_STR);
    $handle->bindParam('f_name', $f_name, PDO::PARAM_STR);
    $handle->bindParam('l_name', $l_name, PDO::PARAM_STR);
    $handle->bindParam('nickname', $nickname, PDO::PARAM_STR);
    $handle->bindParam('email', $email, PDO::PARAM_STR);
    $handle->execute();

    echo "Customer Updated!";

    $handle->closeCursor();
}
