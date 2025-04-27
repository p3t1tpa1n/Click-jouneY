<?php
$pageTitle = 'Mon Profil';
require_once 'includes/header.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

// Récupérer les informations de l'utilisateur
$user = User::getByLogin($_SESSION['user']['login']);

// Récupérer les voyages achetés par l'utilisateur
$purchasedTrips = [];
foreach ($user['purchased_trips'] as $tripId) {
    $trip = Trip::getById($tripId);
    if ($trip) {
        $purchasedTrips[] = getTripSummary($trip);
    }
}

// Pagination des voyages achetés
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$paginatedTrips = paginate($purchasedTrips, $page, 5);
?>

<section class="profile">
  <h2>Profil de <?= htmlspecialchars($user['name']) ?></h2>
  
  <div class="profile-details">
    <div class="profile-section">
      <h3>Mes informations</h3>
      <ul>
        <li><strong>Identifiant:</strong> <?= htmlspecialchars($user['login']) ?></li>
        <li><strong>Nom:</strong> <?= htmlspecialchars($user['name']) ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
        <li><strong>Date de naissance:</strong> <?= formatDate($user['birth_date']) ?></li>
        <li><strong>Adresse:</strong> <?= nl2br(htmlspecialchars($user['address'])) ?></li>
        <li><strong>Date d'inscription:</strong> <?= formatDate($user['registration_date']) ?></li>
        <li><strong>Dernière connexion:</strong> <?= formatDate($user['last_login']) ?></li>
      </ul>
    </div>
  </div>
  
  <div class="purchased-trips">
    <h3>Mes voyages achetés</h3>
    
    <?php if (empty($paginatedTrips['items'])): ?>
      <p class="no-trips">Vous n'avez pas encore acheté de voyage.</p>
    <?php else: ?>
      <div class="trip-list">
        <?php foreach ($paginatedTrips['items'] as $trip): ?>
          <div class="trip-item">
            <div class="trip-image">
              <img src="<?= $trip['image'] ?>" alt="<?= htmlspecialchars($trip['title']) ?>">
            </div>
            <div class="trip-details">
              <h4><?= htmlspecialchars($trip['title']) ?></h4>
              <p><?= htmlspecialchars(substr($trip['description'], 0, 150)) ?>...</p>
              <div class="trip-info">
                <span class="trip-duration"><?= $trip['duration'] ?> jours</span>
                <span class="trip-price"><?= formatPrice($trip['price']) ?></span>
              </div>
              <a href="voyage.php?id=<?= $trip['id'] ?>" class="btn">Voir le détail</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      
      <?php if ($paginatedTrips['pages'] > 1): ?>
        <?= paginationLinks('profil.php', $paginatedTrips) ?>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?> 