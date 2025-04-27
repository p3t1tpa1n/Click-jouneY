<?php
require_once 'includes/init.php';

// Détruire la session
session_unset();
session_destroy();

// Rediriger vers la page d'accueil
redirect('index.php');
?> 