<?php
// Inicia la conexión a la base de datos
require '../Controlador/ConectionMySQL.php';

// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir a entero para evitar inyección SQL

    // Preparar la consulta para obtener el producto por su ID
    $stmt = $pdo->prepare("SELECT * FROM Productos WHERE id_producto = :id");
    $stmt->execute([':id' => $id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el producto
    if ($producto) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <div class="card">
            <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                <p class="card-text">Precio: S/. <?php echo htmlspecialchars($producto['precio']); ?></p>
                <p class="card-text">Descripción: <?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <p class="card-text">Stock disponible: <?php echo htmlspecialchars($producto['stock']); ?></p>
                <p class="card-text">Marca: <?php echo htmlspecialchars($producto['marca']); ?></p>
                <a href="Galery.php" class="btn btn-primary">Volver al catálogo</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    } else {
        echo "Producto no encontrado.";
    }
} else {
    echo "ID de producto no proporcionado.";
}
?>
