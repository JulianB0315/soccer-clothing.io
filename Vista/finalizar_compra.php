<?php
session_start();
require '../Controlador/ConectionMySQL.php';

// Verificar que el cliente ha iniciado sesión
if (!isset($_SESSION['id_cliente'])) {
    echo "No has iniciado sesión.";
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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="mb-4">¡Compra realizada con éxito!</h2>
    
    <h4 class="mb-3">Detalles de tu pedido:</h4>
    
    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($cliente['nombres'] . ' ' . $cliente['apellido']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($cliente['email']); ?></p>
    <p><strong>Fecha de Pedido:</strong> <?php echo date("Y-m-d H:i:s", strtotime($pedido['fecha'])); ?></p>
    <p><strong>Total:</strong> S/. <?php echo number_format($pedido['total'], 2); ?></p>
    
    <h5>Productos Comprados:</h5>
    <table class="table">
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
                    <td><?php echo htmlspecialchars($item['producto_nombre']); ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td>S/. <?php echo number_format($item['precio'], 2); ?></td>
                    <td>S/. <?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h4 class="mt-4">Gracias por tu compra, <?php echo htmlspecialchars($cliente['nombres']); ?>!</h4>

    <!-- Botón para volver a la tienda -->
    <a href="shop.php" class="btn btn-primary mt-3">Volver a la tienda</a>
</div>

</body>
</html>
