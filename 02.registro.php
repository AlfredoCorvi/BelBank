<?php
require_once 'db_conexion.php';

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $cuenta = $_POST['cuenta'];
    $tipo_cuenta = $_POST['tipo_cuenta'] ?? null;

    function generarContrasena($longitud = 8) {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $contrasena = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1); // Ahora usa rand()
            $contrasena .= $caracteres[$indice];
        }
        return $contrasena;
    }

    if (!empty($nombre) && !empty($correo) && !empty($cuenta) && !empty($tipo_cuenta)) {
        // Generar la contraseña aleatoria
        $contrasena = generarContrasena();

        // Insertar en la BD sin hash
        $sql = $cnnPDO->prepare("INSERT INTO USUARIOS (nombre, correo, tipo_cuenta, cuenta, contrasena) VALUES (:nombre, :correo, :tipo_cuenta, :cuenta, :contrasena)");

        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':correo', $correo);
        $sql->bindParam(':tipo_cuenta', $tipo_cuenta);
        $sql->bindParam(':cuenta', $cuenta);
        $sql->bindParam(':contrasena', $contrasena); // Guarda la contraseña en texto plano

        if ($sql->execute()) {
            // Enviar correo
                $asunto = "¡Bienvenido a nuestro Banco!";
                $cabeceras  = "MIME-Version: 1.0\r\n";
                $cabeceras .= "Content-type: text/html; charset=utf-8\r\n";
                $cabeceras .= "From: no-reply@tu-sitio.com\r\n";

                $mensaje = "
                <html>
                <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
                    <div style='max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                        <h1 style='color: #3498db; text-align: center;'>¡Bienvenido a Nuestro Banco!</h1>
                        <p style='font-size: 16px; color: #333;'>Hola, <strong>$nombre</strong></p>
                        <p style='font-size: 16px; color: #333;'>Gracias por registrarte en nuestro banco. Aquí tienes tus datos de acceso:</p>
                        <div style='background: #f9f9f9; padding: 15px; border-radius: 8px;'>
                            <p><strong>Correo:</strong> $correo</p>
                            <p><strong>Número de Cuenta:</strong> $cuenta</p>
                            <p><strong>Tipo de Cuenta:</strong> $tipo_cuenta</p>
                            <p><strong>Contraseña:</strong> <span style='color: red;'>$contrasena</span></p>
                        </div>
                        <p style='text-align: center;'>
                            <a href='01.login.php' style='background: #3498db; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;'>Iniciar Sesión</a>
                        </p>
                        <p style='font-size: 12px; text-align: center; color: #777;'>Este es un mensaje automático, por favor no respondas a este correo.</p>
                    </div>
                </body>
                </html>";

            if (mail($correo, $asunto, $mensaje, $cabeceras)) {
                echo "<script>toastr.success('Registro exitoso. Se ha enviado un correo.', 'Registro Completado');</script>";
            } else {
                echo "<script>toastr.error('Registro completado, pero el correo no se pudo enviar.', 'Error de Envío');</script>";
            }
        } else {
            echo "<script>toastr.error('Error al registrar los datos.', 'Error de Registro');</script>";
        }
    } else {
        echo "<script>toastr.warning('Debes completar todos los campos.', 'Validación');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <?php require_once 'cdn.html'?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body style="background:url(images/fondo.png); background-size: cover; font-family: 'Poppins';">

<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="https://th.bing.com/th/id/OIP.ZwgZsScqAUCrVB5IElNAiAHaEK?w=322&h=181&c=7&r=0&o=5&dpr=1.1&pid=1.7" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            BELBANK
        </a>
        <div class="btn-hdr">
            <a class="btn btn-primary" href="00.index.php" role="button">Inicio</a>
            <a class="btn btn-primary" href="01.login.php" role="button">Iniciar Sesion</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 10vh; margin-top: 2cm;">
    <div class="card h-100" style="width: 35rem;">
        <div class="card-header" style="height: 50px; background-color:blue;">
            <h3 style="text-align: center; color: white;">Registro</h3>
        </div>
        <div class="card-body" style="display: flex;  flex-direction: column; justify-content: space-between;">
            <div class="container d-flex justify-content-center align-items-center" >
                <div class="row">
                    <div class="col">
                    <img src="images/user.png" style="height: 5cm;">
                    <br>
                    </div>
                </div>
            </div>
            <br>
            <form method="post">
                <div class="form-group">
                    <input type="Text"  name="nombre" class="form-control" placeholder="Nombre">
                </div>
                <br>
                <div class="form-group">
                    <input type="Text"  name="correo" class="form-control" placeholder="Correo">
                </div>
                <br>
                <div class="form-group">
                    <input type="text" name="cuenta" class="form-control" placeholder ="N.o de Cuenta">
                </div>
                <br>
                <select class="form-select" name="tipo_cuenta" aria-label="Default select example">
                    <option selected disabled>Tipo de Cuenta</option>
                    <option value="tarjeta de débito">tarjeta de débito</option>
                    <option value="tarjeta de crédito">tarjeta de crédito</option>
                    <option value="cuenta de ahorros">cuenta de ahorros</option>
                    <option value="cuenta corriente">cuenta corriente</option>
                    <option value="inversión">inversión</option>
                </select>
                <br>
                <button type="submit" name="registrar" class="btn btn-primary">Registrarse</button>
                <a href="01.login.php" class="btn btn-primary"> Iniciar sesión</a>
            </form>
        </div>
    </div>
</div>

<!-- Toastr JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "timeOut": "5000",
        "positionClass": "toast-top-right",
    };
</script>

</body>
</html>