<?php
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
        $query = $pdo->prepare("SELECT * FROM clientes WHERE email = :email AND apodo = :usuario");
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
                $mail->Password = 'hbbe zlil zkyo pgst'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587; 

                // Configuración del correo
                $mail->setFrom('futboleraoficialsenati@gmail.com', 'Soporte');
                $mail->addAddress($email);
                $mail->Subject = 'Código de verificación';
                $mail->Body    = "Tu código de verificación es: $codigo\n\nPor favor, ingrésalo en la página para continuar.";

                // Enviar el correo
                if ($mail->send()) {
                    echo "Se ha enviado el código de verificación a $email";
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