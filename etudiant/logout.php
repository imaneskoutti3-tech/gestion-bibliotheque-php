<?php
require_once '../config/config.php';
unset($_SESSION['etud_id']);
unset($_SESSION['etud_nom']);
header('Location: ../index.php');
exit;
?>