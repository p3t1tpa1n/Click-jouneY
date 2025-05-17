/**
 * Tri dynamique des résultats de recherche de voyages
 * 
 * Ce fichier gère le tri des résultats de recherche de voyages sans rechargement de page
 * - Tri par prix (croissant/décroissant)
 * - Tri par durée (croissant/décroissant)
 * - Tri par popularité
 * - Tri par date
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialiser le tri des voyages s'il y a une grille de voyages sur la page
    if (document.querySelector('.trips-grid')) {
        initTripSorting();
    }
});

/**
 * Initialise le tri des voyages
 */
function initTripSorting() {
    const sortSelect = document.getElementById('sort-results');
    if (!sortSelect) return;
    
    // Appliquer le tri au changement de la sélection
    sortSelect.addEventListener('change', function() {
        sortTrips(this.value);
    });
    
    // Tri initial
    sortTrips(sortSelect.value);
}

/**
 * Trie les voyages selon le critère spécifié
 * @param {string} criterion - Critère de tri (price-asc, price-desc, duration-asc, duration-desc, popularity, date)
 */
function sortTrips(criterion) {
    const tripsGrid = document.querySelector('.trips-grid');
    if (!tripsGrid) return;
    
    // Récupérer tous les éléments de voyage
    const tripCards = Array.from(tripsGrid.querySelectorAll('.trip-card'));
    
    // Trier les éléments selon le critère
    tripCards.sort((a, b) => {
        switch (criterion) {
            case 'price-asc':
                return compareValues(a, b, 'data-price', true);
            case 'price-desc':
                return compareValues(a, b, 'data-price', false);
            case 'duration-asc':
                return compareValues(a, b, 'data-duration', true);
            case 'duration-desc':
                return compareValues(a, b, 'data-duration', false);
            case 'popularity':
                return compareValues(a, b, 'data-popularity', false);
            case 'date-asc':
                return compareValues(a, b, 'data-date', true);
            case 'date-desc':
                return compareValues(a, b, 'data-date', false);
            default:
                return 0;
        }
    });
    
    // Appliquer une animation de tri
    animateSorting(tripsGrid, tripCards);
}

/**
 * Compare les valeurs de deux éléments pour le tri
 * @param {HTMLElement} a - Premier élément
 * @param {HTMLElement} b - Deuxième élément
 * @param {string} attribute - Attribut de données à comparer
 * @param {boolean} ascending - Ordre croissant (true) ou décroissant (false)
 * @returns {number} - Résultat de la comparaison (-1, 0 ou 1)
 */
function compareValues(a, b, attribute, ascending) {
    // Récupérer les valeurs des attributs de données
    let valueA = parseFloat(a.getAttribute(attribute)) || 0;
    let valueB = parseFloat(b.getAttribute(attribute)) || 0;
    
    // Gérer les valeurs de date spéciales
    if (attribute === 'data-date') {
        valueA = new Date(a.getAttribute(attribute) || Date.now()).getTime();
        valueB = new Date(b.getAttribute(attribute) || Date.now()).getTime();
    }
    
    // Comparer dans l'ordre approprié
    return ascending ? valueA - valueB : valueB - valueA;
}

/**
 * Anime le réarrangement des éléments de voyage
 * @param {HTMLElement} tripsGrid - Conteneur des voyages
 * @param {Array} sortedTrips - Tableau des voyages triés
 */
function animateSorting(tripsGrid, sortedTrips) {
    // Sauvegarder les positions originales
    const originalPositions = sortedTrips.map(card => {
        const rect = card.getBoundingClientRect();
        return {
            left: rect.left,
            top: rect.top
        };
    });
    
    // Vider la grille
    tripsGrid.innerHTML = '';
    
    // Ajouter une classe d'animation à la grille
    tripsGrid.classList.add('sorting');
    
    // Réinsérer les éléments triés
    sortedTrips.forEach((card, index) => {
        // Ajouter une animation pour le déplacement
        card.style.transition = 'transform 0.4s ease, opacity 0.3s ease';
        card.style.opacity = '0';
        tripsGrid.appendChild(card);
        
        // Animation d'apparition progressive
        setTimeout(() => {
            card.style.opacity = '1';
        }, 50 * index);
    });
    
    // Supprimer la classe d'animation après la fin
    setTimeout(() => {
        tripsGrid.classList.remove('sorting');
        sortedTrips.forEach(card => {
            card.style.transition = '';
        });
    }, 500);
}

/**
 * Ajoute des filtres supplémentaires à l'interface
 * Cette fonction est prévue pour une extension future
 */
function addExtraFilters() {
    const sortContainer = document.querySelector('.results-sort');
    if (!sortContainer) return;
    
    // Créer des boutons de filtre rapide
    const filterButtons = document.createElement('div');
    filterButtons.className = 'quick-filters';
    filterButtons.innerHTML = `
        <span class="quick-filter-label">Filtres rapides :</span>
        <button type="button" class="btn btn-sm btn-outline-secondary quick-filter" data-filter="all">Tous</button>
        <button type="button" class="btn btn-sm btn-outline-secondary quick-filter" data-filter="short">Courts séjours</button>
        <button type="button" class="btn btn-sm btn-outline-secondary quick-filter" data-filter="long">Longs séjours</button>
        <button type="button" class="btn btn-sm btn-outline-secondary quick-filter" data-filter="promo">En promotion</button>
    `;
    
    // Ajouter avant ou après le sélecteur de tri
    const resultsHeader = document.querySelector('.search-results-header');
    if (resultsHeader) {
        resultsHeader.after(filterButtons);
    } else {
        sortContainer.after(filterButtons);
    }
    
    // Styles pour les filtres rapides
    filterButtons.style.display = 'flex';
    filterButtons.style.alignItems = 'center';
    filterButtons.style.gap = '10px';
    filterButtons.style.marginTop = '15px';
    filterButtons.style.marginBottom = '15px';
    
    // Gestionnaire de clic pour les filtres rapides
    const quickFilters = document.querySelectorAll('.quick-filter');
    quickFilters.forEach(button => {
        button.addEventListener('click', function() {
            // Supprimer la classe active de tous les boutons
            quickFilters.forEach(btn => btn.classList.remove('active'));
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            // Appliquer le filtre
            applyQuickFilter(this.dataset.filter);
        });
    });
}

/**
 * Applique un filtre rapide aux résultats
 * @param {string} filter - Filtre à appliquer (all, short, long, promo)
 */
function applyQuickFilter(filter) {
    const tripCards = document.querySelectorAll('.trip-card');
    
    tripCards.forEach(card => {
        card.style.display = 'block'; // Réinitialiser
        
        switch (filter) {
            case 'short':
                if (parseInt(card.dataset.duration) > 7) {
                    card.style.display = 'none';
                }
                break;
            case 'long':
                if (parseInt(card.dataset.duration) <= 7) {
                    card.style.display = 'none';
                }
                break;
            case 'promo':
                if (!card.classList.contains('on-sale')) {
                    card.style.display = 'none';
                }
                break;
            default: // 'all'
                // Afficher tous les voyages
                break;
        }
    });
} 