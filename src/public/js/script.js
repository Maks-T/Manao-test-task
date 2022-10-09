const formAuth = document.querySelector('.form-auth');
const inputsForm = [...document.querySelectorAll('.form-auth__input')];
const btnSubmit = document.querySelector('.form-auth__btn-submit');
const btnLogin = document.querySelector('#btn-log');
const btnReg = document.querySelector('#btn-reg');

window.onload = () => {
  btnSubmit.addEventListener('click', submitFormHandle);

  inputsForm.forEach((input) =>
    input.addEventListener('input', inputChangeHandle)
  );

  btnLogin.addEventListener('click', clickBtnLog);
  btnReg.addEventListener('click', clickBtnReg);
};

const submitFormHandle = async (e) => {
  e.preventDefault();

  const formData = new FormData(formAuth);

  const result = await sendFormData(Object.fromEntries(formData));

  if (result.status === 'success') {
    window.location.replace('/');
  }

  setErrorMessages(result);
};

const inputChangeHandle = (e) => {
  const isInputsValid = inputsForm.every(
    (input) => input.checkValidity() && input.value
  );

  inputsForm.forEach((input) => (input.value = input.value.replace(/\s/g, '')));

  const label = formAuth.querySelector(`#${e.target.id}-message`);

  label.classList.remove('hide');
  label.innerHTML = '';

  const isPasswordRigth =
    typeof checkMatchPassword == 'function' ? checkMatchPassword() : true;

  if (isInputsValid && isPasswordRigth) {
    btnSubmit.removeAttribute('disabled', '');
  } else {
    btnSubmit.setAttribute('disabled', '');
  }
};

const sendFormData = async (formData) => {
  const response = await fetch(URI, {
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    },
    method: 'POST',
    body: JSON.stringify(formData),
  });

  return await response.json();
};

const setErrorMessages = (result) => {
  const labels = [...formAuth.querySelectorAll('.form-auth__label')];
  labels.forEach((label) => {
    label.innerHTML = '';
    label.classList.add('hide');
  });

  if (result.status === 'error') {
    for (error in result.errors) {
      const findLabel = labels.find((label) => label.id === `${error}-message`);

      if (findLabel) {
        findLabel.innerHTML = result.errors[error];
        findLabel.classList.remove('hide');
      }
    }
  }
};

const clickBtnLog = () => {
  window.location.replace('/login');
};

const clickBtnReg = () => {
  window.location.replace('/registration');
};
