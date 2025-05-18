<?php

namespace controllers\ajax;

use core\Controller;
use models\trip\Trip;

/**
 * Contrôleur pour gérer les requêtes AJAX
 */
class AjaxController extends Controller
{
    /**
     * Sauvegarde les sélections du récapitulatif dans la session
     */
    public function saveSelections()
    {
        // Vérifier si c'est bien une requête AJAX
        if (!$this->isAjaxRequest()) {
            $this->jsonResponse(['success' => false, 'error' => 'Requête non autorisée'], 403);
            return;
        }
        
        // Récupérer les données
        $tripId = isset($_POST['trip_id']) ? (int)$_POST['trip_id'] : 0;
        $nbTravelers = isset($_POST['nb_travelers']) ? (int)$_POST['nb_travelers'] : 1;
        $options = isset($_POST['options']) && is_array($_POST['options']) ? $_POST['options'] : [];
        
        // Valider l'ID du voyage
        if ($tripId <= 0) {
            $this->jsonResponse(['success' => false, 'error' => 'ID de voyage invalide'], 400);
            return;
        }
        
        // Sauvegarder dans la session
        if (!isset($_SESSION['recap_selections'])) {
            $_SESSION['recap_selections'] = [];
        }
        
        $_SESSION['recap_selections']['trip_' . $tripId] = [
            'nb_travelers' => $nbTravelers,
            'options' => $options,
            'last_update' => time()
        ];
        
        // Répondre avec succès
        $this->jsonResponse([
            'success' => true, 
            'message' => 'Sélections sauvegardées avec succès',
            'data' => [
                'trip_id' => $tripId,
                'nb_travelers' => $nbTravelers,
                'options' => $options
            ]
        ]);
    }
    
    /**
     * Vérifie si la requête est une requête AJAX
     * 
     * @return bool
     */
    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    /**
     * Envoie une réponse JSON
     * 
     * @param array $data Les données à encoder en JSON
     * @param int $statusCode Code HTTP
     */
    private function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
} 