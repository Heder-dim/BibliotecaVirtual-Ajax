async function ajax(url, method, data) {
const res = await fetch(url, {
    method,
    headers: data ? {'Content-Type':'application/json'} : {},
    body: data ? JSON.stringify(data) : undefined
});
return res.json();
}

document.getElementById('register-form').onsubmit = async e => {
e.preventDefault();
const email = document.getElementById('email').value;
const pass  = document.getElementById('password').value;
const msgEl = document.getElementById('error-msg');
msgEl.textContent = '';

const res = await ajax('/api/register.php', 'POST', { email, password: pass });
if (res.error) {
    msgEl.textContent = res.error;
} else {
    alert('Cadastro realizado! Faça login.');
    window.location = 'login.html';
}
};