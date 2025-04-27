<?php
/**
 * Contrôleur pour la partie administration
 */
class AdminController {
    /**
     * Fonction d'initialisation commune à toutes les actions admin
     * Vérifie les droits d'accès et charge les données de base
     */
    private function init() {
        // Vérifier si l'utilisateur est connecté
        requireLogin();
        
        // Vérifier si l'utilisateur est un administrateur
        if (!isAdmin()) {
            $alertType = 'error';
            $alertMessage = 'Accès refusé. Vous n\'avez pas les droits d\'administration.';
            redirect('index.php');
        }
        
        $pageTitle = 'Administration';
    }
    
    /**
     * Affiche le tableau de bord d'administration
     */
    public function index() {
        $this->init();
        
        $pageTitle = 'Tableau de bord - Administration';
        
        // Récupérer les statistiques
        $statistics = $this->getStatistics();
        
        // Récupérer les 5 derniers utilisateurs inscrits
        $recentUsers = User::getRecent(5);
        
        // Récupérer les 5 dernières réservations
        $recentPayments = Payment::getRecent(5);
        
        // Charger la vue
        include 'views/partials/header.php';
        include 'views/admin/dashboard.php';
        include 'views/partials/footer.php';
    }
    
    /**
     * Affiche la liste des voyages pour l'administration
     */
    public function trips() {
        $this->init();
        
        $pageTitle = 'Gestion des voyages - Administration';
        
        // Paramètres de recherche et pagination
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        
        // Récupérer tous les voyages
        if (!empty($query)) {
            $trips = Trip::search($query);
        } else {
            $trips = Trip::getAll();
        }
        
        // Pagination
        $pagination = paginate($trips, $page, $perPage);
        $paginationLinks = paginationLinks('admin.php?action=trips&', $pagination);
        
        // Charger la vue
        include 'views/partials/header.php';
        include 'views/admin/trips.php';
        include 'views/partials/footer.php';
    }
    
    /**
     * Affiche le formulaire d'édition d'un voyage ou crée un nouveau voyage
     * 
     * @param int $id ID du voyage à éditer (null pour création)
     */
    public function editTrip($id = null) {
        $this->init();
        
        // Vérifier si c'est une édition ou une création
        $tripId = $id ?? (isset($_GET['id']) ? (int)$_GET['id'] : 0);
        $isCreation = ($tripId <= 0);
        
        if ($isCreation) {
            $pageTitle = 'Nouveau voyage - Administration';
            $trip = [
                'id' => 0,
                'title' => '',
                'description' => '',
                'main_image' => '',
                'gallery' => [],
                'duration' => 7,
                'base_price' => 1000,
                'options' => [],
                'steps' => []
            ];
        } else {
            $trip = Trip::getById($tripId);
            if (!$trip) {
                $alertType = 'error';
                $alertMessage = 'Voyage non trouvé.';
                redirect('admin.php?action=trips');
            }
            $pageTitle = 'Éditer ' . $trip['title'] . ' - Administration';
        }
        
        // Traitement du formulaire si soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateTripForm($_POST);
            
            if (empty($errors)) {
                // Préparer les données du voyage
                $tripData = [
                    'title' => trim($_POST['title']),
                    'description' => trim($_POST['description']),
                    'main_image' => trim($_POST['main_image']),
                    'gallery' => isset($_POST['gallery']) ? $_POST['gallery'] : [],
                    'duration' => (int)$_POST['duration'],
                    'base_price' => (float)$_POST['base_price'],
                    'options' => $this->processOptionData($_POST),
                    'steps' => $this->processStepData($_POST)
                ];
                
                // Mettre à jour ou créer le voyage
                if ($isCreation) {
                    $saveResult = Trip::create($tripData);
                } else {
                    $tripData['id'] = $tripId;
                    $saveResult = Trip::update($tripId, $tripData);
                }
                
                if ($saveResult) {
                    $alertType = 'success';
                    $alertMessage = $isCreation ? 'Voyage créé avec succès.' : 'Voyage mis à jour avec succès.';
                    redirect('admin.php?action=trips');
                } else {
                    $alertType = 'error';
                    $alertMessage = 'Une erreur est survenue lors de l\'enregistrement du voyage.';
                }
            } else {
                $alertType = 'error';
                $alertMessage = 'Veuillez corriger les erreurs du formulaire.';
                // Les données soumises sont utilisées pour repeupler le formulaire
                $trip = array_merge($trip, $_POST);
            }
        }
        
        // Charger la vue
        include 'views/partials/header.php';
        include 'views/admin/edit-trip.php';
        include 'views/partials/footer.php';
    }
    
    /**
     * Supprime un voyage
     * 
     * @param int $id ID du voyage à supprimer
     */
    public function deleteTrip($id = null) {
        $this->init();
        
        // Vérifier si un ID est fourni
        $tripId = $id ?? (isset($_GET['id']) ? (int)$_GET['id'] : 0);
        
        if ($tripId <= 0) {
            $alertType = 'error';
            $alertMessage = 'ID de voyage invalide.';
            redirect('admin.php?action=trips');
        }
        
        // Vérifier si le voyage existe
        $trip = Trip::getById($tripId);
        if (!$trip) {
            $alertType = 'error';
            $alertMessage = 'Voyage non trouvé.';
            redirect('admin.php?action=trips');
        }
        
        // Confirmation de suppression si nécessaire
        if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
            $pageTitle = 'Confirmer la suppression - Administration';
            $confirmMessage = 'Êtes-vous sûr de vouloir supprimer le voyage "' . $trip['title'] . '" ?';
            $confirmUrl = 'admin.php?action=delete-trip&id=' . $tripId . '&confirm=yes';
            $cancelUrl = 'admin.php?action=trips';
            
            // Charger la vue de confirmation
            include 'views/partials/header.php';
            include 'views/admin/confirm.php';
            include 'views/partials/footer.php';
            return;
        }
        
        // Supprimer le voyage
        $deleteResult = Trip::delete($tripId);
        
        if ($deleteResult) {
            $alertType = 'success';
            $alertMessage = 'Voyage supprimé avec succès.';
        } else {
            $alertType = 'error';
            $alertMessage = 'Une erreur est survenue lors de la suppression du voyage.';
        }
        
        redirect('admin.php?action=trips');
    }
    
    /**
     * Affiche la liste des utilisateurs pour l'administration
     */
    public function users() {
        $this->init();
        
        $pageTitle = 'Gestion des utilisateurs - Administration';
        
        // Paramètres de recherche et pagination
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        
        // Récupérer tous les utilisateurs
        if (!empty($query)) {
            $users = User::search($query);
        } else {
            $users = User::getAll();
        }
        
        // Pagination
        $pagination = paginate($users, $page, $perPage);
        $paginationLinks = paginationLinks('admin.php?action=users&', $pagination);
        
        // Charger la vue
        include 'views/partials/header.php';
        include 'views/admin/users.php';
        include 'views/partials/footer.php';
    }
    
    /**
     * Affiche les détails d'un utilisateur pour l'administration
     * 
     * @param string $login Login de l'utilisateur
     */
    public function viewUser($login = null) {
        $this->init();
        
        // Vérifier si un login est fourni
        $userLogin = $login ?? (isset($_GET['login']) ? $_GET['login'] : '');
        
        if (empty($userLogin)) {
            $alertType = 'error';
            $alertMessage = 'Login d\'utilisateur invalide.';
            redirect('admin.php?action=users');
        }
        
        // Récupérer les détails de l'utilisateur
        $user = User::getByLogin($userLogin);
        if (!$user) {
            $alertType = 'error';
            $alertMessage = 'Utilisateur non trouvé.';
            redirect('admin.php?action=users');
        }
        
        $pageTitle = 'Détails de ' . $user['name'] . ' - Administration';
        
        // Récupérer les voyages consultés par l'utilisateur
        $viewedTrips = [];
        foreach ($user['viewed_trips'] as $tripId) {
            $trip = Trip::getById($tripId);
            if ($trip) {
                $viewedTrips[] = $trip;
            }
        }
        
        // Récupérer les voyages achetés par l'utilisateur
        $purchasedTrips = [];
        foreach ($user['purchased_trips'] as $tripId) {
            $trip = Trip::getById($tripId);
            if ($trip) {
                $purchasedTrips[] = $trip;
            }
        }
        
        // Récupérer les paiements de l'utilisateur
        $payments = Payment::getByUserLogin($userLogin);
        
        // Charger la vue
        include 'views/partials/header.php';
        include 'views/admin/view-user.php';
        include 'views/partials/footer.php';
    }
    
    /**
     * Change le rôle d'un utilisateur
     * 
     * @param string $login Login de l'utilisateur
     */
    public function changeUserRole($login = null) {
        $this->init();
        
        // Vérifier si un login est fourni
        $userLogin = $login ?? (isset($_GET['login']) ? $_GET['login'] : '');
        
        if (empty($userLogin)) {
            $alertType = 'error';
            $alertMessage = 'Login d\'utilisateur invalide.';
            redirect('admin.php?action=users');
        }
        
        // Récupérer les détails de l'utilisateur
        $user = User::getByLogin($userLogin);
        if (!$user) {
            $alertType = 'error';
            $alertMessage = 'Utilisateur non trouvé.';
            redirect('admin.php?action=users');
        }
        
        // Vérifier si le nouveau rôle est spécifié
        if (!isset($_GET['role']) || !in_array($_GET['role'], ['user', 'admin'])) {
            $alertType = 'error';
            $alertMessage = 'Rôle invalide.';
            redirect('admin.php?action=view-user&login=' . $userLogin);
        }
        
        $newRole = $_GET['role'];
        
        // Ne pas permettre de changer son propre rôle
        if ($userLogin === $_SESSION['user']['login']) {
            $alertType = 'error';
            $alertMessage = 'Vous ne pouvez pas changer votre propre rôle.';
            redirect('admin.php?action=view-user&login=' . $userLogin);
        }
        
        // Mettre à jour le rôle de l'utilisateur
        $updateResult = User::updateRole($userLogin, $newRole);
        
        if ($updateResult) {
            $alertType = 'success';
            $alertMessage = 'Rôle de l\'utilisateur mis à jour avec succès.';
        } else {
            $alertType = 'error';
            $alertMessage = 'Une erreur est survenue lors de la mise à jour du rôle de l\'utilisateur.';
        }
        
        redirect('admin.php?action=view-user&login=' . $userLogin);
    }
    
    /**
     * Affiche la liste des paiements pour l'administration
     */
    public function payments() {
        $this->init();
        
        $pageTitle = 'Gestion des paiements - Administration';
        
        // Paramètres de recherche et pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        
        // Récupérer tous les paiements
        $payments = Payment::getAll();
        
        // Pagination
        $pagination = paginate($payments, $page, $perPage);
        $paginationLinks = paginationLinks('admin.php?action=payments&', $pagination);
        
        // Charger la vue
        include 'views/partials/header.php';
        include 'views/admin/payments.php';
        include 'views/partials/footer.php';
    }
    
    /**
     * Récupère les statistiques pour le tableau de bord
     * 
     * @return array Statistiques
     */
    private function getStatistics() {
        $users = User::getAll();
        $trips = Trip::getAll();
        $payments = Payment::getAll();
        
        $totalUsers = count($users);
        $totalTrips = count($trips);
        $totalPayments = count($payments);
        
        $totalRevenue = array_reduce($payments, function($total, $payment) {
            return $total + $payment['amount'];
        }, 0);
        
        $mostViewedTrip = null;
        $maxViews = 0;
        
        foreach ($trips as $trip) {
            $views = 0;
            foreach ($users as $user) {
                if (in_array($trip['id'], $user['viewed_trips'])) {
                    $views++;
                }
            }
            
            if ($views > $maxViews) {
                $maxViews = $views;
                $mostViewedTrip = $trip;
            }
        }
        
        $mostPurchasedTrip = null;
        $maxPurchases = 0;
        
        foreach ($trips as $trip) {
            $purchases = 0;
            foreach ($users as $user) {
                if (in_array($trip['id'], $user['purchased_trips'])) {
                    $purchases++;
                }
            }
            
            if ($purchases > $maxPurchases) {
                $maxPurchases = $purchases;
                $mostPurchasedTrip = $trip;
            }
        }
        
        return [
            'total_users' => $totalUsers,
            'total_trips' => $totalTrips,
            'total_payments' => $totalPayments,
            'total_revenue' => $totalRevenue,
            'most_viewed_trip' => $mostViewedTrip,
            'most_viewed_count' => $maxViews,
            'most_purchased_trip' => $mostPurchasedTrip,
            'most_purchased_count' => $maxPurchases
        ];
    }
    
    /**
     * Valide les données du formulaire de voyage
     * 
     * @param array $data Données du formulaire
     * @return array Erreurs de validation
     */
    private function validateTripForm($data) {
        $errors = [];
        
        // Valider le titre
        if (empty($data['title'])) {
            $errors['title'] = 'Le titre est obligatoire.';
        } elseif (strlen($data['title']) > 100) {
            $errors['title'] = 'Le titre ne doit pas dépasser 100 caractères.';
        }
        
        // Valider la description
        if (empty($data['description'])) {
            $errors['description'] = 'La description est obligatoire.';
        }
        
        // Valider l'image principale
        if (empty($data['main_image'])) {
            $errors['main_image'] = 'L\'image principale est obligatoire.';
        }
        
        // Valider la durée
        if (!isset($data['duration']) || !is_numeric($data['duration']) || $data['duration'] <= 0) {
            $errors['duration'] = 'La durée doit être un nombre positif.';
        }
        
        // Valider le prix de base
        if (!isset($data['base_price']) || !is_numeric($data['base_price']) || $data['base_price'] <= 0) {
            $errors['base_price'] = 'Le prix de base doit être un nombre positif.';
        }
        
        // Valider les étapes
        if (!isset($data['step_location']) || !is_array($data['step_location']) || count($data['step_location']) === 0) {
            $errors['steps'] = 'Au moins une étape est obligatoire.';
        } else {
            // Vérifier chaque étape
            foreach ($data['step_location'] as $index => $location) {
                if (empty($location)) {
                    $errors['step_' . $index . '_location'] = 'Le lieu de l\'étape est obligatoire.';
                }
                
                if (empty($data['step_description'][$index])) {
                    $errors['step_' . $index . '_description'] = 'La description de l\'étape est obligatoire.';
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Traite les données d'options à partir du formulaire
     * 
     * @param array $data Données du formulaire
     * @return array Options formatées
     */
    private function processOptionData($data) {
        $options = [];
        
        if (isset($data['option_name']) && is_array($data['option_name'])) {
            foreach ($data['option_name'] as $index => $name) {
                if (!empty($name) && isset($data['option_price'][$index]) && is_numeric($data['option_price'][$index])) {
                    $options[] = [
                        'name' => $name,
                        'description' => $data['option_description'][$index] ?? '',
                        'price' => (float)$data['option_price'][$index],
                        'duration' => isset($data['option_duration'][$index]) && is_numeric($data['option_duration'][$index]) 
                            ? (int)$data['option_duration'][$index] 
                            : 0
                    ];
                }
            }
        }
        
        return $options;
    }
    
    /**
     * Traite les données d'étapes à partir du formulaire
     * 
     * @param array $data Données du formulaire
     * @return array Étapes formatées
     */
    private function processStepData($data) {
        $steps = [];
        
        if (isset($data['step_location']) && is_array($data['step_location'])) {
            foreach ($data['step_location'] as $index => $location) {
                if (!empty($location)) {
                    $steps[] = [
                        'location' => $location,
                        'description' => $data['step_description'][$index] ?? '',
                        'image' => $data['step_image'][$index] ?? '',
                        'order' => $index + 1
                    ];
                }
            }
        }
        
        return $steps;
    }
}
?> 