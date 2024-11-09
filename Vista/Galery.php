<?php
session_start();

require '../Controlador/ConectionMySQL.php';

// Verifica si la variable $pdo está definida
if (!$pdo) {
    die("No se pudo establecer una conexión con la base de datos.");
}

$query = $pdo->query("SELECT * FROM productos WHERE stock > 0");
$productos = $query->fetchAll(PDO::FETCH_ASSOC);
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
            <a class="navbar-brand text-light fw-semibold fs-2" href="./index.html">
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
                            <a class="nav-link" href="./novedades.html">Novedades</a>
                        </li>
                        <li class="nav-item p-3 ">
                            <a class="nav-link" href="Galery.php">Galería</a>
                        </li>
                        <li class="nav-item p-3 ">
                            <a class="nav-link" href="#">Ofertas</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="./index.html#contacto">Contacto</a>
                        </li>
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
    <!-- No toque esto diego cabron -->
    <div class="container">
        <div class="row">
            <?php
            // Verifica que haya productos disponibles
            if (empty($productos)) {
                echo "<p>No hay productos disponibles.</p>";
            } else {
                // Bucle para mostrar todos los productos
                foreach ($productos as $producto) {
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" class="card-img-top img-catalog" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <div class="card-body">
                            <p class="card-text text-center"><?php echo htmlspecialchars($producto['nombre']); ?></p>
                            <h5 class="card-title text-center">S/. <?php echo number_format($producto['precio'], 2); ?></h5>
                            <form id="addToCartForm<?php echo $producto['id_producto']; ?>">
                                <input type="hidden" name="product_id" value="<?php echo $producto['id_producto']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo number_format($producto['precio'], 2); ?>">
                                <input type="hidden" name="product_quantity" value="1">
                                <a href="detalles.php?id=<?php echo htmlspecialchars($producto['id_producto']); ?>" class="btn btn-primary ms-4 btn-detalles">Ir a detalles</a>
                                <button type="button" class="btn btn-outline-primary btn-cart ms-4 add-to-cart-btn" onclick="addToCart(<?php echo $producto['id_producto']; ?>)">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <!-- Fin no toque esto diego cabron -->
</body>
<script src="carAlert.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
