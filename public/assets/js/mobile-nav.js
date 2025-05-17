/**
 * Click-jouneY - Script de navigation mobile
 * 
 * Ce script gère le comportement du menu mobile, les animations d'ouverture/fermeture,
 * les dropdowns, et l'interaction avec l'overlay.
 */

document.addEventListener('DOMContentLoaded', function() {
  initMobileNavigation();
});

/**
 * Initialise la navigation mobile et configure les écouteurs d'événements
 */
function initMobileNavigation() {
  const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
  const mobileNav = document.querySelector('.mobile-nav');
  const mobileNavClose = document.querySelector('.mobile-nav-close');
  const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
  const dropdownToggles = document.querySelectorAll('.mobile-nav .dropdown-toggle');
  const menuItems = document.querySelectorAll('.mobile-nav li');
  let isMenuOpen = false;

  // Gestion du bouton toggle du menu
  if (mobileMenuToggle) {
    mobileMenuToggle.addEventListener('click', function(e) {
      e.preventDefault();
      if (!isMenuOpen) {
        openMobileMenu();
      } else {
        closeMobileMenu();
      }
    });
  }

  // Gestion du bouton fermer dans le menu
  if (mobileNavClose) {
    mobileNavClose.addEventListener('click', function(e) {
      e.preventDefault();
      closeMobileMenu();
    });
  }

  // Gestion du clic sur l'overlay
  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener('click', function() {
      closeMobileMenu();
    });
  }

  // Gestion des touches clavier (Escape)
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && isMenuOpen) {
      closeMobileMenu();
    }
  });

  // Gestion des dropdowns dans le menu mobile
  if (dropdownToggles.length > 0) {
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const parent = this.parentElement;
        const dropdownMenu = parent.querySelector('.dropdown-menu');
        
        if (this.classList.contains('active')) {
          this.classList.remove('active');
          slideUp(dropdownMenu);
        } else {
          // Fermer tous les autres dropdowns
          dropdownToggles.forEach(otherToggle => {
            if (otherToggle !== this && otherToggle.classList.contains('active')) {
              otherToggle.classList.remove('active');
              slideUp(otherToggle.parentElement.querySelector('.dropdown-menu'));
            }
          });
          
          this.classList.add('active');
          slideDown(dropdownMenu);
        }
      });
    });
  }

  /**
   * Ouvre le menu mobile avec animation
   */
  function openMobileMenu() {
    if (isMenuOpen) return;
    
    isMenuOpen = true;
    mobileMenuToggle.classList.add('active');
    mobileNav.classList.add('active');
    mobileMenuOverlay.classList.add('active');
    document.body.classList.add('no-scroll');
    
    // Animation des éléments de menu
    menuItems.forEach((item, index) => {
      setTimeout(() => {
        item.classList.add('animate-in');
      }, 100 + (index * 50)); // Délai progressif pour chaque élément
    });
  }

  /**
   * Ferme le menu mobile avec animation
   */
  function closeMobileMenu() {
    if (!isMenuOpen) return;
    
    isMenuOpen = false;
    mobileMenuToggle.classList.remove('active');
    mobileMenuOverlay.classList.remove('active');
    
    // Réinitialiser les animations des éléments
    menuItems.forEach(item => {
      item.classList.remove('animate-in');
    });
    
    // Fermer tous les dropdowns ouverts
    dropdownToggles.forEach(toggle => {
      if (toggle.classList.contains('active')) {
        toggle.classList.remove('active');
        slideUp(toggle.parentElement.querySelector('.dropdown-menu'));
      }
    });
    
    // Délai avant de fermer le menu pour permettre les animations
    setTimeout(() => {
      mobileNav.classList.remove('active');
      document.body.classList.remove('no-scroll');
    }, 300);
  }
}

/**
 * Animation pour déployer un élément
 * @param {HTMLElement} element - L'élément à déployer
 * @param {number} duration - Durée de l'animation en ms
 */
function slideDown(element, duration = 300) {
  if (!element) return;
  
  // Assurer que l'élément est visible mais sa hauteur est à 0
  element.style.display = 'block';
  element.style.height = 'auto';
  
  const height = element.offsetHeight;
  element.style.height = '0px';
  element.style.overflow = 'hidden';
  element.style.transition = `height ${duration}ms ease`;
  
  // Forcer un reflow
  element.offsetHeight;
  
  // Déployer l'élément
  element.style.height = `${height}px`;
  
  // Nettoyer les styles après l'animation
  setTimeout(() => {
    element.style.height = '';
    element.style.overflow = '';
    element.style.transition = '';
    element.classList.add('show');
  }, duration);
}

/**
 * Animation pour replier un élément
 * @param {HTMLElement} element - L'élément à replier
 * @param {number} duration - Durée de l'animation en ms
 */
function slideUp(element, duration = 300) {
  if (!element) return;
  
  // Préparer l'élément pour l'animation
  element.style.height = `${element.offsetHeight}px`;
  element.style.overflow = 'hidden';
  element.style.transition = `height ${duration}ms ease`;
  
  // Forcer un reflow
  element.offsetHeight;
  
  // Replier l'élément
  element.style.height = '0px';
  
  // Nettoyer les styles et cacher l'élément après l'animation
  setTimeout(() => {
    element.style.display = 'none';
    element.style.height = '';
    element.style.overflow = '';
    element.style.transition = '';
    element.classList.remove('show');
  }, duration);
} 