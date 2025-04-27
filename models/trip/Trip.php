<?php

namespace models\trip;

use JsonDataManager;
use models\user\User;

/**
 * Modèle Trip
 */
class Trip {
    /**
     * Récupère tous les voyages
     */
    public static function getAll() {
        return JsonDataManager::getTrips();
    }
    
    /**
     * Récupère un voyage par son ID
     */
    public static function getById($id) {
        return JsonDataManager::getTripById($id);
    }
    
    /**
     * Crée un nouveau voyage
     */
    public static function create($tripData) {
        return JsonDataManager::createTrip($tripData);
    }
    
    /**
     * Met à jour un voyage existant
     */
    public static function update($id, $tripData) {
        return JsonDataManager::updateTrip($tripData);
    }
    
    /**
     * Supprime un voyage
     */
    public static function delete($id) {
        // Cette fonction dépend de l'implémentation de JsonDataManager
        $trips = self::getAll();
        
        // Trouver l'index du voyage à supprimer
        $index = null;
        foreach ($trips as $i => $trip) {
            if (isset($trip['id']) && $trip['id'] == $id) {
                $index = $i;
                break;
            }
        }
        
        if ($index !== null) {
            // Supprimer le voyage du tableau
            array_splice($trips, $index, 1);
            
            // Écrire les données mises à jour
            $result = file_put_contents(TRIPS_FILE, json_encode($trips, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $result !== false;
        }
        
        return false;
    }
    
    /**
     * Recherche des voyages par titre ou description
     */
    public static function search($params) {
        $trips = self::getAll();
        
        // Vérifier si $params est un tableau ou une chaîne
        if (is_array($params)) {
            $query = isset($params['query']) ? (string)$params['query'] : '';
            $region = isset($params['region']) ? (string)$params['region'] : '';
            $minPrice = isset($params['min_price']) ? (int)$params['min_price'] : 0;
            $maxPrice = isset($params['max_price']) ? (int)$params['max_price'] : PHP_INT_MAX;
        } else {
            $query = (string)$params;
            $region = '';
            $minPrice = 0;
            $maxPrice = PHP_INT_MAX;
        }
        
        $query = strtolower($query);
        
        // Filtrer les voyages selon les critères
        $filteredTrips = array_filter($trips, function($trip) use ($query, $region, $minPrice, $maxPrice) {
            // Filtrer par mots-clés (titre, description, étapes)
            $matchesQuery = empty($query) || 
                strpos(strtolower($trip['title'] ?? ''), $query) !== false ||
                strpos(strtolower($trip['description'] ?? ''), $query) !== false ||
                self::containsLocationMatch($trip, $query);
            
            // Filtrer par région
            $matchesRegion = empty($region) || (isset($trip['region']) && $trip['region'] === $region);
            
            // Filtrer par prix
            $price = isset($trip['price']) ? (float)$trip['price'] : 0;
            $matchesPrice = $price >= $minPrice && $price <= $maxPrice;
            
            // Le voyage doit correspondre à tous les critères
            return $matchesQuery && $matchesRegion && $matchesPrice;
        });
        
        // S'assurer que chaque voyage a une propriété main_image
        foreach ($filteredTrips as &$trip) {
            if (!isset($trip['main_image']) && isset($trip['images']) && !empty($trip['images'])) {
                $trip['main_image'] = $trip['images'][0];
            } elseif (!isset($trip['main_image'])) {
                $trip['main_image'] = 'default_trip.jpg';
            }
        }
        
        return $filteredTrips;
    }
    
    /**
     * Vérifie si les étapes du voyage contiennent le terme de recherche
     */
    private static function containsLocationMatch($trip, $query) {
        if (!isset($trip['steps']) || !is_array($trip['steps'])) {
            return false;
        }
        
        foreach ($trip['steps'] as $step) {
            if (isset($step['location']) && strpos(strtolower($step['location']), $query) !== false) {
                return true;
            }
            
            if (isset($step['description']) && strpos(strtolower($step['description']), $query) !== false) {
                return true;
            }
            
            // Vérifier également le titre de l'étape
            if (isset($step['title']) && strpos(strtolower($step['title']), $query) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Calcule le prix total d'un voyage avec options
     */
    public static function calculateTotalPrice($trip, $selectedOptions) {
        $totalPrice = $trip['base_price'];
        
        // Ajouter le prix des options sélectionnées
        if (isset($trip['options']) && is_array($trip['options'])) {
            foreach ($trip['options'] as $index => $option) {
                if (in_array($index, $selectedOptions)) {
                    $totalPrice += $option['price'];
                }
            }
        }
        
        return $totalPrice;
    }
    
    /**
     * Calcule la durée totale d'un voyage avec options
     */
    public static function calculateTotalDuration($trip, $selectedOptions) {
        $totalDuration = $trip['duration'];
        
        // Ajouter la durée des options sélectionnées
        if (isset($trip['options']) && is_array($trip['options'])) {
            foreach ($trip['options'] as $index => $option) {
                if (in_array($index, $selectedOptions) && isset($option['duration'])) {
                    $totalDuration += $option['duration'];
                }
            }
        }
        
        return $totalDuration;
    }
    
    /**
     * Récupère les voyages populaires (les plus consultés)
     */
    public static function getPopular($limit = 4) {
        $trips = self::getAll();
        
        // Si aucun voyage n'existe, retourner un tableau vide
        if (empty($trips)) {
            return [];
        }
        
        // On initialise un compteur de vues pour chaque voyage
        $viewCounts = [];
        foreach ($trips as $trip) {
            if (isset($trip['id'])) {
                $viewCounts[$trip['id']] = 0;
            }
        }
        
        // On essaie de récupérer les utilisateurs
        try {
            $users = User::getAll();
            
            // Compter les vues pour chaque voyage
            if (!empty($users)) {
                foreach ($trips as $trip) {
                    if (!isset($trip['id'])) {
                        continue;
                    }
                    foreach ($users as $user) {
                        if (isset($user['viewed_trips']) && in_array($trip['id'], $user['viewed_trips'])) {
                            $viewCounts[$trip['id']]++;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // En cas d'erreur, on continue avec les compteurs initialisés à 0
        }
        
        // Trier les voyages par nombre de vues (ou par défaut s'il n'y a pas de vues)
        usort($trips, function($a, $b) use ($viewCounts) {
            if (!isset($a['id']) || !isset($b['id'])) {
                return 0;
            }
            if ($viewCounts[$a['id']] == $viewCounts[$b['id']]) {
                // En cas d'égalité, on trie par ID décroissant (les plus récents en premier)
                return $b['id'] - $a['id'];
            }
            return $viewCounts[$b['id']] - $viewCounts[$a['id']];
        });
        
        // S'assurer que chaque voyage a une propriété main_image
        foreach ($trips as &$trip) {
            if (!isset($trip['main_image']) && isset($trip['images']) && !empty($trip['images'])) {
                $trip['main_image'] = $trip['images'][0];
            } elseif (!isset($trip['main_image'])) {
                $trip['main_image'] = 'default_trip.jpg';
            }
            
            // S'assurer que la propriété duration existe
            if (!isset($trip['duration']) && isset($trip['default_duration'])) {
                $trip['duration'] = $trip['default_duration'];
            } elseif (!isset($trip['duration'])) {
                $trip['duration'] = 0;
            }
        }
        
        // Limiter le nombre de voyages
        return array_slice($trips, 0, $limit);
    }
    
    /**
     * Compte le nombre de voyages correspondant aux critères
     */
    public static function count($params = []) {
        $results = self::search($params);
        return count($results);
    }
    
    /**
     * Récupère les régions disponibles
     */
    public static function getAvailableRegions() {
        $trips = self::getAll();
        $regions = [];
        
        foreach ($trips as $trip) {
            if (isset($trip['region']) && !in_array($trip['region'], $regions)) {
                $regions[] = $trip['region'];
            }
        }
        
        sort($regions);
        return $regions;
    }
    
    /**
     * Trouve un voyage par son ID
     */
    public static function findById($id) {
        return self::getById($id);
    }
    
    /**
     * Récupère des voyages similaires
     */
    public static function getSimilar($id, $limit = 3) {
        $currentTrip = self::getById($id);
        if (!$currentTrip) {
            return [];
        }
        
        $trips = self::getAll();
        
        // Filtrer et trier par similarité
        $similarTrips = [];
        foreach ($trips as $trip) {
            if (!isset($trip['id'])) {
                continue; // Ignorer les voyages sans ID
            }
            
            if ($trip['id'] == $id) {
                continue; // Exclure le voyage actuel
            }
            
            // Pour cette version simplifiée, on considère les voyages de la même région comme similaires
            if (isset($trip['region']) && isset($currentTrip['region']) && $trip['region'] === $currentTrip['region']) {
                $similarTrips[] = $trip;
            }
        }
        
        // Si pas assez de voyages dans la même région, ajouter d'autres voyages
        if (count($similarTrips) < $limit) {
            foreach ($trips as $trip) {
                if (!isset($trip['id'])) {
                    continue; // Ignorer les voyages sans ID
                }
                
                if ($trip['id'] == $id) {
                    continue; // Exclure le voyage actuel
                }
                
                if (!in_array($trip, $similarTrips)) {
                    $similarTrips[] = $trip;
                    if (count($similarTrips) >= $limit) {
                        break;
                    }
                }
            }
        }
        
        // Limiter le nombre de résultats
        return array_slice($similarTrips, 0, $limit);
    }
}
?> 