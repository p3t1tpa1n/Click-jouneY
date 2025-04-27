<?php
/**
 * Contrôleur pour la gestion du profil utilisateur
 */
class UserController {
    /**
     * Affiche le profil de l'utilisateur connecté
     */
    public function profile() {
        // Vérifier si l'utilisateur est connecté
        requireLogin();
        
        $pageTitle = 'Mon profil';
        $user = $_SESSION['user'];
        
        // Récupérer les voyages consultés
        $viewedTrips = [];
        if (isset($user['viewed_trips']) && is_array($user['viewed_trips'])) {
            foreach ($user['viewed_trips'] as $tripId) {
                $trip = Trip::getById($tripId);
                if ($trip) {
                    $viewedTrips[] = $trip;
                }
            }
        }
        
        // Limiter aux 5 derniers voyages consultés
        $viewedTrips = array_slice($viewedTrips, 0, 5);
        
        // Récupérer les voyages achetés
        $purchasedTrips = [];
        if (isset($user['purchased_trips']) && is_array($user['purchased_trips'])) {
            foreach ($user['purchased_trips'] as $tripId) {
                $trip = Trip::getById($tripId);
                if ($trip) {
                    $purchasedTrips[] = $trip;
                }
            }
        }
        
        // Récupérer les paiements
        $payments = Payment::getByUserLogin($user['login']);
        
        // Charger la vue
        include 'views/partials/header.php';
        include 'views/user/profile.php';
        include 'views/partials/footer.php';
    }
    
    /**
     * Affiche le formulaire de modification du profil
     */
    public function editProfile() {
        // Vérifier si l'utilisateur est connecté
        requireLogin();
        
        $pageTitle = 'Modifier mon profil';
        $user = $_SESSION['user'];
        $alertMessage = null;
        $alertType = null;
        
        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier le jeton CSRF
            if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                $alertType = 'error';
                $alertMessage = 'Erreur de sécurité. Veuillez réessayer.';
            } else {
                // Préparer les données du formulaire
                $userData = [
                    'id' => $user['id'],
                    'login' => $user['login'], // Le login ne peut pas être modifié
                    'name' => $_POST['name'] ?? $user['name'],
                    'email' => $_POST['email'] ?? $user['email'],
                    'address' => $_POST['address'] ?? $user['address'],
                    'newsletter' => isset($_POST['newsletter']) ? 1 : 0
                ];
                
                // Gestion du changement de mot de passe
                $newPassword = $_POST['new_password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';
                $currentPassword = $_POST['current_password'] ?? '';
                
                if (!empty($newPassword)) {
                    // Valider le mot de passe actuel
                    $userWithPassword = User::getByLogin($user['login']);
                    
                    if (!password_verify($currentPassword, $userWithPassword['password'])) {
                        $alertType = 'error';
                        $alertMessage = 'Le mot de passe actuel est incorrect.';
                    } 
                    // Valider le nouveau mot de passe
                    elseif (strlen($newPassword) < 6) {
                        $alertType = 'error';
                        $alertMessage = 'Le nouveau mot de passe doit contenir au moins 6 caractères.';
                    } 
                    elseif (!preg_match('/[A-Z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
                        $alertType = 'error';
                        $alertMessage = 'Le nouveau mot de passe doit contenir au moins une lettre majuscule et un chiffre.';
                    } 
                    elseif ($newPassword !== $confirmPassword) {
                        $alertType = 'error';
                        $alertMessage = 'Les nouveaux mots de passe ne correspondent pas.';
                    } 
                    else {
                        // Tout est OK, ajouter le nouveau mot de passe aux données
                        $userData['password'] = $newPassword;
                    }
                }
                
                // Mettre à jour le profil si pas d'erreur
                if ($alertType !== 'error') {
                    $result = User::update($userData);
                    
                    if ($result === true) {
                        // Mettre à jour la session
                        $updatedUser = User::getByLogin($user['login']);
                        unset($updatedUser['password']);
                        $_SESSION['user'] = $updatedUser;
                        
                        $alertType = 'success';
                        $alertMessage = 'Votre profil a été mis à jour avec succès.';
                    } else {
                        $alertType = 'error';
                        $alertMessage = $result; // Message d'erreur de User::update
                    }
                }
            }
        }
        
        // Générer un nouveau jeton CSRF
        $csrfToken = generateCSRFToken();
        
        // Charger la vue
        include 'views/partials/header.php';
        include 'views/user/edit-profile.php';
        include 'views/partials/footer.php';
    }
    
    /**
     * Supprime le compte de l'utilisateur connecté
     */
    public function deleteAccount() {
        // Vérifier si l'utilisateur est connecté
        requireLogin();
        
        $pageTitle = 'Supprimer mon compte';
        $user = $_SESSION['user'];
        $alertMessage = null;
        $alertType = null;
        
        // Traitement de la confirmation
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier le jeton CSRF
            if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                $alertType = 'error';
                $alertMessage = 'Erreur de sécurité. Veuillez réessayer.';
            } 
            // Vérifier le mot de passe
            else {
                $password = $_POST['password'] ?? '';
                $userWithPassword = User::getByLogin($user['login']);
                
                if (!password_verify($password, $userWithPassword['password'])) {
                    $alertType = 'error';
                    $alertMessage = 'Le mot de passe est incorrect.';
                } else {
                    // Supprimer le compte
                    $result = User::delete($user['login']);
                    
                    if ($result === true) {
                        // Déconnecter l'utilisateur
                        session_unset();
                        session_destroy();
                        
                        // Rediriger vers la page d'accueil avec un message
                        $_SESSION['flash_message'] = 'Votre compte a été supprimé avec succès.';
                        $_SESSION['flash_type'] = 'success';
                        redirect('index.php');
                    } else {
                        $alertType = 'error';
                        $alertMessage = $result; // Message d'erreur de User::delete
                    }
                }
            }
        }
        
        // Générer un nouveau jeton CSRF
        $csrfToken = generateCSRFToken();
        
        // S'il s'agit d'une demande de confirmation initiale
        if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
            // Charger la vue de confirmation
            include 'views/partials/header.php';
            include 'views/user/delete-account-confirm.php';
            include 'views/partials/footer.php';
            return;
        }
        
        // Charger la vue du formulaire de suppression
        include 'views/partials/header.php';
        include 'views/user/delete-account.php';
        include 'views/partials/footer.php';
    }
}
?> 