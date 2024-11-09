<?php 
    session_start();
    require '../Controlador/ConectionMySQL.php';
    $email=$_POST['email'];
    $password=$_POST['contrasena'];

    $sql="SELECT * FROM usuarios WHERE email='$email' AND contrasena='$password'";
    $verificacion= mysqli_query($conexion, $sql);
    if(mysqli_num_rows($verificacion)>0){
        $_SESSION['email']=$email;
        echo "<script>
                alert('Bienvenido a Futbolera.pe');
                window.location = '../Vista/index.html';
            </script>";
        exit();
    }
    else{
        echo "<script>
                alert('Email o contraseña incorrectos');
                window.location = '../Vista/index.html';
            </script>";
        exit();
    }
?>