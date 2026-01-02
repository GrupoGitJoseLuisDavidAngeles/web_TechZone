import AuthService from "../services/auth.service.js";

setup();

function setup() {
    const form = document.querySelector('.loginForm');
    form.addEventListener("submit", validateUser);
}

async function validateUser(e) {
    e.preventDefault();

    const identifier = document.querySelector('#tIdentifier').value;
    const password = document.querySelector('#tPassword').value;

    const authService = new AuthService();
    try {
        const token = await authService.login(identifier, password, 'http://localhost:8081/api/login.php');
        window.localStorage.setItem('token', token);
        window.location.href = '/public/index.php';
    } catch (error) {
        const errorsDiv = document.querySelector('#tDivErrors');
        errorsDiv.textContent = error.message;
        errorsDiv.classList.add('errors');
    }
}