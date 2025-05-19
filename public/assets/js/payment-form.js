/**
 * Script de soumission automatique du formulaire de paiement
 * Utilisé après la validation du panier pour rediriger vers la page de simulation de paiement
 */
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById("cybank-form");
    if (form) {
        // Soumettre le formulaire automatiquement
        form.submit();
        
        // Ajout d'un compteur de redirection (UX)
        const messageArea = document.querySelector('p');
        if (messageArea) {
            let count = 3;
            messageArea.textContent += ' Redirection dans ' + count + ' secondes...';
            
            const countdown = setInterval(function() {
                count--;
                if (count <= 0) {
                    clearInterval(countdown);
                    messageArea.textContent = 'Redirection en cours...';
                } else {
                    messageArea.textContent = 'Veuillez patienter, vous allez être redirigé automatiquement. Redirection dans ' + count + ' secondes...';
                }
            }, 1000);
        }
    }
}); 