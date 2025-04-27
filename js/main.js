/**
 * Route 66 Odyssey - Script principal
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les fonctions
    initSmoothScroll();
    initOptionSelectors();
    initFormValidation();
    initHeaderScroll();
    initAnimations();
    initCardHoverEffects();
    initLazyLoading();
    initSearchTabs();
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
      
      // Ajouter une animation de sélection
      this.animate([
        { transform: 'scale(0.95)', boxShadow: '0 0 0 3px var(--primary-light)' },
        { transform: 'scale(1)', boxShadow: '0 0 0 3px var(--primary)' }
      ], {
        duration: 300,
        easing: 'ease-out'
      });
      
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
  
  // Animation du changement de prix
  const oldPrice = parseFloat(priceElement.textContent.replace(/[^\d,.-]/g, '').replace(',', '.'));
  if (oldPrice !== basePrice) {
    priceElement.animate([
      { color: 'var(--primary)', transform: 'scale(1.05)' },
      { color: 'inherit', transform: 'scale(1)' }
    ], {
      duration: 500,
      easing: 'ease-out'
    });
  }
  
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
          // Ajouter une classe d'erreur avec animation
          field.classList.add('error');
          field.animate([
            { borderColor: 'var(--danger)', transform: 'translateX(0)' },
            { borderColor: 'var(--danger)', transform: 'translateX(-5px)' },
            { borderColor: 'var(--danger)', transform: 'translateX(5px)' },
            { borderColor: 'var(--danger)', transform: 'translateX(-5px)' },
            { borderColor: 'var(--danger)', transform: 'translateX(0)' }
          ], {
            duration: 400,
            easing: 'ease-in-out'
          });
          
          // Trouver ou créer un message d'erreur
          let errorMsg = field.nextElementSibling;
          if (!errorMsg || !errorMsg.classList.contains('error-message')) {
            errorMsg = document.createElement('small');
            errorMsg.classList.add('error-message');
            field.parentNode.insertBefore(errorMsg, field.nextSibling);
          }
          
          errorMsg.textContent = 'Ce champ est requis';
          // Animation d'apparition du message d'erreur
          errorMsg.style.opacity = '0';
          errorMsg.style.transform = 'translateY(-10px)';
          setTimeout(() => {
            errorMsg.style.transition = 'all 0.3s ease';
            errorMsg.style.opacity = '1';
            errorMsg.style.transform = 'translateY(0)';
          }, 10);
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
 * Initialisation des animations au défilement
 */
function initAnimations() {
  const animatedElements = document.querySelectorAll('.fade-in, .slide-in, .animate-on-scroll, [data-animate]');
  
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
          element.classList.add('visible', 'animated');
          
          // Animations personnalisées basées sur les attributs data
          const animationType = element.dataset.animate;
          if (animationType) {
            switch(animationType) {
              case 'fade-up':
                element.style.animation = 'fadeInUp 0.6s ease forwards';
                break;
              case 'fade-in':
                element.style.animation = 'fadeIn 0.8s ease forwards';
                break;
              case 'slide-right':
                element.style.animation = 'slideInRight 0.5s ease forwards';
                break;
              case 'zoom-in':
                element.style.animation = 'zoomIn 0.7s ease forwards';
                break;
              default:
                element.style.animation = 'fadeIn 0.6s ease forwards';
            }
          }
        }
      });
    }
    
    // Vérifier au chargement et au défilement
    handleScrollAnimations();
    window.addEventListener('scroll', handleScrollAnimations);
  }
}

/**
 * Initialisation des effets de hover sur les cartes
 */
function initCardHoverEffects() {
  const cards = document.querySelectorAll('.card, .trip-card');
  
  cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      const image = card.querySelector('img');
      if (image) {
        image.style.transition = 'transform 0.4s ease';
        image.style.transform = 'scale(1.05)';
      }
      
      card.style.boxShadow = 'var(--shadow-lg)';
    });
    
    card.addEventListener('mouseleave', () => {
      const image = card.querySelector('img');
      if (image) {
        image.style.transform = 'scale(1)';
      }
      
      card.style.boxShadow = 'var(--shadow-md)';
    });
  });
}

/**
 * Lazy loading des images
 */
function initLazyLoading() {
  // Vérifier si l'API IntersectionObserver est disponible
  if ('IntersectionObserver' in window) {
    const lazyImages = document.querySelectorAll('[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          
          // Une fois chargée, ajouter une classe pour une transition en fondu
          img.onload = () => {
            img.classList.add('loaded');
          };
          
          // Ne plus observer cette image
          observer.unobserve(img);
        }
      });
    });
    
    lazyImages.forEach(image => {
      imageObserver.observe(image);
    });
  } else {
    // Fallback pour les navigateurs ne supportant pas IntersectionObserver
    const lazyImages = document.querySelectorAll('[data-src]');
    
    function lazyLoad() {
      lazyImages.forEach(img => {
        if (img.getBoundingClientRect().top <= window.innerHeight && img.getBoundingClientRect().bottom >= 0) {
          img.src = img.dataset.src;
          img.classList.add('loaded');
        }
      });
    }
    
    // Charger les images visibles immédiatement
    lazyLoad();
    // Puis lors du défilement
    window.addEventListener('scroll', lazyLoad);
    window.addEventListener('resize', lazyLoad);
  }
}

/**
 * Initialise les boutons et carrousels dans la section voyage
 */
function initTripButtons() {
  // Gestion du carrousel de voyage
  const carouselButtons = document.querySelectorAll('[data-bs-target="#tripCarousel"]');
  if (carouselButtons.length > 0) {
    carouselButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        const target = this.getAttribute('data-bs-target');
        const slideIndex = parseInt(this.getAttribute('data-bs-slide-to') || 0);
        const carousel = document.querySelector(target);
        
        if (carousel) {
          const slides = carousel.querySelectorAll('.carousel-item');
          
          // Désactiver tous les slides
          slides.forEach(slide => slide.classList.remove('active'));
          
          // Activer le slide cible
          if (slides[slideIndex]) {
            slides[slideIndex].classList.add('active');
          }
          
          // Mettre à jour les indicateurs
          const indicators = carousel.querySelectorAll('.carousel-indicators button');
          indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === slideIndex);
            indicator.setAttribute('aria-current', index === slideIndex ? 'true' : 'false');
          });
        }
      });
    });
    
    // Gestion des contrôles précédent/suivant
    const prevButton = document.querySelector('.carousel-control-prev');
    const nextButton = document.querySelector('.carousel-control-next');
    
    if (prevButton && nextButton) {
      prevButton.addEventListener('click', function(e) {
        e.preventDefault();
        const carousel = document.querySelector('#tripCarousel');
        const slides = carousel.querySelectorAll('.carousel-item');
        let activeIndex = -1;
        
        slides.forEach((slide, index) => {
          if (slide.classList.contains('active')) {
            activeIndex = index;
          }
        });
        
        if (activeIndex > 0) {
          // Aller au slide précédent
          slides.forEach(slide => slide.classList.remove('active'));
          slides[activeIndex - 1].classList.add('active');
          
          // Mettre à jour les indicateurs
          const indicators = carousel.querySelectorAll('.carousel-indicators button');
          indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === activeIndex - 1);
            indicator.setAttribute('aria-current', index === activeIndex - 1 ? 'true' : 'false');
          });
        } else if (activeIndex === 0) {
          // Boucler vers le dernier slide
          slides.forEach(slide => slide.classList.remove('active'));
          slides[slides.length - 1].classList.add('active');
          
          // Mettre à jour les indicateurs
          const indicators = carousel.querySelectorAll('.carousel-indicators button');
          indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === slides.length - 1);
            indicator.setAttribute('aria-current', index === slides.length - 1 ? 'true' : 'false');
          });
        }
      });
      
      nextButton.addEventListener('click', function(e) {
        e.preventDefault();
        const carousel = document.querySelector('#tripCarousel');
        const slides = carousel.querySelectorAll('.carousel-item');
        let activeIndex = -1;
        
        slides.forEach((slide, index) => {
          if (slide.classList.contains('active')) {
            activeIndex = index;
          }
        });
        
        if (activeIndex < slides.length - 1) {
          // Aller au slide suivant
          slides.forEach(slide => slide.classList.remove('active'));
          slides[activeIndex + 1].classList.add('active');
          
          // Mettre à jour les indicateurs
          const indicators = carousel.querySelectorAll('.carousel-indicators button');
          indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === activeIndex + 1);
            indicator.setAttribute('aria-current', index === activeIndex + 1 ? 'true' : 'false');
          });
        } else if (activeIndex === slides.length - 1) {
          // Boucler vers le premier slide
          slides.forEach(slide => slide.classList.remove('active'));
          slides[0].classList.add('active');
          
          // Mettre à jour les indicateurs
          const indicators = carousel.querySelectorAll('.carousel-indicators button');
          indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === 0);
            indicator.setAttribute('aria-current', index === 0 ? 'true' : 'false');
          });
        }
      });
    }
  }
  
  // Gestion des options et cases à cocher du voyage
  const optionCheckboxes = document.querySelectorAll('input[type="checkbox"][name="options[]"]');
  if (optionCheckboxes.length > 0) {
    optionCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        // Ajouter une classe pour l'animation
        const card = this.closest('.card');
        if (card) {
          if (this.checked) {
            card.classList.add('bg-light', 'border-primary');
            card.animate([
              { transform: 'scale(0.98)' },
              { transform: 'scale(1.02)' },
              { transform: 'scale(1)' }
            ], {
              duration: 300,
              easing: 'ease-out'
            });
          } else {
            card.classList.remove('bg-light', 'border-primary');
          }
        }
      });
    });
  }
  
  // Validation du formulaire d'options du voyage
  const tripOptionsForm = document.getElementById('tripOptionsForm');
  if (tripOptionsForm) {
    tripOptionsForm.addEventListener('submit', function(e) {
      // S'assurer que le formulaire soumet aux bons endpoints
      this.action = 'index.php';
      
      // Vérifier si au moins une option est sélectionnée
      const anyOptionSelected = Array.from(this.querySelectorAll('input[name="options[]"]')).some(input => input.checked);
      
      // Validations supplémentaires si nécessaire
      const nbTravelers = parseInt(document.getElementById('nb-travelers').value);
      if (nbTravelers < 1 || isNaN(nbTravelers)) {
        e.preventDefault();
        alert('Veuillez sélectionner au moins 1 voyageur.');
        return false;
      }
      
      return true;
    });
  }
}

/**
 * Initialise les onglets de recherche sur la page des voyages
 */
function initSearchTabs() {
    const simpleTabs = document.getElementById('simple-search-tab');
    const advancedTabs = document.getElementById('advanced-search-tab');
    const simplePanel = document.getElementById('simple-search-panel');
    const advancedPanel = document.getElementById('advanced-search-panel');
    
    if (!simpleTabs || !advancedTabs || !simplePanel || !advancedPanel) return;
    
    // Change d'onglet quand on clique sur l'onglet simple
    simpleTabs.addEventListener('click', function() {
        // Activer cet onglet
        simpleTabs.classList.add('active');
        advancedTabs.classList.remove('active');
        
        // Afficher le panneau correspondant
        simplePanel.classList.add('show', 'active');
        advancedPanel.classList.remove('show', 'active');
    });
    
    // Change d'onglet quand on clique sur l'onglet avancé
    advancedTabs.addEventListener('click', function() {
        // Activer cet onglet
        advancedTabs.classList.add('active');
        simpleTabs.classList.remove('active');
        
        // Afficher le panneau correspondant
        advancedPanel.classList.add('show', 'active');
        simplePanel.classList.remove('show', 'active');
        
        // Synchroniser les champs de recherche
        const simpleQuery = document.getElementById('query-simple');
        const advancedQuery = document.getElementById('query-advanced');
        
        if (simpleQuery && advancedQuery) {
            advancedQuery.value = simpleQuery.value;
        }
    });
    
    // Gérer le tri des résultats
    const sortSelect = document.getElementById('sort-results');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const tripsGrid = document.querySelector('.trips-grid');
            if (!tripsGrid) return;
            
            const tripCards = Array.from(tripsGrid.querySelectorAll('.trip-card'));
            
            tripCards.sort((a, b) => {
                const aPrice = parseFloat(a.dataset.price);
                const bPrice = parseFloat(b.dataset.price);
                const aDuration = parseInt(a.dataset.duration);
                const bDuration = parseInt(b.dataset.duration);
                
                switch (sortSelect.value) {
                    case 'price-asc':
                        return aPrice - bPrice;
                    case 'price-desc':
                        return bPrice - aPrice;
                    case 'duration-asc':
                        return aDuration - bDuration;
                    case 'duration-desc':
                        return bDuration - aDuration;
                    default:
                        return 0;
                }
            });
            
            // Vider la grille et réinsérer les éléments triés
            tripsGrid.innerHTML = '';
            tripCards.forEach(card => tripsGrid.appendChild(card));
        });
    }
}

/**
 * Click-jouneY - Script principal
 */

document.addEventListener('DOMContentLoaded', function() {
    // Gestion du dropdown utilisateur
    const userMenuBtn = document.querySelector('.user-menu-button');
    const userDropdown = document.querySelector('.user-dropdown');
    
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
}); 