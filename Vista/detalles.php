<?php

session_start();

// Verificar si el usuario ha iniciado sesión
require '../Controlador/ConectionMySQL.php'; // Conexión PDO

//Verifica el inicio de sesión 
if (!isset($_SESSION['id_cliente'])) {
    $link = "./login_usuario.html";
    $imagenPerfil = "uploads/perfil/Por defecto.png"; // 
} else {
    $idCliente = $_SESSION['id_cliente'];
    $link = "editUser.php";

    // Consulta para obtener la imagen de perfil del cliente
    $query = "SELECT imagen_perfil FROM clientes WHERE id_cliente = :id_cliente";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_STR);
    $stmt->execute();

    $imagenPerfil = $stmt->fetchColumn();

    // Si no hay imagen de perfil, usa una imagen predeterminada
    if (empty($imagenPerfil)) {
        $imagenPerfil = "uploads/perfil/Por defecto.png";
    }
}

// Verificar si el parámetro 'id' está presente en la URL y es válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir a entero para mayor seguridad

    try {
        // Preparar la consulta para obtener el producto por su ID
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE id_producto = :id");
        $stmt->execute([':id' => $id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el producto
        if ($producto) {
            // Aquí puedes seguir con la lógica para mostrar los detalles del producto
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
                <link href="https://db.onlinewebfonts.com/c/c0cd6ec8ce6d2bbd315a13b62ed13550?family=AdihausDIN" rel="stylesheet">
            </head>

            <body>
                <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #081625;">
                    <div class="container-fluid">
                        <a class="navbar-brand text-light fw-semibold fs-2" href="./index.php">
                            <img src="./imgs/logo-tienda.webp" alt="Shop logo" width="70" height="70"
                                class="d-inline-block align-text-center">
                            Futbolera
                        </a>
                        <button class="navbar-toggler bg-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offCanvas" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <section class="offcanvas offcanvas-end" id="offCanvas" tabindex="-1">
                            <div clasS="offcanvas-header" data-bs-theme="principal">
                                <h5 class="offcanvas-title fs-1 p-3">Futbolera</h5>
                                <button class="btn-close bg-primary" type="button" aria-label="Close"
                                    data-bs-dismiss="offcanvas"></button>
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
                                    <div id="notification"
                                        class="toast align-items-center text-bg-primary border-0"
                                        role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="d-flex">
                                            <div class="toast-body">
                                                Producto añadido al carrito
                                            </div>
                                            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="closeNotification()"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                    <li class="user-buttons d-flex justify-content-evenly p-2 ">
                                        <a class="nav-link user-item" id="user-link" href="<?php echo $link; ?>">
                                            <img src="<?php echo $imagenPerfil; ?>" class="profile-img">
                                        </a>
                                        <a class="nav-link user-item" href="./shop.php">
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
                <main class="main-content d-flex position-relative flex-wrap" id="main">
                    <div class="container-fluid my-5">
                        <div class="row row-detalle">
                            <div class="col-lg-6 col-md-12 p-3">
                                <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <h5 class="detalle-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                <p class="detalle-text">Descripción: <?php echo htmlspecialchars($producto['descripcion']); ?></p>
                                <p class="detalle-text">Stock disponible: <?php echo htmlspecialchars($producto['stock']); ?></p>
                                <p class="detalle-text">Marca: <?php echo htmlspecialchars($producto['marca']); ?></p>
                                <a href="./Catalogo.php" class="btn btn-primary">Volver al catálogo</a>
                            </div>
                        </div>
                    </div>
                    <!-- Botón de whatsapp fijado siempre a la pantalla -->
                    <a href="https://api.whatsapp.com/send?phone=51917096358&text=Quiero%20conocer%20m%C3%A1s%20acerca%20de%20tus%20productos%20waza" class="whatsapp-link" target="_blank">
                        <i class="fa-brands fa-whatsapp py-4 whatsapp-icon"></i>
                    </a>
                </main>
                <footer class="footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 footer-seccion contact-info">
                                <h4 class="footer-title">Método de Contacto</h4>
                                <ul class="footer-list">
                                    <li class="footer-info"><strong>Email:</strong> contacto@futbolera.com</li>
                                    <li class="footer-info"><strong>Teléfono:</strong> +51 234 567 890</li>
                                    <li class="footer-info"><strong>Dirección:</strong> Calle Francisco Cabrera 123, Chiclayo, Perú
                                    </li>
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
            header("Location: 404.html");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error al consultar el producto: " . $e->getMessage();
    }
} else {
    header("Location: 404.html");
    exit();
}
?>