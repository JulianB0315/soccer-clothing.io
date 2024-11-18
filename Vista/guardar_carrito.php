<?php
session_start();
require '../Controlador/ConectionMySQL.php';
function generarIdPedido() {
    $prefijo = "P";  
    $fecha = date('ymd');  
    $hora = date('His');  
    $milisegundos = substr((string)microtime(), 2, 3); 

    $id = $prefijo . $fecha . $hora . $milisegundos;
    // Asegurarnos de que el ID tenga exactamente 8 caracteres.
    if (strlen($id) > 18) {
        $id = substr($id, 0, 8);  
    }

    return $id;
}
$id = generarIdPedido();
$id_pedido=$id;
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
    $stmt = $pdo->prepare("INSERT INTO pedidos (id_pedido,id_cliente, total, estado) VALUES (?,?, ?, 'pendiente')");
    $stmt->execute([$id_pedido,$clienteId, $total_price]);


    // Insertar los detalles del pedido en la tabla 'detalles_pedido'
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
        // Insertar el detalle del pedido en la base de datos
        $stmt = $pdo->prepare("INSERT INTO detalles_pedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_pedido, $item['id'], $item['quantity'], $item['price']]);
        // Actualizar el stock del producto en la base de datos
        $stmt_update = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
        $stmt_update->execute([$item['quantity'], $item['id']]);
    }

    // Actualizar el total del pedido
    $stmt = $pdo->prepare("UPDATE pedidos SET total = ? WHERE id_pedido = ?");
    $stmt->execute([$total_price, $id_pedido]);

    // Vaciar el carrito después de guardar los datos
    unset($_SESSION['cart']);

    // Redirigir a la página de finalización de compra
    header("Location: finalizar_compra.php");
    exit();
} catch (PDOException $e) {
    die("Error al procesar el carrito: " . $e->getMessage());
}
