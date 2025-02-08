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
        echo "<script>toastr.success('Saldo agregado correctamente.', 'Exito');</script>";
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
    <style>
        .card {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
        }
        .card-header {
            background-color: #FF4B2B;
            color: white;
            text-align: center;
            font-size: 1.5rem;
            padding: 15px;
        }
        .btn-hdr a {
            margin: 5px;
        }
    </style>
</head>
<body style="background:url(https://www.dutchcowboys.nl/wp-content/uploads/headers/telco-singtel-aandeel-singapore.jpg); background-size: cover; font-family: 'Poppins';">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">BELBANK</a>
        <div class="btn-hdr">
            <a class="btn btn-primary" href="05.transferencia.php" role="button">Transferencia</a>
            <a class="btn btn-warning" href="06.desactivar_cuenta.php" role="button">Desactivar Cuenta</a>
            <a class="btn btn-danger" href="logout.php" role="button">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 10vh; margin-top: 2cm;">
    <div class="card" style="width: 35rem;">
        <div class="card-header">Sesión Iniciada</div>
        <div class="card-body text-center">
            <img src="images/user.png" class="rounded-circle" style="width: 100px; height: 100px;">
            <h4 class="mt-3">Bienvenido, <strong><?php echo htmlspecialchars($usuarioData['nombre']); ?></strong></h4>
            <p><strong>Cuenta:</strong> <?php echo htmlspecialchars($usuarioData['cuenta']); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuarioData['correo']); ?></p>
            <p><strong>Saldo:</strong> $<?php echo htmlspecialchars($usuarioData['saldo']); ?></p>

            <!-- Formulario para agregar saldo -->
            <form method="post" class="mt-3">
                <div class="form-group">
                    <label for="monto">Agregar Saldo</label>
                    <input type="number" step="0.01" name="monto" class="form-control" required>
                </div>
                <button type="submit" name="agregar_saldo" class="btn btn-success mt-2">Agregar Saldo</button>
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
