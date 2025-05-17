/**
 * Simulation de délai pour la page admin
 * 
 * Ce fichier gère la simulation d'opérations asynchrones dans l'interface d'administration
 * - Désactive temporairement les contrôles pendant les opérations
 * - Simule un délai de traitement
 * - Affiche une animation de chargement
 */

document.addEventListener('DOMContentLoaded', function() {
    // Si nous sommes sur une page d'administration
    if (document.querySelector('.admin-panel')) {
        initAdminDelaySimulation();
    }
});

/**
 * Initialise la simulation de délai sur les éléments interactifs de la page admin
 */
function initAdminDelaySimulation() {
    // Appliquer aux checkboxes de statut d'utilisateur
    setupCheckboxDelay('.user-status-toggle');
    
    // Appliquer aux boutons de suppression
    setupButtonDelay('.delete-btn', 2500);
    
    // Appliquer aux boutons d'action générique
    setupButtonDelay('.action-btn', 1500);
    
    // Appliquer aux sélecteurs de rôle
    setupSelectDelay('.role-selector');
}

/**
 * Configure une simulation de délai pour les checkboxes
 * @param {string} selector - Sélecteur CSS pour les checkboxes
 * @param {number} delay - Délai de simulation en ms (défaut: 2000ms)
 */
function setupCheckboxDelay(selector, delay = 2000) {
    const checkboxes = document.querySelectorAll(selector);
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function(event) {
            // Désactiver la checkbox pendant le traitement
            this.disabled = true;
            
            // Sauvegarder l'état actuel pour la restauration en cas d'échec
            const originalChecked = this.checked;
            
            // Ajouter une classe pour le style visuel de chargement
            this.parentElement.classList.add('processing');
            
            // Créer et afficher l'animation de chargement
            const loadingIndicator = createLoadingIndicator(this.parentElement);
            
            // Simuler une opération asynchrone
            setTimeout(() => {
                // Supprimer l'indicateur de chargement
                if (loadingIndicator && loadingIndicator.parentNode) {
                    loadingIndicator.parentNode.removeChild(loadingIndicator);
                }
                
                // Réactiver le contrôle
                this.disabled = false;
                this.parentElement.classList.remove('processing');
                
                // Simuler une réponse de succès (95% de chance)
                const success = Math.random() > 0.05;
                
                if (success) {
                    // Afficher une notification de succès
                    showNotification('Statut mis à jour avec succès', 'success');
                } else {
                    // Simuler un échec et restaurer l'état d'origine
                    this.checked = originalChecked;
                    showNotification('Erreur lors de la mise à jour du statut', 'error');
                }
            }, delay);
        });
    });
}

/**
 * Configure une simulation de délai pour les boutons
 * @param {string} selector - Sélecteur CSS pour les boutons
 * @param {number} delay - Délai de simulation en ms
 */
function setupButtonDelay(selector, delay = 1500) {
    const buttons = document.querySelectorAll(selector);
    
    buttons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Empêcher le comportement par défaut
            event.preventDefault();
            
            // Sauvegarder le texte original
            const originalText = this.innerHTML;
            
            // Désactiver le bouton
            this.disabled = true;
            
            // Ajouter une classe pour le style visuel
            this.classList.add('processing');
            
            // Remplacer le texte par une animation
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
            
            // Simuler une opération asynchrone
            setTimeout(() => {
                // Réactiver le bouton
                this.disabled = false;
                this.classList.remove('processing');
                
                // Restaurer le texte original
                this.innerHTML = originalText;
                
                // Simuler une réponse de succès (90% de chance)
                const success = Math.random() > 0.1;
                
                if (success) {
                    showNotification('Opération effectuée avec succès', 'success');
                    
                    // Si c'est un bouton de suppression et l'opération réussit
                    if (this.classList.contains('delete-btn')) {
                        // Trouver et masquer l'élément parent (ligne ou carte)
                        const itemToRemove = this.closest('tr') || this.closest('.card');
                        if (itemToRemove) {
                            itemToRemove.style.opacity = '0';
                            setTimeout(() => {
                                itemToRemove.style.display = 'none';
                            }, 500);
                        }
                    }
                } else {
                    showNotification('Erreur lors de l\'opération', 'error');
                }
            }, delay);
        });
    });
}

/**
 * Configure une simulation de délai pour les sélecteurs
 * @param {string} selector - Sélecteur CSS pour les menus déroulants
 * @param {number} delay - Délai de simulation en ms
 */
function setupSelectDelay(selector, delay = 1800) {
    const selects = document.querySelectorAll(selector);
    
    selects.forEach(select => {
        select.addEventListener('change', function(event) {
            // Sauvegarder la valeur sélectionnée
            const selectedValue = this.value;
            
            // Désactiver le sélecteur
            this.disabled = true;
            
            // Ajouter une classe pour le style visuel
            this.classList.add('processing');
            
            // Créer et afficher l'animation de chargement
            const loadingIndicator = createLoadingIndicator(this.parentElement);
            
            // Simuler une opération asynchrone
            setTimeout(() => {
                // Supprimer l'indicateur de chargement
                if (loadingIndicator && loadingIndicator.parentNode) {
                    loadingIndicator.parentNode.removeChild(loadingIndicator);
                }
                
                // Réactiver le sélecteur
                this.disabled = false;
                this.classList.remove('processing');
                
                // Simuler une réponse de succès (95% de chance)
                const success = Math.random() > 0.05;
                
                if (success) {
                    showNotification('Rôle mis à jour avec succès', 'success');
                } else {
                    // Restaurer la valeur précédente
                    this.value = this.dataset.originalValue || this.options[0].value;
                    showNotification('Erreur lors de la mise à jour du rôle', 'error');
                }
                
                // Stocker la nouvelle valeur comme originale
                if (success) {
                    this.dataset.originalValue = selectedValue;
                }
            }, delay);
        });
        
        // Stocker la valeur initiale
        select.dataset.originalValue = select.value;
    });
}

/**
 * Crée un indicateur de chargement à ajouter à un élément
 * @param {HTMLElement} parent - Élément parent où ajouter l'indicateur
 * @returns {HTMLElement} - L'indicateur de chargement créé
 */
function createLoadingIndicator(parent) {
    const indicator = document.createElement('div');
    indicator.className = 'loading-indicator';
    indicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    // Appliquer des styles
    indicator.style.position = 'absolute';
    indicator.style.right = '10px';
    indicator.style.top = '50%';
    indicator.style.transform = 'translateY(-50%)';
    indicator.style.color = '#4169e1';
    indicator.style.fontSize = '1.2rem';
    
    // S'assurer que le parent est positionné relativement
    if (getComputedStyle(parent).position === 'static') {
        parent.style.position = 'relative';
    }
    
    parent.appendChild(indicator);
    return indicator;
}

/**
 * Affiche une notification à l'utilisateur
 * @param {string} message - Message à afficher
 * @param {string} type - Type de notification ('success', 'error', 'info', 'warning')
 */
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    // Définir l'icône en fonction du type
    let icon = '';
    switch (type) {
        case 'success':
            icon = '<i class="fas fa-check-circle"></i>';
            break;
        case 'error':
            icon = '<i class="fas fa-exclamation-circle"></i>';
            break;
        case 'warning':
            icon = '<i class="fas fa-exclamation-triangle"></i>';
            break;
        default:
            icon = '<i class="fas fa-info-circle"></i>';
    }
    
    // Ajouter le contenu
    notification.innerHTML = `
        <div class="notification-icon">${icon}</div>
        <div class="notification-content">${message}</div>
        <button class="notification-close"><i class="fas fa-times"></i></button>
    `;
    
    // Appliquer des styles
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.display = 'flex';
    notification.style.alignItems = 'center';
    notification.style.padding = '12px 15px';
    notification.style.borderRadius = '4px';
    notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    notification.style.marginBottom = '10px';
    notification.style.transform = 'translateX(120%)';
    notification.style.transition = 'transform 0.3s ease';
    
    // Appliquer les couleurs selon le type
    switch (type) {
        case 'success':
            notification.style.backgroundColor = '#d4edda';
            notification.style.color = '#155724';
            notification.style.borderLeft = '4px solid #28a745';
            break;
        case 'error':
            notification.style.backgroundColor = '#f8d7da';
            notification.style.color = '#721c24';
            notification.style.borderLeft = '4px solid #dc3545';
            break;
        case 'warning':
            notification.style.backgroundColor = '#fff3cd';
            notification.style.color = '#856404';
            notification.style.borderLeft = '4px solid #ffc107';
            break;
        default:
            notification.style.backgroundColor = '#d1ecf1';
            notification.style.color = '#0c5460';
            notification.style.borderLeft = '4px solid #17a2b8';
    }
    
    // Styles pour les enfants
    notification.querySelector('.notification-icon').style.marginRight = '10px';
    notification.querySelector('.notification-icon i').style.fontSize = '1.2rem';
    notification.querySelector('.notification-content').style.flex = '1';
    notification.querySelector('.notification-close').style.background = 'none';
    notification.querySelector('.notification-close').style.border = 'none';
    notification.querySelector('.notification-close').style.cursor = 'pointer';
    notification.querySelector('.notification-close').style.color = 'inherit';
    notification.querySelector('.notification-close').style.opacity = '0.7';
    
    // Ajouter au DOM
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Configurer la fermeture
    notification.querySelector('.notification-close').addEventListener('click', () => {
        closeNotification(notification);
    });
    
    // Fermeture automatique après délai
    setTimeout(() => {
        closeNotification(notification);
    }, 5000);
}

/**
 * Ferme une notification avec animation
 * @param {HTMLElement} notification - Élément de notification à fermer
 */
function closeNotification(notification) {
    notification.style.transform = 'translateX(120%)';
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 300);
} 