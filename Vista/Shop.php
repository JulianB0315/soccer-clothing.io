<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                        <div id="notification" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    Producto añadido al carrito
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto btn-close-noti" onclick="closeNotification()" aria-label="Close"></button>
                            </div>
                        </div>
                        <li class="user-buttons d-flex justify-content-evenly p-2 ">
                            <a class="nav-link user-item" href="./login_usuario.html">
                                <i class="fa-solid fa-user users-icon py-2"></i>
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
    <div class="container my-5">
        <h2>Carrito de Compras</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="table table-bordered">
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
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>S/. <?= number_format($item['price'], 2) ?></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
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
                        <td><strong>S/. <?= number_format($total_price, 2) ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <!-- Finalizar compra -->
            <form action="guardar_carrito.php" method="post">
                <button type="submit" name="checkout" class="btn btn-success">Finalizar Compra</button>
            </form>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>
    </div>
</body>
</html>