<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión
header('Location: ../Vista/index.html'); // Redirige al usuario después de cerrar sesión
exit();
?>
