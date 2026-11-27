<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['admin_id'])) { header('Location: ../index.php'); exit; }

$query = "SELECT em.*, et.Nom_etud, et.Prenom_etud, lv.Titre_livre 
          FROM emprunt em 
          JOIN etudiant et ON em.Num_etud = et.Num_etud 
          JOIN livre lv ON em.Num_livre = lv.Num_livre
          ORDER BY em.Date_emprunt DESC";
$prets = $pdo->query($query)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Suivi des emprunts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-marron">📋 Suivi Global des Livres Empruntés</h3>
        <a href="dashboard.php" class="btn btn-grenat">Retour Panel</a>
    </div>
    <table class="table table-striped table-hover bg-white shadow-sm">
        <thead class="bg-grenat text-white">
            <tr><th>Étudiant</th><th>Livre</th><th>Date de Prêt</th><th>Date Retour Effet</th><th>Statut / Action</th></tr>
        </thead>
        <tbody>
            <?php foreach ($prets as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['Nom_etud'] . ' ' . $p['Prenom_etud']) ?></td>
                <td><strong><?= htmlspecialchars($p['Titre_livre']) ?></strong></td>
                <td><?= $p['Date_emprunt'] ?></td>
                <td><?= $p['Date_retour_reelle'] ?? '<span class="text-danger">Pas encore retourné</span>' ?></td>
                <td>
                    <?php if (!$p['Date_retour_reelle']): ?>
                        <a href="valider_retour.php?num_livre=<?= $p['Num_livre'] ?>&num_etud=<?= $p['Num_etud'] ?>" class="btn btn-sm btn-success">Valider le Retour</a>
                    <?php else: ?>
                        <span class="badge bg-secondary">Archivé</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>