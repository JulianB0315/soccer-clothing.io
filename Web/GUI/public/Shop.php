<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    // Recibir datos del formulario
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];

    $product = [
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => $product_quantity
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] == $product_name) {
            $item['quantity'] += $product_quantity;
            $product_exists = true;
            break;
        }
    }

    if (!$product_exists) {
        $_SESSION['cart'][] = $product;
    }

    header("Location: Shop.php"); 
    exit();
}
?>
<?php
session_start();
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
                foreach ($_SESSION['cart'] as $key => $item):
                    $item_total = $item['price'] * $item['quantity'];
                    $total_price += $item_total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>S/. <?= number_format($item['price'], 2) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>S/. <?= number_format($item_total, 2) ?></td>
                    <td>
                        <form action="eliminar.php" method="post" style="display:inline;">
                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['name']) ?>">
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
    <?php else: ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>
</div>

</body>
</html>
