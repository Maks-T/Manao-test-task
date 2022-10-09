const URI = '/user';

const checkMatchPassword = () => {
  const inputPassword = document.querySelector('#password');
  const inputConfirmPassword = document.querySelector('#confirm-password');
  const inputConfirmPasswordMessage = document.querySelector(
    '#confirm-password-message'
  );

  if (inputPassword.value !== inputConfirmPassword.value) {
    inputConfirmPasswordMessage.classList.remove('hide');
    inputConfirmPasswordMessage.innerHTML = "Passwords don't match";
    inputConfirmPassword.classList.add('invalid');

    return false;
  }

  inputConfirmPasswordMessage.classList.add('hide');
  inputConfirmPasswordMessage.innerHTML = '';
  inputConfirmPassword.classList.remove('invalid');

  return true;
};
