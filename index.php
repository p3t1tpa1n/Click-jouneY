<?php
$pageTitle = 'Accueil';
require_once 'includes/header.php';

// Récupérer les voyages récents
$recentTrips = Trip::getRecent(6);
$tripSummaries = [];

foreach ($recentTrips as $trip) {
    $tripSummaries[] = getTripSummary($trip);
}
?>

<section class="welcome">
  <h2>Bienvenue sur Route 66 Odyssey</h2>
  <p>
    Découvrez nos circuits de voyage aux États-Unis, spécialement conçus 
    autour de la mythique Route 66. Personnalisez chaque étape en choisissant 
    hébergements, transports et activités. Préparez-vous à vivre l'aventure 
    américaine !
  </p>
</section>

<section class="featured-trips">
  <h2>Nos voyages à la une</h2>
  <div class="trip-grid">
    <?php foreach ($tripSummaries as $trip): ?>
      <div class="trip-card">
        <img src="<?= $trip['image'] ?>" alt="<?= htmlspecialchars($trip['title']) ?>">
        <div class="trip-info">
          <h3><?= htmlspecialchars($trip['title']) ?></h3>
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
  <div class="cta-container">
    <a href="recherche.php" class="btn btn-large">Voir tous nos voyages</a>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?> 