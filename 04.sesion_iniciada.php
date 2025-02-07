<?php
require_once 'db_conexion.php';
session_start();

// Verificar si el usuario ya inició sesión
if (isset($_SESSION['usuario'])) {
    $usuarioData = $_SESSION['usuario'];
} else {
    // Si no hay sesión, redirigir al login
    header('Location: 01.login.php');
    exit;
}

// Procesar la adición de saldo
if (isset($_POST['agregar_saldo'])) {
    $monto = floatval($_POST['monto']); // Convertir a número

    if ($monto > 0) {
        $saldoActual = floatval($usuarioData['saldo']); // Convertir a número
        $nuevoSaldo = $saldoActual + $monto;

        // Actualizar el saldo en la base de datos
        $sql = $cnnPDO->prepare("UPDATE usuarios SET saldo = :nuevo_saldo WHERE id = :id");
        $sql->bindParam(':nuevo_saldo', $nuevoSaldo);
        $sql->bindParam(':id', $usuarioData['id']);
        $sql->execute();

        // Actualizar los datos del usuario en la sesión
        $usuarioData['saldo'] = $nuevoSaldo;
        $_SESSION['usuario'] = $usuarioData;

        // Mostrar mensaje de éxito
        echo "<script>toastr.success('Saldo agregado correctamente.', 'Éxito');</script>";
    } else {
        echo "<script>toastr.error('El monto debe ser mayor que cero.', 'Error');</script>";
    }
}

// Cerrar sesión
if (isset($_POST['logout'])) {
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
    <title>Sesión Iniciada</title>
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
            <a class="btn btn-primary" href="05.transferencia.php" role="button">Transferencia</a>
            <a class="btn btn-warning" href="06.desactivar_cuenta.php" role="button">Desactivar Cuenta</a>
            <a class="btn btn-danger" href="logout.php" role="button">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 10vh; margin-top: 2cm;">
    <div class="card h-100" style="width: 35rem;">
        <div class="card-header" style="height: 50px; background-color:blue;">
            <h3 style="text-align: center; color: white;">Sesión Iniciada</h3>
        </div>
        <div class="card-body" style="display: flex; flex-direction: column; justify-content: space-between;">
            <img src="images/user.png" style="width: 6cm; height: 5cm;">
            <div class="container">
                <h4>Bienvenido, <strong><?php echo htmlspecialchars($usuarioData['nombre']); ?></strong></h4>
                <p><strong>Cuenta:</strong> <?php echo htmlspecialchars($usuarioData['cuenta']); ?></p>
                <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuarioData['correo']); ?></p>
                <p><strong>Saldo:</strong> $<?php echo htmlspecialchars($usuarioData['saldo']); ?></p>

                <!-- Formulario para agregar saldo -->
                <form method="post">
                    <div class="form-group">
                        <label for="monto">Agregar Saldo</label>
                        <input type="number" step="0.01" name="monto" class="form-control" required>
                    </div>
                    <br>
                    <button type="submit" name="agregar_saldo" class="btn btn-success">Agregar Saldo</button>
                </form>

                <br>
                <form method="post">
                    <a href="logout.php" type="submit" name="logout" class="btn btn-danger">Cerrar Sesión</a>
                </form>
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

</body>
</html>