<?php

namespace controllers\auth;

use core\Controller;
use models\user\User;

/**
 * Contrôleur de la page de connexion
 */
class ConnexionController extends Controller {
    /**
     * Traite la demande de connexion
     */
    public function index() {
        $pageTitle = 'Connexion';
        
        // Si l'utilisateur est déjà connecté, rediriger vers l'accueil
        if (isLoggedIn()) {
            $this->redirect('index.php');
        }
        
        $alertMessage = null;
        $alertType = null;
        $login = '';
        
        // Traitement du formulaire de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember_me']);
            
            // Validation de base
            if (empty($login) || empty($password)) {
                $alertType = 'error';
                $alertMessage = 'Veuillez remplir tous les champs.';
            } else {
                // Tentative d'authentification
                $user = User::authenticate($login, $password);
                
                if ($user) {
                    // Mise à jour de la date de dernière connexion
                    $user['last_login'] = date('Y-m-d H:i:s');
                    User::update($user);
                    
                    // Stockage de l'utilisateur en session
                    $_SESSION['user'] = $user;
                    
                    // Gestion du "Se souvenir de moi"
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $expiry = time() + 60*60*24*30; // 30 jours
                        
                        setcookie('remember_token', $token, $expiry, '/', '', true, true);
                        setcookie('remember_user', $login, $expiry, '/', '', true, true);
                        
                        // Stocker le token en base de données
                        $userData = [
                            'login' => $login,
                            'remember_token' => password_hash($token, PASSWORD_DEFAULT),
                            'token_expiry' => date('Y-m-d H:i:s', $expiry)
                        ];
                        
                        User::update($userData);
                    }
                    
                    // Redirection
                    $redirectUrl = isset($_SESSION['redirect_after_login']) 
                        ? $_SESSION['redirect_after_login'] 
                        : 'index.php';
                    
                    unset($_SESSION['redirect_after_login']);
                    $this->redirect($redirectUrl);
                } else {
                    $alertType = 'error';
                    $alertMessage = 'Identifiants incorrects.';
                }
            }
        }
        
        // Charger la vue
        $this->render('auth/connexion', [
            'pageTitle' => $pageTitle,
            'alertMessage' => $alertMessage,
            'alertType' => $alertType,
            'login' => $login
        ]);
    }
}
?> 