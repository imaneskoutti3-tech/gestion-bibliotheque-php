<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['admin_id'])) { header('Location: ../index.php'); exit; }

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM livre WHERE Num_livre = ?");
$stmt->execute([$id]);
$livre = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $annee = $_POST['annee'];
    $photo = $_POST['photo'];
    $dispo = $_POST['disponible'];

    $update = $pdo->prepare("UPDATE livre SET Titre_livre = ?, Annee_edition = ?, Photo = ?, disponible = ? WHERE Num_livre = ?");
    $update->execute([$titre, $annee, $photo, $dispo, $id]);
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Modifier le Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>
<div class="container mt-5 col-md-6">
    <div class="card card-custom p-4 bg-white">
        <h3 class="text-marron text-center mb-4">Modifier le Livre #<?= htmlspecialchars($id) ?></h3>
        <form method="POST">
            <div class="mb-3"><label class="form-label">Titre</label><input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($livre['Titre_livre']) ?>" required></div>
            <div class="mb-3"><label class="form-label">Année</label><input type="number" name="annee" class="form-control" value="<?= $livre['Annee_edition'] ?>" required></div>
            <div class="mb-3"><label class="form-label">Image URL</label><input type="text" name="photo" class="form-control" value="<?= htmlspecialchars($livre['Photo']) ?>"></div>
            <div class="mb-3">
                <label class="form-label">Statut</label>
                <select name="disponible" class="form-select">
                    <option value="1" <?= $livre['disponible'] == 1 ? 'selected' : '' ?>>Disponible</option>
                    <option value="0" <?= $livre['disponible'] == 0 ? 'selected' : '' ?>>Non disponible / Emprunté</option>
                </select>
            </div>
            <button type="submit" class="btn btn-marron w-100">Mettre à jour</button>
            <a href="dashboard.php" class="btn btn-outline-secondary w-100 mt-2">Annuler</a>
        </form>
    </div>
</div>
</body>
</html>