<?php
require_once '../config/config.php';
require_once '../config/connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $adresse = trim($_POST['adresse']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $pass = trim($_POST['password']);

    // Vérifier si le login existe déjà
    $check = $pdo->prepare("SELECT COUNT(*) FROM etudiant WHERE login = ?");
    $check->execute([$login]);
    
    if ($check->fetchColumn() == 0) {
        $ins = $pdo->prepare("INSERT INTO etudiant (Nom_etud, Prenom_etud, Adresse_etud, login, mot_de_passe, email) VALUES (?, ?, ?, ?, ?, ?)");
        $ins->execute([$nom, $prenom, $adresse, $login, $pass, $email]);
        $success = "Inscription réussie ! Connectez-vous sur la page d'accueil.";
    } else {
        $error = "Ce nom d'utilisateur (login) est déjà pris.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Inscription Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>
<div class="container mt-5 col-md-6">
    <div class="card card-custom p-4 bg-white">
        <h3 class="text-grenat text-center mb-3">Formulaire d'Inscription Étudiant</h3>
        <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Prénom</label><input type="text" name="prenom" class="form-control" required></div>
            </div>
            <div class="mb-3"><label class="form-label">Adresse physique</label><input type="text" name="adresse" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Adresse Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Identifiant (Login)</label><input type="text" name="login" class="form-control" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Mot de passe</label><input type="password" name="password" class="form-control" required></div>
            </div>
            <button type="submit" class="btn btn-grenat w-100">Créer mon compte étudiant</button>
            <a href="../index.php" class="btn btn-outline-secondary w-100 mt-2">Retour à l'accueil</a>
        </form>
    </div>
</div>
</body>
</html>