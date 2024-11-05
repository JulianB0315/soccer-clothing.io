<?php
// Datos de conexión
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "soccer-clothing";

try {
    // Crear la conexión
    $conexion = new mysqli($servidor, $usuario, $password, $base_datos);

    // Verificar si hay errores en la conexión
    if ($conexion->connect_error) {
        throw new Exception("Conexión fallida: " . $conexion->connect_error);
    }
    
    // Opcional: mensaje de conexión exitosa
    echo "Conexión exitosa a la base de datos";
    
} catch (Exception $e) {
    // Capturar el error y mostrar un mensaje
    echo "Se produjo un error: " . $e->getMessage();
}
?>