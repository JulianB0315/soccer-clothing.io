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
        $query = $pdo->prepare("SELECT * FROM clientes WHERE email = :email AND nombre = :usuario");
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
            background-color: #f5f5f5;
        }
        .error-section {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
        }
        .error-title {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .error-text {
            color: #555555;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <section class="error-section">
        <h1 class="error-title">Tu código es: ' . htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8') . '</h1>
        <p class="error-text">Por favor, ingrésalo en la página para continuar.</p>
    </section>
</body>
</html>';
                // Enviar el correo
                if ($mail->send()) {
?>
                    <!DOCTYPE html>
                    <html lang="en">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Futbolera</title>
                        <link rel="icon" href="./imgs/logo-tienda.webp">
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
                        <link rel="stylesheet" href="./style.css">
                        <link rel="preconnect" href="https://fonts.googleapis.com">
                        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
                        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
                        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
                        <link href="https://db.onlinewebfonts.com/c/c0cd6ec8ce6d2bbd315a13b62ed13550?family=AdihausDIN" rel="stylesheet">
                    </head>

                    <body>
                        <!-- Navbar -->
                        <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #081625;">
                            <div class="container-fluid">
                                <a class="navbar-brand text-light fw-semibold fs-2" href="./index.php">
                                    <img src="./imgs/logo-tienda.webp" alt="Shop logo" width="70" height="70" class="d-inline-block align-text-center">
                                    Futbolera
                                </a>
                                <button class="navbar-toggler bg-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvas" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <section class="offcanvas offcanvas-end" id="offCanvas" tabindex="-1">
                                    <div clasS="offcanvas-header" data-bs-theme="principal">
                                        <h5 class="offcanvas-title fs-1 p-3">Futbolera</h5>
                                        <button class="btn-close bg-primary" type="button" aria-label="Close" data-bs-dismiss="offcanvas"></button>
                                    </div>
                                    <div class="offcanvas-body d-flex flex-column justify-content-between px-0">
                                        <ul class="navbar-nav fs-5 justify-content-evenly">
                                            <li class="nav-item p-3 ">
                                                <a class="nav-link" href="./novedades.php">Novedades</a>
                                            </li>
                                            <li class="nav-item p-3 ">
                                                <a class="nav-link" href="./Catalogo.php">Catálogo</a>
                                            </li>
                                            <li class="nav-item p-3 ">
                                                <a class="nav-link" href="ofertas.php">Ofertas</a>
                                            </li>
                                            <li class="nav-item p-3">
                                                <a class="nav-link" href="./index.php#contacto">Contacto</a>
                                            </li>
                                            <li class="user-buttons d-flex justify-content-evenly p-2 ">
                                                <a class="nav-link user-item" href="./login_usuario.html">
                                                    <i class="fa-solid fa-user users-icon py-2"></i>
                                                </a>
                                                <a class="nav-link user-item" href="#">
                                                    <i class="fa-solid fa-cart-shopping users-icon py-2 px-1"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="d-lg-none align-self-center py-3 d-flex icons-socials">
                                            <a href="" class="nav-link">
                                                <i class="px-2 py-4  fa-brands fa-facebook-f fa-lg text-center"></i>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?phone=51917096358&text=Quiero%20conocer%20m%C3%A1s%20acerca%20de%20tus%20productos%20waza" class="nav-link">
                                                <i class="ps-1 py-4 fa-brands fa-whatsapp fa-lg text-center"></i>
                                            </a>
                                            <a href="" class="nav-link">
                                                <i class="px-2 py-4 fa-brands fa-instagram fa-lg text-center"></i>
                                            </a>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </nav>
                        <section class="form-login">
                            <div class="container login-form-container registro-form">
                                <div class="formulario">
                                    <form action="../Controlador/verificar_codigo.php" method="POST">
                                        <h2 class="title-form-login">Verificación</h2>
                                        <div class="input-contenedor">
                                            <span class="material-symbols-outlined">
                                                rocket_launch
                                            </span>
                                            <input type="hidden" name="email" value="<?php echo $email;?>">
                                            <input type="hidden" name="codigo_web" value="<?php echo $codigo;?>">
                                            <input type="text" required class="input-login" id="codigo_email" name="codigo_email">
                                            <label for="codigo_email" class="lbl-nombres-registro">Ingresar codigo</label>
                                        </div>
                                        <input type="submit" class="btn-acceder" value="Registrarse">
                                        <div class="registrar">
                                            <a href="./index.php" class="volver">Volver a la tienda</a>
                                        </div>
                                </div>
                                </form>
                            </div>
                            </div>
                        </section>
                        <footer class="footer">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 footer-seccion contact-info">
                                        <h4 class="footer-title">Método de Contacto</h4>
                                        <ul class="footer-list">
                                            <li class="footer-info"><strong>Email:</strong> contacto@futbolera.com</li>
                                            <li class="footer-info"><strong>Teléfono:</strong> +51 234 567 890</li>
                                            <li class="footer-info"><strong>Dirección:</strong> Calle Francisco Cabrera 123, Chiclayo, Perú</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 footer-seccion links-footer">
                                        <h4 class="footer-title">Síguenos</h4>
                                        <ul class="footer-list social-media">
                                            <li><a class="footer-link" href="#" target="_blank">
                                                    <i class="fa-brands fa-facebook fa-2xl"> </i>
                                                    Futbolera.pe
                                                </a></li>
                                            <li><a class="footer-link" href="#" target="_blank">
                                                    <i class="fa-brands fa-instagram fa-2xl"></i>
                                                    Futbolera.pe
                                                </a></li>
                                            <li><a class="footer-link" href="#" target="_blank">
                                                    <i class="fa-brands fa-x-twitter fa-2xl"></i>
                                                    Futbolera.pe
                                                </a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 footer-seccion">
                                        <h4 class="footer-title">Sobre Nosotros</h4>
                                        <ul class="footer-list">
                                            <li><a class="footer-link" href="#">Quiénes Somos</a></li>
                                            <li><a class="footer-link" href="#">Formas de Pago</a></li>
                                            <li><a class="footer-link" href="#">Guía de tallas</a></li>
                                            <li><a class="footer-link" href="#">Cambios y Devoluciones</a></li>
                                            <li><a class="footer-link" href="#">Preguntas Frecuentes (FAQ)</a></li>
                                            <li><a class="footer-link" href="#">Términos y condiciones</a></li>
                                            <li><a class="footer-link" href="#">Política de privacidad</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-copy">
                                <p>&copy; 2024 Futbolera. Todos los derechos reservados.</p>
                            </div>
                        </footer>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                    </body>

                    </html>
<?php
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
