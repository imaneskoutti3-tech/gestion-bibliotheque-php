<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['etud_id'])) { header('Location: ../index.php'); exit; }

$id_etud = $_SESSION['etud_id'];
$query = "SELECT em.*, lv.Titre_livre, lv.Photo FROM emprunt em 
          JOIN livre lv ON em.Num_livre = lv.Num_livre 
          WHERE em.Num_etud = ? ORDER BY em.Date_emprunt DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_etud]);
$mes_prets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Mes Emprunts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-grenat">📋 Historique personnel de vos emprunts</h3>
        <a href="dashboard.php" class="btn btn-marron">Retour Catalogue</a>
    </div>

    <div class="row">
        <?php if(empty($mes_prets)): ?>
            <div class="alert alert-info">Vous n'avez pas encore emprunté de livres.</div>
        <?php endif; ?>
        
        <?php foreach ($mes_prets as $p): ?>
            <div class="col-md-6 mb-3">
                <div class="card p-3 shadow-sm d-flex flex-row card-custom bg-white">
                    <img src="<?= $p['Photo'] ?>" style="width:80px; height:110px; object-fit:cover;" class="rounded me-3">
                    <div class="w-100">
                        <h5><?= htmlspecialchars($p['Titre_livre']) ?></h5>
                        <p class="small text-muted mb-1">Date d'emprunt : <?= $p['Date_emprunt'] ?></p>
                        <p class="small mb-2">
                            Statut : <?= $p['Date_retour_reelle'] ? '<span class="text-success">Rendu le ' . $p['Date_retour_reelle'] . '</span>' : '<span class="text-warning fw-bold">En votre possession</span>' ?>
                        </p>
                        <?php if (!$p['Date_retour_reelle']): ?>
                            <a href="retour.php?id=<?= $p['Num_livre'] ?>" class="btn btn-sm btn-outline-danger">Déclarer le livre comme rendu</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>