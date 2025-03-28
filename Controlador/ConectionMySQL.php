<?php
$host = 'localhost';  // o el host que estés utilizando
$dbname = 'soccer-clothing';  // nombre de tu base de datos
$username = 'root';  // tu usuario de la base de datos
$password = '';  // tu contraseña

try {
    // Crea la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configura el modo de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}
?>
