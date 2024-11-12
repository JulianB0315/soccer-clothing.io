<?php
session_start();
require '../Controlador/ConectionMySQL.php';
// para poder saber que usuario esta iniciado
$id_cliente = $_SESSION['id_cliente'];

// Obtener los datos cambiados 
$nombres = $_POST['inputFirstName'];
$apellido = $_POST['inputLastName'];
$email = $_POST['inputEmailAddress'];
$telefono = $_POST['inputPhone'];
$direccion = $_POST['inputLocation'];

// Actualizar los datos en la DB
$query = "UPDATE clientes SET nombres = ?, apellido = ?, email = ?, telefono = ?, direccion = ? WHERE id_cliente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssi", $nombres, $apellido, $email, $telefono, $direccion, $id_cliente);

if ($stmt->execute()) {
    echo "<script>alert('Yia se guardó'); window.location.href = 'editUser.php';</script>";
} else {
    echo "<script>alert('Error al guardar');</script>";
}

