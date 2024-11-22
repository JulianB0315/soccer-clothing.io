<?php
// Incluir la conexión PDO
require '../Controlador/ConectionMySQL.php';

// Obtener los datos del formulario
$email = $_POST['email'];
$codigo_web = $_POST['codigo_web'];
$codigo_email = $_POST['codigo_email'];

// Verificar si los códigos coinciden
if ($codigo_web === $codigo_email) {
    try {
        // Preparar la consulta para obtener el ID del cliente
        $stmt = $pdo->prepare("SELECT id_cliente FROM clientes WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Comprobar si se encontró un cliente
        if ($stmt->rowCount() > 0) {
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_cliente = $cliente['id_cliente'];

            // Redirigir a otra página pasando el id_cliente como parámetro GET
            header("Location: ../Vista/nueva_contraseña.php?id_cliente=" . urlencode($id_cliente));
            exit;
        } else {
            // Si no se encuentra el cliente
            echo "No se encontró un cliente con el correo proporcionado.";
        }
    } catch (PDOException $e) {
        // Manejar errores en la base de datos
        echo "Error en la consulta: " . $e->getMessage();
    }
} else {
    // Si los códigos no coinciden
    header("Location: ../Vista/menu_codigo.php?codigo=" . urlencode($codigo_email) . "&email=" . urlencode($email));          
}
