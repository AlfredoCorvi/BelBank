<?php
require_once 'db_conexion.php';
session_start();

// Verificar si el usuario ya inició sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: 01.login.php');
    exit;
}

$usuarioData = $_SESSION['usuario'];

// Procesar la desactivación de la cuenta
if (isset($_POST['desactivar'])) {
    $sql = $cnnPDO->prepare("UPDATE usuarios SET status = 0 WHERE id = :id");
    $sql->bindParam(':id', $usuarioData['id']);
    $sql->execute();

    // Cerrar sesión y redirigir al login
    session_destroy();
    header('Location: 01.login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desactivar Cuenta</title>
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
            <a class="btn btn-primary" href="04.sesion_iniciada.php" role="button">Inicio</a>
            <a class="btn btn-danger" href="logout.php" role="button">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 10vh; margin-top: 2cm;">
    <div class="card h-100" style="width: 35rem;">
        <div class="card-header" style="height: 50px; background-color:blue;">
            <h3 style="text-align: center; color: white;">Desactivar Cuenta</h3>
        </div>
        <div class="card-body">
            <p>¿Estás seguro de que deseas desactivar tu cuenta? Esta acción se puede deshacer volviendo a activar tu cuenta.</p>
            <form method="post">
                <button type="submit" name="desactivar" class="btn btn-danger">Desactivar Cuenta</button>
                <a href="04.sesion_iniciada.php" class="btn btn-secondary">Cancelar</a>
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