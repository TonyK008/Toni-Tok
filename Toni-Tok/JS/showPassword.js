let togglePasswordButton = document.getElementById('togglePassword');
let passwordInput = document.getElementById('password');

togglePasswordButton.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
});