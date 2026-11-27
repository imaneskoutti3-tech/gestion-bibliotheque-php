<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['etud_id'])) { exit; }

$id_livre = $_GET['id'] ?? null;
$id_etud = $_SESSION['etud_id'];

if ($id_livre) {
    // 1. Vérification de sécurité de la disponibilité du livre
    $chk = $pdo->prepare("SELECT disponible FROM livre WHERE Num_livre = ?");
    $chk->execute([$id_livre]);
    if ($chk->fetchColumn() == 1) {
        
        // 2. Insérer une nouvelle ligne dans emprunt (Date_emprunt = aujourd'hui)
        $stmt1 = $pdo->prepare("INSERT INTO emprunt (Num_livre, Num_etud, Date_emprunt, Date_retour_reelle) VALUES (?, ?, NOW(), NULL)");
        $stmt1->execute([$id_livre, $id_etud]);
        
        // 3. Basculer le livre sur indisponible (0)
        $stmt2 = $pdo->prepare("UPDATE livre SET disponible = 0 WHERE Num_livre = ?");
        $stmt2->execute([$id_livre]);
    }
}

header('Location: mes_prets.php');
exit;
?>