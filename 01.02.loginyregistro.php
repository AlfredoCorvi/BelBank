<?php
require_once 'db_conexion.php';
require_once 'cdn.html';

session_start();

if (isset($_POST['login'])) {
    $usuario = $_POST['Correo'];
    $contrasena = $_POST['contraseña'];

    if (!empty($usuario) && !empty($contrasena)) {
        // Consulta para verificar usuario, contraseña y si está activo
        $sql = $cnnPDO->prepare("SELECT * FROM usuarios WHERE (correo = :usuario OR cuenta = :usuario) AND contrasena = :contrasena");
        $sql->bindParam(':usuario', $usuario);
        $sql->bindParam(':contrasena', $contrasena);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $usuarioData = $sql->fetch(PDO::FETCH_ASSOC);

            if ($usuarioData['status'] == 1) {
                // Guardar datos del usuario en la sesión
                $_SESSION['usuario'] = $usuarioData;

                // Redirigir a la página de sesión iniciada
                header('Location: 04.sesion_iniciada.php');
                exit;
            } else {
                // Cuenta no activada
                echo "<script>
                    toastr.warning('Tu cuenta no está activada. Por favor, actívala antes de iniciar sesión.', 'Cuenta no activada');
                </script>";
            }
        } else {
            // Usuario o contraseña incorrectos
            echo "<script>
                toastr.error('Usuario o contraseña incorrectos. Intenta nuevamente.', 'Error de autenticación');
            </script>";
        }
    } else {
        // Campos vacíos
        echo "<script>
            toastr.warning('Por favor, completa todos los campos.', 'Validación');
        </script>";
    }
}


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
    <title>Login y Registro</title>
    <link rel="stylesheet" href="login-styles.css">
</head>
<body>
<h2>¡Bienvenido a CarsCon!</h2>
<div class="container" id="container">
    <!-- Formulario de registro -->
    <div class="form-container sign-up-container">
        <form method="POST" action="">
            <h1>Crear cuenta</h1>
            <span>o usa tu email para registrarte</span><br>
            <input type="text" name="nombre" placeholder="Nombre" required />
            <input type="text" name="correo" placeholder="Correo" required />
            <input type="text" name="cuenta" placeholder="No. de Cuenta" required />
            <button type="submit" name="registrar">Registrar</button>
        </form>
    </div>

    <!-- Formulario de inicio de sesión -->
    <div class="form-container sign-in-container">
        <form method="POST" action="">
            <h1>Inicia sesión</h1>
            <span>o usa tu cuenta</span><br>
            <input type="text" name="Correo" placeholder="Correo o No. de cuenta" required />
            <input type="password" name="contraseña" placeholder="Contraseña" required />
            <button type="submit" name="login">Iniciar sesión</button>
            <button>
                <a href="03.activar.php" style="color: white; text-decoration: none;">Activar Cuenta</a>
            </button>


        </form>
    </div>

    <!-- Paneles de overlay -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Bienvenido!</h1>
                <p>Para empezar a navegar con nosotros, por favor inicia sesión con tu información personal</p>
                <button class="ghost" id="signIn">Iniciar sesión</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hola, amigo!</h1>
                <p>Regístrate si aún no tienes cuenta y sé parte de nuestra familia</p>
                <button class="ghost" id="signUp">Registrarse</button>
            </div>
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

<script src="myjs.js"></script>


</body>
</html>
