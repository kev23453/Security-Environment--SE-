<!--esta es la conexion a la base de datos-->
<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if(isset($_POST[''])){} //evaluar el metodo de envio


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/account_styles/style.css">
    <link rel="stylesheet" href="../assets/css/messages_styles/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>Sing up OR Log In</title>
</head>
<body>
    <form action="" method="post" id="container_login">
        <div id="message_left">
            <span>SE</span>
            <h2>if you have to report a crime, sing up, we wait for you</h2>
            <span>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facilis autem molestiae natus dolor quas rem exercitationem temporibus, eius aliquid libero minima quod quasi ipsam odio veritatis quaerat similique vel laudantium.</span>
        </div>

        <div id="form">
 
        </div>

    </form>
</body>
<script src="../assets/js/account_scripts/script.js"></script>
</html>