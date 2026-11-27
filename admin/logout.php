<?php
require_once '../config/config.php';
unset($_SESSION['admin_id']);
unset($_SESSION['admin_login']);
header('Location: ../index.php');
exit;
?>