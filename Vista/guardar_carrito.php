<?php
session_start();
require '../Controlador/ConectionMySQL.php';

// Verificar que el carrito no está vacío o no está logueado 
if (empty($_SESSION['cart'])) {
    echo  "<script>
            alert('No hay productos en el carrito');
            window.location = 'Catalogo.php'; 
        </script>";
    exit();
}
if (!isset($_SESSION['id_cliente'])) {
    echo  "<script>
            alert('Por favor iniciar sesión');
            window.location = 'login_usuario.html';
        </script>";
    exit();
}

// Guardar los productos del carrito en la base de datos
$clienteId = $_SESSION['id_cliente'];
$total_price = 0;

try {
    // Insertar el pedido en la tabla 'pedidos'
    $stmt = $pdo->prepare("INSERT INTO pedidos (id_cliente, total, estado) VALUES (?, ?, 'pendiente')");
    $stmt->execute([$clienteId, $total_price]);

    // Obtener el ID del pedido recién insertado
    $pedidoId = $pdo->lastInsertId();

    // Insertar los detalles del pedido en la tabla 'detalles_pedido'
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
        $stmt = $pdo->prepare("INSERT INTO detalles_pedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pedidoId, $item['id'], $item['quantity'], $item['price']]);
    }

    // Actualizar el total del pedido
    $stmt = $pdo->prepare("UPDATE pedidos SET total = ? WHERE id_pedido = ?");
    $stmt->execute([$total_price, $pedidoId]);

    // Vaciar el carrito después de guardar los datos
    unset($_SESSION['cart']);

    // Redirigir a la página de finalización de compra
    header("Location: finalizar_compra.php");
    exit();
} catch (PDOException $e) {
    die("Error al procesar el carrito: " . $e->getMessage());
}
