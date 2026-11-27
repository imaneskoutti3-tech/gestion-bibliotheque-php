<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['admin_id'])) { exit; }

$num_livre = $_GET['num_livre'] ?? null;
$num_etud = $_GET['num_etud'] ?? null;

if($num_livre && $num_etud) {
    // 1. Mettre à jour la date de retour réelle à aujourd'hui dans la table emprunt
    $stmt1 = $pdo->prepare("UPDATE emprunt SET Date_retour_reelle = NOW() WHERE Num_livre = ? AND Num_etud = ? AND Date_retour_reelle IS NULL");
    $stmt1->execute([$num_livre, $num_etud]);

    // 2. Rendre à nouveau le livre disponible dans la table livre
    $stmt2 = $pdo->prepare("UPDATE livre SET disponible = 1 WHERE Num_livre = ?");
    $stmt2->execute([$num_livre]);
}

header('Location: liste_prets.php');
exit;
?>