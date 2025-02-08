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
<body style="'Montserrat', sans-serif;">

<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand ms-3" href="00.index.php">
            <img src="https://th.bing.com/th/id/OIP.ZwgZsScqAUCrVB5IElNAiAHaEK?w=322&h=181&c=7&r=0&o=5&dpr=1.1&pid=1.7" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            BELBANK
        </a>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 10vh; margin-top: 35px; width: 350px;">
    <div class="card h-100" style="width: 35rem;" id="container-master">
        <div class="card-header" style="height: 50px; background-color:crimson;">
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
                <button type="submit" name="activar">Activar</button>
                <button>
                    <a href="01.02.loginyregistro.php">Iniciar Sesión</a>
                </button>
                <style>
                    button {
                        border-radius: 20px;
                        border: 1px solid #FF4B2B;
                        background-color: #FF4B2B;
                        color: #FFFFFF;
                        font-size: 14px;
                        font-weight: bold;
                        padding: 12px 45px;
                        letter-spacing: 1px;
                        text-transform: uppercase;
                        transition: transform 80ms ease-in;
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    button:active {
                        transform: scale(0.95);
                    }

                    button:focus {
                        outline: none;
                    }

                    button.ghost {
                        background-color: transparent;
                        border-color: #FFFFFF;
                    }

                    a {
                        color: #fff;
                        font-size: 14px;
                        text-decoration: none;
                        margin: 15px 0;
                    }

                    #container-master {
                        background-color: #fff;
                        border-radius: 10px;
                        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
                                0 10px 10px rgba(0,0,0,0.22);
                    }

                    h3{
                        font-weight: bold;
                    }
                </style>
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
