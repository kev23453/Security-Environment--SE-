<!--esta es la conexion a la base de datos-->
<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$conection = mysqli_connect($_ENV['SERVER'], $_ENV['USER'], $_ENV['PASSWORD'], $_ENV['DATABASE']);

if(!$conection){
    echo "error al conectar la base de datos";
}else{
    $event_actived = "SET GLOBAL event_scheduler='ON'";

    if($conection->query($event_actived) == false){
        $message_error[] = "el manejador de eventos no puedo activarse";
    }
}

?>