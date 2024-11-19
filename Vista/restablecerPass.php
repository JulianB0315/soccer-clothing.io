<?php
require '../Controlador/ConectionMySQL.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email && $usuario) {
        $query = $pdo->prepare("SELECT * FROM clientes WHERE email = :email AND apodo = :usuario");
        $query->execute(['email' => $email, 'usuario' => $usuario]);
        $user = $query->fetch();

        if ($user) {
            $codigo = rand(100000, 999999);  

            $subject = "Código de verificación";
            $message = "Tu código de verificación es: $codigo\n\n" .
                       "Por favor, ingrésalo en la página para continuar.";

            $headers = "From: futboleraoficialsenati@gmail.com\r\n";  
            $headers .= "Reply-To: futboleraoficialsenati@gmail.com\r\n"; 
            $headers .= "X-Mailer: PHP/" . phpversion();

            if (mail($email, $subject, $message, $headers)) {
                echo "Se ha enviado el código de verificación a $email";
            } else {
                echo "Hubo un problema al enviar el correo.";
            }

        } else {
            echo "El nombre de usuario o el correo no coinciden con nuestros registros.";
        }
    } else {
        echo "Por favor, ingresa un correo y un nombre de usuario válidos.";
    }
}
?>

