<?php
require '../Controlador/ConectionMySQL.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function generarIdCliente() {
        $prefijo = "P";  
        $fecha = date('md');  
        $hora = date('Hs');  
    
        $id = $prefijo . $fecha . $hora ;
        // Asegurarnos de que el ID tenga exactamente 8 caracteres.
        if (strlen($id) > 8) {
            $id = substr($id, 0, 8);  
        }
    
        return $id;
    }
    $id = generarIdCliente();
    $id_producto=$id;
    
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
    $imagen_url = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
        
        // Verificar que la extensión sea una de las permitidas (por ejemplo, jpg, jpeg, png, webp)
        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array(strtolower($imagen_extension), $extensiones_permitidas)) {
            // Verificar si la imagen es válida
            $image_info = getimagesize($imagen_tmp);
            if ($image_info !== false) {
                // Definir la ruta donde se guardará la imagen
                $directorio_destino = 'uploads/Catalogo/';
                $imagen_url = $directorio_destino . uniqid() . '.' . $imagen_extension;
                
                // Mover la imagen a la carpeta del servidor
                if (move_uploaded_file($imagen_tmp, $imagen_url)) {
                    echo "Imagen cargada con éxito.";
                } else {
                    echo "Error al cargar la imagen.";
                }
            } else {
                echo "El archivo no es una imagen válida.";
            }
        } else {
            echo "Solo se permiten archivos JPG, JPEG, PNG o WebP.";
        }
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
