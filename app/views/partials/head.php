<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?>Click-JourneY</title>
    <meta name="description" content="<?= isset($pageDescription) ? htmlspecialchars($pageDescription) : 'Voyagez sur la Route 66 avec Click-JourneY, votre partenaire de confiance pour une aventure inoubliable.' ?>">
    
    <!-- Favicon -->
    <link rel="icon" href="<?= BASE_URL ?>/public/assets/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>/public/assets/images/apple-touch-icon.png">
    
    <!-- CSS Styles -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
    
    <!-- Theme Stylesheets -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/theme-light.css" id="theme-light">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/theme-dark.css" id="theme-dark" disabled>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/theme-accessible.css" id="theme-accessible" disabled>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Page specific CSS (if exists) -->
    <?php if (isset($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/<?= $style ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Preload fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Meta Tags -->
    <meta property="og:title" content="<?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?>Click-JourneY">
    <meta property="og:description" content="<?= isset($pageDescription) ? htmlspecialchars($pageDescription) : 'Voyagez sur la Route 66 avec Click-JourneY, votre partenaire de confiance pour une aventure inoubliable.' ?>">
    <meta property="og:image" content="<?= BASE_URL ?>/public/assets/images/og-image.jpg">
    <meta property="og:url" content="<?= isset($_SERVER['REQUEST_URI']) ? htmlspecialchars($_SERVER['REQUEST_URI']) : '/' ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
</head>
<body>
<!-- Le reste du contenu sera inclus depuis d'autres fichiers partiels -->
</body>
</html> 