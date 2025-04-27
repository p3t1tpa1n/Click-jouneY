<?php
$pageTitle = 'Connexion';
require_once 'includes/header.php';

// Rediriger si déjà connecté
if (isLoggedIn()) {
    redirect('index.php');
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        $alertType = 'error';
        $alertMessage = 'Veuillez remplir tous les champs.';
    } else {
        $user = User::authenticate($login, $password);
        
        if ($user) {
            // Stocker les informations de l'utilisateur en session
            $_SESSION['user'] = $user;
            
            // Rediriger vers la page d'accueil
            redirect('index.php');
        } else {
            $alertType = 'error';
            $alertMessage = 'Identifiants incorrects. Veuillez réessayer.';
        }
    }
}
?>

<section class="auth-form">
  <h2>Connexion</h2>
  
  <?php if (isset($alertMessage) && isset($alertType)): ?>
    <div class="alert <?= $alertType ?>">
      <?= $alertMessage ?>
    </div>
  <?php endif; ?>
  
  <form action="connexion.php" method="post">
    <div class="form-group">
      <label for="login">Identifiant</label>
      <input type="text" id="login" name="login" required>
    </div>
    
    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" required>
    </div>
    
    <div class="form-actions">
      <button type="submit" class="btn">Se connecter</button>
    </div>
  </form>
  
  <p class="auth-links">
    Pas encore de compte ? <a href="inscription.php">S'inscrire</a>
  </p>
</section>

<?php require_once 'includes/footer.php'; ?> 