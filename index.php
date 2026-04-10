<?php
require_once 'config.php';
require_once 'auth.php';

$res = $pdo->prepare("SELECT promo FROM utilisateurs");
$res->execute();
$reqPromo = $res->fetchAll(PDO::FETCH_ASSOC);

$promo = str_replace('-', ' ', $_GET['promo']) ?? '';

foreach ($reqPromo as $p) {
  if ($promo === 'Tout') {
    $req = $pdo->prepare("SELECT * FROM utilisateurs");
    $req->execute();
    $user = $req->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE promo = :promo");
    $req->bindValue(":promo", $promo, PDO::PARAM_STR);
    $req->execute();
    $user = $req->fetchAll(PDO::FETCH_ASSOC);
  }
}

$promoArray = [];
foreach ($reqPromo as $row) {
  $p = trim($row['promo'] ?? '');
  if ($p !== '') {
    $promoArray[] = $p;
  }
}

if (!empty($promoArray)) {
    natcasesort($promoArray);
    $promoArray = array_values(array_unique($promoArray));
} else {
    $promoArray = [];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trombinoscope — Accueil</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <script src="./assets/js/script.js" defer></script>
</head>

<body>

  <nav>
    <a href="index.php" class="nav-logo">trombi<span>.</span></a>
    <button class="nav-toggle" aria-label="Ouvrir le menu">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <ul class="nav-links">
      <li><a href="index.php">Accueil</a></li>
      <li><a href="register.php">Inscription</a></li>
      <li><a href="login.php" class="btn-nav">Connexion</a></li>
    </ul>
  </nav>

  <div class="container">

    <div class="hero">
      <h1>Le trombinoscope<br>de <em>votre promo <u>B1</u></em></h1>
      <p>Retrouvez tous vos camarades, partagez vos publications et échangez des commentaires.</p>
      <a href="register.php" class="btn btn-primary btn-inline">Rejoindre la promo</a>
    </div>

    <div class="flash flash-success">
      Bienvenue sur le trombinoscope ! Inscrivez-vous pour rejoindre la promo.
    </div>

    <div class="filter-bar">
      <a href="?promo=Tout" class="filter-btn active">Tous</a>
      <?php foreach ($promoArray as $p): ?>
        <a href="?promo=<?= $p ?>" class="filter-btn"><?= $p ?></a>
      <?php endforeach; ?>
    </div>

    <div class="trombi-grid">

      <?php foreach ($user as $u): ?>
        <div class="trombi-card card">
          <a href="profil.php?id=<?= $u['id'] ?>">
            <img class="card-img" src="https://api.dicebear.com/7.x/personas/svg?seed=Alice&backgroundColor=b6e3f4" alt="Alice Martin">
            <div class="card-body">
              <div class="card-name"><?= $u['prenom'] . " " . $u['nom'] ?></div>
              <div class="card-role"><?= $u['specialite'] ?></div>
              <span class="card-promo"><?= $u['promo'] ?></span>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <footer>
    <div class="container">
      <p>Trombinoscope &mdash; Projet PHP &copy; <span class="footer-year"></span></p>
    </div>
  </footer>

</body>

</html>