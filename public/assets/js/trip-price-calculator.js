/**
 * Mise à jour dynamique du prix d'un voyage
 * 
 * Ce fichier gère le calcul en temps réel du prix total d'un voyage
 * - Mise à jour du prix en fonction des options sélectionnées
 * - Mise à jour du prix en fonction du nombre de participants
 * - Calcul des réductions éventuelles
 */

document.addEventListener('DOMContentLoaded', function() {
    // Si nous sommes sur la page d'un voyage ou la page de réservation
    const priceCalculator = document.getElementById('price-calculator');
    if (priceCalculator) {
        initPriceCalculator();
    }
});

/**
 * Initialise le calculateur de prix
 */
function initPriceCalculator() {
    // Éléments du calculateur
    const travelerCountInput = document.getElementById('traveler-count');
    const optionCheckboxes = document.querySelectorAll('.trip-option-checkbox');
    const roomTypeSelect = document.getElementById('room-type');
    const insuranceCheckbox = document.getElementById('insurance-option');
    const promoCodeInput = document.getElementById('promo-code');
    const promoCodeButton = document.getElementById('apply-promo');
    
    // Éléments d'affichage du prix
    const basePrice = parseFloat(document.getElementById('base-price')?.dataset?.price || 0);
    const basePriceElement = document.getElementById('trip-base-price');
    const optionsPriceElement = document.getElementById('trip-options-price');
    const discountElement = document.getElementById('trip-discount');
    const totalPriceElement = document.getElementById('trip-total-price');
    
    // Variables de calcul
    let currentDiscount = 0;
    let validPromoCode = false;
    
    // Codes promo valides (simulés)
    const promoCodes = {
        'ROUTE66': { type: 'percentage', value: 10 },
        'SUMMER23': { type: 'percentage', value: 15 },
        'WELCOME': { type: 'amount', value: 50 },
        'FLASH25': { type: 'percentage', value: 25 }
    };
    
    // Initialiser les prix de base
    if (basePriceElement) {
        basePriceElement.textContent = formatPrice(basePrice);
    }
    
    // Ajouter des écouteurs d'événements
    
    // Nombre de voyageurs
    if (travelerCountInput) {
        travelerCountInput.addEventListener('change', updatePrice);
        travelerCountInput.addEventListener('input', updatePrice);
    }
    
    // Options du voyage
    optionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updatePrice);
    });
    
    // Type de chambre
    if (roomTypeSelect) {
        roomTypeSelect.addEventListener('change', updatePrice);
    }
    
    // Assurance
    if (insuranceCheckbox) {
        insuranceCheckbox.addEventListener('change', updatePrice);
    }
    
    // Code promo
    if (promoCodeButton && promoCodeInput) {
        promoCodeButton.addEventListener('click', function(e) {
            e.preventDefault();
            applyPromoCode(promoCodeInput.value);
        });
        
        promoCodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyPromoCode(this.value);
            }
        });
    }
    
    // Calculer le prix initial
    updatePrice();
    
    /**
     * Met à jour le prix total du voyage
     */
    function updatePrice() {
        const travelerCount = parseInt(travelerCountInput?.value || 1);
        
        // Calcul du prix de base pour tous les voyageurs
        let totalBasePrice = basePrice * travelerCount;
        
        // Appliquer une réduction pour les groupes
        let groupDiscount = 0;
        if (travelerCount >= 5) {
            groupDiscount = 0.1; // 10% de réduction pour 5 personnes ou plus
        } else if (travelerCount >= 3) {
            groupDiscount = 0.05; // 5% de réduction pour 3-4 personnes
        }
        
        if (groupDiscount > 0) {
            const discountAmount = totalBasePrice * groupDiscount;
            totalBasePrice -= discountAmount;
            
            // Afficher l'info de réduction de groupe
            const groupDiscountInfo = document.getElementById('group-discount-info');
            if (groupDiscountInfo) {
                groupDiscountInfo.textContent = `Réduction groupe (${groupDiscount * 100}%): -${formatPrice(discountAmount)}`;
                groupDiscountInfo.style.display = 'block';
            }
        } else {
            // Masquer l'info de réduction de groupe
            const groupDiscountInfo = document.getElementById('group-discount-info');
            if (groupDiscountInfo) {
                groupDiscountInfo.style.display = 'none';
            }
        }
        
        // Mise à jour du prix de base affiché
        if (basePriceElement) {
            basePriceElement.textContent = formatPrice(totalBasePrice);
        }
        
        // Calcul du prix des options
        let optionsPrice = 0;
        
        // Options cochées
        optionCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const optionPrice = parseFloat(checkbox.dataset.price || 0);
                // Certaines options sont par voyageur, d'autres sont fixes
                if (checkbox.dataset.perPerson === 'true') {
                    optionsPrice += optionPrice * travelerCount;
                } else {
                    optionsPrice += optionPrice;
                }
            }
        });
        
        // Type de chambre
        if (roomTypeSelect) {
            const roomExtraPrice = parseFloat(roomTypeSelect.options[roomTypeSelect.selectedIndex].dataset.extraPrice || 0);
            optionsPrice += roomExtraPrice * travelerCount;
        }
        
        // Assurance
        if (insuranceCheckbox && insuranceCheckbox.checked) {
            const insurancePrice = parseFloat(insuranceCheckbox.dataset.price || 0);
            optionsPrice += insurancePrice * travelerCount;
        }
        
        // Mise à jour du prix des options affiché
        if (optionsPriceElement) {
            optionsPriceElement.textContent = formatPrice(optionsPrice);
        }
        
        // Calcul des réductions
        let discount = 0;
        
        // Réduction du code promo
        if (validPromoCode) {
            const promoInfo = promoCodes[promoCodeInput.value.toUpperCase()];
            if (promoInfo) {
                if (promoInfo.type === 'percentage') {
                    discount = (totalBasePrice + optionsPrice) * (promoInfo.value / 100);
                } else {
                    discount = promoInfo.value;
                }
            }
        }
        
        // Mise à jour de la réduction affichée
        if (discountElement) {
            if (discount > 0) {
                discountElement.textContent = `-${formatPrice(discount)}`;
                discountElement.parentElement.style.display = 'flex';
            } else {
                discountElement.parentElement.style.display = 'none';
            }
        }
        
        // Calcul du prix total
        const totalPrice = totalBasePrice + optionsPrice - discount;
        
        // Mise à jour du prix total affiché
        if (totalPriceElement) {
            totalPriceElement.textContent = formatPrice(totalPrice);
            
            // Animation pour mettre en évidence le changement
            totalPriceElement.classList.add('price-updated');
            setTimeout(() => totalPriceElement.classList.remove('price-updated'), 500);
        }
        
        // Mettre à jour le récapitulatif des options
        updateOptionsSummary();
    }
    
    /**
     * Applique un code promo
     * @param {string} code - Code promo à appliquer
     */
    function applyPromoCode(code) {
        const formattedCode = code.trim().toUpperCase();
        const promoStatus = document.getElementById('promo-status');
        
        // Vérifier si le code est valide
        if (promoCodes[formattedCode]) {
            validPromoCode = true;
            
            const promoInfo = promoCodes[formattedCode];
            let message = '';
            
            if (promoInfo.type === 'percentage') {
                message = `Code promo appliqué : ${promoInfo.value}% de réduction`;
            } else {
                message = `Code promo appliqué : ${formatPrice(promoInfo.value)} de réduction`;
            }
            
            if (promoStatus) {
                promoStatus.textContent = message;
                promoStatus.className = 'text-success';
            }
            
            // Désactiver le champ et le bouton
            if (promoCodeInput) {
                promoCodeInput.disabled = true;
            }
            if (promoCodeButton) {
                promoCodeButton.textContent = 'Appliqué';
                promoCodeButton.disabled = true;
            }
            
            // Ajouter un bouton pour retirer le code promo
            const removeButton = document.createElement('button');
            removeButton.textContent = 'Retirer';
            removeButton.className = 'btn btn-sm btn-outline-secondary ml-2';
            removeButton.style.marginLeft = '10px';
            
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                validPromoCode = false;
                
                if (promoStatus) {
                    promoStatus.textContent = '';
                }
                
                if (promoCodeInput) {
                    promoCodeInput.disabled = false;
                    promoCodeInput.value = '';
                }
                
                if (promoCodeButton) {
                    promoCodeButton.textContent = 'Appliquer';
                    promoCodeButton.disabled = false;
                }
                
                this.remove();
                
                updatePrice();
            });
            
            if (promoCodeButton.parentElement) {
                promoCodeButton.parentElement.appendChild(removeButton);
            }
        } else {
            validPromoCode = false;
            
            if (promoStatus) {
                promoStatus.textContent = 'Code promo invalide';
                promoStatus.className = 'text-danger';
            }
        }
        
        // Mettre à jour le prix
        updatePrice();
    }
    
    /**
     * Met à jour le récapitulatif des options
     */
    function updateOptionsSummary() {
        const summaryContainer = document.getElementById('options-summary');
        if (!summaryContainer) return;
        
        // Vider le récapitulatif
        summaryContainer.innerHTML = '';
        
        // Nombre de voyageurs
        const travelerCount = parseInt(travelerCountInput?.value || 1);
        
        // Ajouter un élément pour les voyageurs
        const travelersItem = document.createElement('div');
        travelersItem.className = 'summary-item';
        travelersItem.innerHTML = `
            <span class="summary-label">Voyageurs</span>
            <span class="summary-value">${travelerCount}</span>
        `;
        summaryContainer.appendChild(travelersItem);
        
        // Ajouter les options sélectionnées
        optionCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const optionLabel = checkbox.nextElementSibling?.textContent || 'Option';
                const optionPrice = parseFloat(checkbox.dataset.price || 0);
                let displayPrice;
                
                if (checkbox.dataset.perPerson === 'true') {
                    displayPrice = `${formatPrice(optionPrice)} × ${travelerCount} = ${formatPrice(optionPrice * travelerCount)}`;
                } else {
                    displayPrice = formatPrice(optionPrice);
                }
                
                const optionItem = document.createElement('div');
                optionItem.className = 'summary-item';
                optionItem.innerHTML = `
                    <span class="summary-label">${optionLabel}</span>
                    <span class="summary-value">${displayPrice}</span>
                `;
                summaryContainer.appendChild(optionItem);
            }
        });
        
        // Ajouter le type de chambre
        if (roomTypeSelect) {
            const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
            const roomLabel = selectedOption.textContent;
            const roomExtraPrice = parseFloat(selectedOption.dataset.extraPrice || 0);
            
            if (roomExtraPrice > 0) {
                const roomItem = document.createElement('div');
                roomItem.className = 'summary-item';
                roomItem.innerHTML = `
                    <span class="summary-label">${roomLabel}</span>
                    <span class="summary-value">${formatPrice(roomExtraPrice)} × ${travelerCount} = ${formatPrice(roomExtraPrice * travelerCount)}</span>
                `;
                summaryContainer.appendChild(roomItem);
            }
        }
        
        // Ajouter l'assurance
        if (insuranceCheckbox && insuranceCheckbox.checked) {
            const insuranceLabel = insuranceCheckbox.nextElementSibling?.textContent || 'Assurance';
            const insurancePrice = parseFloat(insuranceCheckbox.dataset.price || 0);
            
            const insuranceItem = document.createElement('div');
            insuranceItem.className = 'summary-item';
            insuranceItem.innerHTML = `
                <span class="summary-label">${insuranceLabel}</span>
                <span class="summary-value">${formatPrice(insurancePrice)} × ${travelerCount} = ${formatPrice(insurancePrice * travelerCount)}</span>
            `;
            summaryContainer.appendChild(insuranceItem);
        }
    }
}

/**
 * Formate un prix pour l'affichage
 * @param {number} price - Prix à formater
 * @returns {string} - Prix formaté
 */
function formatPrice(price) {
    return price.toFixed(2).replace('.', ',') + ' €';
} 