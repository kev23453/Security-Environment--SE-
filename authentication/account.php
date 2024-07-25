<!--esta es la conexion a la base de datos-->
<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

include '../conexion.php';

date_default_timezone_set($_ENV['DATEZONE']);

//creacion del intervalo del otp (5min)
$currentTime = new DateTime();
$modifiedTime = clone $currentTime; 
$modifiedTime->add(new DateInterval('PT1H'));
// Formatear las marcas de tiempo para la inserción en la base de datos
$timeFormatted = $modifiedTime->format('Y-m-d H:i:s');

//register code PHP
if(isset($_POST['regSend'])){
    $regName = mysqli_real_escape_string($conection, $_POST['regName']);
    $regUsername = mysqli_real_escape_string($conection, $_POST['regUsername']);
    $regEmail = mysqli_real_escape_string($conection, $_POST['regEmail']);
    $regPass = mysqli_real_escape_string($conection, md5($_POST['regPass']));
    $regCpass = mysqli_real_escape_string($conection, md5($_POST['regCpass']));

    if(!empty($regName) && !empty($regUsername) && !empty($regEmail) && !empty($regPass) && !empty($regCpass)){
        
    $slct_user_lg = mysqli_query($conection, "SELECT * FROM users WHERE email = '$regEmail' AND password = '$regCpass' ");
    if(mysqli_num_rows($slct_user_lg) > 0){
        $message_error[] = "este usuario ya existe";//false 
    }else{
        if($regPass != $regCpass){
            $message_error[] = "las contraseñas no coinciden";
        }
        else{
            $insertUser = mysqli_query($conection, "INSERT INTO users(username, emailName, email, password)
            VALUES('$regName','$regUsername','$regEmail','$regCpass')");
            
            $idUser = $conection->insert_id;


            if($insertUser){
                $message_check[] = "registro exitoso";

                //apartado para insertar el codigo OTP 
                function generateOtp($lenght = 6){
                    $opt = '';
                    $codigo = '';
                    for($i = 0; $i < $lenght; $i++){
                        $opt .= mt_rand(0, 6);
                        $codigo = md5($opt);
                    }
                    return array(
                        'codigo' => $codigo,
                        'otp' => $opt,
                    );
                }
                $otp_code = generateOtp();

               $insert_token = mysqli_query($conection, "INSERT INTO token(token, kill_at, idType) VALUES(' ".$otp_code['codigo']." ' , '$timeFormatted', 1 )");
                if($insert_token){//linea del error
                    $idToken = $conection->insert_id;
                    $insert_relationToken = mysqli_query($conection, "INSERT INTO usertokens(user_id, token_id) VALUES('$idUser','$idToken')");
                    if($insert_relationToken){
                        $message_check[] = "el codigo ha sido enviado";
                        $slct_user_lg_a = mysqli_query($conection, "SELECT * FROM users WHERE idUser = '$idUser'");
                        $row = mysqli_fetch_assoc($slct_user_lg_a);
                        setcookie('user_id', $row['idUser'], time() + 60*60*12, '/');
                        header("refresh:1; url='auth_token.php?user=".base64_encode($row['idUser'])."'");

                        //Send Email
                        $body = [
                            'Messages' => [
                                [
                                'From' => [
                                    'Email' => "".$_ENV['EMAIL_ADMIN']."",
                                    'Name' => "".$_ENV['NAME_EMAIL'].""
                                ],
                                'To' => [
                                    [
                                        'Email' => "".$regEmail."",
                                        'Name' => "".$regName.""
                                    ]
                                ],
                                'Subject' => "Activa tu cuenta",
                                'HTMLPart' => "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            text-align: center;
                            padding: 20px;
                        }
                        .container_msg {
                            width: 95%;
                            margin: 0 auto;
                            border: 1px solid #e0e0e0;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                        }
                        h2 {
                            font-size: 1.8em;
                            color: #333;
                            margin-bottom: 20px;
                        }
                        .box {
                            padding: 20px;
                            margin-bottom: 20px;
                        }
                        input {
                            width: 90%;
                            max-width: 300px;
                            border: 1px solid #dbdbdb;
                            color: #5e5e5e;
                            font-weight: 600;
                            padding: 8px 14px;
                            font-size: 18px;
                            margin-bottom: 10px;
                            text-align: center;
                        }
                        span {
                            font-size: 13px;
                            text-align: center;
                        }
                        p {
                            font-size: 14px;
                            color: #555;
                            margin-top: 20px;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <hr style='border: 2.5px solid #3670db; width: 100%; margin-bottom: 20px;'>
                    <div class='container_msg'>
                        <h2>Your one-time sign up code is</h2>
                        <table class='box'>
                            <tr>
                                <td>
                                    <input type='text' value=".$otp_code['otp']." disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>You have five attempts to enter the code, if you fail your account will be locked.</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <p>This email was sent by LoginTest for your new account creation, please let us know if you feel this email was sent to you by mistake.</p>
                </body>
                </html>"
                                ]
                            ]
                        ];
                         
                        $ch = curl_init();
                         
                        curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                            'Content-Type: application/json')
                        );
                        curl_setopt($ch, CURLOPT_USERPWD, $_ENV['KEY']);
                        $server_output = curl_exec($ch);
                        curl_close ($ch);
                         
                        $response = json_decode($server_output);
                        if ($response->Messages[0]->Status == 'success') {
                            $message_check[] = "Email sent successfully.";
                        }







                    }else{
                        $message_error[] = "error al insertar" . mysqli_error($conection);
                    }

                }else{
                    $message_error[] = "ha ocurrido un error con el codigo otp " . mysqli_error($conection);
                }

                //----------------------------------------------------//
            }else{
                $message_error[] = "ha ocurrido un error" . mysqli_error($conection);
            }
        }
    }
    }else{
        $message_alert[] = "favor de rellenar todos los campos";
    }

}






//login code PHP

if(isset($_POST['logSend'])){
    $logEmail = mysqli_real_escape_string($conection, $_POST['logEmail']);
    $logPass = mysqli_real_escape_string($conection, md5($_POST['logPass']));

    if(!empty($logEmail) && !empty($logPass)){
        $slct_user_lg = mysqli_query($conection, "SELECT * FROM users WHERE email = '$logEmail' AND password = '$logPass' ");
        if(mysqli_num_rows($slct_user_lg) > 0){
            $row = mysqli_fetch_assoc($slct_user_lg);
            if($row['verify'] == true){
                setcookie('user_id', $row['idUser'], time() + 60*60*12, '/');
                $message_check[] = "Bienvenido de vuelta";
                header("refresh:1; url='../index.php' ");
            }else{
                $message_alert[] = "tu cuenta aun no ha sido activada";
            }
        }else{
            $message_alert[] = "incorrect email or password";
        }
    }
    else{
        $message_alert[] = "rellene ambos campos para completar la accion";
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
    <title>Registrarse o Iniciar sesion</title>
</head>
<body>
    <?php include '../assets/extra_componets/messages.php'; ?>
    <div id="fullContainer">
        <div id="container_forms">
            <!--formulario del login o inicio de sesion-->
            <form action="" method="post" id="login">
                <span id="titleLog">login</span>
                <div class="box">
                    <span>email:</span>
                    <input type="email" name="logEmail" id="logEmail" placeholder="example@gmail.com">
                </div>
                <div class="box">
                    <span>password:</span>
                    <i class="fas fa-eye" id="eye-login"></i>
                    <input type="password" name="logPass" id="logPass" placeholder="example1234">
                </div>
                <a href="forgot_pass.php">forgot password?</a>
                <div class="box">
                    <button type="submit" name="logSend" id="logSend">log in</button>
                </div>
                <span>don't have account? <a href="" id="changeForm">sign in now</a></span>
            </form>

            <!--formulario del sign up o registro de nueva cuenta-->
            <form action="" method="post" id="register">
                <span id="titleReg">Register</span>
                <div class="containerBoxes">
                    <div class="box">
                        <span>name</span>
                        <input type="text" name="regName" id="regName">
                    </div>
                    <div class="box">
                        <span>username</span>
                        <input type="text" name="regUsername" id="regUsername">
                    </div>
                </div>
                <div class="box">
                    <span>email</span>
                    <input type="email" name="regEmail" id="regEmail">
                </div>
                <div class="containerBoxes">
                    <div class="box">
                        <span>contraseña</span>
                        <input type="password" name="regPass" id="regPass">
                    </div>
                    <div class="box">
                        <span>confirmar contraseña</span>
                        <input type="password" name="regCpass" id="regCpass">
                    </div>
                </div>
                <div class="checkContainer">
                    <input type="checkbox" name="checkTerms" id="check">
                    <span>acepto los terminos y condiciones</span>
                </div>
                <p>Al iniciar sesión, aceptas nuestros Términos y Condiciones y Política de Privacidad. Tu información será utilizada conforme a nuestras políticas.</p>
                <button type="submit" name="regSend" id="regSend" disabled>registrarse</button>
                <span id="spanC">already have account <a href="" id="changeForm2">Log in</a></span>

            </form>

        </div>
    </div>  
</body>
<script src="../assets/js/account_scripts/script.js"></script>
</html>