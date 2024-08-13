<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

include '../conexion.php';

date_default_timezone_set($_ENV['DATEZONE']);

$user = base64_decode($_GET['user']);

if(isset($_POST['send'])){
    $pass = mysqli_real_escape_string($conection, md5($_POST['pass']));
    $cpass = mysqli_real_escape_string($conection, md5($_POST['cpass']));

    if(empty($pass) && empty($cpass)){
        $message_error[] = 'para completar la accion es necesario que se llenen ambos campos';
    }
    else{
        if($pass != $cpass){
            $message_error[] = "las contraseñas no coinciden";
        }
        else{
            $upd_pass = mysqli_query($conection, "UPDATE users SET password = '$cpass' WHERE idUser = '$user' ");
            if($upd_pass){
                $message_check[] = "contraseña actualizada exitosamente";
                header("refresh:1; url='account.php'");
            }
            else{
                $message_error[] = "ha ocurrido un error" . mysqli_error($conection);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/account_styles/style.css">
    <link rel="stylesheet" href="../assets/css/messages_styles/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>Cambiar contraseña</title>
</head>
<body>
    <?php include '../assets/extra_componets/messages.php'?>
    <form action="" method="post">
        <div class="box">
            <span>ingresa tu nueva contraseña</span>
            <input type="password" name="pass" placeholder="escribe...">
        </div>

        <div class="box">
            <span>confirma tu contraseña</span>
            <input type="password" name="cpass" placeholder="escribe...">
        </div>

        <button type="submit" name="send">confirmar</button>
    </form>
</body>
</html>