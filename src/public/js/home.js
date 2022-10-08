const btnLogin = document.querySelector('#btn-log');
const btnReg = document.querySelector('#btn-reg');
const welcomeUser = document.querySelector('.welcome__user');

window.onload = () => {
  btnLogin.addEventListener('click', clickBtnLog);
  btnReg.addEventListener('click', clickBtnReg);

  const userName = getCookie('name');

  if (!userName) {
    window.location.replace('/login');
    return;
  }

  btnReg.classList.add('hide');
  btnLogin.innerHTML = 'Log out';
  welcomeUser.innerHTML = userName;
};

const clickBtnLog = () => {
  clearCookies();
  window.location.replace('/login');
};

const clickBtnReg = () => {
  window.location.replace('/registration');
};

const getCookie = (name) => {
  let matches = document.cookie.match(
    new RegExp(
      '(?:^|; )' +
        name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') +
        '=([^;]*)'
    )
  );
  return matches ? decodeURIComponent(matches[1]) : undefined;
};

const clearCookies = () => {
  var cookies = document.cookie.split(';');
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];
    var eqPos = cookie.indexOf('=');
    var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;';
    document.cookie =
      name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  }
};
