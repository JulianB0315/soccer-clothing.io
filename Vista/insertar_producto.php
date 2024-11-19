<?php
require '../Controlador/ConectionMySQL.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function idProductos()
    {
        $id = 'P';
        for ($i = 0; $i < 7; $i++) {
            $id .= rand(0, 9);
        }
        return $id;
    }
    $id_producto = idProductos();

    // Obtener los datos del formulario
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
    $oferta = filter_input(INPUT_POST, 'oferta', FILTER_SANITIZE_STRING);
    $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
    $talla = filter_input(INPUT_POST, 'talla', FILTER_SANITIZE_STRING);
    $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_STRING);
    $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);

    // Procesar la imagen cargada
    // Procesar la imagen cargada
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/avif'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $mime_type = mime_content_type($imagen_tmp);

        // Verificación manual para AVIF
        if (pathinfo($imagen_nombre, PATHINFO_EXTENSION) === 'avif') {
            $mime_type = 'image/avif';
        }

        if (in_array($mime_type, $tipos_permitidos)) {
            $directorio_destino = 'uploads/Catalogo/';
            $imagen_extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
            $imagen_url = $directorio_destino . uniqid() . '.' . $imagen_extension;

            if (move_uploaded_file($imagen_tmp, $imagen_url)) {
                echo "Imagen cargada con éxito.";
            } else {
                echo "Error al cargar la imagen.";
            }
        } else {
            echo "Solo se permiten archivos de imagen (JPG, JPEG, PNG, GIF, WebP, AVIF).";
        }
    } else {
        echo "No se seleccionó ninguna imagen o ocurrió un error al cargarla.";
    }



    // Insertar el producto en la base de datos
    if ($nombre && $precio && $stock) {
        $query = $pdo->prepare("INSERT INTO productos (id_producto, nombre, descripcion, precio, stock, oferta, id_categoria, talla, marca, color, imagen_url)
                                VALUES (:id_producto, :nombre, :descripcion, :precio, :stock, :oferta, :id_categoria, :talla, :marca, :color, :imagen_url)");

        $query->execute([
            'id_producto' => $id_producto,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'stock' => $stock,
            'oferta' => $oferta,
            'id_categoria' => $id_categoria,
            'talla' => $talla,
            'marca' => $marca,
            'color' => $color,
            'imagen_url' => $imagen_url
        ]);

        echo "Producto agregado correctamente.";
    } else {
        echo "Por favor, complete todos los campos obligatorios.";
    }
}
?>

<!-- Formulario HTML para ingresar el producto -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Agregar Producto</h2>
        <form method="post" action="insertar_producto.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" required step="0.01">
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="oferta">Oferta</label>
                <input type="text" class="form-control" id="oferta" name="oferta">
            </div>
            <div class="form-group">
                <label for="id_categoria">ID Categoría</label>
                <input type="text" class="form-control" id="id_categoria" name="id_categoria">
            </div>
            <div class="form-group">
                <label for="talla">Talla</label>
                <input type="text" class="form-control" id="talla" name="talla">
            </div>
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca">
            </div>
            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" class="form-control" id="color" name="color">
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
        </form>
    </div>
</body>

</html>