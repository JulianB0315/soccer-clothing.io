<?php
session_start();

// Configuración de la respuesta en JSON
header('Content-Type: application/json');

// Captura y decodifica los datos enviados por AJAX
$data = json_decode(file_get_contents("php://input"), true);

// Inicializa el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($data['product_id'], $data['product_name'], $data['product_price'], $data['product_quantity'])) {
    // Validación básica de los datos
    if (is_numeric($data['product_id']) && is_string($data['product_name']) && is_numeric($data['product_price']) && is_numeric($data['product_quantity'])) {
        // Estructura de producto a añadir
        $product = [
            "id" => $data['product_id'],
            "name" => $data['product_name'],
            "price" => $data['product_price'],
            "quantity" => $data['product_quantity'],
        ];

        // Añade el producto a la sesión
        $_SESSION['cart'][] = $product;

        // Respuesta en caso de éxito
        echo json_encode(["success" => true]);
    } else {
        // Respuesta en caso de error de validación
        echo json_encode(["success" => false, "error" => "Invalid data format"]);
    }
} else {
    // Respuesta en caso de error
    echo json_encode(["success" => false, "error" => "Missing data"]);
}
?>
