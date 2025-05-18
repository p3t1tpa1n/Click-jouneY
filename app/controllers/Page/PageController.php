<?php

namespace controllers\page;

use core\Controller;
use core\Session;

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
        // Si c'est une soumission de formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $old = [];
            
            // Récupération et validation des données
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $privacy = isset($_POST['privacy']) ? 1 : 0;
            
            // Validation des champs
            if (empty($name)) {
                $errors['name'] = 'Le nom est obligatoire';
            }
            
            if (empty($email)) {
                $errors['email'] = 'L\'email est obligatoire';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'L\'email n\'est pas valide';
            }
            
            if (!empty($phone) && !preg_match('/^[0-9+\(\)\s.-]{6,20}$/', $phone)) {
                $errors['phone'] = 'Le numéro de téléphone n\'est pas valide';
            }
            
            if (empty($subject)) {
                $errors['subject'] = 'Le sujet est obligatoire';
            }
            
            if (empty($message)) {
                $errors['message'] = 'Le message est obligatoire';
            }
            
            if (!$privacy) {
                $errors['privacy'] = 'Vous devez accepter la politique de confidentialité';
            }
            
            // Sauvegarde des données pour repopuler le formulaire
            $old = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message,
                'privacy' => $privacy
            ];
            
            // Si pas d'erreurs, traiter le formulaire
            if (empty($errors)) {
                // Ici, vous pourriez envoyer un email, enregistrer en BDD, etc.
                // Pour l'exemple, on simule juste un succès
                
                Session::set('success', 'Votre message a bien été envoyé ! Nous vous répondrons dans les plus brefs délais.');
                
                // Rediriger vers la page de contact
                redirect('index.php?route=contact');
            } else {
                // Stockage des erreurs et anciennes valeurs en session
                Session::set('errors', $errors);
                Session::set('old', $old);
                
                // Rediriger vers le formulaire
                redirect('index.php?route=contact');
            }
        } else {
            // Rediriger vers le formulaire
            redirect('index.php?route=contact');
        }
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