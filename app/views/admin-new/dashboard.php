<?php
/**
 * Vue du tableau de bord d'administration
 * 
 * Cette vue affiche les statistiques et informations principales
 * du tableau de bord administrateur
 */
?>

<div class="container mt-4">
    <h1 class="mb-4">Tableau de bord</h1>

    <!-- Statistiques globales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Utilisateurs</h5>
                    <h2 class="display-4"><?= $statistics['total_users'] ?? 0 ?></h2>
                    <p class="card-text">Utilisateurs inscrits</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Voyages</h5>
                    <h2 class="display-4"><?= $statistics['total_trips'] ?? 0 ?></h2>
                    <p class="card-text">Voyages disponibles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Réservations</h5>
                    <h2 class="display-4"><?= $statistics['total_payments'] ?? 0 ?></h2>
                    <p class="card-text">Réservations totales</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Revenus</h5>
                    <h2 class="display-4"><?= number_format($statistics['total_revenue'] ?? 0, 0, ',', ' ') ?> €</h2>
                    <p class="card-text">Revenus totaux</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Derniers utilisateurs -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Derniers utilisateurs inscrits</h5>
                    <a href="admin.php?action=users" class="btn btn-sm btn-outline-primary">Voir tous</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if (!empty($recentUsers)): ?>
                            <?php foreach ($recentUsers as $user): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0"><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></h6>
                                            <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                                        </div>
                                        <a href="admin.php?action=view-user&login=<?= urlencode($user['login']) ?>" class="btn btn-sm btn-outline-secondary">Détails</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item">
                                <p class="mb-0 text-muted">Aucun utilisateur récent.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dernières réservations -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dernières réservations</h5>
                    <a href="admin.php?action=payments" class="btn btn-sm btn-outline-primary">Voir toutes</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if (!empty($recentPayments)): ?>
                            <?php foreach ($recentPayments as $payment): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Réservation #<?= $payment['id'] ?></h6>
                                            <small class="text-muted">
                                                <?= isset($payment['user_id']) ? htmlspecialchars($payment['user_id']) : 'Utilisateur inconnu' ?> - 
                                                <?= isset($payment['amount']) ? number_format($payment['amount'], 2, ',', ' ') . ' €' : 'Montant non défini' ?>
                                            </small>
                                        </div>
                                        <span class="badge bg-success">Payé</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item">
                                <p class="mb-0 text-muted">Aucune réservation récente.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 