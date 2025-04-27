/**
 * Route 66 Odyssey - Script principal
 */

document.addEventListener('DOMContentLoaded', () => {
  // Animations de défilement doux pour les ancres
  initSmoothScroll();
  
  // Initialisation des sélecteurs d'options pour les voyages
  initOptionSelectors();
  
  // Gestion des formulaires avec validation
  initFormValidation();
  
  // Animation du header lors du défilement
  initHeaderScroll();
});

/**
 * Initialise le défilement doux pour les liens d'ancrage
 */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;
      
      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 80,
          behavior: 'smooth'
        });
      }
    });
  });
}

/**
 * Initialise les sélecteurs d'options pour les voyages
 */
function initOptionSelectors() {
  const optionCards = document.querySelectorAll('.option-card');
  
  optionCards.forEach(card => {
    card.addEventListener('click', function() {
      // Désélectionner toutes les options du même groupe
      const optionGroup = this.closest('.option-group');
      const optionType = this.dataset.optionType;
      
      if (optionGroup) {
        optionGroup.querySelectorAll(`.option-card[data-option-type="${optionType}"]`).forEach(otherCard => {
          otherCard.classList.remove('selected');
        });
      }
      
      // Sélectionner cette option
      this.classList.add('selected');
      
      // Mettre à jour le champ caché avec l'ID de l'option
      const optionId = this.dataset.optionId;
      const stepId = this.closest('.step').dataset.stepId;
      
      if (optionId && stepId) {
        const hiddenInput = document.querySelector(`input[name="options[${stepId}][${optionType}]"]`);
        if (hiddenInput) {
          hiddenInput.value = optionId;
        }
      }
      
      // Mettre à jour le prix si nécessaire
      updateTotalPrice();
    });
  });
}

/**
 * Met à jour le prix total en fonction des options sélectionnées
 */
function updateTotalPrice() {
  const priceElement = document.getElementById('total-price');
  if (!priceElement) return;
  
  // Prix de base
  let basePrice = parseFloat(priceElement.dataset.basePrice || 0);
  
  // Ajouter le prix des options sélectionnées
  document.querySelectorAll('.option-card.selected').forEach(selectedOption => {
    const optionPrice = parseFloat(selectedOption.dataset.price || 0);
    basePrice += optionPrice;
  });
  
  // Mettre à jour l'affichage
  priceElement.textContent = formatPrice(basePrice);
}

/**
 * Formatage du prix
 */
function formatPrice(price) {
  return price.toFixed(2).replace('.', ',') + ' €';
}

/**
 * Initialise la validation des formulaires
 */
function initFormValidation() {
  const forms = document.querySelectorAll('form[data-validate="true"]');
  
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      let isValid = true;
      
      // Validation des champs requis
      this.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          // Ajouter une classe d'erreur
          field.classList.add('error');
          
          // Trouver ou créer un message d'erreur
          let errorMsg = field.nextElementSibling;
          if (!errorMsg || !errorMsg.classList.contains('error-message')) {
            errorMsg = document.createElement('small');
            errorMsg.classList.add('error-message');
            field.parentNode.insertBefore(errorMsg, field.nextSibling);
          }
          
          errorMsg.textContent = 'Ce champ est requis';
        } else {
          field.classList.remove('error');
          // Supprimer le message d'erreur s'il existe
          const errorMsg = field.nextElementSibling;
          if (errorMsg && errorMsg.classList.contains('error-message')) {
            errorMsg.remove();
          }
        }
      });
      
      // Validation email
      const emailField = this.querySelector('input[type="email"]');
      if (emailField && emailField.value.trim()) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value.trim())) {
          isValid = false;
          emailField.classList.add('error');
          
          let errorMsg = emailField.nextElementSibling;
          if (!errorMsg || !errorMsg.classList.contains('error-message')) {
            errorMsg = document.createElement('small');
            errorMsg.classList.add('error-message');
            emailField.parentNode.insertBefore(errorMsg, emailField.nextSibling);
          }
          
          errorMsg.textContent = 'Veuillez entrer une adresse email valide';
        }
      }
      
      // Validation des mots de passe
      const passwordField = this.querySelector('input[name="password"]');
      const confirmField = this.querySelector('input[name="confirm_password"]');
      
      if (passwordField && confirmField && passwordField.value.trim() && confirmField.value.trim()) {
        if (passwordField.value !== confirmField.value) {
          isValid = false;
          confirmField.classList.add('error');
          
          let errorMsg = confirmField.nextElementSibling;
          if (!errorMsg || !errorMsg.classList.contains('error-message')) {
            errorMsg = document.createElement('small');
            errorMsg.classList.add('error-message');
            confirmField.parentNode.insertBefore(errorMsg, confirmField.nextSibling);
          }
          
          errorMsg.textContent = 'Les mots de passe ne correspondent pas';
        }
      }
      
      if (!isValid) {
        e.preventDefault();
      }
    });
    
    // Suppression des classes d'erreur lors de la saisie
    form.querySelectorAll('input, select, textarea').forEach(field => {
      field.addEventListener('input', function() {
        this.classList.remove('error');
        const errorMsg = this.nextElementSibling;
        if (errorMsg && errorMsg.classList.contains('error-message')) {
          errorMsg.remove();
        }
      });
    });
  });
}

/**
 * Initialise les effets de défilement pour le header
 */
function initHeaderScroll() {
  const header = document.querySelector('header');
  if (!header) return;
  
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
}

/**
 * Click-jouneY - Script principal
 */

document.addEventListener('DOMContentLoaded', function() {
    // Toggle du menu mobile
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const navContainer = document.querySelector('.nav-container');
    const overlay = document.querySelector('.overlay');
    const userMenuBtn = document.querySelector('.user-menu-button');
    const userDropdown = document.querySelector('.user-dropdown');
    
    if (menuToggle && navContainer && overlay) {
        menuToggle.addEventListener('click', function() {
            menuToggle.classList.toggle('active');
            navContainer.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.classList.toggle('no-scroll');
        });
        
        overlay.addEventListener('click', function() {
            menuToggle.classList.remove('active');
            navContainer.classList.remove('active');
            overlay.classList.remove('active');
            document.body.classList.remove('no-scroll');
        });
    }
    
    // Gestion du dropdown utilisateur
    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', function() {
            userDropdown.classList.toggle('active');
            userMenuBtn.setAttribute('aria-expanded', 
                userMenuBtn.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
            );
        });
        
        document.addEventListener('click', function(event) {
            if (!userMenuBtn.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.remove('active');
                userMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }
    
    // Fermeture des alertes
    const closeButtons = document.querySelectorAll('.close-btn');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.alert').remove();
        });
    });
    
    // Animations au défilement
    const animatedElements = document.querySelectorAll('.fade-in, .slide-in');
    
    if (animatedElements.length > 0) {
        // Vérifier si un élément est visible dans la fenêtre
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }
        
        // Appliquer les animations aux éléments visibles
        function handleScrollAnimations() {
            animatedElements.forEach(element => {
                if (isElementInViewport(element)) {
                    element.classList.add('visible');
                }
            });
        }
        
        // Vérifier au chargement et au défilement
        handleScrollAnimations();
        window.addEventListener('scroll', handleScrollAnimations);
    }
    
    // Gestion des formulaires de recherche avancée
    const advancedSearchToggle = document.querySelector('.advanced-search-toggle');
    const advancedSearchForm = document.querySelector('.advanced-search-options');
    
    if (advancedSearchToggle && advancedSearchForm) {
        advancedSearchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            advancedSearchForm.classList.toggle('show');
            
            // Changer le texte du bouton
            const btnText = advancedSearchToggle.querySelector('span');
            if (btnText) {
                btnText.textContent = advancedSearchForm.classList.contains('show') 
                    ? 'Masquer les options' 
                    : 'Options avancées';
            }
            
            // Changer l'icône
            const btnIcon = advancedSearchToggle.querySelector('i');
            if (btnIcon) {
                btnIcon.className = advancedSearchForm.classList.contains('show')
                    ? 'fas fa-chevron-up'
                    : 'fas fa-chevron-down';
            }
        });
    }
    
    // Initialisation du menu mobile
    initMobileMenu();
});

/**
 * Initialisation du menu mobile
 */
function initMobileMenu() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navbarNav = document.querySelector('.navbar-nav, .nav-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const body = document.body;
    
    if (!mobileMenuToggle || !navbarNav || !mobileMenuOverlay) return;
    
    mobileMenuToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        navbarNav.classList.toggle('active');
        mobileMenuOverlay.classList.toggle('active');
        body.classList.toggle('no-scroll');
    });
    
    // Fermer le menu lorsqu'on clique sur l'overlay
    mobileMenuOverlay.addEventListener('click', function() {
        mobileMenuToggle.classList.remove('active');
        navbarNav.classList.remove('active');
        mobileMenuOverlay.classList.remove('active');
        body.classList.remove('no-scroll');
    });
    
    // Fermer le menu lorsqu'on clique sur un lien du menu
    const navLinks = navbarNav.querySelectorAll('a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenuToggle.classList.remove('active');
            navbarNav.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            body.classList.remove('no-scroll');
        });
    });
} 