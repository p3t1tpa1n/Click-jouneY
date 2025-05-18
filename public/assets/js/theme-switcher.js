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
  // Mettre à jour l'icône du bouton principal
  const themeButton = document.getElementById('theme-switcher');
  if (themeButton) {
    const iconElement = themeButton.querySelector('i') || themeButton.querySelector('.theme-icon');
    if (iconElement) {
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
  }
  
  // Mettre à jour l'icône du bouton mobile
  const mobileThemeButton = document.getElementById('mobile-theme-switcher');
  if (mobileThemeButton) {
    const mobileIconElement = mobileThemeButton.querySelector('i');
    if (mobileIconElement) {
      // Supprimer toutes les classes d'icônes sauf 'me-2'
      mobileIconElement.className = 'me-2';
      
      // Ajouter la classe d'icône correspondante au thème
      if (theme === 'dark') {
        mobileIconElement.className += ' fas fa-moon';
      } else if (theme === 'accessible') {
        mobileIconElement.className += ' fas fa-universal-access';
      } else {
        mobileIconElement.className += ' fas fa-sun';
      }
    }
    
    // Mettre à jour le texte du bouton
    let themeText = 'Changer de thème';
    if (theme === 'light') {
      themeText = 'Mode sombre';
    } else if (theme === 'dark') {
      themeText = 'Mode accessible';
    } else {
      themeText = 'Mode clair';
    }
    
    // Mettre à jour le texte (en gardant l'icône)
    const buttonText = mobileIconElement ? mobileIconElement.nextSibling : null;
    if (buttonText && buttonText.nodeType === 3) { // nodeType 3 = nœud de texte
      buttonText.textContent = ' ' + themeText;
    }
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

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
  console.log('Theme Switcher: Initialisation...');
  
  // Trouver les boutons de changement de thème
  const themeButton = document.getElementById('theme-switcher');
  const mobileThemeButton = document.getElementById('mobile-theme-switcher');
  
  // Récupérer le thème actuel depuis localStorage ou utiliser 'light' par défaut
  const currentTheme = localStorage.getItem('theme') || 'light';
  
  // Trouver toutes les feuilles de style des thèmes
  const lightTheme = findStyleSheet('theme-light');
  const darkTheme = findStyleSheet('theme-dark');
  const accessibleTheme = findStyleSheet('theme-accessible');
  
  console.log('Theme Switcher: Feuilles de style trouvées:', {
    light: lightTheme ? 'OK' : 'NON TROUVÉ',
    dark: darkTheme ? 'OK' : 'NON TROUVÉ',
    accessible: accessibleTheme ? 'OK' : 'NON TROUVÉ'
  });
  
  // Appliquer le thème actuel
  applyTheme(currentTheme);
  
  // Gérer le clic sur le bouton de thème principal
  if (themeButton) {
    themeButton.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Theme Switcher: CLICK DÉTECTÉ - Bouton cliqué');
      switchToNextTheme();
    });
  }
  
  // Gérer le clic sur le bouton de thème mobile
  if (mobileThemeButton) {
    mobileThemeButton.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Theme Switcher: Bouton mobile cliqué');
      switchToNextTheme();
    });
  }
});