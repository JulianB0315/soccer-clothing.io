<?php
session_start();

include "ConectionMySQL.php";

// Consulta a la base de datos
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
    <div class="container">
        <div class="row">
            <?php
            // Bucle para mostrar todos los productos
            foreach ($productos as $producto) {
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" class="card-img-top img-catalog" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <div class="card-body">
                            <p class="card-text text-center"><?php echo htmlspecialchars($producto['nombre']); ?></p>
                            <h5 class="card-title text-center">S/. <?php echo number_format($producto['precio'], 2); ?></h5>
                            <form id="addToCartForm">
                                <input type="hidden" name="product_id" value="<?php echo $producto['id_producto']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo number_format($producto['precio'], 2); ?>">
                                <input type="hidden" name="product_quantity" value="1">
                                <a href="#" class="btn btn-primary ms-4 btn-detalles">Ir a detalles</a>
                                <button type="button" class="btn btn-outline-primary btn-cart ms-4 add-to-cart-btn" onclick="addToCart()">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

<script src="carAlert.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
