<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['etud_id'])) { exit; }

$id_livre = $_GET['id'] ?? null;
$id_etud = $_SESSION['etud_id'];

if ($id_livre) {
    // Rend le livre virtuellement (met à jour la date pour informer l'administrateur)
    $stmt = $pdo->prepare("UPDATE emprunt SET Date_retour_reelle = NOW() WHERE Num_livre = ? AND Num_etud = ? AND Date_retour_reelle IS NULL");
    $stmt->execute([$id_livre, $id_etud]);

    // Rend le livre disponible immédiatement dans le catalogue général
    $stmt2 = $pdo->prepare("UPDATE livre SET disponible = 1 WHERE Num_livre = ?");
    $stmt2->execute([$id_livre]);
}

header('Location: mes_prets.php');
exit;
?>