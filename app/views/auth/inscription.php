<?php /* Inclusion du CSS dédié à l'authentification */ ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/auth.css">

<section class="auth-section">
  <div class="auth-container">
    <div class="auth-form-container">
      <div class="auth-header">
        <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Click-JourneY" class="auth-logo">
        <h2>Créez votre compte voyageur</h2>
        <p class="auth-subtitle">Rejoignez notre communauté et préparez-vous pour des aventures inoubliables sur la Route 66</p>
      </div>
      
      <?php if (isset($alertMessage) && isset($alertType)): ?>
        <div class="alert <?= $alertType ?>">
          <i class="fas fa-<?= $alertType === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
          <?= $alertMessage ?>
        </div>
      <?php endif; ?>
      
      <form action="index.php?route=register" method="post" class="auth-form" id="register-form">
        <div class="form-group">
          <label for="login">Identifiant<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-user"></i>
            <input type="text" id="login" name="login" value="<?= isset($login) ? htmlspecialchars($login) : '' ?>" required placeholder="Choisissez un identifiant unique">
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="password">Mot de passe<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-lock"></i>
              <input type="password" id="password" name="password" required placeholder="Votre mot de passe">
            </div>
            <small class="form-hint">Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule, un chiffre et un caractère spécial.</small>
          </div>
          
          <div class="form-group">
            <label for="confirm_password">Confirmation<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-lock"></i>
              <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirmez votre mot de passe">
            </div>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="firstname">Prénom<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-user-circle"></i>
              <input type="text" id="firstname" name="firstname" value="<?= isset($firstname) ? htmlspecialchars($firstname) : '' ?>" required placeholder="Votre prénom">
            </div>
          </div>
          
          <div class="form-group">
            <label for="lastname">Nom<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-user-circle"></i>
              <input type="text" id="lastname" name="lastname" value="<?= isset($lastname) ? htmlspecialchars($lastname) : '' ?>" required placeholder="Votre nom">
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="email">Email<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required placeholder="Votre adresse email">
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="birth_date">Date de naissance<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-calendar-alt"></i>
              <input type="date" id="birth_date" name="birth_date" value="<?= isset($birthDate) ? htmlspecialchars($birthDate) : '' ?>" required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="phone">Téléphone</label>
            <div class="input-with-icon">
              <i class="fas fa-phone"></i>
              <input type="tel" id="phone" name="phone" value="<?= isset($phone) ? htmlspecialchars($phone) : '' ?>" placeholder="Votre numéro de téléphone">
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="address">Adresse<span class="required">*</span></label>
          <div class="input-with-icon textarea-icon">
            <i class="fas fa-map-marker-alt"></i>
            <textarea id="address" name="address" required placeholder="Votre adresse complète"><?= isset($address) ? htmlspecialchars($address) : '' ?></textarea>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="city">Ville<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-city"></i>
              <input type="text" id="city" name="city" value="<?= isset($city) ? htmlspecialchars($city) : '' ?>" required placeholder="Votre ville">
            </div>
          </div>
          
          <div class="form-group">
            <label for="postal_code">Code postal<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-map"></i>
              <input type="text" id="postal_code" name="postal_code" value="<?= isset($postalCode) ? htmlspecialchars($postalCode) : '' ?>" required placeholder="Votre code postal">
            </div>
          </div>
        </div>
        
        <div class="form-group checkbox-group">
          <input type="checkbox" id="newsletter" name="newsletter" value="1" <?= isset($newsletter) && $newsletter ? 'checked' : '' ?>>
          <label for="newsletter">Je souhaite recevoir les offres et nouveautés par email</label>
        </div>
        
        <div class="form-group checkbox-group">
          <input type="checkbox" id="terms" name="terms" required>
          <label for="terms">J'accepte les <a href="#" target="_blank">conditions générales d'utilisation</a><span class="required">*</span></label>
        </div>
        
        <input type="hidden" name="name" value="<?= isset($firstname) ? htmlspecialchars($firstname) : '' ?> <?= isset($lastname) ? htmlspecialchars($lastname) : '' ?>">
        
        <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-user-plus"></i> Créer mon compte
          </button>
        </div>
      </form>
      
      <div class="auth-footer">
        <p>Déjà inscrit ? <a href="index.php?route=login">Se connecter</a></p>
        <div class="auth-divider">
          <span>ou continuer avec</span>
        </div>
        <div class="social-auth">
          <a href="#" class="social-btn" title="S'inscrire avec Google">
            <i class="fab fa-google"></i>
          </a>
          <a href="#" class="social-btn" title="S'inscrire avec Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="social-btn" title="S'inscrire avec Apple">
            <i class="fab fa-apple"></i>
          </a>
        </div>
      </div>
    </div>
    
    <div class="auth-image">
      <img src="<?= BASE_URL ?>/public/assets/images/backgrounds/route66-signup.jpg" alt="Route 66" class="auth-background">
      <div class="auth-overlay">
        <div class="auth-quote">
          <i class="fas fa-quote-left"></i>
          <p>"La vie est un voyage, et celui qui voyage vit deux fois."</p>
          <cite>Omar Khayyam</cite>
        </div>
        <div class="auth-benefits">
          <h3>Avantages membres</h3>
          <ul class="benefits-list">
            <li class="benefit-item">
              <i class="fas fa-percentage"></i>
              <span>Réductions exclusives</span>
            </li>
            <li class="benefit-item">
              <i class="fas fa-gift"></i>
              <span>Offres spéciales</span>
            </li>
            <li class="benefit-item">
              <i class="fas fa-bell"></i>
              <span>Alertes nouveaux voyages</span>
            </li>
            <li class="benefit-item">
              <i class="fas fa-suitcase"></i>
              <span>Gestion de réservations</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<?php /* Inclusion du JS dédié à l'authentification */ ?>
<script src="<?= BASE_URL ?>/public/assets/js/auth.js" defer></script> 