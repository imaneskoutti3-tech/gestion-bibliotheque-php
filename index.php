<?php
require_once 'config/config.php';
require_once 'config/connexion.php';

// Connexion Administration
if (isset($_POST['login_admin'])) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE Login = ? AND MotDePasse = ?");
    $stmt->execute([$login, $password]);
    $admin = $stmt->fetch();
    
    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_login'] = $admin['Login'];
        header('Location: admin/dashboard.php');
        exit;
    } else {
        $error = "Identifiants Admin incorrects.";
    }
}

// Connexion Étudiant
if (isset($_POST['login_etudiant'])) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE login = ? AND mot_de_passe = ?");
    $stmt->execute([$login, $password]);
    $etud = $stmt->fetch();
    
    if ($etud) {
        $_SESSION['etud_id'] = $etud['Num_etud'];
        $_SESSION['etud_nom'] = $etud['Nom_etud'] . " " . $etud['Prenom_etud'];
        header('Location: etudiant/dashboard.php');
        exit;
    } else {
        $error = "Identifiants Étudiant incorrects.";
    }
}

// Récupération des livres disponibles
$query = "SELECT l.*, a.Nom_auteur, t.Intitule_theme FROM livre l 
          LEFT JOIN auteur a ON l.Num_auteur = a.Num_auteur 
          LEFT JOIN theme t ON l.Num_theme = t.Num_theme 
          WHERE l.disponible = 1";
$livres = $pdo->query($query)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque en Ligne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php inject_custom_css(); ?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">📚 Ma Bibliothèque imane skoutti</a>
        
        <div>
            <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginEtudiantModal">Espace Étudiant</button>
            <button class="btn btn-grenat" data-bs-toggle="modal" data-bs-target="#loginAdminModal">🔑 Admin</button>
        </div>
    </div>
</nav>

<div class="container">
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="p-5 mb-4 bg-marron rounded-3 text-center text-white">
        <h1 class="display-5 fw-bold">Bienvenue dans votre Bibliothèque numérique</h1>
        <p class="fs-4">Consultez, réservez et apprenez en quelques clics.</p>
        <div class="col-md-6 mx-auto mt-3">
            <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Rechercher un livre par son titre...">
        </div>
    </div>

    <h2 class="mb-4 text-grenat">📖 Catalogue des Livres Disponibles</h2>
    <div class="row" id="booksCatalog">
        <?php foreach ($livres as $livre): ?>
            <div class="col-md-3 mb-4 book-card" data-title="<?= strtolower(htmlspecialchars($livre['Titre_livre'])) ?>">
                <div class="card h-100 card-custom">
                    <?php if($livre['Photo']): ?>
                        <img src="<?= htmlspecialchars($livre['Photo']) ?>" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Couverture">
                    <?php else: ?>
                        <div class="bg-secondary text-white text-center py-5">Pas d'image</div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-marron"><?= htmlspecialchars($livre['Titre_livre']) ?></h5>
                        <p class="card-text text-muted mb-1">Auteur : <?= htmlspecialchars($livre['Nom_auteur']) ?></p>
                        <p class="badge bg-grenat align-self-start"><?= htmlspecialchars($livre['Intitule_theme']) ?></p>
                        <p class="small text-end mt-auto text-secondary">Édition : <?= $livre['Annee_edition'] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="loginAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header bg-grenat text-white">
                <h5 class="modal-title">Connexion Administration</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-shadow="none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Identifiant Administrateur</label>
                    <input type="text" name="login" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="login_admin" class="btn btn-grenat w-100">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="loginEtudiantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header bg-marron text-white">
                <h5 class="modal-title">Espace Étudiant Connecté</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nom d'utilisateur (Login)</label>
                    <input type="text" name="login" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="text-center mt-2">
                    <a href="etudiant/inscription.php" class="text-grenat small">Pas encore inscrit ? Créez un compte ici</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="login_etudiant" class="btn btn-marron w-100">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Recherche dynamique en temps réel avec JS
    document.getElementById('searchInput').addEventListener('input', function(e) {
        let filter = e.target.value.toLowerCase();
        let cards = document.querySelectorAll('.book-card');
        cards.forEach(card => {
            let title = card.getAttribute('data-title');
            if(title.includes(filter)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });
</script>
</body>
</html>