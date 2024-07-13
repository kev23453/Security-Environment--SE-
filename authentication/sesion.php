<?php

$route_lg;//variable de ruta para redireccionar al login
$route_c; //variable de ruta para la conexion a la DB

//include '../conexion.php';
include $route_c;


if(isset($_COOKIE['user_id'])){ 
    $user_id = $_COOKIE['user_id'];
}else{   
    $user_id = '';
    header("location:$route_lg");// header("location:$route_lg");
}
$select = mysqli_query($conection, "SELECT * FROM users WHERE idUser = $user_id ");
$fetch = mysqli_fetch_assoc($select);
?>