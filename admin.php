<?php
$pageTitle = 'Administration';
require_once 'includes/header.php';

// Vérifier si l'utilisateur est administrateur
requireAdmin();

// Récupérer tous les utilisateurs
$users = User::getAll();

// Pagination des utilisateurs
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$paginatedUsers = paginate($users, $page, 10);
?>

<section class="admin-panel">
  <h2>Administration - Gestion des utilisateurs</h2>
  
  <div class="user-list">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Identifiant</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Rôle</th>
          <th>Date d'inscription</th>
          <th>Dernière connexion</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($paginatedUsers['items'] as $index => $user): ?>
          <tr>
            <td><?= $index + 1 + (($page - 1) * 10) ?></td>
            <td><?= htmlspecialchars($user['login']) ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td>
              <span class="user-role <?= $user['role'] === 'admin' ? 'admin' : 'user' ?>">
                <?= $user['role'] === 'admin' ? 'Administrateur' : 'Utilisateur' ?>
              </span>
            </td>
            <td><?= formatDate($user['registration_date']) ?></td>
            <td><?= formatDate($user['last_login']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  
  <?php if ($paginatedUsers['pages'] > 1): ?>
    <?= paginationLinks('admin.php', $paginatedUsers) ?>
  <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?> 