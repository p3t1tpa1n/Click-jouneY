<?php
require_once __DIR__ . '/init.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Route 66 Odyssey</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
  <h1>Route 66 Odyssey</h1>
  <nav>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="presentation.php">Présentation</a></li>
      <li><a href="recherche.php">Recherche</a></li>
      <?php if (!isLoggedIn()): ?>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="connexion.php">Connexion</a></li>
      <?php else: ?>
        <li><a href="profil.php">Profil</a></li>
        <?php if (isAdmin()): ?>
          <li><a href="admin.php">Administration</a></li>
        <?php endif; ?>
        <li><a href="deconnexion.php">Déconnexion</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main class="container">
  <?php if (isset($alertMessage)): ?>
    <div class="alert <?= isset($alertType) ? $alertType : 'info' ?>">
      <?= $alertMessage ?>
    </div>
  <?php endif; ?> 