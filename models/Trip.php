<?php
require_once __DIR__ . '/../includes/JsonDataManager.php';

class Trip {
    
    /**
     * Obtenir tous les voyages
     * @return array Liste des voyages
     */
    public static function getAll() {
        return JsonDataManager::getTrips();
    }
    
    /**
     * Obtenir un voyage par son ID
     * @param int $id ID du voyage
     * @return array|null Données du voyage
     */
    public static function getById($id) {
        return JsonDataManager::getTripById($id);
    }
    
    /**
     * Calculer le prix total d'un voyage avec les options sélectionnées
     * @param array $trip Données du voyage
     * @param array $selectedOptions IDs des options sélectionnées
     * @return float Prix total
     */
    public static function calculateTotalPrice($trip, $selectedOptions) {
        $totalPrice = $trip['price'];
        
        foreach ($trip['options'] as $option) {
            if (in_array($option['id'], $selectedOptions)) {
                $totalPrice += $option['price'];
            }
        }
        
        return $totalPrice;
    }
    
    /**
     * Rechercher des voyages
     * @param string $query Terme de recherche
     * @return array Voyages correspondants
     */
    public static function search($query) {
        $trips = self::getAll();
        $results = [];
        
        $query = strtolower($query);
        
        foreach ($trips as $trip) {
            if (strpos(strtolower($trip['title']), $query) !== false ||
                strpos(strtolower($trip['description']), $query) !== false) {
                $results[] = $trip;
            }
        }
        
        return $results;
    }
    
    /**
     * Obtenir les voyages récents
     * @param int $limit Nombre maximum de voyages à retourner
     * @return array Voyages récents
     */
    public static function getRecent($limit = 3) {
        $trips = self::getAll();
        
        // Trier par date de début
        usort($trips, function($a, $b) {
            return strtotime($b['start_date']) - strtotime($a['start_date']);
        });
        
        return array_slice($trips, 0, $limit);
    }
    
    /**
     * Calcule la durée totale d'un voyage personnalisé
     * @param array $trip Données du voyage de base
     * @param array $selectedOptions Options sélectionnées par l'utilisateur
     * @return int Durée totale en jours
     */
    public static function calculateTotalDuration($trip, $selectedOptions) {
        $totalDuration = 0;
        
        foreach ($trip['steps'] as $step) {
            $stepId = $step['id'];
            $stepDuration = $step['default_duration'];
            
            // Ajuster la durée en fonction des options de transport choisies
            if (isset($selectedOptions[$stepId]['transport'])) {
                foreach ($step['options']['transport'] as $transport) {
                    if ($transport['id'] == $selectedOptions[$stepId]['transport']) {
                        // Calculer le temps de transport en fonction de la distance et de la vitesse moyenne
                        $stepDuration = $step['default_duration'];
                        if (isset($transport['average_speed']) && isset($step['distance_to_next'])) {
                            $travelTime = $step['distance_to_next'] / $transport['average_speed'];
                            // Convertir en jours (en supposant 8 heures de voyage par jour)
                            $travelDays = ceil($travelTime / 8);
                            // Ajuster la durée
                            $stepDuration += $travelDays;
                        }
                        break;
                    }
                }
            }
            
            $totalDuration += $stepDuration;
        }
        
        return $totalDuration;
    }
    
    /**
     * Enregistre tous les voyages dans le fichier
     * @param array $trips Liste des voyages
     * @return bool True si succès, false si échec
     */
    private static function saveAll($trips) {
        // Créer le répertoire si nécessaire
        $dir = dirname(TRIPS_FILE);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $data = json_encode($trips, JSON_PRETTY_PRINT);
        return file_put_contents(TRIPS_FILE, $data) !== false;
    }
    
    /**
     * Initialise les voyages par défaut si aucun n'existe
     */
    public static function initDefaultTrips() {
        if (file_exists(TRIPS_FILE)) {
            $trips = self::getAll();
            if (!empty($trips)) {
                return; // Des voyages existent déjà
            }
        }
        
        $defaultTrips = [];
        
        // Voyage 1: Route 66 Classique
        $defaultTrips[] = [
            'id' => 1,
            'title' => 'Route 66 Classique',
            'description' => 'Le parcours mythique de Chicago à Los Angeles sur la Route 66, découvrez les paysages américains légendaires.',
            'created_at' => date('Y-m-d H:i:s', strtotime('-30 days')),
            'start_date' => '2024-06-15',
            'end_date' => '2024-06-29',
            'default_duration' => 15,
            'base_price' => 2500,
            'participants' => 2,
            'steps' => [
                [
                    'id' => 1,
                    'title' => 'Chicago - Départ',
                    'location' => 'Chicago, Illinois',
                    'gps' => ['lat' => 41.8781, 'lng' => -87.6298],
                    'arrival_date' => '2024-06-15',
                    'departure_date' => '2024-06-17',
                    'default_duration' => 2,
                    'distance_to_next' => 480,
                    'options' => [
                        'accommodation' => [
                            ['id' => 1, 'name' => 'Hôtel Standard', 'description' => 'Chambre double standard', 'price_per_person' => 80, 'default' => true],
                            ['id' => 2, 'name' => 'Hôtel Luxe', 'description' => 'Suite avec vue sur la ville', 'price_per_person' => 150, 'default' => false],
                            ['id' => 3, 'name' => 'Auberge de jeunesse', 'description' => 'Ambiance conviviale et économique', 'price_per_person' => 40, 'default' => false]
                        ],
                        'meals' => [
                            ['id' => 1, 'name' => 'Petit-déjeuner uniquement', 'description' => 'Continental', 'price_per_person' => 15, 'default' => false],
                            ['id' => 2, 'name' => 'Demi-pension', 'description' => 'Petit-déjeuner et dîner', 'price_per_person' => 40, 'default' => true],
                            ['id' => 3, 'name' => 'Pension complète', 'description' => 'Tous les repas inclus', 'price_per_person' => 70, 'default' => false]
                        ],
                        'activities' => [
                            ['id' => 1, 'name' => 'Visite architecturale', 'description' => 'Tour guidé des gratte-ciels', 'price_per_person' => 35, 'default' => true],
                            ['id' => 2, 'name' => 'Croisière sur le lac Michigan', 'description' => '2h de croisière panoramique', 'price_per_person' => 60, 'default' => false],
                            ['id' => 3, 'name' => 'Soirée Jazz', 'description' => 'Concert dans un club historique', 'price_per_person' => 45, 'default' => false]
                        ],
                        'transport' => [
                            ['id' => 1, 'name' => 'Voiture de location', 'description' => 'Berline standard', 'price_per_person' => 50, 'average_speed' => 80, 'default' => true],
                            ['id' => 2, 'name' => 'Moto Harley Davidson', 'description' => 'La Route 66 en Harley', 'price_per_person' => 120, 'average_speed' => 70, 'default' => false],
                            ['id' => 3, 'name' => 'Van aménagé', 'description' => 'Parfait pour couples ou petits groupes', 'price_per_person' => 80, 'average_speed' => 75, 'default' => false]
                        ]
                    ]
                ],
                [
                    'id' => 2,
                    'title' => 'Saint Louis',
                    'location' => 'Saint Louis, Missouri',
                    'gps' => ['lat' => 38.6270, 'lng' => -90.1994],
                    'arrival_date' => '2024-06-17',
                    'departure_date' => '2024-06-19',
                    'default_duration' => 2,
                    'distance_to_next' => 320,
                    'options' => [
                        'accommodation' => [
                            ['id' => 1, 'name' => 'Hôtel Standard', 'description' => 'Chambre double standard', 'price_per_person' => 75, 'default' => true],
                            ['id' => 2, 'name' => 'Bed & Breakfast', 'description' => 'Charme local et authenticité', 'price_per_person' => 85, 'default' => false]
                        ],
                        'meals' => [
                            ['id' => 1, 'name' => 'Petit-déjeuner uniquement', 'description' => 'Continental', 'price_per_person' => 15, 'default' => false],
                            ['id' => 2, 'name' => 'Demi-pension', 'description' => 'Petit-déjeuner et dîner', 'price_per_person' => 35, 'default' => true]
                        ],
                        'activities' => [
                            ['id' => 1, 'name' => 'Gateway Arch', 'description' => 'Visite du monument emblématique', 'price_per_person' => 20, 'default' => true],
                            ['id' => 2, 'name' => 'Anheuser-Busch Brewery', 'description' => 'Tour de la brasserie avec dégustation', 'price_per_person' => 30, 'default' => false]
                        ],
                        'transport' => [
                            ['id' => 1, 'name' => 'Continuation location', 'description' => 'Même véhicule que précédemment', 'price_per_person' => 0, 'average_speed' => 80, 'default' => true],
                            ['id' => 2, 'name' => 'Changement véhicule', 'description' => 'Option pour changer de véhicule', 'price_per_person' => 30, 'average_speed' => 80, 'default' => false]
                        ]
                    ]
                ],
                [
                    'id' => 3,
                    'title' => 'Oklahoma City',
                    'location' => 'Oklahoma City, Oklahoma',
                    'gps' => ['lat' => 35.4676, 'lng' => -97.5164],
                    'arrival_date' => '2024-06-19',
                    'departure_date' => '2024-06-21',
                    'default_duration' => 2,
                    'distance_to_next' => 410,
                    'options' => [
                        'accommodation' => [
                            ['id' => 1, 'name' => 'Hôtel Standard', 'description' => 'Chambre double standard', 'price_per_person' => 70, 'default' => true],
                            ['id' => 2, 'name' => 'Ranch', 'description' => 'Expérience western authentique', 'price_per_person' => 90, 'default' => false]
                        ],
                        'meals' => [
                            ['id' => 1, 'name' => 'Petit-déjeuner uniquement', 'description' => 'Continental', 'price_per_person' => 15, 'default' => false],
                            ['id' => 2, 'name' => 'Demi-pension', 'description' => 'Petit-déjeuner et dîner', 'price_per_person' => 35, 'default' => true]
                        ],
                        'activities' => [
                            ['id' => 1, 'name' => 'Musée National Cowboy', 'description' => 'Immersion dans la culture western', 'price_per_person' => 25, 'default' => true],
                            ['id' => 2, 'name' => 'Oklahoma City Memorial', 'description' => 'Visite guidée', 'price_per_person' => 15, 'default' => false]
                        ],
                        'transport' => [
                            ['id' => 1, 'name' => 'Continuation location', 'description' => 'Même véhicule que précédemment', 'price_per_person' => 0, 'average_speed' => 80, 'default' => true],
                            ['id' => 2, 'name' => 'Changement véhicule', 'description' => 'Option pour changer de véhicule', 'price_per_person' => 30, 'average_speed' => 80, 'default' => false]
                        ]
                    ]
                ]
            ]
        ];
        
        // Voyage 2: Ouest Américain
        $defaultTrips[] = [
            'id' => 2,
            'title' => 'Ouest Américain - Parcs Nationaux',
            'description' => 'Découvrez les plus beaux parcs nationaux de l\'Ouest américain, des paysages à couper le souffle.',
            'created_at' => date('Y-m-d H:i:s', strtotime('-25 days')),
            'start_date' => '2024-07-10',
            'end_date' => '2024-07-24',
            'default_duration' => 14,
            'base_price' => 3200,
            'participants' => 2,
            'steps' => [
                [
                    'id' => 1,
                    'title' => 'Las Vegas - Départ',
                    'location' => 'Las Vegas, Nevada',
                    'gps' => ['lat' => 36.1699, 'lng' => -115.1398],
                    'arrival_date' => '2024-07-10',
                    'departure_date' => '2024-07-12',
                    'default_duration' => 2,
                    'distance_to_next' => 450,
                    'options' => [
                        'accommodation' => [
                            ['id' => 1, 'name' => 'Hôtel Casino standard', 'description' => 'Sur le Strip', 'price_per_person' => 90, 'default' => true],
                            ['id' => 2, 'name' => 'Hôtel de luxe', 'description' => 'Suite avec vue panoramique', 'price_per_person' => 180, 'default' => false]
                        ],
                        'meals' => [
                            ['id' => 1, 'name' => 'Petit-déjeuner uniquement', 'description' => 'Buffet américain', 'price_per_person' => 20, 'default' => true],
                            ['id' => 2, 'name' => 'Demi-pension', 'description' => 'Petit-déjeuner et dîner', 'price_per_person' => 60, 'default' => false]
                        ],
                        'activities' => [
                            ['id' => 1, 'name' => 'Spectacle de cirque', 'description' => 'Show international renommé', 'price_per_person' => 120, 'default' => false],
                            ['id' => 2, 'name' => 'Survol en hélicoptère', 'description' => 'Vue aérienne de Las Vegas', 'price_per_person' => 250, 'default' => false]
                        ],
                        'transport' => [
                            ['id' => 1, 'name' => 'SUV de location', 'description' => 'Idéal pour les parcs nationaux', 'price_per_person' => 60, 'average_speed' => 85, 'default' => true],
                            ['id' => 2, 'name' => '4x4 tout-terrain', 'description' => 'Pour les chemins difficiles', 'price_per_person' => 95, 'average_speed' => 75, 'default' => false]
                        ]
                    ]
                ]
            ]
        ];
        
        // On ajoute d'autres voyages similaires pour atteindre 15 voyages
        for ($i = 3; $i <= 15; $i++) {
            $destinations = [
                'Californie Côtière', 'Floride Ensoleillée', 'Nouvelle-Angleterre', 
                'Alaska Sauvage', 'Hawaii Paradisiaque', 'Texas Authentique',
                'Louisiane et Jazz', 'Grands Lacs', 'Rocheuses Majestueuses',
                'New York City', 'Washington DC', 'Seattle et Nord-Ouest',
                'Arizona et Grand Canyon'
            ];
            
            $idx = $i - 3;
            
            $defaultTrips[] = [
                'id' => $i,
                'title' => $destinations[$idx],
                'description' => 'Découvrez les merveilles de ' . $destinations[$idx] . ' lors d\'un voyage personnalisable.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . (20 - $idx) . ' days')),
                'start_date' => date('Y-m-d', strtotime('+' . (30 + $idx * 7) . ' days')),
                'end_date' => date('Y-m-d', strtotime('+' . (30 + $idx * 7 + 14) . ' days')),
                'default_duration' => 14,
                'base_price' => 2800 + ($idx * 200),
                'participants' => 2,
                'steps' => [
                    [
                        'id' => 1,
                        'title' => 'Étape initiale',
                        'location' => 'Ville principale, ' . $destinations[$idx],
                        'gps' => ['lat' => 35 + $idx/10, 'lng' => -100 + $idx],
                        'arrival_date' => date('Y-m-d', strtotime('+' . (30 + $idx * 7) . ' days')),
                        'departure_date' => date('Y-m-d', strtotime('+' . (32 + $idx * 7) . ' days')),
                        'default_duration' => 2,
                        'distance_to_next' => 300 + ($idx * 10),
                        'options' => [
                            'accommodation' => [
                                ['id' => 1, 'name' => 'Hôtel Standard', 'description' => 'Chambre double standard', 'price_per_person' => 75 + $idx, 'default' => true],
                                ['id' => 2, 'name' => 'Hôtel Luxe', 'description' => 'Suite de luxe', 'price_per_person' => 150 + $idx * 2, 'default' => false]
                            ],
                            'meals' => [
                                ['id' => 1, 'name' => 'Petit-déjeuner uniquement', 'description' => 'Continental', 'price_per_person' => 15, 'default' => false],
                                ['id' => 2, 'name' => 'Demi-pension', 'description' => 'Petit-déjeuner et dîner', 'price_per_person' => 40, 'default' => true]
                            ],
                            'activities' => [
                                ['id' => 1, 'name' => 'Visite culturelle', 'description' => 'Découverte des sites incontournables', 'price_per_person' => 30 + $idx, 'default' => true],
                                ['id' => 2, 'name' => 'Activité locale', 'description' => 'Expérience unique', 'price_per_person' => 50 + $idx, 'default' => false]
                            ],
                            'transport' => [
                                ['id' => 1, 'name' => 'Voiture de location', 'description' => 'Berline standard', 'price_per_person' => 50, 'average_speed' => 80, 'default' => true],
                                ['id' => 2, 'name' => 'Option premium', 'description' => 'Véhicule haut de gamme', 'price_per_person' => 90, 'average_speed' => 85, 'default' => false]
                            ]
                        ]
                    ],
                    [
                        'id' => 2,
                        'title' => 'Deuxième étape',
                        'location' => 'Seconde ville, ' . $destinations[$idx],
                        'gps' => ['lat' => 35.5 + $idx/10, 'lng' => -99 + $idx],
                        'arrival_date' => date('Y-m-d', strtotime('+' . (32 + $idx * 7) . ' days')),
                        'departure_date' => date('Y-m-d', strtotime('+' . (35 + $idx * 7) . ' days')),
                        'default_duration' => 3,
                        'distance_to_next' => 200 + ($idx * 5),
                        'options' => [
                            'accommodation' => [
                                ['id' => 1, 'name' => 'Hôtel Standard', 'description' => 'Chambre double standard', 'price_per_person' => 70 + $idx, 'default' => true],
                                ['id' => 2, 'name' => 'Option spéciale', 'description' => 'Hébergement typique', 'price_per_person' => 100 + $idx, 'default' => false]
                            ],
                            'meals' => [
                                ['id' => 1, 'name' => 'Petit-déjeuner uniquement', 'description' => 'Continental', 'price_per_person' => 15, 'default' => false],
                                ['id' => 2, 'name' => 'Demi-pension', 'description' => 'Petit-déjeuner et dîner', 'price_per_person' => 35, 'default' => true]
                            ],
                            'activities' => [
                                ['id' => 1, 'name' => 'Activité nature', 'description' => 'Exploration des environs', 'price_per_person' => 25 + $idx, 'default' => true],
                                ['id' => 2, 'name' => 'Expérience locale', 'description' => 'Immersion culturelle', 'price_per_person' => 40 + $idx, 'default' => false]
                            ],
                            'transport' => [
                                ['id' => 1, 'name' => 'Continuation location', 'description' => 'Même véhicule que précédemment', 'price_per_person' => 0, 'average_speed' => 80, 'default' => true],
                                ['id' => 2, 'name' => 'Changement véhicule', 'description' => 'Option pour changer de véhicule', 'price_per_person' => 30, 'average_speed' => 80, 'default' => false]
                            ]
                        ]
                    ]
                ]
            ];
        }
        
        self::saveAll($defaultTrips);
    }
}
?> 