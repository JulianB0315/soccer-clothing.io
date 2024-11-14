<?php
session_start();

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
    $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
    $stmt->execute();

    $imagenPerfil = $stmt->fetchColumn();

    // Si no hay imagen de perfil, usa una imagen predeterminada
    if (empty($imagenPerfil)) {
        $imagenPerfil = "uploads/perfil/Por defecto.png";
    }
}
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
</head>

<body>
    <!-- Navbar -->
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
                        <li class="user-buttons d-flex justify-content-evenly p-2 ">
                            <a class="nav-link user-item" id="user-link" href="<?php echo $link; ?>">
                                <img src="<?php echo $imagenPerfil; ?>" class="profile-img">
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
                        <a href="" class="nav-link">
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
    <!-- Main -->
    <main class="main-content d-flex position-relative flex-wrap" id="main">
        <div class="container my-4 d-flex justify-content-center pt-5 pb-5 flex-wrap">
            <!-- Columna izquierda -->
            <div class="col-md-3 col-sm-6 pt-5">
                <div class="product-card">
                    <img src="./imgs/novedades/modelo2.webp" class="img-fluid" alt="Producto 1">
                    <div class="overlay">
                        <h5 class="text-white text-center">Adidas Horizon Pack</h5>
                        <button class="btn btn-primary">Ver más</button>
                    </div>
                </div>
                <div class="product-card mt-1">
                    <img src="./imgs/novedades/modelo4.webp" class="img-fluid" alt="Producto 2">
                    <div class="overlay">
                        <h5 class="text-white text-center">Adidas Vivid Horizon Pack</h5>
                        <button class="btn btn-primary">Ver más</button>
                    </div>
                </div>
            </div>

            <!-- Imagen grande en el centro -->
            <div class="col-md-6 col-sm-12 pt-5">
                <div class="product-card">
                    <img src="./imgs/novedades/modelo1.webp" class="img-fluid" alt="Producto central">
                    <div class="overlay">
                        <h5 class="text-white text-center">Producto Central</h5>
                        <button class="btn btn-primary">Ver Más</button>
                    </div>
                </div>
            </div>
            <div class="container my-4 d-flex justify-content-center pt-5 pb-5 flex-wrap">
                <!-- Columna izquierda -->
                <div class="col-md-3 col-sm-6 pt-5">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo2.webp" class="img-fluid" alt="Producto 1">
                        <div class="overlay">
                            <h5 class="text-white text-center">Adidas Horizon Pack</h5>
                            <button class="btn btn-primary">Ver más</button>
                        </div>
                    </div>
                    <div class="product-card mt-1">
                        <img src="./imgs/novedades/modelo4.webp" class="img-fluid" alt="Producto 2">
                        <div class="overlay">
                            <h5 class="text-white text-center">Adidas Vivid Horizon Pack</h5>
                            <button class="btn btn-primary">Ver más</button>
                        </div>
                    </div>
                </div>

                <!-- Imagen grande en el centro -->
                <div class="col-md-6 col-sm-12 pt-5">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo1.webp" class="img-fluid" alt="Producto central">
                        <div class="overlay">
                            <h5 class="text-white text-center">Producto Central</h5>
                            <button class="btn btn-primary">Ver Más</button>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha -->
                <div class="col-md-3 col-sm-6 pt-5">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo3.webp" class="img-fluid" alt="Producto 3">
                        <div class="overlay">
                            <h5 class="text-white text-center">Adidas Horizon Pack</h5>
                            <button class="btn btn-primary">Ver más</button>
                        </div>
                    </div>
                    <div class="product-card mt-1">
                        <img src="./imgs/novedades/modelo5.webp" class="img-fluid" alt="Producto 4">
                        <div class="overlay">
                            <h5 class="text-white text-center">Adidas Vivid Horizon Pack</h5>
                            <button class="btn btn-primary">Ver más</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de productos adicionales -->
            <div class="container my-4 d-flex justify-content-center pb-5 flex-wrap">
                <div class="col-md-3 col-sm-6 pt-5">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo1.webp" class="img-fluid" alt="Producto 5">
                        <div class="overlay">
                            <h5 class="text-white text-center">Adidas Horizon Pack</h5>
                            <button class="btn btn-primary">Ver más</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 pt-5">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo2.webp" class="img-fluid" alt="Producto 6">
                        <div class="overlay">
                            <h5 class="text-white text-center">Producto 6</h5>
                            <button class="btn btn-primary">Ver Más</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 pt-5">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo3.webp" class="img-fluid" alt="Producto 7">
                        <div class="overlay">
                            <h5 class="text-white text-center">Producto 7</h5>
                            <button class="btn btn-primary">Ver Más</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 pt-5">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo4.webp" class="img-fluid" alt="Producto 8">
                        <div class="overlay">
                            <h5 class="text-white text-center">Producto 8</h5>
                            <button class="btn btn-primary">Ver Más</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo1.webp" class="img-fluid" alt="Producto 5">
                        <div class="overlay">
                            <h5 class="text-white text-center">Adidas Horizon Pack</h5>
                            <button class="btn btn-primary">Ver más</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo2.webp" class="img-fluid" alt="Producto 6">
                        <div class="overlay">
                            <h5 class="text-white text-center">Producto 6</h5>
                            <button class="btn btn-primary">Ver Más</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo3.webp" class="img-fluid" alt="Producto 7">
                        <div class="overlay">
                            <h5 class="text-white text-center">Producto 7</h5>
                            <button class="btn btn-primary">Ver Más</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="product-card">
                        <img src="./imgs/novedades/modelo4.webp" class="img-fluid" alt="Producto 8">
                        <div class="overlay">
                            <h5 class="text-white text-center">Producto 8</h5>
                            <button class="btn btn-primary">Ver Más</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center mb-4">
                <button class="btn btn-outline-primary btn-lg">Más lanzamientos de material de fútbol</button>
            </div>

            <!-- Botón de whatsapp fijado siempre a la pantalla -->
            <a href="#" class="whatsapp-link" target="_blank">
                <i class="fa-brands fa-whatsapp py-4 whatsapp-icon"></i>
            </a>
    </main>


    <!-- Pie de pagina / Footer -->
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