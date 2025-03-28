<?php
session_start();
require '../Controlador/ConectionMySQL.php';

// Verificar que el cliente ha iniciado sesión
if (!isset($_SESSION['id_cliente'])) {
    echo  "<script>
            alert('Por favor iniciar sesión');
            window.location = '../Vista/login_usuario.html'; 
          </script>";
    exit();
}

// Obtener los detalles del pedido
$clienteId = $_SESSION['id_cliente'];

// Obtener los últimos detalles del pedido del cliente
try {
    $stmt = $pdo->prepare("SELECT * FROM pedidos WHERE id_cliente = ? ORDER BY fecha DESC LIMIT 1");
    $stmt->execute([$clienteId]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pedido) {
        echo "No se encontró el pedido.";
        exit();
    }

    // Obtener los detalles del pedido
    $stmt = $pdo->prepare("SELECT dp.*, p.nombre AS producto_nombre FROM detalles_pedido dp JOIN productos p ON dp.id_producto = p.id_producto WHERE dp.id_pedido = ?");
    $stmt->execute([$pedido['id_pedido']]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los detalles del pedido: " . $e->getMessage());
}

// Obtener los datos del cliente
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmt->execute([$clienteId]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['id_cliente'])) {
    $link = "./login_usuario.html";
    $icon = '<i class="fa-solid fa-user users-icon py-2"></i>';
} else {
    $idCliente = $_SESSION['id_cliente'];
    $link = "editUser.php";
    // Consulta para obtener la imagen de perfil del cliente
    $query = "SELECT imagen_perfil FROM clientes WHERE id_cliente = :id_cliente";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_STR);
    $stmt->execute();

    $imagenPerfil = $stmt->fetchColumn();
    $icon = '<img src="'.$imagenPerfil.'" class="profile-img">';
    // Si no hay imagen de perfil, usa una imagen predeterminada
    if (empty($imagenPerfil)) {
        $icon = '<i class="fa-solid fa-user users-icon py-2"></i>';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Compra</title>
    <link rel="icon" href="./imgs/logo-tienda.webp">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
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
                        <div id="notification" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    Producto añadido al carrito
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto btn-close-noti" onclick="closeNotification()" aria-label="Close"></button>
                            </div>
                        </div>
                        <li class="user-buttons d-flex justify-content-evenly p-2 ">
                            <a class="nav-link user-item" id="user-link" href="<?php echo $link; ?>">
                                <?php echo $icon; ?>
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
        <!-- Container para subdividir en dos secciones el main -->
        <div class="container container-compra">
            <h2 class="mb-4 compra-title">¡Compra realizada con éxito!</h2>
            <h4 class="mb-3 compra-subtitle">Detalles de tu pedido:</h4>
            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($cliente['nombres'] . ' ' . $cliente['apellido']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($cliente['email']); ?></p>
            <p><strong>Fecha de Pedido:</strong> <?php echo date("Y-m-d H:i:s", strtotime($pedido['fecha'])); ?></p>
            <p><strong>Total:</strong> S/. <?php echo number_format($pedido['total'], 2); ?></p>
            <h5 class="mt-3 compra-subtitle">Productos Comprados:</h5>
            <table class="table compra-tabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $item) { ?>
                        <tr>
                            <td class="marcado"><?php echo htmlspecialchars($item['producto_nombre']); ?></td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td class="marcado">S/. <?php echo number_format($item['precio'], 2); ?></td>
                            <td>S/. <?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h4 class="mt-4 compra-title">Gracias por tu compra, <?php echo htmlspecialchars($cliente['nombres']); ?>!</h4>
            <!-- Botón para volver a la tienda -->
            <a href="index.php" class="btn btn-primary mt-3">Volver a la tienda</a>
        </div>
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