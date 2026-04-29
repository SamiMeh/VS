const usernameRegex = /^[a-zA-Z0-9_]{3,}$/;
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const dateInput = document.getElementById('dateofbirth');
const passwordInput = document.getElementById('password');
const passwordConfirmInput = document.getElementById('passwordconfirm');
const registerButton = document.getElementById('Register-button');

function showError(input, message) {
  const err = document.createElement('p');
  err.className = 'error-msg';
  err.textContent = message;
  input.after(err);
  input.style.borderColor = '#e74c3c';
}

const registerForm = document.getElementById('register-form');

registerForm.onsubmit = function(e) {
  document.querySelectorAll('.error-msg').forEach(el => el.remove());
  document.querySelectorAll('input').forEach(el => el.style.borderColor = '');

  let valid = true;

  if (!usernameRegex.test(usernameInput.value)) {
    showError(usernameInput, 'Username duhet te ket se paku 3 karaktere');
    valid = false;
  }

  if (!emailRegex.test(emailInput.value)) {
    showError(emailInput, 'Email nuk eshte valid');
    valid = false;
  }

  if (!dateInput.value) {
    showError(dateInput, 'Zgjidh daten e lindjes');
    valid = false;
  }

  if (!passwordRegex.test(passwordInput.value)) {
    showError(passwordInput, 'Password: 8+ karaktere, 1 i madh, 1 i vogel, 1 numer, 1 simbol (@$!%*?&)');
    valid = false;
  }

  if (passwordInput.value !== passwordConfirmInput.value || passwordConfirmInput.value === '') {
    showError(passwordConfirmInput, 'Passwordet nuk përputhen');
    valid = false;
  }

  if (!valid) {
    e.preventDefault();
    return false;
  }
  
  // If valid, allow form to submit normally
  return true;
};