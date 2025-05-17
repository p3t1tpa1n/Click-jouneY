/**
 * Modification dynamique du profil utilisateur
 * 
 * Ce fichier gère l'édition des champs de profil sans rechargement de page
 * - Permet de rendre les champs modifiables via un bouton
 * - Offre la possibilité de valider ou annuler chaque modification
 * - Affiche un bouton de soumission global si des modifications sont en attente
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du gestionnaire de profil
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        initProfileEditor();
    }
});

/**
 * Initialise l'éditeur de profil
 */
function initProfileEditor() {
    // Stocker les valeurs originales pour pouvoir les restaurer
    const originalValues = {};
    
    // Liste des champs modifiés (pour afficher le bouton de soumission)
    const modifiedFields = new Set();
    
    // Obtenir tous les champs éditables
    const editableFields = document.querySelectorAll('.editable-field');
    
    // Configuration de chaque champ éditable
    editableFields.forEach(fieldContainer => {
        const fieldId = fieldContainer.dataset.field;
        const input = fieldContainer.querySelector('input, select, textarea');
        const editButton = fieldContainer.querySelector('.edit-button');
        
        if (!input || !editButton || !fieldId) return;
        
        // Désactiver initialement le champ
        input.disabled = true;
        
        // Stocker la valeur originale
        originalValues[fieldId] = input.value;
        
        // Ajouter le gestionnaire d'événement pour le bouton d'édition
        editButton.addEventListener('click', function() {
            toggleEditMode(fieldContainer, fieldId, input, originalValues, modifiedFields);
        });
    });
    
    // Créer et ajouter le bouton de soumission (initialement caché)
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.className = 'btn btn-primary submit-all-btn';
    submitButton.textContent = 'Enregistrer toutes les modifications';
    submitButton.style.display = 'none';
    submitButton.style.marginTop = '20px';
    
    const formActions = document.createElement('div');
    formActions.className = 'form-actions';
    formActions.appendChild(submitButton);
    
    const profileForm = document.getElementById('profile-form');
    profileForm.appendChild(formActions);
    
    // Mettre à jour l'affichage du bouton de soumission lorsque des champs sont modifiés
    function updateSubmitButton() {
        submitButton.style.display = modifiedFields.size > 0 ? 'block' : 'none';
    }
    
    // Fonction pour basculer le mode d'édition d'un champ
    function toggleEditMode(container, fieldId, input, originalValues, modifiedFields) {
        const isEditing = !input.disabled;
        
        if (isEditing) {
            // Actuellement en mode édition, donc il faut valider ou annuler
            // Ne rien faire ici, car géré par les boutons valider/annuler
        } else {
            // Passer en mode édition
            enableEditMode(container, fieldId, input, originalValues, modifiedFields, updateSubmitButton);
        }
    }
}

/**
 * Active le mode d'édition pour un champ
 * @param {HTMLElement} container - Conteneur du champ
 * @param {string} fieldId - Identifiant du champ
 * @param {HTMLElement} input - Élément input à éditer
 * @param {Object} originalValues - Valeurs originales des champs
 * @param {Set} modifiedFields - Ensemble des champs modifiés
 * @param {Function} updateSubmitButton - Fonction pour mettre à jour le bouton de soumission
 */
function enableEditMode(container, fieldId, input, originalValues, modifiedFields, updateSubmitButton) {
    // Activer le champ
    input.disabled = false;
    input.focus();
    
    // Cacher le bouton d'édition
    const editButton = container.querySelector('.edit-button');
    if (editButton) {
        editButton.style.display = 'none';
    }
    
    // Créer les boutons de confirmation et d'annulation
    const actionsContainer = document.createElement('div');
    actionsContainer.className = 'edit-actions';
    actionsContainer.style.marginTop = '10px';
    
    const confirmButton = document.createElement('button');
    confirmButton.type = 'button';
    confirmButton.className = 'btn btn-sm btn-success confirm-button';
    confirmButton.innerHTML = '<i class="fas fa-check"></i> Valider';
    confirmButton.style.marginRight = '10px';
    
    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.className = 'btn btn-sm btn-outline-secondary cancel-button';
    cancelButton.innerHTML = '<i class="fas fa-times"></i> Annuler';
    
    actionsContainer.appendChild(confirmButton);
    actionsContainer.appendChild(cancelButton);
    container.appendChild(actionsContainer);
    
    // Gestionnaire pour le bouton de confirmation
    confirmButton.addEventListener('click', function() {
        // Valider la modification
        if (input.value !== originalValues[fieldId]) {
            modifiedFields.add(fieldId);
        } else {
            modifiedFields.delete(fieldId);
        }
        
        disableEditMode(container, input);
        updateSubmitButton();
    });
    
    // Gestionnaire pour le bouton d'annulation
    cancelButton.addEventListener('click', function() {
        // Annuler la modification et restaurer la valeur originale
        input.value = originalValues[fieldId];
        disableEditMode(container, input);
        updateSubmitButton();
    });
}

/**
 * Désactive le mode d'édition pour un champ
 * @param {HTMLElement} container - Conteneur du champ
 * @param {HTMLElement} input - Élément input à désactiver
 */
function disableEditMode(container, input) {
    // Désactiver le champ
    input.disabled = true;
    
    // Supprimer les boutons de confirmation et d'annulation
    const actionsContainer = container.querySelector('.edit-actions');
    if (actionsContainer) {
        actionsContainer.remove();
    }
    
    // Réafficher le bouton d'édition
    const editButton = container.querySelector('.edit-button');
    if (editButton) {
        editButton.style.display = 'inline-block';
    }
} 