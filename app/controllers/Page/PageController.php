<?php

namespace controllers\page;

use core\Controller;

/**
 * Contrôleur pour les pages statiques et erreurs
 */
class PageController extends Controller
{
    /**
     * Affiche la page d'erreur 404
     */
    public function error404()
    {
        $pageTitle = 'Page non trouvée - 404';
        require_once __DIR__ . '/../../views/partials/header.php';
        require_once __DIR__ . '/../../views/errors/404.php';
        require_once __DIR__ . '/../../views/partials/footer.php';
    }
    
    /**
     * Affiche la page À propos
     */
    public function about()
    {
        $pageTitle = 'À propos de ' . APP_NAME;
        require_once __DIR__ . '/../../views/partials/header.php';
        require_once __DIR__ . '/../../views/home/about.php';
        require_once __DIR__ . '/../../views/partials/footer.php';
    }
    
    /**
     * Affiche la page Contact
     */
    public function contact()
    {
        $pageTitle = 'Contactez-nous';
        require_once __DIR__ . '/../../views/partials/header.php';
        require_once __DIR__ . '/../../views/home/contact.php';
        require_once __DIR__ . '/../../views/partials/footer.php';
    }
    
    /**
     * Traite le formulaire de contact
     */
    public function submitContact()
    {
        // Traitement du formulaire et envoi d'email
        // Ici on simule juste un message de confirmation
        
        // Rediriger avec un message de confirmation
        core\Session::set('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
        $this->redirect('/contact');
    }
} 