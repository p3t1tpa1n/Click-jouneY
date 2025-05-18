<?php
// app/views/cart.php
$this->setLayout('layout');
?>
<div class="container py-4">
  <h1 class="mb-4">Mon panier</h1>
  <?php if (empty($cart)): ?>
    <div class="alert alert-info">Votre panier est vide.</div>
  <?php else: ?>
    <table class="table table-bordered table-hover bg-white">
      <thead class="table-light">
        <tr>
          <th>Voyage</th>
          <th>Région</th>
          <th>Durée</th>
          <th>Prix</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Charger les infos des voyages depuis le modèle
        $trips = \models\trip\Trip::getAll();
        foreach ($cart as $tripId):
          $trip = null;
          foreach ($trips as $t) {
            if ($t['id'] == $tripId) {
              $trip = $t;
              break;
            }
          }
          if (!$trip) continue;
        ?>
        <tr>
          <td><a href="<?= BASE_URL ?>/trips/show/<?= $trip['id'] ?>"><?= htmlspecialchars($trip['title']) ?></a></td>
          <td><?= htmlspecialchars($trip['region'] ?? '-') ?></td>
          <td><?= htmlspecialchars($trip['duration'] ?? '-') ?> jours</td>
          <td><?= number_format($trip['price'], 2, ',', ' ') ?> €</td>
          <td>
            <form method="post" action="<?= BASE_URL ?>/cart/remove" style="display:inline;">
              <input type="hidden" name="trip_id" value="<?= $trip['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Retirer</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="text-end">
      <a href="<?= BASE_URL ?>/trips" class="btn btn-outline-primary">Ajouter d'autres voyages</a>
      <a href="<?= BASE_URL ?>/payment" class="btn btn-success">Passer au paiement</a>
    </div>
  <?php endif; ?>
</div> 