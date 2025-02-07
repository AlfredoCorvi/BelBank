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
    $tipo_cuenta = $_POST['tipo_cuenta'] ?? null;


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

    if (!empty($nombre) && !empty($correo) && !empty($cuenta) && !empty($tipo_cuenta)) {
        // Generar contraseña aleatoria
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
    <title>Login y Registro</title>
    <link rel="stylesheet" href="login-styles.css">
</head>
<body>
<h2>¡Bienvenido a BelBank!</h2>
<div class="container" id="container">
    <!-- Formulario de registro -->
    <div class="form-container sign-up-container">
        <form method="POST" action="">
            <h1>Crear cuenta</h1>
            <span>o usa tu email para registrarte</span><br>
            <input type="text" name="nombre" placeholder="Nombre" required />
            <input type="text" name="correo" placeholder="Correo" required />
            <input type="text" name="cuenta" placeholder="No. de Cuenta" required />
            <select class="form-select" name="tipo_cuenta" aria-label="Default select example">
                <option selected disabled>Tipo de Cuenta</option>
                <option value="tarjeta de débito">tarjeta de débito</option>
                <option value="tarjeta de crédito">tarjeta de crédito</option>
                <option value="cuenta de ahorros">cuenta de ahorros</option>
                <option value="cuenta corriente">cuenta corriente</option>
                <option value="inversión">inversión</option>
            </select>
            <br>    
            <button type="submit" name="registrar">Registrar</button>
        </form>
    </div>

    <!-- Formulario de inicio de sesión -->
    <div class="form-container sign-in-container">
        <form method="POST" action="">
            <h1>Inicia sesión</h1>
            <span>o usa tu cuenta</span><br>
            <input type="text" name="Correo" placeholder="Correo o No. de cuenta" />
            <input type="password" name="contraseña" placeholder="Contraseña" />
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
