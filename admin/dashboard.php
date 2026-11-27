<?php
require_once '../config/config.php';
require_once '../config/connexion.php';

if (!isset($_SESSION['admin_id'])) { header('Location: ../index.php'); exit; }

// Statistiques
$total_livres = $pdo->query("SELECT COUNT(*) FROM livre")->fetchColumn();
$total_etud = $pdo->query("SELECT COUNT(*) FROM etudiant")->fetchColumn();
$total_prets = $pdo->query("SELECT COUNT(*) FROM emprunt WHERE Date_retour_reelle IS NULL")->fetchColumn();

// Liste des livres
$livres = $pdo->query("SELECT l.*, a.Nom_auteur FROM livre l LEFT JOIN auteur a ON l.Num_auteur = a.Num_auteur")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>
<nav class="navbar navbar-dark navbar-custom p-3">
    <div class="container-fluid">
        <span class="navbar-brand">Panel Administrateur (<?= $_SESSION['admin_login'] ?>)</span>
        <div>
            <a href="liste_etudiants.php" class="btn btn-sm btn-outline-light me-2">Étudiants</a>
            <a href="liste_prets.php" class="btn btn-sm btn-outline-light me-2">Prêts</a>
            <a href="logout.php" class="btn btn-sm btn-grenat">Déconnexion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row text-center text-white mb-4">
        <div class="col-md-4"><div class="p-3 bg-marron rounded"><h5>Livres Référencés</h5><h3><?= $total_livres ?></h3></div></div>
        <div class="col-md-4"><div class="p-3 bg-grenat rounded"><h5>Étudiants Inscrits</h5><h3><?= $total_etud ?></h3></div></div>
        <div class="col-md-4"><div class="p-3 bg-warning text-dark rounded"><h5>Emprunts Actifs</h5><h3><?= $total_prets ?></h3></div></div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-marron">📚 Tous les livres</h3>
        <a href="ajouter_livre.php" class="btn btn-grenat">+ Ajouter un livre</a>
    </div>

    <table class="table table-striped align-middle card-custom bg-white">
        <thead class="bg-marron text-white">
            <tr><th>Numéro</th><th>Image</th><th>Titre</th><th>Auteur</th><th>Disponibilité</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($livres as $l): ?>
            <tr>
                <td><?= $l['Num_livre'] ?></td>
                <td><img src="<?= $l['Photo'] ?>" style="width:50px;height:65px;object-fit:cover;"></td>
                <td><strong><?= htmlspecialchars($l['Titre_livre']) ?></strong></td>
                <td><?= htmlspecialchars($l['Nom_auteur']) ?></td>
                <td><?= $l['disponible'] ? '<span class="badge bg-success">Disponible</span>' : '<span class="badge bg-danger">Emprunté</span>' ?></td>
                <td>
                    <a href="modifier_livre.php?id=<?= $l['Num_livre'] ?>" class="btn btn-sm btn-marron">Modifier</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>