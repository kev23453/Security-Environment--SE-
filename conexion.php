<!--esta es la conexion a la base de datos-->
<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$conection = mysqli_connect($_ENV['SERVER'], $_ENV['USER'], $_ENV['PASSWORD'], $_ENV['DATABASE']);

if(!$conection){
    echo "error al conectar la base de datos";
}

?>