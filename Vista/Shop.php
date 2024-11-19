<?php
session_start();
require '../Controlador/ConectionMySQL.php';

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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
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
        <div class="container carrito-container">
            <h2 class="carrito-title">Carrito de Compras</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <table class="table carrito-tabla">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_price = 0;
                        foreach ($_SESSION['cart'] as $item):
                            $item_total = $item['price'] * $item['quantity'];
                            $total_price += $item_total;
                        ?>
                            <tr>
                                <td class="marcado"><?= htmlspecialchars($item['name']) ?></td>
                                <td>S/. <?= number_format($item['price'], 2) ?></td>
                                <td class="marcado"><?= htmlspecialchars($item['quantity']) ?></td>
                                <td>S/. <?= number_format($item_total, 2) ?></td>
                                <td>
                                    <!-- Formulario para eliminar el producto -->
                                    <form action="remove_from_cart.php" method="post" style="display:inline;">
                                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['id']) ?>">
                                        <button type="submit" name="remove_item" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td class="marcado"><strong>S/. <?= number_format($total_price, 2) ?></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Finalizar compra -->
                <form action="guardar_carrito.php" method="post" class="finalizar-compra-form">
                    <button type="submit" name="checkout" class="btn btn-success btn-comprar">Finalizar Compra</button>
                </form>
            <?php else: ?>
                <p class="carrito-vacio">Tu carrito está vacío.</p>
            <?php endif; ?>
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