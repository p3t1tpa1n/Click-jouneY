<?php
$pageTitle = 'Recherche de voyages';
require_once 'includes/header.php';

// Initialiser les variables
$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Récupérer les voyages correspondant à la recherche
$trips = [];
if (!empty($keywords)) {
    $trips = Trip::search($keywords);
} else {
    $trips = Trip::getAll();
}

// Convertir les voyages en résumés pour l'affichage
$tripSummaries = [];
foreach ($trips as $trip) {
    $tripSummaries[] = getTripSummary($trip);
}

// Paginer les résultats
$paginatedTrips = paginate($tripSummaries, $page, 6);
?>

<section class="search-section">
  <h2>Recherche de voyages</h2>
  
  <form action="recherche.php" method="get" class="search-form">
    <div class="form-group">
      <input type="text" name="keywords" placeholder="Rechercher par lieu, activité, etc." value="<?= htmlspecialchars($keywords) ?>">
      <button type="submit" class="btn">Rechercher</button>
    </div>
  </form>
  
  <div class="search-results">
    <?php if (!empty($keywords)): ?>
      <h3>Résultats pour "<?= htmlspecialchars($keywords) ?>"</h3>
      <?php if (empty($paginatedTrips['items'])): ?>
        <p class="no-results">Aucun voyage ne correspond à votre recherche.</p>
      <?php endif; ?>
    <?php else: ?>
      <h3>Tous nos voyages</h3>
    <?php endif; ?>
    
    <?php if (!empty($paginatedTrips['items'])): ?>
      <div class="trip-grid">
        <?php foreach ($paginatedTrips['items'] as $trip): ?>
          <div class="trip-card">
            <img src="<?= $trip['image'] ?>" alt="<?= htmlspecialchars($trip['title']) ?>">
            <div class="trip-info">
              <h4><?= htmlspecialchars($trip['title']) ?></h4>
              <p class="trip-description"><?= htmlspecialchars(substr($trip['description'], 0, 100)) ?>...</p>
              <div class="trip-details">
                <span class="trip-duration"><?= $trip['duration'] ?> jours</span>
                <span class="trip-price"><?= formatPrice($trip['price']) ?></span>
              </div>
              <a href="voyage.php?id=<?= $trip['id'] ?>" class="btn">Découvrir</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      
      <?php if ($paginatedTrips['pages'] > 1): ?>
        <?= paginationLinks('recherche.php' . (!empty($keywords) ? '?keywords=' . urlencode($keywords) . '&' : '?'), $paginatedTrips) ?>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?> 