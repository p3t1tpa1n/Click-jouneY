<?php

namespace controllers\Page;

use core\Controller;
use core\Validator;
use models\Message;

class ContactController extends Controller
{
    /**
     * Affiche la page de contact
     */
    public function index()
    {
        $this->render('home/contact');
    }

    /**
     * Traite l'envoi du formulaire de contact
     */
    public function send()
    {
        // Validation des données du formulaire
        $validator = new Validator();
        $validator->validate($_POST, [
            'name' => ['required', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'max:20'],
            'subject' => ['required', 'in:information,reservation,complaint,other'],
            'message' => ['required', 'min:10', 'max:2000'],
            'privacy' => ['required']
        ], [
            'name' => 'nom',
            'email' => 'email',
            'phone' => 'téléphone',
            'subject' => 'sujet',
            'message' => 'message',
            'privacy' => 'politique de confidentialité'
        ]);

        // Si la validation échoue, redirection vers le formulaire avec les erreurs
        if ($validator->fails()) {
            $_SESSION['flash']['errors'] = $validator->getErrors();
            $_SESSION['flash']['old'] = $_POST;
            $_SESSION['flash']['error'] = 'Veuillez corriger les erreurs dans le formulaire.';
            
            $this->redirect('contact');
            return;
        }

        try {
            // Création d'un nouveau message dans la base de données
            $messageModel = new Message();
            $result = $messageModel->create([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'] ?? null,
                'subject' => $_POST['subject'],
                'message' => $_POST['message'],
                'status' => 'unread',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                // Envoi d'un e-mail de confirmation (simulation)
                $this->sendConfirmationEmail($_POST['email'], $_POST['name']);
                
                // Message de succès et redirection
                $_SESSION['flash']['success'] = 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.';
                $this->redirect('contact');
            } else {
                throw new \Exception('Erreur lors de l\'enregistrement du message.');
            }
        } catch (\Exception $e) {
            // En cas d'erreur, affichage d'un message d'erreur et redirection
            $_SESSION['flash']['error'] = 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer plus tard.';
            $_SESSION['flash']['old'] = $_POST;
            
            $this->redirect('contact');
        }
    }

    /**
     * Envoie un e-mail de confirmation (simulation)
     * 
     * @param string $email Adresse e-mail du destinataire
     * @param string $name Nom du destinataire
     * @return bool
     */
    private function sendConfirmationEmail(string $email, string $name): bool
    {
        // Cette méthode simule l'envoi d'un email de confirmation
        // Dans un environnement de production, utiliser PHPMailer ou une API d'envoi d'emails
        
        // Simulation d'un délai d'envoi
        usleep(500000); // 0.5 secondes
        
        // Journalisation de l'email (à des fins de débogage)
        $logMessage = date('Y-m-d H:i:s') . " - Email de confirmation envoyé à $name <$email>\n";
        error_log($logMessage, 3, __DIR__ . '/../../logs/emails.log');
        
        return true;
    }
} 