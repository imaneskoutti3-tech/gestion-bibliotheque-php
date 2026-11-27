<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['etud_id'])) { header('Location: ../index.php'); exit; }

// Liste de tous les livres
$query = "SELECT l.*, a.Nom_auteur, t.Intitule_theme FROM livre l 
          LEFT JOIN auteur a ON l.Num_auteur = a.Num_auteur 
          LEFT JOIN theme t ON l.Num_theme = t.Num_theme";
$livres = $pdo->query($query)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Espace Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>
<nav class="navbar navbar-dark navbar-custom p-3">
    <div class="container-fluid">
        <span class="navbar-brand">👋 Bienvenue, <?= htmlspecialchars($_SESSION['etud_nom']) ?></span>
        <div>
            <a href="mes_prets.php" class="btn btn-sm btn-outline-light me-2">📋 Mes emprunts</a>
            <a href="logout.php" class="btn btn-sm btn-grenat">Déconnexion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4 text-marron">📚 Rechercher et emprunter un livre</h3>
    <div class="row">
        <?php foreach ($livres as $l): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 card-custom bg-white">
                    <img src="<?= $l['Photo'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold"><?= htmlspecialchars($l['Titre_livre']) ?></h6>
                        <p class="small text-muted mb-1">Auteur: <?= htmlspecialchars($l['Nom_auteur']) ?></p>
                        <span class="badge bg-marron align-self-start mb-2"><?= htmlspecialchars($l['Intitule_theme']) ?></span>
                        
                        <div class="mt-auto">
                            <?php if ($l['disponible'] == 1): ?>
                                <a href="emprunter.php?id=<?= $l['Num_livre'] ?>" class="btn btn-sm btn-grenat w-100">Emprunter ce livre</a>
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary w-100" disabled>Indisponible</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>