<?php
# Inicia Código de REGISTRAR
require_once 'db_conexion.php';

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $cuenta = $_POST['cuenta'];

    // Función para generar la contraseña
    function generarContrasena(){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $longitud = 5;
        $contrasena = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $contrasena .= $caracteres[$indice];
        }
        return $contrasena;
    }

    if (!empty($nombre) && !empty($correo) && !empty($cuenta)) {
        // Generar contraseña aleatoria
        $contrasena = generarContrasena();

        // Preparar la consulta SQL
        $sql = $cnnPDO->prepare("INSERT INTO USUARIOS (nombre, correo, cuenta, contrasena) VALUES (:nombre, :correo, :cuenta, :contrasena)");

        // Bindear los valores a la consulta
        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':correo', $correo);
        $sql->bindParam(':cuenta', $cuenta);
        $sql->bindParam(':contrasena', $contrasena);

        // Ejecutar la consulta
        if ($sql->execute()) {
            // Enviar correo de bienvenida
                $asunto = "¡Bienvenido a nuestro Banco!";
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $cabeceras .= 'From: no-reply@tu-sitio.com' . "\r\n";

                $mensaje = "
                    <html>
                    <head>
                        <title>¡Bienvenido a BelBank!</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                max-width: 600px;
                                margin: 20px auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border-radius: 8px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            }
                            h1 {
                                color: #333333;
                                font-size: 24px;
                                margin-bottom: 20px;
                            }
                            p {
                                color: #555555;
                                font-size: 16px;
                                line-height: 1.6;
                            }
                            ul {
                                list-style-type: none;
                                padding: 0;
                            }
                            ul li {
                                background-color: #f9f9f9;
                                margin: 10px 0;
                                padding: 10px;
                                border-radius: 4px;
                                border: 1px solid #dddddd;
                            }
                            ul li strong {
                                color: #333333;
                            }
                            .footer {
                                margin-top: 20px;
                                text-align: center;
                                font-size: 14px;
                                color: #777777;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>Hola, $nombre</h1>
                            <p>Gracias por registrarte en nuestro banco. Aquí tienes tus datos de acceso:</p>
                            <ul>
                                <li><strong>Correo:</strong> $correo</li>
                                <li><strong>Cuenta:</strong> $cuenta</li>
                                <li><strong>Contraseña:</strong> $contrasena</li>
                            </ul>
                            <p>Favor de activar tu cuenta con la contraseña generada.</p>
                            <div class='footer'>
                                <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
                            </div>
                        </div>
                    </body>
                    </html>
";

            // Enviar el correo
            if (mail($correo, $asunto, $mensaje, $cabeceras)) {
                echo "<script>
                    toastr.success('Registro exitoso. Se ha enviado un correo de bienvenida con tus datos de acceso.', 'Registro Completado');
                </script>";
            } else {
                echo "<script>
                    toastr.error('Registro completado, pero no se pudo enviar el correo. Verifica tu dirección de correo.', 'Error de Envío');
                </script>";
            }
        } else {
            // Notificación toastr de error
            echo "<script>
                toastr.error('Ocurrió un error al registrar los datos. Intenta nuevamente.', 'Error de Registro');
            </script>";
        }
    } else {
        // Notificación toastr de advertencia
        echo "<script>
            toastr.warning('Debes completar todos los campos.', 'Validación');
        </script>";
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
    <!-- Toastr CSS -->
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
                    <input type="text" name="cuenta" class="form-control" placeholder="N.o de Cuenta">
                </div>
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
