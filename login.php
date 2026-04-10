<?php
require_once 'config.php';
require_once 'auth.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $password = trim(htmlspecialchars($_POST['password'])) ?? '';
  $remember = $_POST['remember'] ?? '';
  

  $req = "SELECT * FROM utilisateurs WHERE email = :email";
  $select = $pdo->prepare($req);
  $select->bindValue(':email', $email, PDO::PARAM_STR);
  $select->execute();

  if ($select->rowCount() > 0) {
    $stmt = $select->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $stmt['password'])) {
      $_SESSION['user_id'] = $stmt['id'];
      $_SESSION['prenom'] = $stmt['prenom'];
      header("Location: index.php");
    }
  } else {
    $_SESSION['flash_error'] = "L'email ou le mot de passe est incorrect";
  }

  if ($remember == 1) {
    setcookie('email', "$email", time() + (3600 * 24 * 30));
  }

  if (isset($_COOKIE['email']) && !empty($_COOKIE['email'])) {
    $emailCookie = $_COOKIE['email'];
  }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trombinoscope — Connexion</title>
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
      <li><a href="register.php" class="btn-nav">Inscription</a></li>
    </ul>
  </nav>

  <div class="container-sm">

    <?php require 'flash.php';?>

    <div class="form-card">
      <div class="form-title">Se connecter</div>
      <div class="form-subtitle">Bon retour parmi nous.</div>

      <form action="" method="POST">

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" placeholder="alice@exemple.fr" value="<?php echo $emailCookie ?? '' ?>" required>
        </div>

        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
        </div>

        <div class="form-check">
          <input type="checkbox" id="remember" name="remember" value="1">
          <label for="remember">Se souvenir de moi</label>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>

      </form>

      <div class="form-footer">
        Pas encore de compte ? <a href="register.php">S'inscrire</a>
      </div>
    </div>
  </div>

  <footer>
    <div class="container">
      <p>Trombinoscope &mdash; Projet PHP &copy; <span class="footer-year"></span></p>
    </div>
  </footer>

</body>

</html>