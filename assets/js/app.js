/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Elementos da página
const homePage = document.getElementById('homePage');
const formPage = document.getElementById('formPage');
const participateBtn = document.getElementById('participateBtn');
const leadForm = document.getElementById('leadForm');
const successMessage = document.getElementById('successMessage');

// Navegação entre páginas
participateBtn.addEventListener('click', function() {
    homePage.style.display = 'none';
    formPage.style.display = 'block';
});

// Inicialização e detecção da localização para autopreenchimento do estado
window.addEventListener('DOMContentLoaded', function() {
    // Tentativa de obter localização
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // Na prática, aqui seria feita uma chamada a uma API de geolocalização
            // para converter coordenadas em Estado e Cidade
            // Por simplicidade, vamos apenas preencher com um estado padrão
            document.getElementById('state').value = 'SP';
        });
    }

    // Máscara para telefone
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);

        // Formatação do número
        if (value.length > 2) {
            value = '(' + value.substring(0, 2) + ') ' + value.substring(2);
        }
        if (value.length > 10) {
            value = value.substring(0, 10) + '-' + value.substring(10);
        }

        e.target.value = value;
    });
});

// Validação e envio do formulário
leadForm.addEventListener('submit', function(e) {
    e.preventDefault();

    // Limpar mensagens de erro anteriores
    document.querySelectorAll('.error').forEach(error => {
        error.style.display = 'none';
    });

    // Validar campos
    let isValid = true;

    // Nome
    if (document.getElementById('name').value.trim() === '') {
        document.getElementById('nameError').style.display = 'block';
        isValid = false;
    }

    // Cidade
    if (document.getElementById('city').value.trim() === '') {
        document.getElementById('cityError').style.display = 'block';
        isValid = false;
    }

    // Estado
    if (document.getElementById('state').value === '') {
        document.getElementById('stateError').style.display = 'block';
        isValid = false;
    }

    // Email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(document.getElementById('email').value.trim())) {
        document.getElementById('emailError').style.display = 'block';
        isValid = false;
    }

    // Telefone
    const phoneValue = document.getElementById('phone').value.replace(/\D/g, '');
    if (phoneValue.length < 10) {
        document.getElementById('phoneError').style.display = 'block';
        isValid = false;
    }

    // Categoria
    if (document.getElementById('category').value === '') {
        document.getElementById('categoryError').style.display = 'block';
        isValid = false;
    }

    // Se todos os campos estiverem válidos
    if (isValid) {
        leadForm.submit();
    }
});