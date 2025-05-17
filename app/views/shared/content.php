<?php if (isset($theme_elements) && $theme_elements): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Force application du thème sur les éléments de la page');
    
    // Obtenir le thème actuel
    const root = document.documentElement;
    let currentTheme = 'light'; // Thème par défaut
    
    if (root.classList.contains('theme-dark')) {
        currentTheme = 'dark';
    } else if (root.classList.contains('theme-accessible')) {
        currentTheme = 'accessible';
    }
    
    console.log('Thème actuel détecté:', currentTheme);
    
    // Forcer l'application du thème sur la section "pas de résultats"
    const noResults = document.querySelector('.no-results');
    if (noResults) {
        console.log('Force application des styles sur la section "pas de résultats"');
        
        // Force des couleurs en fonction du thème
        if (currentTheme === 'accessible') {
            noResults.style.backgroundColor = '#222222';
            noResults.style.color = '#ffffff';
            noResults.style.border = '3px solid #ffd700';
            
            // Styles pour l'icône
            const icon = noResults.querySelector('.no-results-icon i');
            if (icon) {
                icon.style.color = '#ffd700';
                icon.style.fontSize = '4em';
            }
            
            // Styles pour les textes
            const texts = noResults.querySelectorAll('h2, p');
            texts.forEach(text => {
                text.style.color = '#ffffff';
                text.style.fontWeight = 'bold';
            });
            
            // Styles pour le bouton
            const btn = noResults.querySelector('.btn');
            if (btn) {
                btn.style.backgroundColor = '#ffd700';
                btn.style.color = '#000000';
                btn.style.borderColor = '#ffd700';
                btn.style.fontWeight = 'bold';
                btn.style.fontSize = '1.2em';
                btn.style.padding = '12px 20px';
            }
        } else if (currentTheme === 'dark') {
            noResults.style.backgroundColor = '#32363c';
            noResults.style.color = '#e1e1e1';
            noResults.style.border = '1px solid #444';
            
            // Styles pour l'icône
            const icon = noResults.querySelector('.no-results-icon i');
            if (icon) {
                icon.style.color = '#6c94ff';
                icon.style.fontSize = '3em';
            }
            
            // Styles pour les textes
            const texts = noResults.querySelectorAll('h2, p');
            texts.forEach(text => {
                text.style.color = '#e1e1e1';
            });
            
            // Styles pour le bouton
            const btn = noResults.querySelector('.btn');
            if (btn) {
                btn.style.backgroundColor = '#6c94ff';
                btn.style.color = '#111';
                btn.style.borderColor = '#6c94ff';
            }
        } else {
            noResults.style.backgroundColor = '#f8f9fa';
            noResults.style.color = '#333333';
            noResults.style.border = '1px solid #dee2e6';
            
            // Styles pour l'icône
            const icon = noResults.querySelector('.no-results-icon i');
            if (icon) {
                icon.style.color = '#4169e1';
                icon.style.fontSize = '2.5em';
            }
            
            // Styles pour les textes
            const texts = noResults.querySelectorAll('h2, p');
            texts.forEach(text => {
                text.style.color = '#333333';
            });
            
            // Styles pour le bouton
            const btn = noResults.querySelector('.btn');
            if (btn) {
                btn.style.backgroundColor = 'transparent';
                btn.style.color = '#4169e1';
                btn.style.borderColor = '#4169e1';
            }
        }
        
        console.log('Styles forcés appliqués avec succès');
    }
});
</script>
<?php endif; ?> 