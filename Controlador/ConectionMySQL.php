<?php
// Datos de conexión a la base de datos
$servidor = "localhost";  // Usualmente es "localhost" en XAMPP
$usuario = "root";        // Usuario por defecto en XAMPP es "root"
$password = "";           // Contraseña por defecto en XAMPP es vacía
$base_datos = "soccer-clothing"; // Reemplaza con el nombre de tu base de datos

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa a la base de datos<br>";
}
?>