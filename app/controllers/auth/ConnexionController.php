<?php

namespace controllers\auth;

use core\Controller;
use models\user\User;
use core\Session;

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
        if (isset($_SESSION['user'])) {
            $this->redirect('index.php');
        }
        
        $alertMessage = null;
        $alertType = null;
        $login = '';
        
        // Traitement du formulaire de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            error_log('DEBUG LOGIN: login reçu = ' . $login);
            error_log('DEBUG LOGIN: password reçu = ' . $password);
            error_log('DEBUG LOGIN: remember = ' . ($remember ? 'true' : 'false'));
            error_log('DEBUG LOGIN: redirect_after_login = ' . (isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'non défini'));
            
            // Validation de base
            if (empty($login) || empty($password)) {
                $alertType = 'error';
                $alertMessage = 'Veuillez remplir tous les champs.';
            } else {
                // Tentative d'authentification
                $user = User::getByLogin($login);
                error_log('DEBUG LOGIN: utilisateur trouvé = ' . print_r($user, true));
                
                // Vérifier si l'utilisateur existe et a un mot de passe
                if (!$user) {
                    error_log('DEBUG LOGIN: Utilisateur non trouvé pour le login: ' . $login);
                    $alertType = 'error';
                    $alertMessage = 'Identifiants incorrects. Utilisateur non trouvé.';
                } else if (!isset($user['password'])) {
                    error_log('DEBUG LOGIN: Utilisateur trouvé mais sans mot de passe défini');
                    $alertType = 'error';
                    $alertMessage = 'Erreur de configuration du compte. Contactez l\'administrateur.';
                } else {
                    error_log('DEBUG LOGIN: mot de passe stocké = ' . $user['password']);
                    error_log('DEBUG LOGIN: mot de passe saisi = ' . $password);
                    
                    // Vérifier si le mot de passe est hashé ou en clair
                    $passwordValid = false;
                    
                    // Si le mot de passe est hashé (commence par $2y$)
                    if (strpos($user['password'], '$2y$') === 0) {
                        $passwordValid = password_verify($password, $user['password']);
                        error_log('DEBUG LOGIN: vérification avec password_verify = ' . ($passwordValid ? 'true' : 'false'));
                    } else {
                        // Sinon, comparaison directe (password en clair)
                        $passwordValid = ($password === $user['password']);
                        error_log('DEBUG LOGIN: vérification directe = ' . ($passwordValid ? 'true' : 'false'));
                    }
                    
                    if ($passwordValid) {
                        // Mise à jour de la date de dernière connexion
                        $user['last_login'] = date('Y-m-d H:i:s');
                        User::update($user);
                        
                        // Stockage de l'utilisateur en session - IMPORTANT
                        $_SESSION['user'] = $user;
                        
                        // Log de débogage
                        error_log('Utilisateur connecté: ' . print_r($user, true));
                        error_log('Session après connexion: ' . print_r($_SESSION, true));
                        
                        // Gestion du "Se souvenir de moi"
                        if ($remember) {
                            $token = bin2hex(random_bytes(32));
                            $expiry = time() + 60*60*24*30; // 30 jours
                            
                            setcookie('remember_token', $token, $expiry, '/', '', false, true);
                            setcookie('remember_user', $login, $expiry, '/', '', false, true);
                            
                            // Stocker le token en base de données
                            $userData = [
                                'login' => $login,
                                'remember_token' => password_hash($token, PASSWORD_DEFAULT),
                                'token_expiry' => date('Y-m-d H:i:s', $expiry)
                            ];
                            
                            User::update($userData);
                        }
                        
                        // Ajouter un message de succès dans la session
                        Session::set('success', 'Vous êtes maintenant connecté.');
                        
                        // Redirection
                        $redirectUrl = isset($_SESSION['redirect_after_login']) 
                            ? $_SESSION['redirect_after_login'] 
                            : 'index.php';
                        
                        unset($_SESSION['redirect_after_login']);
                        $this->redirect($redirectUrl);
                        exit; // Assurer que l'exécution s'arrête ici
                    } else {
                        $alertType = 'error';
                        $alertMessage = 'Identifiants incorrects.';
                        error_log('Échec de connexion pour: ' . $login);
                    }
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