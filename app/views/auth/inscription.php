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
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const elements = document.querySelectorAll('.auth-form-container, .auth-image');
      elements.forEach(el => el.classList.add('fade-in'));
      
      // Animation des avantages
      const benefits = document.querySelectorAll('.benefit-item');
      benefits.forEach((benefit, index) => {
        setTimeout(() => {
          benefit.classList.add('slide-in');
        }, 300 + index * 200);
      });
      
      // Ajouter les boutons pour afficher/masquer les mots de passe
      const passwordInputs = document.querySelectorAll('input[type="password"]');
      passwordInputs.forEach(input => {
        const toggleButton = document.createElement('button');
        toggleButton.type = 'button';
        toggleButton.className = 'password-toggle-btn';
        toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
        toggleButton.title = 'Afficher le mot de passe';
        input.parentElement.appendChild(toggleButton);
        
        toggleButton.addEventListener('click', function() {
          if (input.type === 'password') {
            input.type = 'text';
            toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            toggleButton.title = 'Masquer le mot de passe';
          } else {
            input.type = 'password';
            toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
            toggleButton.title = 'Afficher le mot de passe';
          }
        });
      });
      
      // Ajouter les compteurs de caractères
      document.getElementById('login').dataset.maxLength = '30';
      document.getElementById('email').dataset.maxLength = '100';
      
      const inputsWithCount = document.querySelectorAll('input[data-max-length]');
      inputsWithCount.forEach(input => {
        const maxLength = input.dataset.maxLength;
        const counter = document.createElement('div');
        counter.className = 'character-counter';
        counter.textContent = `0/${maxLength}`;
        input.parentElement.parentElement.appendChild(counter);
        
        input.addEventListener('input', function() {
          const currentLength = this.value.length;
          counter.textContent = `${currentLength}/${maxLength}`;
          
          if (currentLength >= maxLength) {
            counter.style.color = 'var(--danger)';
          } else if (currentLength >= maxLength * 0.8) {
            counter.style.color = 'var(--warning)';
          } else {
            counter.style.color = 'var(--gray-500)';
          }
        });
      });
    });
  </script>
</section>

<style>
  .auth-section {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
    background-color: #f8f9fa;
    padding: 2rem;
  }
  
  .auth-container {
    width: 100%;
    max-width: 1200px;
    display: flex;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    background-color: #fff;
  }
  
  .auth-form-container {
    flex: 1;
    padding: 3rem;
    max-width: 600px;
  }
  
  .auth-image {
    flex: 1;
    position: relative;
    display: block;
    min-height: 100%;
  }
  
  .auth-logo {
    width: 150px;
    display: block;
    margin: 0 auto 1.5rem;
  }
  
  .auth-header {
    text-align: center;
    margin-bottom: 2rem;
  }
  
  .auth-header h2 {
    font-size: 2.2rem;
    color: #2a6de1;
    margin-bottom: 0.5rem;
    font-weight: 700;
  }
  
  .auth-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
  }
  
  .form-group {
    margin-bottom: 1.5rem;
  }
  
  .form-row {
    display: flex;
    gap: 1.5rem;
  }
  
  .form-row .form-group {
    flex: 1;
  }
  
  .input-with-icon {
    position: relative;
  }
  
  .input-with-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
  }
  
  .textarea-icon i {
    top: 25px;
    transform: none;
  }
  
  .input-with-icon input,
  .input-with-icon textarea {
    padding: 15px 15px 15px 45px;
    width: 100%;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
  }
  
  .input-with-icon textarea {
    min-height: 120px;
    resize: vertical;
    padding-top: 40px;
  }
  
  .input-with-icon input:focus,
  .input-with-icon textarea:focus {
    border-color: #2a6de1;
    box-shadow: 0 0 0 3px rgba(42, 109, 225, 0.1);
    outline: none;
  }
  
  .checkbox-group {
    display: flex;
    align-items: center;
  }
  
  .checkbox-group input[type="checkbox"] {
    margin-right: 10px;
    width: 18px;
    height: 18px;
    accent-color: #2a6de1;
  }
  
  .checkbox-group label {
    font-size: 0.95rem;
    color: #495057;
  }
  
  .checkbox-group a {
    color: #2a6de1;
    text-decoration: none;
    transition: all 0.3s ease;
  }
  
  .checkbox-group a:hover {
    text-decoration: underline;
  }
  
  .required {
    color: #dc3545;
    margin-left: 4px;
  }
  
  .form-hint {
    display: block;
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.5rem;
  }
  
  .btn-primary {
    background-color: #2a6de1;
    border: none;
    color: white;
    padding: 15px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    cursor: pointer;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .btn-primary:hover {
    background-color: #1c5ac4;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(42, 109, 225, 0.2);
  }
  
  .btn-primary i {
    margin-right: 10px;
  }
  
  .auth-footer {
    margin-top: 2.5rem;
    text-align: center;
  }
  
  .auth-footer p {
    color: #6c757d;
    font-size: 1rem;
  }
  
  .auth-footer a {
    color: #2a6de1;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
  }
  
  .auth-footer a:hover {
    text-decoration: underline;
  }
  
  .auth-divider {
    position: relative;
    text-align: center;
    margin: 1.5rem 0;
  }
  
  .auth-divider:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background-color: #dee2e6;
    z-index: 1;
  }
  
  .auth-divider span {
    position: relative;
    background: white;
    padding: 0 15px;
    z-index: 2;
    color: #6c757d;
  }
  
  .social-auth {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1.5rem;
  }
  
  .social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #f8f9fa;
    color: #495057;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
  }
  
  .social-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  
  .social-btn:nth-child(1):hover {
    background-color: #DB4437;
    color: white;
  }
  
  .social-btn:nth-child(2):hover {
    background-color: #4267B2;
    color: white;
  }
  
  .social-btn:nth-child(3):hover {
    background-color: #000000;
    color: white;
  }
  
  .auth-background {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
  }
  
  .auth-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(rgba(33, 37, 41, 0.7), rgba(33, 37, 41, 0.9));
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 3rem;
  }
  
  .auth-quote {
    text-align: center;
    color: white;
    margin-bottom: 3rem;
  }
  
  .auth-quote i {
    font-size: 2.5rem;
    color: #2a6de1;
    margin-bottom: 1.5rem;
    display: block;
  }
  
  .auth-quote p {
    font-size: 1.5rem;
    font-style: italic;
    line-height: 1.6;
    margin-bottom: 1rem;
  }
  
  .auth-benefits {
    width: 100%;
  }
  
  .auth-benefits h3 {
    color: white;
    font-size: 1.5rem;
    margin-bottom: 2rem;
    position: relative;
    text-align: center;
  }
  
  .auth-benefits h3:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background-color: #2a6de1;
  }
  
  .benefits-list {
    list-style: none;
    padding: 0;
  }
  
  .benefit-item {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    color: white;
    opacity: 0;
    transform: translateX(-20px);
    transition: all 0.5s ease;
  }
  
  .benefit-item i {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: rgba(42, 109, 225, 0.2);
    color: #2a6de1;
    border-radius: 50%;
    margin-right: 1rem;
    flex-shrink: 0;
  }
  
  .benefit-item span {
    font-size: 1.1rem;
  }
  
  .slide-in {
    opacity: 1;
    transform: translateX(0);
  }
  
  .fade-in {
    animation: fadeIn 0.8s ease forwards;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  .password-toggle-btn {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    font-size: 1rem;
    padding: 0;
    transition: color 0.3s ease;
  }
  
  .password-toggle-btn:hover {
    color: #2a6de1;
  }
  
  .character-counter {
    text-align: right;
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.5rem;
  }
  
  @media (max-width: 992px) {
    .auth-container {
      flex-direction: column;
    }
    
    .auth-form-container {
      max-width: 100%;
    }
    
    .auth-image {
      display: none;
    }
    
    .form-row {
      flex-direction: column;
      gap: 0;
    }
  }
</style> 