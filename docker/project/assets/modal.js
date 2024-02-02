// assets/js/modal.js

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal');
    const loginButton = document.getElementById('login-btn');
    const cancelButton = document.getElementById('cancel-btn');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    const showModal = () => {
        modal.classList.remove('hidden');
    };

    const hideModal = () => {
        modal.classList.add('hidden');
    };

    const handleLogin = async () => {
        // ... your login logic ...
    };

    cancelButton.addEventListener('click', hideModal);

    loginButton.addEventListener('click', handleLogin);
});
