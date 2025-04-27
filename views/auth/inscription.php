<section class="auth-section">
  <div class="auth-container">
    <div class="auth-form-container">
      <div class="auth-header">
        <h2>Rejoignez l'aventure Route 66</h2>
        <p class="auth-subtitle">Créez votre compte pour explorer nos circuits et réserver votre prochain voyage.</p>
      </div>
      
      <?php if (isset($alertMessage) && isset($alertType)): ?>
        <div class="alert <?= $alertType ?>">
          <i class="fas fa-<?= $alertType === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
          <?= $alertMessage ?>
        </div>
      <?php endif; ?>
      
      <form action="index.php?route=register" method="post" class="auth-form" data-validate="true">
        <div class="form-group">
          <label for="login">Identifiant<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-user"></i>
            <input type="text" id="login" name="login" value="<?= isset($login) ? htmlspecialchars($login) : '' ?>" required>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="password">Mot de passe<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-lock"></i>
              <input type="password" id="password" name="password" required>
            </div>
            <small class="form-hint">Le mot de passe doit contenir au moins 6 caractères, dont une lettre majuscule et un chiffre.</small>
          </div>
          
          <div class="form-group">
            <label for="confirm_password">Confirmation<span class="required">*</span></label>
            <div class="input-with-icon">
              <i class="fas fa-lock"></i>
              <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="name">Nom complet<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-user-circle"></i>
            <input type="text" id="name" name="name" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="email">Email<span class="required">*</span></label>
          <div class="input-with-icon">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
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
        </div>
        
        <div class="form-group">
          <label for="address">Adresse<span class="required">*</span></label>
          <div class="input-with-icon textarea-icon">
            <i class="fas fa-map-marker-alt"></i>
            <textarea id="address" name="address" required><?= isset($address) ? htmlspecialchars($address) : '' ?></textarea>
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
        
        <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-user-plus"></i> Créer mon compte
          </button>
        </div>
      </form>
      
      <div class="auth-footer">
        <p>Déjà inscrit ? <a href="index.php?route=login">Se connecter</a></p>
      </div>
    </div>
    
    <div class="auth-image">
      <img src="/images/backgrounds/route66-signup.jpg" alt="Route 66" class="auth-background">
      <div class="auth-overlay">
        <div class="auth-quote">
          <i class="fas fa-quote-left"></i>
          <p>La vie est un voyage, et celui qui voyage vit deux fois.</p>
          <cite>Omar Khayyam</cite>
        </div>
      </div>
    </div>
  </div>
</section> 