<?php /* Inclusion du CSS dédié à l'authentification */ ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/auth.css">

<section class="auth-section">
  <div class="auth-container">
    <div class="auth-form-container">
      <div class="auth-header">
        <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Click-JourneY" class="auth-logo">
        <h2>Bienvenue sur Click-JourneY</h2>
        <p class="auth-subtitle">Connectez-vous pour accéder à vos voyages sur la Route 66</p>
      </div>
      
      <?php if (isset($alertMessage) && isset($alertType)): ?>
        <div class="alert <?= $alertType ?>">
          <i class="fas fa-<?= $alertType === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
          <?= $alertMessage ?>
        </div>
      <?php endif; ?>
      
      <form action="index.php?route=login" method="post" class="auth-form" id="login-form">
        <div class="form-group">
          <label for="login">Identifiant<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-user"></i>
            <input type="text" id="login" name="login" required placeholder="Votre identifiant" value="<?= htmlspecialchars($login ?? '') ?>">
          </div>
        </div>
        
        <div class="form-group">
          <label for="password">Mot de passe<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" required placeholder="Votre mot de passe">
            <button type="button" class="password-toggle-btn" aria-label="Afficher/masquer le mot de passe">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        
        <div class="form-group checkbox-group">
          <input type="checkbox" id="remember" name="remember" value="1">
          <label for="remember">Se souvenir de moi</label>
        </div>
        
        <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-sign-in-alt"></i> Se connecter
          </button>
        </div>
        
        <div class="auth-links">
          <a href="#" class="forgot-password">Mot de passe oublié ?</a>
        </div>
      </form>
      
      <div class="auth-footer">
        <p>Pas encore de compte ? <a href="index.php?route=register">S'inscrire</a></p>
        <div class="auth-divider">
          <span>ou continuer avec</span>
        </div>
        <div class="social-auth">
          <a href="#" class="social-btn" title="Se connecter avec Google">
            <i class="fab fa-google"></i>
          </a>
          <a href="#" class="social-btn" title="Se connecter avec Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="social-btn" title="Se connecter avec Apple">
            <i class="fab fa-apple"></i>
          </a>
        </div>
      </div>
    </div>
    
    <div class="auth-image">
      <img src="<?= BASE_URL ?>/public/assets/images/backgrounds/route66-login.jpg" alt="Route 66" class="auth-background">
      <div class="auth-overlay">
        <div class="auth-quote">
          <i class="fas fa-quote-left"></i>
          <p>"Le voyage est la seule chose que vous achetez qui vous rend plus riche."</p>
          <cite>Anonyme</cite>
        </div>
        <div class="auth-features">
          <h3>Fonctionnalités</h3>
          <ul class="features-list">
            <li class="feature-item">
              <i class="fas fa-route"></i>
              <span>Planifiez vos étapes</span>
            </li>
            <li class="feature-item">
              <i class="fas fa-hotel"></i>
              <span>Réservez votre hébergement</span>
            </li>
            <li class="feature-item">
              <i class="fas fa-map-marked-alt"></i>
              <span>Découvrez les lieux incontournables</span>
            </li>
            <li class="feature-item">
              <i class="fas fa-car"></i>
              <span>Location de véhicules</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<?php /* Inclusion du JS dédié à l'authentification */ ?>
<script src="<?= BASE_URL ?>/public/assets/js/auth.js" defer></script> 