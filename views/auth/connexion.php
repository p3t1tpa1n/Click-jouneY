<section class="auth-section">
  <div class="auth-container">
    <div class="auth-form-container">
      <div class="auth-header">
        <h2>Connexion</h2>
        <p class="auth-subtitle">Connectez-vous pour accéder à votre compte et gérer vos voyages sur la Route 66.</p>
      </div>
      
      <?php if (isset($alertMessage) && isset($alertType)): ?>
        <div class="alert <?= $alertType ?>">
          <i class="fas fa-<?= $alertType === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
          <?= $alertMessage ?>
        </div>
      <?php endif; ?>
      
      <form action="index.php?route=login" method="post" class="auth-form">
        <div class="form-group">
          <label for="login">Identifiant<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-user"></i>
            <input type="text" id="login" name="login" value="<?= isset($login) ? htmlspecialchars($login) : '' ?>" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="password">Mot de passe<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" required>
          </div>
        </div>
        
        <div class="form-group checkbox-group">
          <input type="checkbox" id="remember_me" name="remember_me" value="1">
          <label for="remember_me">Se souvenir de moi</label>
        </div>
        
        <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-sign-in-alt"></i> Se connecter
          </button>
        </div>
        
        <div class="form-link">
          <a href="#" class="forgot-password">Mot de passe oublié ?</a>
        </div>
      </form>
      
      <div class="auth-footer">
        <p>Pas encore de compte ? <a href="index.php?route=register">S'inscrire</a></p>
      </div>
    </div>
    
    <div class="auth-image">
      <img src="/images/backgrounds/route66-login.jpg" alt="Route 66" class="auth-background">
      <div class="auth-overlay">
        <div class="auth-quote">
          <i class="fas fa-quote-left"></i>
          <p>Le bonheur n'est pas une destination, mais une façon de voyager.</p>
          <cite>Margaret Lee Runbeck</cite>
        </div>
      </div>
    </div>
  </div>
</section> 