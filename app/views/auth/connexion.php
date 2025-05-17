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
            <input type="text" id="login" name="login" required placeholder="Votre identifiant">
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
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const elements = document.querySelectorAll('.auth-form-container, .auth-image');
      elements.forEach(el => el.classList.add('fade-in'));
      
      // Animation des fonctionnalités
      const features = document.querySelectorAll('.feature-item');
      features.forEach((feature, index) => {
        setTimeout(() => {
          feature.classList.add('slide-in');
        }, 300 + index * 200);
      });
      
      // Toggle password visibility
      const togglePasswordBtn = document.querySelector('.password-toggle-btn');
      const passwordInput = document.getElementById('password');
      
      if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener('click', function() {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          togglePasswordBtn.querySelector('i').classList.toggle('fa-eye');
          togglePasswordBtn.querySelector('i').classList.toggle('fa-eye-slash');
        });
      }
    });
  </script>
  
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
      max-width: 550px;
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
      margin-bottom: 2.5rem;
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
    
    .input-with-icon input {
      padding: 15px 15px 15px 45px;
      width: 100%;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    
    .input-with-icon input:focus {
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
    }
    
    .btn-primary:hover {
      background-color: #1c5ac4;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(42, 109, 225, 0.2);
    }
    
    .auth-links {
      text-align: center;
      margin-top: 1.5rem;
    }
    
    .forgot-password {
      color: #2a6de1;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .forgot-password:hover {
      text-decoration: underline;
    }
    
    .auth-footer {
      margin-top: 2.5rem;
      text-align: center;
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
    
    .auth-features {
      width: 100%;
    }
    
    .auth-features h3 {
      color: white;
      font-size: 1.5rem;
      margin-bottom: 2rem;
      position: relative;
      text-align: center;
    }
    
    .auth-features h3:after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 3px;
      background-color: #2a6de1;
    }
    
    .features-list {
      list-style: none;
      padding: 0;
    }
    
    .feature-item {
      display: flex;
      align-items: center;
      margin-bottom: 1.5rem;
      color: white;
      opacity: 0;
      transform: translateX(-20px);
      transition: all 0.5s ease;
    }
    
    .feature-item i {
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
    
    .feature-item span {
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
    }
  </style>
</section> 