<?php
session_start();
require '../Controlador/ConectionMySQL.php'; // Conexión PDO

// Obtener datos del formulario
$email = $_POST['email'];
$password = $_POST['contrasena'];

// Preparar la consulta para evitar inyecciones SQL
$sql = "SELECT * FROM clientes WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $email]);

// Verificar si el usuario existe
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cliente) {
    // Verificar la contraseña (suponiendo que la contraseña esté almacenada de forma encriptada)
    if (password_verify($password, $cliente['contrasena'])) {
        // Almacenar el id_cliente y email en la sesión
        $_SESSION['id_cliente'] = $cliente['id_cliente'];
        $_SESSION['email'] = $email;

        // Pasar los valores de PHP a JavaScript usando sessionStorage
        echo "<script>
                sessionStorage.setItem('id_cliente', '" . $cliente['id_cliente'] . "');
                sessionStorage.setItem('email', '" . $email . "');
                alert('Bienvenido a fulbolera');
                window.location = '../Vista/index.php';
              </script>";
        exit();
    } else {
        // Si la contraseña es incorrecta
        echo "<script>
                alert('Email o contraseña incorrectos');
                window.location = '../Vista/login_usuario.html'; 
              </script>";
        exit();
    }
} else {
    // Si no se encuentra el cliente con ese email
    echo "<script>
            alert('Email o contraseña incorrectos');
            window.location = '../Vista/login_usuario.html'; 
          </script>";
    exit();
}
?>
