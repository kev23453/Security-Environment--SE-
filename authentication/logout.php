<?php

$route_logout;

include '../conexion.php';

setcookie("user_id", "", time() - 1, "/");

// header("location:$route_logout");
header("location:account.php");

?>