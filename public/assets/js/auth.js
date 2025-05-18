document.addEventListener('DOMContentLoaded', function() {
  const elements = document.querySelectorAll('.auth-form-container, .auth-image');
  elements.forEach(el => el.classList.add('fade-in'));

  // Animation des avantages
  const benefits = document.querySelectorAll('.benefit-item');
  benefits.forEach((benefit, index) => {
    setTimeout(() => {
      benefit.classList.add('slide-in');
    }, 300 + index * 200);
  });

  // Ajouter les boutons pour afficher/masquer les mots de passe
  const passwordInputs = document.querySelectorAll('input[type="password"]');
  passwordInputs.forEach(input => {
    const toggleButton = document.createElement('button');
    toggleButton.type = 'button';
    toggleButton.className = 'password-toggle-btn';
    toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
    toggleButton.title = 'Afficher le mot de passe';
    input.parentElement.appendChild(toggleButton);

    toggleButton.addEventListener('click', function() {
      if (input.type === 'password') {
        input.type = 'text';
        toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
        toggleButton.title = 'Masquer le mot de passe';
      } else {
        input.type = 'password';
        toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
        toggleButton.title = 'Afficher le mot de passe';
      }
    });
  });

  // Ajouter les compteurs de caractères
  const loginInput = document.getElementById('login');
  if (loginInput) loginInput.dataset.maxLength = '30';
  const emailInput = document.getElementById('email');
  if (emailInput) emailInput.dataset.maxLength = '100';

  const inputsWithCount = document.querySelectorAll('input[data-max-length]');
  inputsWithCount.forEach(input => {
    const maxLength = input.dataset.maxLength;
    const counter = document.createElement('div');
    counter.className = 'character-counter';
    counter.textContent = `0/${maxLength}`;
    input.parentElement.parentElement.appendChild(counter);

    input.addEventListener('input', function() {
      const currentLength = this.value.length;
      counter.textContent = `${currentLength}/${maxLength}`;

      if (currentLength >= maxLength) {
        counter.style.color = 'var(--danger)';
      } else if (currentLength >= maxLength * 0.8) {
        counter.style.color = 'var(--warning)';
      } else {
        counter.style.color = 'var(--gray-500)';
      }
    });
  });
}); 