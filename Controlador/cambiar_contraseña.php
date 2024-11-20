<?php
require '../Controlador/ConectionMySQL.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_STRING);
    $nuevaContrasena = filter_input(INPUT_POST, 'nuevaContrasena', FILTER_SANITIZE_STRING);
    $confirmarContrasena = filter_input(INPUT_POST, 'confirmarContrasena', FILTER_SANITIZE_STRING);

    // Validar que las contraseñas coincidan
    if ($nuevaContrasena !== $confirmarContrasena) {
        header("Location:../Vista/nueva_contraseña.php?id_cliente=" . urlencode($id_cliente));
        echo "<script>
                alert('Las contraseñas no coinciden');
              </script>";
        exit;
    }

    // Actualizar la contraseña en la base de datos
    $hashedPassword = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
    $query = $pdo->prepare("UPDATE clientes SET contrasena = :contrasena WHERE id_cliente = :id_cliente");
    $query->execute([
        'contrasena' => $hashedPassword, 
        'id_cliente' => $id_cliente,
    ]);

    if ($query->rowCount() > 0) {
        "<script>
                alert('Se cambio la contraseña con exito');
                window.location = '../Vista/login_usuario.html'; 
              </script>";
        exit();
    } else {
        echo "No se pudo actualizar la contraseña. Verifica tus datos.";
    }
} else {
    echo "Método no permitido.";
}
?>