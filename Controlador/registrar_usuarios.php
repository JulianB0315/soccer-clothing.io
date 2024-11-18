<?php
// Incluir el archivo de conexión PDO
require '../Controlador/ConectionMySQL.php'; 
function generarIdCliente() {
    $prefijo = "C";  
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
$id_cliente=$id;
// Obtener los datos del formulario
$nombres = $_POST['nombres'];
$telf = $_POST['telf'];
$email = $_POST['email-registro'];
$password = $_POST['password-registro'];

// Verificar si el correo ya está registrado  
$sql = "SELECT * FROM clientes WHERE email = :email"; // Usamos un parámetro para evitar inyecciones SQL
$stmt = $pdo->prepare($sql); // Preparamos la consulta

// Vincular el parámetro
$stmt->bindParam(':email', $email, PDO::PARAM_STR); // Vinculamos el email con el parámetro :email

// Ejecutamos la consulta
$stmt->execute();

// Verificamos si el email ya está registrado
if ($stmt->rowCount() > 0) {
    echo "<script>
            alert('El correo ya se encuentra registrado');
            window.location = '../Vista/registrar_usuario.html';
        </script>";
    exit();
}

// Encriptar la contraseña antes de guardarla
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertar los datos en la base de datos
$sql_insert = "INSERT INTO clientes (id_cliente ,nombres, telefono, email, contrasena) VALUES (:id_cliente,:nombres, :telefono, :email, :contrasena)";
$stmt_insert = $pdo->prepare($sql_insert);

// Vinculamos los parámetros para la inserción
$stmt_insert->bindParam(':id_cliente', $id_cliente, PDO::PARAM_STR);
$stmt_insert->bindParam(':nombres', $nombres, PDO::PARAM_STR);
$stmt_insert->bindParam(':telefono', $telf, PDO::PARAM_STR);
$stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);
$stmt_insert->bindParam(':contrasena', $hashed_password, PDO::PARAM_STR);

// Ejecutar la inserción
if ($stmt_insert->execute()) {
    echo "<script>
            alert('Se ha registrado correctamente');
            window.location = '../Vista/login_usuario.html'; 
        </script>";
        // Redirigir a la página de inicio de sesión (corregido)
} else {
    echo "<script>
            alert('Algo falló, inténtalo de nuevo');
            window.location = '../Vista/registrar_usuario.html';
        </script>";
}
?>