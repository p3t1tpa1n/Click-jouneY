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

<section class="search-section">
    <div class="container">
        <!-- Recherche simple uniquement -->
        <div class="search-box mb-5">
            <form action="<?= BASE_URL ?>/index.php" method="GET" id="search-form">
                <input type="hidden" name="route" value="trips">
                
                <div class="search-form-content">
                    <div class="form-group">
                        <label for="query">Recherche par mots-clés</label>
                        <div class="input-with-icon">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control form-control-lg" id="query" name="query" value="<?= htmlspecialchars($query) ?>" placeholder="Où souhaitez-vous voyager sur la Route 66 ?">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="region">Région</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <select class="form-control" id="region" name="region">
                                    <option value="">Toutes les régions</option>
                                    <?php foreach ($regions as $r): ?>
                                    <option value="<?= htmlspecialchars($r) ?>" <?= $region == $r ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($r) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="min-price">Prix min</label>
                            <div class="input-with-icon">
                                <i class="fas fa-euro-sign"></i>
                                <input type="number" class="form-control" id="min-price" name="min_price" value="<?= $minPrice ?>" placeholder="0">
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="max-price">Prix max</label>
                            <div class="input-with-icon">
                                <i class="fas fa-euro-sign"></i>
                                <input type="number" class="form-control" id="max-price" name="max_price" value="<?= $maxPrice ?>" placeholder="10000">
                            </div>
                        </div>
                    </div>
                    
                    <div class="search-actions">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrer les résultats
                        </button>
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
                <i class="fas fa-redo"></i> Voir tous les voyages
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
                                <i class="far fa-clock"></i> <?= $trip['duration'] ?> jours
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
                                <span class="trip-price-prefix">À partir de</span><br>
                                <?= number_format($trip['price'] ?? 0, 2, ',', ' ') ?> €
                            </div>
                            <a href="<?= BASE_URL ?>/index.php?route=trip&id=<?= $trip['id'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-info-circle"></i> Détails
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
            <div class="pagination-container text-center mt-5">
                <ul class="pagination">
                    <?php if ($pagination['current_page'] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= BASE_URL ?>/index.php?route=trips&page=<?= $pagination['current_page'] - 1 ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            <i class="fas fa-chevron-left"></i> Précédent
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++): ?>
                    <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                        <a class="page-link" href="<?= BASE_URL ?>/index.php?route=trips&page=<?= $i ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= BASE_URL ?>/index.php?route=trips&page=<?= $pagination['current_page'] + 1 ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            Suivant <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
            
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Styles spécifiques à cette page */
.search-hero {
    background-image: url('<?= BASE_URL ?>/images/backgrounds/route66-hero.jpg');
    padding: 80px 0;
    position: relative;
}

.search-hero-content {
    position: relative;
    z-index: 2;
    color: white;
    text-align: center;
}

.search-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 1;
}

.search-section {
    padding: 50px 0;
}

.search-box {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin-top: -70px;
    position: relative;
    z-index: 10;
}

.search-form-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: flex;
    gap: 20px;
}

.form-group {
    flex: 1;
}

.form-control {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #777;
}

.search-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 10px;
}

.badge {
    display: inline-block;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 30px;
    margin-right: 5px;
}

.bg-info {
    background-color: #17a2b8;
    color: white;
}

.bg-secondary {
    background-color: #6c757d;
    color: white;
}

.trips-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 30px;
}

.trip-card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    background-color: white;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.trip-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

.trip-image {
    position: relative;
    height: 200px;
}

.trip-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.trip-badges {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.trip-content {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.trip-title {
    font-size: 20px;
    margin-bottom: 15px;
    font-weight: 700;
}

.trip-features {
    list-style: none;
    margin: 0 0 15px;
    padding: 0;
}

.trip-features li {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.trip-features li i {
    width: 25px;
    margin-right: 10px;
    color: #5e3bee;
}

.trip-description {
    color: #666;
    margin-bottom: 20px;
    line-height: 1.5;
}

.trip-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    border-top: 1px solid #eee;
    padding-top: 15px;
}

.trip-price {
    font-size: 22px;
    font-weight: 700;
    color: #5e3bee;
}

.trip-price-prefix {
    font-size: 12px;
    color: #777;
    font-weight: normal;
}

.pagination-container {
    margin-top: 30px;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 5px;
    list-style: none;
    padding: 0;
}

.page-item {
    display: inline-block;
}

.page-link {
    display: block;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    background-color: #f8f9fa;
    color: #5e3bee;
    transition: background-color 0.3s;
}

.page-item.active .page-link {
    background-color: #5e3bee;
    color: white;
}

.page-link:hover {
    background-color: #e9ecef;
}

.no-results {
    text-align: center;
    padding: 50px;
    background-color: #f8f9fa;
    border-radius: 10px;
}

.no-results-icon {
    font-size: 48px;
    color: #aaa;
    margin-bottom: 20px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tri des résultats de voyage
    const sortSelect = document.getElementById('sort-results');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const tripsGrid = document.querySelector('.trips-grid');
            if (!tripsGrid) return;
            
            const tripCards = Array.from(tripsGrid.querySelectorAll('.trip-card'));
            
            tripCards.sort((a, b) => {
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
            
            // Vider la grille et réinsérer les éléments triés
            tripsGrid.innerHTML = '';
            tripCards.forEach(card => tripsGrid.appendChild(card));
        });
    }
});
</script> 