/**
 * Gestion du consentement aux cookies
 */
document.addEventListener('DOMContentLoaded', function() {
    const cookieConsent = document.getElementById('cookie-consent');
    const acceptButton = document.getElementById('accept-cookies');
    const declineButton = document.getElementById('decline-cookies');
    
    // Vérifier si l'utilisateur a déjà fait son choix
    const cookieChoice = getCookie('cookie_consent');
    
    if (!cookieChoice && cookieConsent) {
        // Afficher la bannière avec une animation
        setTimeout(() => {
            cookieConsent.classList.add('active');
        }, 1000);
        
        // Gérer le clic sur le bouton d'acceptation
        if (acceptButton) {
            acceptButton.addEventListener('click', function() {
                acceptCookies();
                hideBanner();
            });
        }
        
        // Gérer le clic sur le bouton de refus
        if (declineButton) {
            declineButton.addEventListener('click', function() {
                declineCookies();
                hideBanner();
            });
        }
    }
    
    // Fonction pour masquer la bannière
    function hideBanner() {
        cookieConsent.classList.add('hiding');
        setTimeout(() => {
            cookieConsent.style.display = 'none';
        }, 500);
    }
    
    // Fonction pour accepter les cookies
    function acceptCookies() {
        setCookie('cookie_consent', 'accepted', 365);
        // Autoriser les scripts d'analyse, etc.
    }
    
    // Fonction pour refuser les cookies
    function declineCookies() {
        setCookie('cookie_consent', 'declined', 365);
        // Désactiver les scripts d'analyse, etc.
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
}); 