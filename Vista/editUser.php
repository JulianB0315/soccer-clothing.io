
<?php
session_start();
require '../Controlador/ConectionMySQL.php';

 // Verificar si id_cliente está en la sesión
try {
    // Verificar si id_cliente está en la sesión
    if (isset($_SESSION['id_cliente'])) {
        $id_cliente = $_SESSION['id_cliente'];

        // Consulta para obtener los datos del cliente incluyendo imagen_perfil
        $query = "SELECT id_cliente, nombres, apellido, email, telefono, direccion, apodo, imagen_perfil FROM clientes WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($query); // Usamos PDO
        $stmt->execute(['id_cliente' => $id_cliente]);

        // Obtener los resultados
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            echo "<script>
            alert('Por favor iniciar sesión');
            window.location = '../Vista/login_usuario.html'; 
            </script>";
        } else {
            // Verificar si existe la imagen de perfil, si no, asignar la imagen por defecto
            $imagenPerfil = $cliente['imagen_perfil'] ? $cliente['imagen_perfil'] : '../Vista/imgs/novedades/modelo1.webp';
        }
    } else {
        echo "<script>
            alert('Por favor iniciar sesión');
            window.location = '../Vista/login_usuario.html'; 
            </script>";
    }
} catch (PDOException $e) {
    echo "Error al consultar la base de datos: " . $e->getMessage();
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
    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #081625;">
        <div class="container-fluid">
            <a class="navbar-brand text-light fw-semibold fs-2" href="./index.html">
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
                            <a class="nav-link" href="./novedades.html">Novedades</a>
                        </li>
                        <li class="nav-item p-3 ">
                            <a class="nav-link" href="./Catalogo.php">Catálogo</a>
                        </li>
                        <li class="nav-item p-3 ">
                            <a class="nav-link" href="ofertas.php">Ofertas</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="./index.html#contacto">Contacto</a>
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
    <main>
        <!-- Comienzo de la pagina de editar perfil -->
        <div id="layoutSidenav_content" class="bg-light pt-4" >
            <main>
                <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
                    <div class="container-xl px-4">
                        <div class="page-header-content">
                            <div class="row align-items-center justify-content-between pt-3">
                                <div class="col-auto mb-3">
                                    <h1 class="page-header-title">
                                        <div class="page-header-icon"><i data-feather="user"></i></div>
                                        Configuracion - Perfil
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- Main page content-->
                <div class="container-xl px-4 mt-4">
                    <!-- Account page navigation-->
                    <nav class="nav nav-borders">
                        <a class="nav-link active ms-0" href="#">Perfil</a>
                        <a class="nav-link" href="#">Historial</a>
                    </nav>
                    <hr class="mt-0 mb-4" />
                    <div class="row">
                        <div class="col-xl-4">
                            <!-- Profile picture card-->
                            <div class="card mb-4 mb-xl-0">
                                <div class="card-header">Foto de Perfil</div>
                                <div class="card-body text-center">
                                    <!-- Profile picture image-->
                                    <img class="img-account-profile rounded-circle mb-2" id="profilePic" src="<?php echo $imagenPerfil; ?>" alt="" />
                                    <!-- Profile picture help block-->
                                    <div class="small font-italic text-muted mb-4">JPG o PNG no mayor de 5 MB</div>
                                    <!-- Profile picture upload form-->
                                    <form action="upload_image.php" method="POST" enctype="multipart/form-data">
                                        <!-- File input for image -->
                                        <input type="file" name="profile_image" accept="image/jpeg, image/png" class="form-control mb-3" required />
                                        <!-- Submit button -->
                                        <button class="btn btn-primary" type="submit">Sube una imagen</button>
                                    </form>
                                </div>
    
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <!-- Account details card-->
                            <div class="mb-4">
                                <div class="card-header">Detalles de la Cuenta</div>
                                <div class="card-body">
                                    <form method="post" action="guardar_cambios_user.php">
                                        <!-- Form Group (username)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputUsername">Nombre de Usuario:</label>
                                            <input class="form-control" id="inputUsername" type="text" placeholder="Ingresa tu nombre de usuario" value="<?php echo htmlspecialchars($cliente['apodo']); ?>" disabled />
                                        </div>
                                        <!-- Form Row-->
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (first name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputFirstName">Nombre:</label>
                                                <input class="form-control" id="inputFirstName" type="text" placeholder="Ingresa tu nombre" value="<?php echo htmlspecialchars($cliente['nombres']); ?>" disabled />
                                            </div>
                                            <!-- Form Group (last name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputLastName">Apellido:</label>
                                                <input class="form-control" id="inputLastName" type="text" placeholder="Ingresa tu apellido" value="<?php echo htmlspecialchars($cliente['apellido']); ?>" disabled />
                                            </div>
                                        </div>
                                        <!-- Form Row-->
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (location)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputLocation">Ubicación:</label>
                                                <input class="form-control" id="inputLocation" type="text" placeholder="Ingresa tu ubicacion" value="<?php echo htmlspecialchars($cliente['direccion']); ?>" disabled />
                                            </div>
                                        </div>
                                        <!-- Form Group (email address)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmailAddress">Correo Electronico:</label>
                                            <input class="form-control" id="inputEmailAddress" type="email" placeholder="Ingresa tu email" value="<?php echo htmlspecialchars($cliente['email']); ?>" disabled />
                                        </div>
                                        <!-- Form Row-->
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (phone number)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputPhone">Numero telefonico:</label>
                                                <input class="form-control" id="inputPhone" type="tel" placeholder="Ingresa tu numero" value="<?php echo htmlspecialchars($cliente['telefono']); ?>" disabled />
                                            </div>
                                            <!-- Form Group (birthday)-->
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <!--Save changes button-->
                                            <button class="btn btn-primary me-3" type="button" onclick="habilitarCampos()">Editar perfil</button>
                                            <button class="btn btn-primary me-3 " type="button" id="guardarCambios" disabled onclick="deshabilitarCampos()">Guardar cambios</button>
                                            <button class="btn btn-primary me-3 " type="button" id="cancelarCambios" disabled onclick="deshabilitarCampos()">Cancelar cambios</button>
                                        </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </main>

    <!-- Scripts  para los botones -->

    <script>
        // Función para habilitar los cosos del form
        function habilitarCampos() {
            const inputs = document.querySelectorAll('input.form-control');
            inputs.forEach(input => input.disabled = false);

            // Se supone q con este se habilita el para guardar cambios
            document.getElementById('guardarCambios').disabled = false;
            document.getElementById('cancelarCambios').disabled = false;
        }

        // Función para deshabilitar
        function deshabilitarCampos() {
            const inputs = document.querySelectorAll('input.form-control');
            inputs.forEach(input => input.disabled = true);

            // Se supone q con este se deshabilita el para guardar cambios
            document.getElementById('guardarCambios').disabled = true;
            document.getElementById('cancelarCambios').disabled = true;
        }
    </script>
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