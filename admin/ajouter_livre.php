<?php
require_once '../config/config.php';
require_once '../config/connexion.php';
if (!isset($_SESSION['admin_id'])) { header('Location: ../index.php'); exit; }

$auteurs = $pdo->query("SELECT * FROM auteur")->fetchAll();
$editeurs = $pdo->query("SELECT * FROM editeur")->fetchAll();
$themes = $pdo->query("SELECT * FROM theme")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num = $_POST['num_livre'];
    $titre = $_POST['titre'];
    $auteur = $_POST['num_auteur'];
    $editeur = $_POST['num_editeur'];
    $theme = $_POST['num_theme'];
    $annee = $_POST['annee'];
    $photo = $_POST['photo']; // URL textuelle ou base64

    $stmt = $pdo->prepare("INSERT INTO livre (Num_livre, Titre_livre, Num_auteur, Num_editeur, Num_theme, Annee_edition, Photo, disponible) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->execute([$num, $titre, $auteur, $editeur, $theme, $annee, $photo]);
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Ajouter un Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>
<div class="container mt-5 col-md-6">
    <div class="card card-custom p-4 bg-white">
        <h3 class="text-grenat text-center mb-4">Ajouter un nouveau Livre</h3>
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Numéro Unique</label><input type="number" name="num_livre" class="form-control" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Année d'édition</label><input type="number" name="annee" class="form-control" required></div>
            </div>
            <div class="mb-3"><label class="form-label">Titre du livre</label><input type="text" name="titre" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">URL de la photo de couverture</label><input type="text" name="photo" class="form-control" placeholder="https://example.com/image.jpg"></div>
            
            <div class="mb-3">
                <label class="form-label">Auteur</label>
                <select name="num_auteur" class="form-select">
                    <?php foreach ($auteurs as $a): ?><option value="<?= $a['Num_auteur']; ?>"><?= htmlspecialchars($a['Nom_auteur']) ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Éditeur</label>
                <select name="num_editeur" class="form-select">
                    <?php foreach ($editeurs as $e): ?><option value="<?= $e['Num_editeur'] ?>"><?= htmlspecialchars($e['Nom_editeur']) ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Thème</label>
                <select name="num_theme" class="form-select">
                    <?php foreach ($themes as $t): ?><option value="<?= $t['Num_theme'] ?>"><?= htmlspecialchars($t['Intitule_theme']) ?></option><?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-grenat w-100">Enregistrer dans le Catalogue</button>
            <a href="dashboard.php" class="btn btn-outline-secondary w-100 mt-2">Retour</a>
        </form>
    </div>
</div>
</body>
</html>