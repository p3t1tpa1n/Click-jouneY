<?php
$pageTitle = 'Inscription';
require_once 'includes/header.php';

// Rediriger si déjà connecté
if (isLoggedIn()) {
    redirect('index.php');
}

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $birthDate = $_POST['birth_date'] ?? '';
    $address = $_POST['address'] ?? '';
    
    // Validation des champs
    $errors = [];
    
    if (empty($login)) {
        $errors[] = 'L\'identifiant est obligatoire.';
    } elseif (User::getByLogin($login)) {
        $errors[] = 'Cet identifiant est déjà utilisé.';
    }
    
    if (empty($password)) {
        $errors[] = 'Le mot de passe est obligatoire.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }
    
    if (empty($name)) {
        $errors[] = 'Le nom est obligatoire.';
    }
    
    if (empty($email)) {
        $errors[] = 'L\'email est obligatoire.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'L\'email n\'est pas valide.';
    }
    
    if (empty($birthDate)) {
        $errors[] = 'La date de naissance est obligatoire.';
    }
    
    if (empty($address)) {
        $errors[] = 'L\'adresse est obligatoire.';
    }
    
    if (empty($errors)) {
        // Création de l'utilisateur
        $userData = [
            'login' => $login,
            'password' => $password, // Le modèle User::create se chargera du hachage
            'name' => $name,
            'email' => $email,
            'birth_date' => $birthDate,
            'address' => $address,
            'role' => 'user' // Rôle par défaut
        ];
        
        $result = User::create($userData);
        
        if ($result === true) {
            // Authentifier automatiquement l'utilisateur
            $user = User::getByLogin($login);
            unset($user['password']); // Ne pas stocker le mot de passe en session
            $_SESSION['user'] = $user;
            
            // Rediriger vers la page d'accueil
            redirect('index.php');
        } else {
            $alertType = 'error';
            $alertMessage = $result; // Le message d'erreur retourné par User::create
        }
    } else {
        $alertType = 'error';
        $alertMessage = implode('<br>', $errors);
    }
}
?>

<section class="auth-form">
  <h2>Inscription</h2>
  
  <?php if (isset($alertMessage) && isset($alertType)): ?>
    <div class="alert <?= $alertType ?>">
      <?= $alertMessage ?>
    </div>
  <?php endif; ?>
  
  <form action="inscription.php" method="post">
    <div class="form-group">
      <label for="login">Identifiant*</label>
      <input type="text" id="login" name="login" value="<?= isset($login) ? htmlspecialchars($login) : '' ?>" required>
    </div>
    
    <div class="form-group">
      <label for="password">Mot de passe*</label>
      <input type="password" id="password" name="password" required>
      <small>Le mot de passe doit contenir au moins 6 caractères.</small>
    </div>
    
    <div class="form-group">
      <label for="confirm_password">Confirmer le mot de passe*</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    
    <div class="form-group">
      <label for="name">Nom complet*</label>
      <input type="text" id="name" name="name" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
    </div>
    
    <div class="form-group">
      <label for="email">Email*</label>
      <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
    </div>
    
    <div class="form-group">
      <label for="birth_date">Date de naissance*</label>
      <input type="date" id="birth_date" name="birth_date" value="<?= isset($birthDate) ? htmlspecialchars($birthDate) : '' ?>" required>
    </div>
    
    <div class="form-group">
      <label for="address">Adresse*</label>
      <textarea id="address" name="address" required><?= isset($address) ? htmlspecialchars($address) : '' ?></textarea>
    </div>
    
    <div class="form-actions">
      <button type="submit" class="btn">S'inscrire</button>
    </div>
  </form>
  
  <p class="auth-links">
    Déjà inscrit ? <a href="connexion.php">Se connecter</a>
  </p>
</section>

<?php require_once 'includes/footer.php'; ?> 