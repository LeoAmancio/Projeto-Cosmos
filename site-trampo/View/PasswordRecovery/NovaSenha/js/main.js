var password = document.querySelector('#password');
var password_confirm_wrapper = document.querySelector('#password_confirm_wrapper');
var password_confirm = document.querySelector('#password_confirm');

function validatePassword() {
    if (password.value != password_confirm.value) {
        password_confirm_wrapper.classList.add('is-invalid');
    } else {
        password_confirm_wrapper.classList.remove('is-invalid');
    }
}

password.onchange = validatePassword;
password_confirm.onkeyup = validatePassword;