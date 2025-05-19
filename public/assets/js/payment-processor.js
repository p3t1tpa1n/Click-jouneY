/**
 * Gestion des formulaires de paiement pour CY Bank
 */
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du formulaire de paiement dans la page payment.php
    const cyBankForm = document.querySelector('.cybank-form form');
    if (cyBankForm) {
        // Soumettre automatiquement le formulaire après un court délai
        setTimeout(function() {
            // Décommenté en production pour soumettre automatiquement
            // cyBankForm.submit();
            
            // Notification de délai
            const notif = document.createElement('div');
            notif.className = 'alert alert-info mt-3';
            notif.innerHTML = '<i class="fas fa-info-circle me-2"></i> En environnement de test, le formulaire ne sera pas soumis automatiquement.';
            cyBankForm.parentNode.appendChild(notif);
        }, 5000);
        
        // Ajouter une animation au bouton de paiement
        const paymentButton = document.querySelector('.btn-success');
        if (paymentButton) {
            paymentButton.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i> Traitement en cours...';
                this.disabled = true;
                
                // Soumettre le formulaire après une courte animation
                setTimeout(function() {
                    cyBankForm.submit();
                }, 800);
            });
        }
    }
    
    // Gestion du formulaire de redirection pour le processPayment
    const redirectForm = document.getElementById('cybank-form');
    if (redirectForm) {
        redirectForm.submit();
    }
}); 