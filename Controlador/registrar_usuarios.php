<?php
    include "ConectionMySQL.php";
    $nombres=$_GET['nombres'];
    $telf=$_GET['telf'];
    $email=$_GET['email-registro'];
    $password=$_GET['password-registro'];

    $sql="INSERT INTO usuarios (nombres,telf,email,contrasena) VALUES ('$nombres','$telf','$email','$password')";
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