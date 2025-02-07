<?php
require_once 'db_conexion.php';

if (isset($_POST['cuenta'])) {
    $cuenta = $_POST['cuenta'];
    $sql = $cnnPDO->prepare("SELECT nombre FROM usuarios WHERE cuenta = :cuenta");
    $sql->bindParam(':cuenta', $cuenta);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        echo "Dueño de la cuenta: " . htmlspecialchars($usuario['nombre']);
    } else {
        echo "Cuenta no encontrada.";
    }
}
?>