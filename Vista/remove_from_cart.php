<?php
session_start();

// Verificar si se ha enviado el ID del producto para eliminar
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Verificar si el carrito existe en la sesión
    if (isset($_SESSION['cart'])) {
        // Filtrar el carrito para eliminar el producto con el ID dado
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($product_id) {
            return $item['id'] != $product_id;
        });

        // Reindexar el array del carrito para evitar huecos en los índices
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    // Redirigir de vuelta al carrito de compras
    header("Location: shop.php");
    exit();
} else {
    // Si no se recibe el ID del producto, redirigir con mensaje de error
    header("Location: shop.php");
    exit();
}