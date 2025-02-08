<?php
require_once 'db_conexion.php';
session_start();

// Verificar si el usuario ya inició sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: 01.login.php');
    exit;
}

$usuarioData = $_SESSION['usuario'];

// Procesar la transferencia
$mensaje = "";
if (isset($_POST['transferir'])) {
    $cuentaDestino = trim($_POST['cuenta_destino']);
    $monto = floatval($_POST['monto']);
    $concepto = trim($_POST['concepto']);
    $contrasena = $_POST['contrasena'];

    try {
        // Verificar que los campos no estén vacíos
        if (empty($cuentaDestino) || empty($monto) || empty($concepto) || empty($contrasena)) {
            $mensaje = "Todos los campos son obligatorios.";
        } elseif ($monto <= 0) {
            $mensaje = "El monto debe ser mayor a cero.";
        } else {
            // Verificar la contraseña del usuario
            $sql = $cnnPDO->prepare("SELECT * FROM usuarios WHERE cuenta = :cuenta AND contrasena = :contrasena");
            $sql->bindParam(':cuenta', $usuarioData['cuenta']);
            $sql->bindParam(':contrasena', $contrasena);
            $sql->execute();
            $usuario = $sql->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                $mensaje = "Contraseña incorrecta.";
            } else {
                // Verificar saldo suficiente
                if ($usuario['saldo'] < $monto) {
                    $mensaje = "Saldo insuficiente.";
                } else {
                    // Registrar la transacción
                    $cnnPDO->beginTransaction();

                    // Restar el monto de la cuenta origen
                    $sql = $cnnPDO->prepare("UPDATE usuarios SET saldo = saldo - :monto WHERE cuenta = :cuenta");
                    $sql->bindParam(':monto', $monto);
                    $sql->bindParam(':cuenta', $usuarioData['cuenta']);
                    $sql->execute();

                    // Sumar el monto a la cuenta destino
                    $sql = $cnnPDO->prepare("UPDATE usuarios SET saldo = saldo + :monto WHERE cuenta = :cuenta");
                    $sql->bindParam(':monto', $monto);
                    $sql->bindParam(':cuenta', $cuentaDestino);
                    $sql->execute();

                    // Registrar la transacción en la tabla `transacciones`
                    $sql = $cnnPDO->prepare(
                        "INSERT INTO transacciones (cuenta_origen, cuenta_destino, monto, concepto, fecha) 
                         VALUES (:cuenta_origen, :cuenta_destino, :monto, :concepto, NOW())"
                    );
                    $sql->bindParam(':cuenta_origen', $usuarioData['cuenta']);
                    $sql->bindParam(':cuenta_destino', $cuentaDestino);
                    $sql->bindParam(':monto', $monto);
                    $sql->bindParam(':concepto', $concepto);
                    $sql->execute();

                    $cnnPDO->commit();

                    $mensaje = "Transferencia realizada con éxito.";
                }
            }
        }
    } catch (Exception $e) {
        $cnnPDO->rollBack();
        $mensaje = "Error al realizar la transferencia: " . $e->getMessage();
    }
}

// Obtener el historial de transacciones
$sql = $cnnPDO->prepare("SELECT * FROM transacciones WHERE cuenta_origen = :cuenta_origen ORDER BY fecha DESC");
$sql->bindParam(':cuenta_origen', $usuarioData['cuenta']);
$sql->execute();
$transacciones = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferencia</title>
    <?php require_once 'cdn.html'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: url(https://www.dutchcowboys.nl/wp-content/uploads/headers/telco-singtel-aandeel-singapore.jpg); 
            background-size: cover; 
            font-family: 'Poppins';
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .btn-custom {
            width: 100%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">BELBANK</a>
        <div class="btn-hdr">
            <a class="btn btn-danger" href="logout.php" role="button">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4" style="width: 35rem;">
        <div class="card-header bg-primary text-white text-center">
            <h3>Transferencia</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="cuenta_destino">Número de Cuenta Destino</label>
                    <input type="text" name="cuenta_destino" class="form-control" required onblur="validarCuenta(this.value)">
                    <div id="nombre_dueno" style="margin-top: 5px;"></div>
                </div>
                <div class="form-group">
                    <label for="monto">Monto a Transferir</label>
                    <input type="number" step="0.01" name="monto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="concepto">Concepto</label>
                    <input type="text" name="concepto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" name="contrasena" class="form-control" required>
                </div>
                <br>
                <button type="submit" name="transferir" class="btn btn-primary btn-custom">Transferir</button>
                <a href="04.sesion_iniciada.php" class="btn btn-secondary btn-custom mt-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h3 style="color: white;">Historial de Transacciones</h3>
    <table class="table table-bordered table-striped mg-3">
        <thead class="bg-dark text-white">
            <tr>
                <th>Fecha</th>
                <th>Cuenta Destino</th>
                <th>Monto</th>
                <th>Concepto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transacciones as $transaccion): ?>
                <tr>
                    <td><?php echo htmlspecialchars($transaccion['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($transaccion['cuenta_destino']); ?></td>
                    <td>$<?php echo number_format(htmlspecialchars($transaccion['monto']), 2); ?></td>
                    <td><?php echo htmlspecialchars($transaccion['concepto']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function validarCuenta(cuenta) {
        $.ajax({
            url: '07.validar_cuenta.php',
            type: 'POST',
            data: {cuenta: cuenta},
            success: function(response) {
                $('#nombre_dueno').html(response);
            }
        });
    }
</script>

<!-- Toastr JS -->
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