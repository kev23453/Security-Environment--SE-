<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


include '../conexion.php';

if(isset($_POST['reset'])){
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
                <a href=''></a>
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
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
    <h2>presiona aqui para recuperar tu contraseña</h2>
    <span>se te enviara un email al correo con el que estas registrado</span>
    <button type="submit" name="reset">resetear</button>
    </form>
</body>
</html>