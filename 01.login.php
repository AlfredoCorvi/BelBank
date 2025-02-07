<?php
require_once 'db_conexion.php';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php require_once 'cdn.html'; ?>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body style="background:url(images/fondobnk.jpg); background-size: cover; font-family: 'Poppins';">
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="https://th.bing.com/th/id/OIP.ZwgZsScqAUCrVB5IElNAiAHaEK?w=322&h=181&c=7&r=0&o=5&dpr=1.1&pid=1.7" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            BELBANK
        </a>
        <div class="btn-hdr">
            <a class="btn btn-danger" href="00.index.php" role="button">Inicio</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 10vh; margin-top: 2cm;">
    <div class="card h-100" style="width: 35rem;">
        <div class="card-header" style="height: 50px; background-color:#3279e6;">
            <h3 style="text-align: center; color: white;">Inicio de Sesion</h3>
        </div>
        <div class="card-body" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div class="container d-flex justify-content-center align-items-center">
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
                    <input type="text" name="Correo" class="form-control" placeholder="Correo o N.o Cuenta">
                </div>
                <br>
                <div class="form-group">
                    <input type="password" name="contraseña" class="form-control" placeholder="Contraseña">
                </div>
                <br>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
                <a href="02.registro.php" class="btn btn-primary"> Registrarse</a>
                <a href="03.activar.php" class="btn btn-warning"> Activar cuenta</a>
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
