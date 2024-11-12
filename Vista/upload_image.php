<?php
session_start();

require '../Controlador/ConectionMySQL.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_cliente'])) {
    header("Location: login_usuario.html");
    exit();
}

// Verificar si se ha enviado una imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];

    // Verificar si la imagen es válida
    $validTypes = ['image/jpeg', 'image/png']; // Tipos de archivo permitidos
    $maxSize = 5 * 1024 * 1024; // 5 MB

    // Obtener el tipo de archivo y el tamaño
    $fileType = $file['type'];
    $fileSize = $file['size'];

    // Verificar el tipo de archivo
    if (!in_array($fileType, $validTypes)) {
        echo "<script>
            alert('Tipo de imagen incorrecta');
            window.location = '../Vista/editUser.php'; 
            </script>";
        exit();
    }

    // Verificar el tamaño del archivo
    if ($fileSize > $maxSize) {
        echo "<script>
            alert('Error: La imagen es demasiado grande. El tamaño máximo es 5 MB.');
            window.location = '../Vista/editUser.php'; 
            </script>";
        exit();
    }

    // Directorio donde se guardará la imagen
    $uploadDir = '../Vista/uploads/perfil/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generar un nombre único para la imagen
    $fileName = uniqid('profile_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;

    // Mover el archivo al directorio de destino
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Actualizar la base de datos con la nueva imagen
        try {
            $id_cliente = $_SESSION['id_cliente'];
            $query = "UPDATE clientes SET imagen_perfil = :imagen_perfil WHERE id_cliente = :id_cliente";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['imagen_perfil' => $filePath, 'id_cliente' => $id_cliente]);

            echo "<script>
            alert('Error: Se cargo bien la imagen');
            window.location = '../Vista/editUser.php'; 
            </script>";
        } catch (PDOException $e) {
            echo "Error al actualizar la imagen: " . $e->getMessage();
        }
    } else {
        echo "<script>
            alert('Error: La imagen es demasiado grande. El tamaño máximo es 5 MB.');
            window.location = '../Vista/editUser.php'; 
            </script>";
        exit();
    }
} else {
    echo "<script>
            alert('No se ha enviado ningún archivo');
            window.location = '../Vista/editUser.php'; 
            </script>";
    exit();
}
