<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


date_default_timezone_set($_ENV['DATEZONE']);

include '../conexion.php';



if(isset($_POST['reset'])){

    $email = mysqli_real_escape_string($conection, $_POST['email']);
    $nameEmail = mysqli_real_escape_string($conection, $_POST['nameEmail']);
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $execute = mysqli_query($conection, $query);

    if(mysqli_num_rows($execute) > 0){
        $row = mysqli_fetch_assoc($execute);
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
                        'Email' => "".$email."",
                        'Name' => "".$nameEmail.""
                    ]
                ],
                'Subject' => "Recupera tu cuenta",
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
                    <span>this is your code for recoveritt your account</span>
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

            //creacion del intervalo del otp (1hr)
              $currentTime = new DateTime();
              $modifiedTime = clone $currentTime; 
              $modifiedTime->add(new DateInterval('PT24H'));
              //Formatear las marcas de tiempo para la inserción en la base de datos
              $timeFormatted = $modifiedTime->format('Y-m-d H:i:s');

              $code = $otp_code['codigo'];
              $insert_tok = "INSERT INTO token(idType, kill_at, token) VALUES(2, '$timeFormatted', '$code')";
              $execute_instok = mysqli_query($conection, $insert_tok);

              $idTok = $conection->insert_id;

              $insert_relation = mysqli_query($conection, "INSERT INTO usertokens(user_id, token_id) VALUES( '".$row['idUser']."', '$idTok')");
              //insertar tambien en la tabla de relacion user-token

            if($execute_instok && $insert_relation){
                $message_check[] = "token creado";

                setcookie('user_id', $row['idUser'], time() + 60*60*12, '/');
                header("refresh:1; url='recoverit_token.php?user=".base64_encode($row['idUser'])." ' ");
            }
            else{
                $message_error[] = "ha ocurrido un error" . mysqli_error($conection);
            }
        }
    }
    else{
        $message_alert[] = 'el usuario no existe';
    }

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/account_styles/recoverit.css">
    <link rel="stylesheet" href="../assets/css/messages_styles/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="icon" href="<?php echo $_ENV['LOGOTYPE'] ?>">
    <title>Recuperar contraseña</title>
</head>
<body>
    <?php include '../assets/extra_componets/messages.php';?>

    <form action="" method="post">
    <h2>presiona aqui para recuperar tu contraseña</h2>
    <i class="fas fa-envelope"></i>
    <span id="instruction">ingresa el email y nombre de email al que quieres que se envie el codigo de recuperacion</span>
    <div id="container_inputs">
        <div class="box">
            <span>name email</span>
            <input type="text" name="nameEmail" placeholder="write...">
        </div>
        <div class="box">
            <span>email</span>
            <input type="email" name="email" placeholder="write...">
        </div>
    </div>
    <button type="submit" name="reset">resetear</button>
    </form>
</body>
</html>