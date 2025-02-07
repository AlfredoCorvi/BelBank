<?php
session_start();
session_destroy();
header("Location: 00.index.php");
exit;
?>
