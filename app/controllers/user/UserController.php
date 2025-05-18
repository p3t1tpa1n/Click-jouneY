<?php

namespace controllers\user;

use core\Controller;
use core\Auth;
use core\Session;
use models\user\User;
use models\trip\Trip;
use models\payment\Payment;

/**
 * Contrôleur pour la gestion des comptes utilisateurs
 */
class UserController extends Controller
{
    /**
     * Affiche le profil de l'utilisateur connecté
     */
    public function profile()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour accéder à cette page');
            Session::set('redirect_after_login', '/profile');
            $this->redirect('/login');
            return;
        }
        
        $user = Auth::getUser();
        
        // Récupérer les voyages consultés
        $viewedTrips = [];
        if (isset($user['viewed_trips']) && is_array($user['viewed_trips'])) {
            foreach (array_slice(array_reverse($user['viewed_trips']), 0, 5) as $tripId) {
                $trip = Trip::findById($tripId);
                if ($trip) {
                    $viewedTrips[] = $trip;
                }
            }
        }
        
        // Récupérer les voyages achetés
        $purchasedTrips = [];
        if (isset($user['purchased_trips']) && is_array($user['purchased_trips'])) {
            foreach ($user['purchased_trips'] as $tripId) {
                $trip = Trip::findById($tripId);
                if ($trip) {
                    $purchasedTrips[] = $trip;
                }
            }
        }
        
        // Récupérer les paiements effectués
        $payments = Payment::getByUserId($user['id'] ?? 0);
        
        // Rendre la vue
        $this->render('user/profile', [
            'title' => 'Mon profil',
            'user' => $user,
            'viewedTrips' => $viewedTrips,
            'purchasedTrips' => $purchasedTrips,
            'payments' => $payments
        ]);
    }
    
    /**
     * Traite les modifications du profil
     */
    public function updateProfile()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour accéder à cette page');
            $this->redirect('/login');
            return;
        }
        
        $user = Auth::getUser();
        
        // Traiter le formulaire si soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->sanitize($_POST['name'] ?? '');
            $email = $this->sanitize($_POST['email'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validation de base
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Le nom est obligatoire';
            }
            
            if (empty($email)) {
                $errors[] = 'L\'email est obligatoire';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'L\'email est invalide';
            }
            
            // Gestion du changement de mot de passe
            if (!empty($newPassword)) {
                // Vérification du mot de passe actuel
                $isPasswordValid = User::verifyPassword($user['login'], $currentPassword);
                if (!$isPasswordValid) {
                    $errors[] = 'Le mot de passe actuel est incorrect';
                }
                
                // Validation du nouveau mot de passe
                if (strlen($newPassword) < 8) {
                    $errors[] = 'Le nouveau mot de passe doit contenir au moins 8 caractères';
                }
                
                if ($newPassword !== $confirmPassword) {
                    $errors[] = 'Les nouveaux mots de passe ne correspondent pas';
                }
            }
            
            // S'il n'y a pas d'erreurs, mettre à jour le profil
            if (empty($errors)) {
                $userData = [
                    'id' => $user['id'],
                    'login' => $user['login'],
                    'name' => $name,
                    'email' => $email
                ];
                
                // Ajouter le nouveau mot de passe s'il a été modifié
                if (!empty($newPassword)) {
                    $userData['password'] = $newPassword;
                }
                
                // Mettre à jour l'utilisateur
                $result = User::update($userData);
                
                if ($result === true) {
                    // Mise à jour de la session
                    $updatedUser = User::getByLogin($user['login']);
                    Auth::login($updatedUser);
                    
                    Session::set('success', 'Votre profil a été mis à jour avec succès');
                    $this->redirect('/profile');
                } else {
                    Session::set('error', $result);
                }
            } else {
                // Afficher les erreurs
                Session::set('error', implode('<br>', $errors));
            }
        }
        
        // Rendre la vue
        $this->render('user/edit-profile', [
            'title' => 'Modifier mon profil',
            'user' => $user
        ]);
    }
    
    /**
     * Affiche la page de l'historique des voyages
     */
    public function history()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour accéder à cette page');
            Session::set('redirect_after_login', '/history');
            $this->redirect('/login');
            return;
        }
        
        $user = Auth::getUser();
        
        // Récupérer tous les voyages consultés
        $viewedTrips = [];
        if (isset($user['viewed_trips']) && is_array($user['viewed_trips'])) {
            foreach (array_reverse($user['viewed_trips']) as $tripId) {
                $trip = Trip::findById($tripId);
                if ($trip) {
                    $viewedTrips[] = $trip;
                }
            }
        }
        
        // Récupérer tous les voyages achetés
        $purchasedTrips = [];
        if (isset($user['purchased_trips']) && is_array($user['purchased_trips'])) {
            foreach ($user['purchased_trips'] as $tripId) {
                $trip = Trip::findById($tripId);
                if ($trip) {
                    $purchasedTrips[] = $trip;
                }
            }
        }
        
        // Rendre la vue
        $this->render('user/history', [
            'title' => 'Mon historique de voyages',
            'user' => $user,
            'viewedTrips' => $viewedTrips,
            'purchasedTrips' => $purchasedTrips
        ]);
    }
    
    /**
     * Supprime un élément de l'historique des voyages consultés
     */
    public function removeFromHistory($id = null)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour accéder à cette page');
            $this->redirect('/login');
            return;
        }
        
        // Récupérer l'ID du voyage depuis POST si non fourni en paramètre
        if (!$id) {
            $id = $_POST['trip_id'] ?? null;
        }
        
        // Vérifier si l'ID est valide
        if (!$id || !is_numeric($id)) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/history');
            return;
        }
        
        $user = Auth::getUser();
        
        // Supprimer le voyage de l'historique
        if (isset($user['viewed_trips']) && is_array($user['viewed_trips'])) {
            $updatedViewedTrips = array_filter($user['viewed_trips'], function($tripId) use ($id) {
                return $tripId != $id;
            });
            
            // Mettre à jour l'utilisateur
            $userData = $user;
            $userData['viewed_trips'] = array_values($updatedViewedTrips);
            User::update($userData);
            
            // Mettre à jour la session
            $updatedUser = User::getByLogin($user['login']);
            Auth::login($updatedUser);
            
            Session::set('success', 'Le voyage a été supprimé de votre historique');
        }
        
        // Rediriger vers l'historique
        $this->redirect('/history');
    }
    
    /**
     * Nettoie les données entrantes
     * 
     * @param string $data Données à nettoyer
     * @return string Données nettoyées
     */
    protected function sanitize($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}
?> 