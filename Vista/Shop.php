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
        <form action="checkout.php" method="post">
            <button type="submit" name="checkout" class="btn btn-success">Finalizar Compra</button>
        </form>
    <?php else: ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>
</div>

</body>
</html>
