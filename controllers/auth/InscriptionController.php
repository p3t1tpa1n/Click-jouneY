<?php
/**
 * Contrôleur de la page d'inscription
 */

namespace controllers\auth;

use core\Controller;
use models\user\User;

class InscriptionController extends Controller {
    /**
     * Traite la demande d'inscription
     */
    public function index() {
        $pageTitle = 'Inscription';
        
        // Si l'utilisateur est déjà connecté, rediriger vers l'accueil
        if (isLoggedIn()) {
            $this->redirect('index.php');
        }
        
        $alertMessage = null;
        $alertType = null;
        $formData = [];
        
        // Traitement du formulaire d'inscription
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = [
                'login' => $_POST['login'] ?? '',
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? '',
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? '',
                'address' => $_POST['address'] ?? '',
                'newsletter' => isset($_POST['newsletter']) ? 1 : 0
            ];
            
            // Validation des champs
            $errors = $this->validateForm($formData);
            
            if (empty($errors)) {
                // Création de l'utilisateur
                $userData = [
                    'login' => $formData['login'],
                    'password' => $formData['password'], // Le modèle User::create se chargera du hachage
                    'name' => $formData['name'],
                    'email' => $formData['email'],
                    'birth_date' => $formData['birth_date'],
                    'address' => $formData['address'],
                    'role' => 'user', // Rôle par défaut
                    'newsletter' => $formData['newsletter']
                ];
                
                $result = User::create($userData);
                
                if ($result === true) {
                    // Authentifier automatiquement l'utilisateur
                    $user = User::getByLogin($formData['login']);
                    unset($user['password']); // Ne pas stocker le mot de passe en session
                    $_SESSION['user'] = $user;
                    
                    // Rediriger vers la page d'accueil
                    $this->redirect('index.php');
                } else {
                    $alertType = 'error';
                    $alertMessage = $result; // Le message d'erreur retourné par User::create
                }
            } else {
                $alertType = 'error';
                $alertMessage = implode('<br>', $errors);
            }
        }
        
        // Charger la vue
        $this->render('auth/inscription', [
            'pageTitle' => $pageTitle,
            'alertMessage' => $alertMessage,
            'alertType' => $alertType,
            'formData' => $formData
        ]);
    }
    
    /**
     * Valide les données du formulaire d'inscription
     * 
     * @param array $data Données du formulaire
     * @return array Liste des erreurs
     */
    private function validateForm($data) {
        $errors = [];
        
        if (empty($data['login'])) {
            $errors[] = 'L\'identifiant est obligatoire.';
        } elseif (User::getByLogin($data['login'])) {
            $errors[] = 'Cet identifiant est déjà utilisé.';
        }
        
        if (empty($data['password'])) {
            $errors[] = 'Le mot de passe est obligatoire.';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        } elseif (!preg_match('/[A-Z]/', $data['password']) || !preg_match('/[0-9]/', $data['password'])) {
            $errors[] = 'Le mot de passe doit contenir au moins une lettre majuscule et un chiffre.';
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
        
        if (empty($data['name'])) {
            $errors[] = 'Le nom est obligatoire.';
        }
        
        if (empty($data['email'])) {
            $errors[] = 'L\'email est obligatoire.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L\'email n\'est pas valide.';
        }
        
        if (empty($data['birth_date'])) {
            $errors[] = 'La date de naissance est obligatoire.';
        }
        
        if (empty($data['address'])) {
            $errors[] = 'L\'adresse est obligatoire.';
        }
        
        if (!isset($_POST['terms'])) {
            $errors[] = 'Vous devez accepter les conditions générales d\'utilisation.';
        }
        
        return $errors;
    }
}
?> 