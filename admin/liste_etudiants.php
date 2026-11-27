<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['admin_id'])) { header('Location: ../index.php'); exit; }

$etudiants = $pdo->query("SELECT * FROM etudiant")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Liste des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-grenat">👥 Comptes Étudiants Enregistrés</h3>
        <a href="dashboard.php" class="btn btn-marron">Retour Panel</a>
    </div>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="bg-marron text-white">
            <tr><th>Numéro</th><th>Nom & Prénom</th><th>Email</th><th>Adresse</th><th>Login</th></tr>
        </thead>
        <tbody>
            <?php foreach ($etudiants as $e): ?>
            <tr>
                <td><?= $e['Num_etud'] ?></td>
                <td><?= htmlspecialchars($e['Nom_etud'] . ' ' . $e['Prenom_etud']) ?></td>
                <td><?= htmlspecialchars($e['email']) ?></td>
                <td><?= htmlspecialchars($e['Adresse_etud']) ?></td>
                <td><code><?= htmlspecialchars($e['login']) ?></code></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>