<?php
session_start();

// Agregar producto al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];

    // Crear el producto como array
    $product = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => $product_quantity
    ];

    // Inicializar el carrito si no existe en la sesión
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verificar si el producto ya está en el carrito usando el product_id
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            // Si existe, actualizar la cantidad
            $item['quantity'] += $product_quantity;
            $product_exists = true;
            break;
        }
    }

    // Si no existe, añadir al carrito
    if (!$product_exists) {
        $_SESSION['cart'][] = $product;
    }

    // Redirigir al carrito o catálogo tras añadir
    header("Location: shop.php");
    exit();
}

// Eliminar producto del carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_item'])) {
    $product_id = $_POST['product_id'];

    // Filtrar productos que no coincidan con el producto a eliminar
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($product_id) {
        return $item['id'] !== $product_id;
    });

    header("Location: shop.php");
    exit();
}

// Finalizar compra
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $_SESSION['cart'] = [];
    header("Location: gracias.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container my-5">
    <h2>Carrito de Compras</h2>
    
    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table">
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
                        <form action="shop.php" method="post" style="display:inline;">
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
        
        <!-- Formulario de "Finalizar Compra" -->
        <form action="shop.php" method="post">
            <button type="submit" name="checkout" class="btn btn-success">Finalizar Compra</button>
        </form>
    <?php else: ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>
</div>

</body>
</html>
