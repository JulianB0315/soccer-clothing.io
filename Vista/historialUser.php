<?php
session_start();
require '../Controlador/ConectionMySQL.php';

try {
    if (!isset($_SESSION['id_cliente'])) {
        echo "<script>
                alert('Por favor iniciar sesión');
                window.location = '../Vista/login_usuario.html';
            </script>";
        exit();
    }

    $id_cliente = $_SESSION['id_cliente'];

    $query = "SELECT p.id_pedido, p.fecha, p.total FROM pedidos AS p WHERE p.id_cliente = :id_cliente ORDER BY p.fecha DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_cliente' => $id_cliente]);

    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $queryCliente = "SELECT nombres, apellido FROM clientes WHERE id_cliente = :id_cliente";
    $stmtCliente = $pdo->prepare($queryCliente);
    $stmtCliente->execute(['id_cliente' => $id_cliente]);
    $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        echo "<script>
                alert('Error al obtener datos del cliente.');
                window.location = '../Vista/login_usuario.html';
            </script>";
        exit();
    }

    if (!$pedidos) {
        echo "<script>
                alert('No se encontraron pedidos.');
                window.location = '../Vista/editUser.php';
            </script>";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
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
                            <a class="nav-link user-item" href="./login_usuario.html">
                                <i class="fa-solid fa-user users-icon py-2"></i>
                            </a>
                            <a class="nav-link user-item" href="Shop.php">
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
    <!-- Main page content-->
    <main class="pt-5 bg-body-secondary pb-4">
        <div class="container-xl px-4 mt-4 pt-5">
            <!-- Navegacion-->
            <nav class="nav nav-borders">
                <a class="nav-link ms-0" href="./editUser.php">Perfil</a>
                <a class="nav-link active" href="./historialUser.php">Historial</a>
            </nav>
            <hr class="mt-0 mb-4" />
            <!-- Historial de compras-->
            <div class="card mb-4">
                <div class="card-header">Historial de compras</div>
                <div class="card-body p-0">
                    <div class="table-responsive table-billing-history">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha</th>
                                    <th>ID Compra</th>
                                    <th>Detalles</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cliente['nombres'] . ' ' . $cliente['apellido']); ?></td>
                                        <td><?= htmlspecialchars($pedido['fecha']); ?></td>
                                        <td><?= htmlspecialchars($pedido['id_pedido']); ?></td>
                                        <td>
                                            <button class="btn btn-info btnVerDetalles"
                                                data-bs-toggle="modal"
                                                data-bs-target="#verProductosModal"
                                                data-id-pedido="<?= $pedido['id_pedido']; ?>"
                                                data-nombre-cliente="<?= $cliente['nombres']; ?>"
                                                data-fecha="<?= $pedido['fecha']; ?>"
                                                data-total="<?= $pedido['total']; ?>">
                                                Ver
                                            </button>
                                        </td>
                                        <td>S/. <?= htmlspecialchars($pedido['total']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para ver productos -->
        <div class="modal fade" id="verProductosModal" tabindex="-1" role="dialog" aria-labelledby="verProductosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                    <!-- Header del Modal -->
                    <div class="modal-header" style="background-color: #f5f5f5; border-bottom: 2px solid #e0e0e0;">
                        <h5 class="modal-title fw-bold" id="verProductosModalLabel" style="color: #333;">Detalles de Compra</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" style="font-family: 'Inter', sans-serif; color: #e2e0e0;">
                        <!-- Resumen del Pedido -->
                        <div class="mb-4">
                            <h6 class="fw-bold" style="color: #ffffff; border-bottom: 2px solid #e2e0e0; padding-bottom: 5px;">Resumen</h6>
                            <div class="d-flex justify-content-between">
                                <p class="mb-1"><strong>Nombre:</strong></p>
                                <p class="mb-1" id="nombreCliente"></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="mb-1"><strong>ID de pedido:</strong></p>
                                <p class="mb-1" id="idPedido"></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="mb-1"><strong>Fecha del pedido:</strong></p>
                                <p class="mb-1" id="fechaPedido"></p>
                            </div>
                            <div class="d-flex justify-content-between fw-bold">
                                <p class="mb-1">Total:</p>
                                <p id="totalCompra" style="color: #e2e0e0"></p>
                            </div>
                        </div>
                        <!-- Detalles de los Productos -->
                        <!-- <ul>
                            <?php foreach ($productos as $producto): ?>
                                <li><?= $producto['nombre']; ?> - Cantidad: <?= $producto['cantidad']; ?> - S/. <?= number_format($producto['precio'], 2); ?></li>
                            <?php endforeach; ?>
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>


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
    <!-- Bootstrap Bundle JS (incluye Popper) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesVer = document.querySelectorAll('.btnVerDetalles');

            botonesVer.forEach(function(boton) {
                boton.addEventListener('click', function(event) {
                    // Obtener los datos del botón
                    const idPedido = event.target.getAttribute('data-id-pedido');
                    const nombreCliente = event.target.getAttribute('data-nombre-cliente');
                    const fechaPedido = event.target.getAttribute('data-fecha');
                    const totalCompra = event.target.getAttribute('data-total');

                    // Actualizar los campos del modal con los datos del pedido
                    document.getElementById('nombreCliente').innerText = nombreCliente;
                    document.getElementById('idPedido').innerText = idPedido;
                    document.getElementById('fechaPedido').innerText = fechaPedido;
                    document.getElementById('totalCompra').innerText = "S/. " + totalCompra;

                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>