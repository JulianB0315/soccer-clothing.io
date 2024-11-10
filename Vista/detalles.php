<?php
// Inicia la conexión a la base de datos
require '../Controlador/ConectionMySQL.php';

// Verifica si la conexión se ha establecido correctamente
if (!isset($pdo)) {
    die("No se pudo establecer una conexión con la base de datos.");
}

// Verificar si el parámetro 'id' está presente en la URL y es válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir a entero para mayor seguridad

    try {
        // Preparar la consulta para obtener el producto por su ID
        $stmt = $pdo->prepare("SELECT * FROM Productos WHERE id_producto = :id");
        $stmt->execute([':id' => $id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el producto
        if ($producto) {
            // Aquí puedes seguir con la lógica para mostrar los detalles del producto
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futbolera</title>
    <link rel="icon" href="./imgs/logo-tienda.webp">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/c0cd6ec8ce6d2bbd315a13b62ed13550?family=AdihausDIN" rel="stylesheet">
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
            header("Location: 404.html");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error al consultar el producto: " . $e->getMessage();
    }
} else {
    header("Location: 404.html");
    exit();
}
?>