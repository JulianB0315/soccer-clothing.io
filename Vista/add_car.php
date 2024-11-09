<?php
session_start();

// Verificar si los datos del producto fueron enviados
if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['product_quantity'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verificar si el producto ya está en el carrito
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            // Si ya existe, aumentar la cantidad
            $item['quantity'] += $product_quantity;
            $found = true;
            break;
        }
    }

    // Si no se encuentra el producto, agregarlo al carrito
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity
        ];
    }

    // Devolver respuesta en formato JSON
    echo json_encode(['status' => 'success', 'message' => 'Producto agregado al carrito']);
} else {
    // Si los datos no son correctos
    echo json_encode(['status' => 'error', 'message' => 'Datos incorrectos']);
}
?>