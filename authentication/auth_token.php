<?php


require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

include '../conexion.php';

$user = base64_decode($_GET['user']);

if(isset($_POST['testCode'])){
    $conect_strt = "";

    //iterar sobre estos
    foreach($_POST['digit'] as $input){
        $conect_strt .= $input;
    }
    $codigo = md5($conect_strt);


    $sql_queryTok = "SELECT * FROM usertokens INNER JOIN token ON token.idToken = usertokens.token_id WHERE usertokens.user_id = $user";
    $slct_tok = mysqli_query($conection, $sql_queryTok);
    $fetch_tok = mysqli_fetch_assoc($slct_tok);
    $token = trim($fetch_tok['token']);//trim es un metodo para eliminar los espacios en blanco que tenga la variable


    if($fetch_tok['contador'] == $fetch_tok['intentos']){
        $message_alert[] = "has agotado tus intentos";
    }
    else{
        if($codigo != $token){//el usuario se equivoco de codigo
            $message_alert[] = "token incorrecto";
            $fail = $fetch_tok['contador'] += 1;
            $update_contador = mysqli_query($conection, "UPDATE token SET contador = '$fail' WHERE idToken = ".$fetch_tok['idToken']." ");
        }
        else{
            $message_check[] = "bienvenido";
            header("refresh:1; url='../index.php'");
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
    <title>Activa tu cuenta</title>
</head>
<body>
    <?php include '../assets/extra_componets/messages.php';?>
    <form action="" method="post">
        <div class="container_inputs_tokens">
            <input type="text" name="digit[]">
            <input type="text" name="digit[]">
            <input type="text" name="digit[]">
            <input type="text" name="digit[]">
            <input type="text" name="digit[]">
            <input type="text" name="digit[]">
        </div>
        <button type="submit" name="testCode">evaluar</button>
    </form>
</body>
</html>