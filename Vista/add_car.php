<?php
session_start();

// Verificar si se reciben los datos del producto
if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['product_quantity'])) {
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

    // Verificar si el producto ya está en el carrito
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            // Si existe, actualizar la cantidad
            $item['quantity'] += $product_quantity;
            $product_exists = true;
            break;
        }
    }

    // Si no existe, agregar el producto al carrito
    if (!$product_exists) {
        $_SESSION['cart'][] = $product;
    }

    // Responder con éxito
    echo json_encode(['status' => 'success']);
} else {
    // Responder con error
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}
?>
