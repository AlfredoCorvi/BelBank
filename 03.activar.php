<?php
require_once 'db_conexion.php';

if (isset($_POST['activar'])) {
    $usuario = $_POST['Correo'];
    $contrasena = $_POST['contraseña'];

    if (!empty($usuario) && !empty($contrasena)) {
        // Verificar si el usuario o cuenta existe en la base de datos
        $sql = $cnnPDO->prepare("SELECT * FROM usuarios WHERE (correo = :usuario OR cuenta = :usuario) AND contrasena = :contrasena");
        $sql->bindParam(':usuario', $usuario);
        $sql->bindParam(':contrasena', $contrasena);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $usuarioData = $sql->fetch(PDO::FETCH_ASSOC);

            if ($usuarioData['status'] == 0) {
                // Activar la cuenta
                $updateSql = $cnnPDO->prepare("UPDATE usuarios SET status = 1 WHERE id = :id");
                $updateSql->bindParam(':id', $usuarioData['id']);
                if ($updateSql->execute()) {
                    echo "<script>
                        toastr.success('Tu cuenta ha sido activada exitosamente.', 'Activación Exitosa');
                    </script>";
                } else {
                    echo "<script>
                        toastr.error('Hubo un problema al activar tu cuenta. Intenta nuevamente.', 'Error de Activación');
                    </script>";
                }
            } else {
                echo "<script>
                    toastr.info('Tu cuenta ya está activada.', 'Información');
                </script>";
            }
        } else {
            echo "<script>
                toastr.error('Usuario, cuenta o contraseña incorrectos.', 'Error de Validación');
            </script>";
        }
    } else {
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
    <title>Activar Cuenta</title>
    <?php require_once 'cdn.html'; ?>
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
            <a class="btn btn-primary" href="01.login.php" role="button">iniciar Sesion</a>
            <a class="btn btn-primary" href="02.registro.php" role="button">Registrar</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 10vh; margin-top: 2cm;">
    <div class="card h-100" style="width: 35rem;">
        <div class="card-header" style="height: 50px; background-color:blue;">
            <h3 style="text-align: center; color: white;">Activar Cuenta</h3>
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
                <button type="submit" name="activar" class="btn btn-primary">Activar</button>
                <a href="02.registro.php" class="btn btn-primary"> Registrarse</a>
                <a href="01.login.php" class="btn btn-primary"> Iniciar Sesión</a>
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
