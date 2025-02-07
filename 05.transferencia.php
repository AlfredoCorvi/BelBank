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
if (isset($_POST['transferir'])) {
    $cuentaDestino = $_POST['cuenta_destino'];
    $monto = floatval($_POST['monto']); // Convertir a número
    $concepto = $_POST['concepto'];
    $contrasena = $_POST['contrasena']; // Obtener la contraseña

    // Validar que el monto sea positivo
    if ($monto <= 0) {
        echo "<script>toastr.error('El monto debe ser mayor que cero.', 'Error');</script>";
    } elseif ($usuarioData['cuenta'] === $cuentaDestino) {
        // Verificar que no se transfiera a la misma cuenta
        echo "<script>toastr.error('No se puede transferir a la misma cuenta.', 'Error');</script>";
    } else {
        // Verificar la contraseña
        if ($contrasena === $usuarioData['contrasena']) {
            // Verificar si la cuenta destino existe
            $sql = $cnnPDO->prepare("SELECT * FROM usuarios WHERE cuenta = :cuenta_destino");
            $sql->bindParam(':cuenta_destino', $cuentaDestino);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $cuentaDestinoData = $sql->fetch(PDO::FETCH_ASSOC);

                // Convertir saldos a números
                $saldoOrigen = floatval($usuarioData['saldo']);
                $saldoDestino = floatval($cuentaDestinoData['saldo']);

                // Verificar que el saldo de la cuenta origen sea suficiente
                if ($saldoOrigen >= $monto) {
                    // Iniciar transacción
                    $cnnPDO->beginTransaction();

                    try {
                        // Actualizar saldo de la cuenta origen
                        $nuevoSaldoOrigen = $saldoOrigen - $monto;
                        $sql = $cnnPDO->prepare("UPDATE usuarios SET saldo = :nuevo_saldo WHERE cuenta = :cuenta_origen");
                        $sql->bindParam(':nuevo_saldo', $nuevoSaldoOrigen);
                        $sql->bindParam(':cuenta_origen', $usuarioData['cuenta']);
                        $sql->execute();

                        // Actualizar saldo de la cuenta destino
                        $nuevoSaldoDestino = $saldoDestino + $monto;
                        $sql = $cnnPDO->prepare("UPDATE usuarios SET saldo = :nuevo_saldo WHERE cuenta = :cuenta_destino");
                        $sql->bindParam(':nuevo_saldo', $nuevoSaldoDestino);
                        $sql->bindParam(':cuenta_destino', $cuentaDestino);
                        $sql->execute();

                        // Registrar la transacción
                        $sql = $cnnPDO->prepare("INSERT INTO transacciones (cuenta_origen, cuenta_destino, monto, concepto) VALUES (:cuenta_origen, :cuenta_destino, :monto, :concepto)");
                        $sql->bindParam(':cuenta_origen', $usuarioData['cuenta']);
                        $sql->bindParam(':cuenta_destino', $cuentaDestino);
                        $sql->bindParam(':monto', $monto);
                        $sql->bindParam(':concepto', $concepto);
                        $sql->execute();

                        // Commit de la transacción
                        $cnnPDO->commit();

                        // Enviar correo
                            $to = $usuarioData['correo'];
                            $subject = "💰 Transferencia Realizada con Éxito";
                            $headers  = "MIME-Version: 1.0\r\n";
                            $headers .= "Content-type: text/html; charset=utf-8\r\n";
                            $headers .= "From: no-reply@tu-banco.com\r\n";

                            $message = "
                            <html>
                            <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
                                <div style='max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                                    <h1 style='color: #27ae60; text-align: center;'>✅ Transferencia Exitosa</h1>
                                    <p style='font-size: 16px; color: #333;'>Hola, <strong>{$usuarioData['nombre']}</strong></p>
                                    <p style='font-size: 16px; color: #333;'>Tu transferencia ha sido procesada con éxito. Aquí están los detalles:</p>
                                    <div style='background: #f9f9f9; padding: 15px; border-radius: 8px;'>
                                        <p><strong>💰 Monto Transferido:</strong> <span style='color: #27ae60;'>$".number_format($monto, 2)."</span></p>
                                        <p><strong>🏦 Cuenta Destino:</strong> $cuentaDestino</p>
                                        <p><strong>📄 Concepto:</strong> $concepto</p>
                                        <p><strong>📅 Fecha:</strong> ".date("d/m/Y H:i:s")."</p>
                                    </div>
                                    <p style='text-align: center;'>
                                        <a href='https://tu-banco.com/historial' style='background: #27ae60; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;'>Ver Historial</a>
                                    </p>
                                    <p style='font-size: 12px; text-align: center; color: #777;'>Si no realizaste esta transferencia, contacta con nuestro soporte de inmediato.</p>
                                </div>
                            </body>
                            </html>";

                        mail ($to, $subject, $message, $headers);

                        // Actualizar los datos del usuario en la sesión
                        $usuarioData['saldo'] = $nuevoSaldoOrigen;
                        $_SESSION['usuario'] = $usuarioData;

                        echo "<script>toastr.success('Transferencia realizada con éxito.', 'Éxito');</script>";
                    } catch (Exception $e) {
                        // Rollback en caso de error
                        $cnnPDO->rollBack();
                        echo "<script>toastr.error('Error al realizar la transferencia.', 'Error');</script>";
                    }
                } else {
                    echo "<script>toastr.error('Saldo insuficiente.', 'Error');</script>";
                }
            } else {
                echo "<script>toastr.error('La cuenta destino no existe.', 'Error');</script>";
            }
        } else {
            echo "<script>toastr.error('Contraseña incorrecta.', 'Error');</script>";
        }
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
</head>
<body style="background:url(images/fondo.png); background-size: cover; font-family: 'Poppins';">

<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="https://th.bing.com/th/id/OIP.ZwgZsScqAUCrVB5IElNAiAHaEK?w=322&h=181&c=7&r=0&o=5&dpr=1.1&pid=1.7" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            BELBANK
        </a>
        <div class="btn-hdr">
            <a class="btn btn-danger" href="logout.php" role="button">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 10vh; margin-top: 2cm;">
    <div class="card h-100" style="width: 35rem;">
        <div class="card-header" style="height: 50px; background-color:blue;">
            <h3 style="text-align: center; color: white;">Transferencia</h3>
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
                <button type="submit" name="transferir" class="btn btn-primary">Transferir</button>
                <a href="04.sesion_iniciada.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 2cm;">
    <h3>Historial de Transacciones</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cuenta Destino</ <th>Monto</th>
                <th>Concepto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transacciones as $transaccion): ?>
                <tr>
                    <td><?php echo htmlspecialchars($transaccion['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($transaccion['cuenta_destino']); ?></td>
                    <td><?php echo htmlspecialchars($transaccion['monto']); ?></td>
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