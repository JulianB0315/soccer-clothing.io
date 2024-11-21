<?php
session_start();
require '../Controlador/ConectionMySQL.php';
require '../lib/phpmailer/PHPMailer.php';
require '../lib/phpmailer/SMTP.php';
require '../lib/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email && $usuario) {
        // Verificar si el correo y el nombre de usuario existen en la base de datos
        $query = $pdo->prepare("SELECT * FROM clientes WHERE email = :email AND nombres = :usuario");
        $query->execute(['email' => $email, 'usuario' => $usuario]);
        $user = $query->fetch();

        if ($user) {
            // Generar un código de verificación aleatorio
            $codigo = rand(100000, 999999);

            // Configurar el correo con PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor de correo
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'futboleraoficialsenati@gmail.com';
                $mail->Password = 'wtnc ieor nxme ezhq';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Configuración del correo
                $mail->setFrom('futboleraoficialsenati@gmail.com', 'Soporte');
                $mail->addAddress($email);
                $mail->Subject = 'Codigo de verificacion';
                $mail->isHTML(true);
                $mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futbolera</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #081625;
        }
        .error-section {
            background-color: #123254;
            box-shadow: 2px 2px 20px gray;
            border-radius: 18px;
            padding: 20px;
            max-width: 500px;
            margin: 170px auto;
            
            text-align: center;
        }
        .title{
            color: #fdf6d0;
            font-family:"Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
            font-size: 3rem;
            margin-bottom: 10px;
        }
        .msg{
            font-family:"Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
            font-size: 3rem;
            margin-bottom: 10px;
            color: #659adb;
        }
        .text {
            color: #9e9e9e;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <section class="error-section">
        <h1 class="title">Futbolera</h1>
        <h2 class="msg">Tu código es: ' . htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8') . '</h2>
        <p class="text">Por favor, ingrésalo en la página para continuar.</p>
    </section>
</body>
</html>';

                // Enviar el correo
                if ($mail->send()) {
                    // Redirigir solo si el correo se envió correctamente
                    header("Location: ../Vista/menu_codigo.php?codigo=" . urlencode($codigo) . "&email=" . urlencode($email));
                    exit;
                } else {
                    echo "Hubo un problema al enviar el correo.";
                }
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            echo "El nombre de usuario o el correo no coinciden con nuestros registros.";
        }
    } else {
        echo "Por favor, ingresa un correo y un nombre de usuario válidos.";
    }
}
?>
