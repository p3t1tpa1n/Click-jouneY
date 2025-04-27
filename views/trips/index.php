<?php
/**
 * Vue pour l'affichage de la liste des voyages
 * 
 * Cette page affiche les voyages disponibles avec une barre de recherche et des filtres
 */
?>

<section class="search-hero">
    <div class="search-overlay"></div>
    <div class="container">
        <div class="search-hero-content">
            <h1><?= $title ?></h1>
            <p>Découvrez nos circuits personnalisés sur la mythique Route 66</p>
        </div>
    </div>
</section>

<section class="search-section py-5">
    <div class="container">
        <!-- Barre de recherche avancée -->
        <div class="search-box mb-5">
            <form action="index.php" method="GET" id="search-form">
                <input type="hidden" name="route" value="trips">
                
                <div class="search-tabs-container">
                    <ul class="nav nav-tabs search-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="simple-search-tab" data-bs-toggle="tab" data-bs-target="#simple-search-panel" type="button" role="tab" aria-controls="simple-search-panel" aria-selected="true">
                                <i class="fas fa-search"></i> Recherche simple
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="advanced-search-tab" data-bs-toggle="tab" data-bs-target="#advanced-search-panel" type="button" role="tab" aria-controls="advanced-search-panel" aria-selected="false">
                                <i class="fas fa-sliders-h"></i> Filtres avancés
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="search-body">
                    <div class="tab-content">
                        <!-- Recherche simple -->
                        <div class="tab-pane fade show active" id="simple-search-panel" role="tabpanel" aria-labelledby="simple-search-tab">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <div class="input-with-icon">
                                        <i class="fas fa-route"></i>
                                        <input type="text" class="form-control form-control-lg" id="query-simple" name="query" value="<?= htmlspecialchars($query) ?>" placeholder="Où souhaitez-vous voyager sur la Route 66 ?">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-search me-2"></i>Rechercher
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recherche avancée -->
                        <div class="tab-pane fade" id="advanced-search-panel" role="tabpanel" aria-labelledby="advanced-search-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="query-advanced" class="form-label">Mots-clés</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="form-control" id="query-advanced" placeholder="Chicago, Grand Canyon, désert..." value="<?= htmlspecialchars($query) ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="region" class="form-label">Région</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <select class="form-select" id="region" name="region">
                                            <option value="">Toutes les régions</option>
                                            <?php foreach ($regions as $r): ?>
                                            <option value="<?= htmlspecialchars($r) ?>" <?= $region == $r ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($r) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Prix</label>
                                    <div class="price-range-container">
                                        <div id="price-range-slider"></div>
                                        <div class="price-inputs mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">€</span>
                                                <input type="number" class="form-control" id="min-price" name="min_price" value="<?= $minPrice ?>" placeholder="Min">
                                            </div>
                                            <div class="price-separator">-</div>
                                            <div class="input-group">
                                                <span class="input-group-text">€</span>
                                                <input type="number" class="form-control" id="max-price" name="max_price" value="<?= $maxPrice ?>" placeholder="Max">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 d-flex justify-content-end mt-4">
                                    <a href="index.php?route=trips" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-redo me-1"></i>Réinitialiser
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-2"></i>Filtrer les résultats
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <?php if (empty($trips)): ?>
        <div class="no-results text-center py-5">
            <div class="no-results-icon mb-3">
                <i class="fas fa-search"></i>
            </div>
            <h2 class="h4 mb-3">Aucun voyage ne correspond à votre recherche</h2>
            <p class="text-muted">Essayez d'autres critères ou parcourez tous nos voyages ci-dessous.</p>
            <a href="index.php?route=trips" class="btn btn-outline-primary mt-3">
                <i class="fas fa-redo me-2"></i>Voir tous les voyages
            </a>
        </div>
        <?php else: ?>
        
        <!-- Résultats de recherche -->
        <div class="search-results">
            <div class="search-results-header d-flex justify-content-between align-items-center mb-4">
                <div class="results-count">
                    <h2 class="h5 mb-0"><?= count($trips) ?> voyage(s) trouvé(s)</h2>
                </div>
                <div class="results-sort">
                    <select class="form-select" id="sort-results">
                        <option value="price-asc">Prix croissant</option>
                        <option value="price-desc">Prix décroissant</option>
                        <option value="duration-asc">Durée croissante</option>
                        <option value="duration-desc">Durée décroissante</option>
                    </select>
                </div>
            </div>
            
            <div class="trips-grid">
                <?php foreach ($trips as $trip): ?>
                <div class="trip-card" data-price="<?= $trip['price'] ?? 0 ?>" data-duration="<?= isset($trip['duration']) ? $trip['duration'] : 0 ?>">
                    <div class="trip-image">
                        <?php
                        // Vérifier si l'image existe réellement sur le serveur
                        $imageExists = isset($trip['main_image']) && file_exists('images/trips/' . $trip['main_image']);
                        $imagePath = $imageExists 
                                    ? 'images/trips/' . htmlspecialchars($trip['main_image'])
                                    : 'images/backgrounds/route66-hero.jpg';
                        ?>
                        <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= htmlspecialchars($trip['title'] ?? 'Voyage Route 66') ?>">
                        
                        <div class="trip-badges">
                            <?php if (isset($trip['region'])): ?>
                            <span class="badge bg-info"><?= htmlspecialchars($trip['region']) ?></span>
                            <?php endif; ?>
                            
                            <?php if (isset($trip['duration'])): ?>
                            <span class="badge bg-secondary">
                                <i class="far fa-clock me-1"></i><?= $trip['duration'] ?> jours
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="trip-content">
                        <h3 class="trip-title"><?= htmlspecialchars($trip['title'] ?? 'Circuit Route 66') ?></h3>
                        <div class="trip-highlights">
                            <?php 
                            // Générer quelques points forts aléatoires
                            $highlights = [
                                '<i class="fas fa-map-marker-alt"></i> Étapes emblématiques',
                                '<i class="fas fa-hotel"></i> Hôtels authentiques',
                                '<i class="fas fa-camera"></i> Spots photos uniques',
                                '<i class="fas fa-utensils"></i> Diners typiques',
                                '<i class="fas fa-car"></i> Location de véhicule',
                                '<i class="fas fa-mountain"></i> Paysages variés',
                                '<i class="fas fa-monument"></i> Sites historiques'
                            ];
                            shuffle($highlights);
                            $selectedHighlights = array_slice($highlights, 0, 3);
                            ?>
                            
                            <ul class="trip-features">
                                <?php foreach ($selectedHighlights as $highlight): ?>
                                <li><?= $highlight ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <p class="trip-description"><?= htmlspecialchars(substr($trip['description'] ?? 'Découvrez ce circuit étonnant à travers l\'Amérique', 0, 120)) ?>...</p>
                        
                        <div class="trip-footer">
                            <div class="trip-price">
                                <span class="price-label">À partir de</span>
                                <span class="price-value"><?= number_format($trip['price'] ?? 0, 0, ',', ' ') ?> €</span>
                            </div>
                            <a href="index.php?route=trip&id=<?= $trip['id'] ?? 0 ?>" class="btn btn-primary">
                                Voir le détail
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($pagination['total_pages'] > 1): ?>
            <nav aria-label="Pagination" class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php if ($pagination['current_page'] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?route=trips&page=<?= $pagination['current_page'] - 1 ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            <i class="fas fa-chevron-left"></i> Précédent
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-chevron-left"></i> Précédent</span>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++): ?>
                    <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?route=trips&page=<?= $i ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?route=trips&page=<?= $pagination['current_page'] + 1 ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            Suivant <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Suivant <i class="fas fa-chevron-right"></i></span>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Styles pour la section hero de recherche */
.search-hero {
    position: relative;
    background-image: url('../images/backgrounds/route66-hero.jpg');
    background-size: cover;
    background-position: center;
    padding: 4rem 0;
    text-align: center;
    color: #fff;
    margin-bottom: 0;
}

.search-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.search-hero-content {
    position: relative;
    z-index: 10;
}

.search-hero h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.search-hero p {
    font-size: 1.2rem;
    max-width: 700px;
    margin: 0 auto;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

/* Barre de recherche améliorée */
.search-box {
    margin-top: -70px;
    position: relative;
    z-index: 20;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.search-tabs-container {
    padding: 0 20px;
}

.search-tabs {
    border-bottom: none;
    padding-top: 15px;
}

.search-tabs .nav-link {
    border: none;
    color: var(--gris-vintage);
    padding: 12px 20px;
    font-weight: 500;
}

.search-tabs .nav-link.active {
    color: var(--rouge-vintage);
    background-color: transparent;
    border-bottom: 2px solid var(--rouge-vintage);
}

.search-tabs .nav-link i {
    margin-right: 5px;
}

.search-body {
    padding: 20px;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gris-vintage);
    font-size: 1.1rem;
}

.input-with-icon input,
.input-with-icon select {
    padding-left: 45px;
}

.price-range-container {
    padding: 0 10px;
}

.price-inputs {
    display: flex;
    align-items: center;
    gap: 10px;
}

.price-separator {
    color: var(--gris-vintage);
    font-weight: bold;
}

/* Cartes de voyage améliorées */
.trips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin: 2rem 0;
}

.trip-card {
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.trip-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
}

.trip-image {
    height: 220px;
    position: relative;
    overflow: hidden;
}

.trip-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.trip-card:hover .trip-image img {
    transform: scale(1.1);
}

.trip-badges {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    align-items: flex-end;
}

.trip-badges .badge {
    padding: 6px 10px;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
}

.trip-content {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.trip-title {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: var(--rouge-vintage);
}

.trip-features {
    list-style: none;
    padding: 0;
    margin: 0 0 15px 0;
}

.trip-features li {
    padding: 6px 0;
    color: var(--gris-vintage);
    font-size: 0.9rem;
}

.trip-features i {
    color: var(--rouge-vintage);
    margin-right: 8px;
    width: 18px;
    text-align: center;
}

.trip-description {
    color: var(--gris-vintage);
    margin-bottom: 20px;
    flex-grow: 1;
}

.trip-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.trip-price {
    display: flex;
    flex-direction: column;
}

.price-label {
    font-size: 0.8rem;
    color: var(--gris-vintage);
}

.price-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--rouge-vintage);
}

/* Aucun résultat */
.no-results {
    background-color: #fff;
    border-radius: 10px;
    padding: 50px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.no-results-icon {
    font-size: 4rem;
    color: var(--beige-fonce);
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .trips-grid {
        grid-template-columns: 1fr;
    }
    
    .search-hero {
        padding: 3rem 0;
    }
    
    .search-hero h1 {
        font-size: 2rem;
    }
    
    .search-box {
        margin-top: -50px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Synchroniser les onglets de recherche
    document.getElementById('query-simple').addEventListener('input', function() {
        document.getElementById('query-advanced').value = this.value;
    });
    
    document.getElementById('query-advanced').addEventListener('input', function() {
        document.getElementById('query-simple').value = this.value;
    });
    
    // Tri des résultats
    const sortSelect = document.getElementById('sort-results');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const tripCards = Array.from(document.querySelectorAll('.trip-card'));
            const tripsGrid = document.querySelector('.trips-grid');
            
            // Trier les cartes
            tripCards.sort(function(a, b) {
                const aPrice = parseFloat(a.dataset.price);
                const bPrice = parseFloat(b.dataset.price);
                const aDuration = parseInt(a.dataset.duration);
                const bDuration = parseInt(b.dataset.duration);
                
                switch (sortSelect.value) {
                    case 'price-asc':
                        return aPrice - bPrice;
                    case 'price-desc':
                        return bPrice - aPrice;
                    case 'duration-asc':
                        return aDuration - bDuration;
                    case 'duration-desc':
                        return bDuration - aDuration;
                    default:
                        return 0;
                }
            });
            
            // Vider la grille et ajouter les cartes triées
            tripsGrid.innerHTML = '';
            tripCards.forEach(function(card) {
                tripsGrid.appendChild(card);
            });
        });
    }
});
</script> 