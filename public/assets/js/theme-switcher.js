// Fonction pour trouver une feuille de style par ID ou sélecteur d'attribut
function findStyleSheet(id) {
  const stylesheetById = document.getElementById(id);
  if (stylesheetById) {
    console.log(`Theme Switcher: Feuille de style ${id} trouvée par ID`);
    return stylesheetById;
  }

  const stylesheetBySelector = document.querySelector(`link[id="${id}"]`);
  if (stylesheetBySelector) {
    console.log(`Theme Switcher: Feuille de style ${id} trouvée par sélecteur`);
    return stylesheetBySelector;
  }

  console.warn(`Theme Switcher: Feuille de style ${id} non trouvée`);
  return null;
}

// Fonction pour obtenir le thème actif
function getActiveTheme() {
  return localStorage.getItem('theme') || 'light';
}

// Fonction pour appliquer le thème
function applyTheme(theme) {
  console.log(`Theme Switcher: Application du thème "${theme}"`);
  
  // Récupérer les feuilles de style des thèmes
  const lightStylesheet = findStyleSheet('theme-light');
  const darkStylesheet = findStyleSheet('theme-dark');
  const accessibleStylesheet = findStyleSheet('theme-accessible');
  
  if (!lightStylesheet || !darkStylesheet || !accessibleStylesheet) {
    console.error('Theme Switcher: Une ou plusieurs feuilles de style sont manquantes');
    return;
  }
  
  // Désactiver toutes les feuilles de style
  lightStylesheet.disabled = true;
  darkStylesheet.disabled = true;
  accessibleStylesheet.disabled = true;
  
  // Activer la feuille de style correspondante au thème
  if (theme === 'dark') {
    darkStylesheet.disabled = false;
    document.documentElement.classList.add('theme-dark');
    document.documentElement.classList.remove('theme-light', 'theme-accessible');
    document.body.classList.add('theme-dark');
    document.body.classList.remove('theme-light', 'theme-accessible');
  } else if (theme === 'accessible') {
    accessibleStylesheet.disabled = false;
    document.documentElement.classList.add('theme-accessible');
    document.documentElement.classList.remove('theme-light', 'theme-dark');
    document.body.classList.add('theme-accessible');
    document.body.classList.remove('theme-light', 'theme-dark');
  } else {
    // Par défaut, on utilise le thème clair
    lightStylesheet.disabled = false;
    document.documentElement.classList.add('theme-light');
    document.documentElement.classList.remove('theme-dark', 'theme-accessible');
    document.body.classList.add('theme-light');
    document.body.classList.remove('theme-dark', 'theme-accessible');
  }
  
  // Mettre à jour l'icône du bouton
  updateThemeIcon(theme);
  
  // Enregistrer le thème dans le localStorage et dans un cookie
  localStorage.setItem('theme', theme);
  setCookie('theme', theme, 30); // Cookie valide pour 30 jours
  
  console.log(`Theme Switcher: Thème "${theme}" appliqué avec succès`);
}

// Fonction pour mettre à jour l'icône du bouton
function updateThemeIcon(theme) {
  const themeButton = document.getElementById('theme-switcher');
  if (!themeButton) {
    console.warn('Theme Switcher: Bouton de changement de thème non trouvé');
    return;
  }
  
  const iconElement = themeButton.querySelector('i') || themeButton.querySelector('.theme-icon');
  if (!iconElement) {
    console.warn('Theme Switcher: Icône du bouton non trouvée');
    return;
  }
  
  // Supprimer toutes les classes d'icônes
  iconElement.className = '';
  
  // Ajouter la classe d'icône correspondante au thème
  if (theme === 'dark') {
    iconElement.className = 'fas fa-moon';
  } else if (theme === 'accessible') {
    iconElement.className = 'fas fa-universal-access';
  } else {
    iconElement.className = 'fas fa-sun';
  }
}

// Fonction pour passer au thème suivant
function switchToNextTheme() {
  const currentTheme = getActiveTheme();
  let nextTheme;
  
  if (currentTheme === 'light') {
    nextTheme = 'dark';
  } else if (currentTheme === 'dark') {
    nextTheme = 'accessible';
  } else {
    nextTheme = 'light';
  }
  
  applyTheme(nextTheme);
}

// Fonction pour définir un cookie
function setCookie(name, value, days) {
  const date = new Date();
  date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
  const expires = `expires=${date.toUTCString()}`;
  document.cookie = `${name}=${value};${expires};path=/;SameSite=Strict`;
}

// Fonction pour récupérer un cookie
function getCookie(name) {
  const nameEQ = `${name}=`;
  const ca = document.cookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) === ' ') c = c.substring(1);
    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length);
  }
  return null;
}

// Validation des formulaires
function setupFormValidation() {
  const forms = document.querySelectorAll('form[data-validate="true"], #login-form, #register-form');
  
  forms.forEach(form => {
    console.log(`Form Validation: Configuration du formulaire #${form.id || 'sans-id'}`);
    
    // Ajouter une classe pour identifier les formulaires validés
    form.classList.add('validated-form');
    
    // Configurer la validation au moment de la soumission
    form.addEventListener('submit', function(e) {
      if (!validateForm(form)) {
        e.preventDefault();
        console.log('Form Validation: Formulaire invalide, soumission bloquée');
      } else {
        console.log('Form Validation: Formulaire valide, soumission autorisée');
      }
    });
    
    // Valider les champs à la perte de focus
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
      input.addEventListener('blur', function() {
        validateInput(input);
      });
      
      // Pour les champs de mot de passe, ajouter un vérificateur de force
      if (input.type === 'password' && !input.id.includes('confirm')) {
        setupPasswordStrengthChecker(input);
      }
      
      // Pour les champs de confirmation de mot de passe
      if (input.id.includes('confirm_password')) {
        const passwordInput = form.querySelector('input[type="password"]:not([id*="confirm"])');
        if (passwordInput) {
          input.dataset.equalTo = passwordInput.id;
        }
      }
    });
  });
  
  // Configuration des toggles de visibilité de mot de passe
  setupPasswordToggles();
  
  // Configuration des compteurs de caractères
  setupCharacterCounters();
}

// Fonction pour valider un formulaire complet
function validateForm(form) {
  let isValid = true;
  const inputs = form.querySelectorAll('input, textarea, select');
  
  inputs.forEach(input => {
    if (!validateInput(input)) {
      isValid = false;
    }
  });
  
  return isValid;
}

// Fonction pour valider un champ individuel
function validateInput(input) {
  // Ignorer les champs désactivés ou en lecture seule
  if (input.disabled || input.readOnly) return true;
  
  let isValid = true;
  const errorContainer = input.parentElement.querySelector('.error-message') || 
                        document.createElement('div');
  
  // S'assurer que le conteneur d'erreur est configuré correctement
  if (!input.parentElement.querySelector('.error-message')) {
    errorContainer.className = 'error-message';
    input.parentElement.appendChild(errorContainer);
  }
  
  // Réinitialiser les messages d'erreur
  errorContainer.textContent = '';
  input.classList.remove('is-invalid');
  
  // Validation required
  if (input.required && !input.value.trim()) {
    isValid = false;
    errorContainer.textContent = 'Ce champ est requis';
  }
  
  // Validation email
  else if (input.type === 'email' && input.value.trim() && !validateEmail(input.value)) {
    isValid = false;
    errorContainer.textContent = 'Veuillez entrer une adresse email valide';
  }
  
  // Validation des mots de passe
  else if (input.type === 'password' && !input.id.includes('confirm') && input.value.trim()) {
    const strength = checkPasswordStrength(input.value);
    if (strength === 'weak') {
      isValid = false;
      errorContainer.textContent = 'Le mot de passe est trop faible';
    }
  }
  
  // Validation de confirmation de mot de passe
  else if (input.dataset.equalTo) {
    const targetInput = document.getElementById(input.dataset.equalTo);
    if (targetInput && input.value !== targetInput.value) {
      isValid = false;
      errorContainer.textContent = 'Les mots de passe ne correspondent pas';
    }
  }
  
  // Validation de longueur minimale
  else if (input.minLength && input.value.length < input.minLength && input.value.trim()) {
    isValid = false;
    errorContainer.textContent = `Minimum ${input.minLength} caractères requis`;
  }
  
  // Validation de longueur maximale
  else if (input.maxLength && input.value.length > input.maxLength) {
    isValid = false;
    errorContainer.textContent = `Maximum ${input.maxLength} caractères autorisés`;
  }
  
  // Validation des données max-length définies en attribut data
  else if (input.dataset.maxLength && input.value.length > parseInt(input.dataset.maxLength)) {
    isValid = false;
    errorContainer.textContent = `Maximum ${input.dataset.maxLength} caractères autorisés`;
  }
  
  // Afficher/cacher l'erreur en fonction de la validité
  if (!isValid) {
    input.classList.add('is-invalid');
    errorContainer.style.display = 'block';
  } else {
    errorContainer.style.display = 'none';
  }
  
  return isValid;
}

// Fonction pour valider une adresse email
function validateEmail(email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

// Vérifier la force d'un mot de passe
function checkPasswordStrength(password) {
  let strength = 0;
  
  // Longueur minimale
  if (password.length >= 8) strength += 1;
  
  // Contient des lettres minuscules
  if (/[a-z]/.test(password)) strength += 1;
  
  // Contient des lettres majuscules
  if (/[A-Z]/.test(password)) strength += 1;
  
  // Contient des chiffres
  if (/[0-9]/.test(password)) strength += 1;
  
  // Contient des caractères spéciaux
  if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
  
  // Évaluer la force
  if (strength < 3) return 'weak';
  if (strength < 4) return 'medium';
  if (strength < 5) return 'good';
  return 'strong';
}

// Configurer l'indicateur de force de mot de passe
function setupPasswordStrengthChecker(input) {
  // Créer les éléments pour l'indicateur de force
  const strengthContainer = document.createElement('div');
  strengthContainer.className = 'password-strength';
  
  const strengthMeter = document.createElement('div');
  strengthMeter.className = 'password-strength-meter';
  
  const strengthText = document.createElement('div');
  strengthText.className = 'password-strength-text';
  
  // Ajouter les éléments au DOM
  strengthContainer.appendChild(strengthMeter);
  input.parentElement.appendChild(strengthContainer);
  input.parentElement.appendChild(strengthText);
  
  // Ajouter un écouteur d'événement pour mettre à jour l'indicateur
  input.addEventListener('input', function() {
    updatePasswordStrength(input, strengthContainer, strengthMeter, strengthText);
  });
}

// Mettre à jour l'indicateur de force de mot de passe
function updatePasswordStrength(input, container, meter, text) {
  const password = input.value;
  
  if (!password) {
    container.className = 'password-strength';
    meter.style.width = '0';
    text.textContent = '';
    return;
  }
  
  const strength = checkPasswordStrength(password);
  
  // Mettre à jour l'affichage
  container.className = `password-strength strength-${strength}`;
  
  // Définir le texte
  switch (strength) {
    case 'weak':
      text.textContent = 'Faible';
      text.style.color = 'var(--danger)';
      break;
    case 'medium':
      text.textContent = 'Moyen';
      text.style.color = 'var(--warning)';
      break;
    case 'good':
      text.textContent = 'Bon';
      text.style.color = 'var(--info)';
      break;
    case 'strong':
      text.textContent = 'Fort';
      text.style.color = 'var(--success)';
      break;
  }
}

// Configurer les toggles de visibilité des mots de passe
function setupPasswordToggles() {
  const passwordInputs = document.querySelectorAll('input[type="password"]');
  
  passwordInputs.forEach(input => {
    // Vérifier si le toggle existe déjà
    if (input.parentElement.querySelector('.password-toggle-btn')) return;
    
    const toggleButton = document.createElement('button');
    toggleButton.type = 'button';
    toggleButton.className = 'password-toggle-btn';
    toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
    toggleButton.title = 'Afficher/masquer le mot de passe';
    
    input.parentElement.appendChild(toggleButton);
    
    toggleButton.addEventListener('click', function() {
      if (input.type === 'password') {
        input.type = 'text';
        toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        input.type = 'password';
        toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
      }
    });
  });
}

// Configurer les compteurs de caractères
function setupCharacterCounters() {
  const inputs = document.querySelectorAll('input[data-max-length], textarea[data-max-length]');
  
  inputs.forEach(input => {
    const maxLength = input.dataset.maxLength;
    
    // Vérifier si le compteur existe déjà
    if (input.parentElement.parentElement.querySelector('.character-counter')) return;
    
    const counter = document.createElement('div');
    counter.className = 'character-counter';
    counter.textContent = `0/${maxLength}`;
    
    input.parentElement.parentElement.appendChild(counter);
    
    input.addEventListener('input', function() {
      const currentLength = this.value.length;
      counter.textContent = `${currentLength}/${maxLength}`;
      
      if (currentLength > maxLength) {
        counter.style.color = 'var(--danger)';
      } else if (currentLength >= maxLength * 0.8) {
        counter.style.color = 'var(--warning)';
      } else {
        counter.style.color = 'var(--gray-500)';
      }
    });
    
    // Déclencher l'événement pour initialiser le compteur
    const event = new Event('input');
    input.dispatchEvent(event);
  });
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
  console.log('Theme Switcher: Initialisation...');
  
  // Récupérer le thème enregistré, d'abord depuis le cookie, puis depuis localStorage
  let savedTheme = getCookie('theme') || localStorage.getItem('theme') || 'light';
  console.log(`Theme Switcher: Thème enregistré: ${savedTheme}`);
  
  // Appliquer le thème enregistré
  applyTheme(savedTheme);
  
  // Configurer le bouton de changement de thème
  const themeButton = document.getElementById('theme-switcher');
  if (themeButton) {
    console.log('Theme Switcher: Bouton de changement de thème trouvé');
    themeButton.addEventListener('click', function(e) {
      console.log('Theme Switcher: CLICK DÉTECTÉ - Bouton cliqué');
      switchToNextTheme();
    });
  } else {
    console.warn('Theme Switcher: Bouton de changement de thème non trouvé');
  }
  
  // Initialiser la validation des formulaires
  setupFormValidation();
});