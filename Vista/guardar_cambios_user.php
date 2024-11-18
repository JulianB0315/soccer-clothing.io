<?php
session_start();
require '../Controlador/ConectionMySQL.php'; // Archivo de conexión PDO

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id_cliente'])) {
    die("Error: No has iniciado sesión");
}

$id_cliente = $_SESSION['id_cliente'];

// Verifica si todos los campos están definidos
if (isset($_POST['apodo'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['telefono'], $_POST['direccion'])) {
    // Obtener los datos cambiados
    $apodo = $_POST['apodo'];
    $nombres = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    try {
        // Preparar la consulta SQL
        $query = "UPDATE clientes SET apodo = :apodo, nombres = :nombres, apellido = :apellido, email = :email, telefono = :telefono, direccion = :direccion WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($query);

        // Asignar los parámetros
        $stmt->bindParam(':apodo', $apodo);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Se han guardado los cambios'); window.location.href = 'editUser.php';</script>";
        } else {
            echo "<script>alert('Error al guardar los datos');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('Faltan datos para actualizar');</script>";
}
?>
