<?php
    include "ConectionMySQL.php";
    $nombres=$_POST['nombres'];
    $telf=$_POST['telf'];
    $email=$_POST['email-registro'];
    $password=$_POST['password-registro'];

    $sql="INSERT INTO usuarios (nombres,telf,email,contrasena) VALUES ('$nombres','$telf','$email','$password')";
    $verificar="SELECT * FROM usuarios WHERE email='$email'";
    $verificacion= mysqli_query($conexion, $verificar);
    if(mysqli_num_rows($verificacion)>0){
        echo "<script>
                alert('El correo ya se encuentra registrado');
                window.location = '../Vista/registrar_usuario.html';
            </script>";
        exit();
    }

    $execute= mysqli_query($conexion, $sql);
    if($execute){
        echo "<script>
                alert('Se ha registrado correctamente');
                window.location = '../Vista/index.html';
            </script>";
        
    }
    else{
        echo "<script>
                alert('Algo falló, inténtalo de nuevo');
                window.location = '../Vista/index.html';
            </script>";
        
    }
    mysqli_close($conexion);
?>