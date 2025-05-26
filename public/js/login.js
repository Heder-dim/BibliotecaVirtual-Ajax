async function ajax(url, method, data) {
    const res = await fetch(url, {
      method,
      headers: data ? {'Content-Type':'application/json'} : {},
      body: data ? JSON.stringify(data) : undefined
    });
    return res.json();
  }

  document.getElementById('login-form').onsubmit = async e => {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const pass  = document.getElementById('password').value;
    const msgEl = document.getElementById('error-msg');
    msgEl.textContent = '';

    const res = await ajax('/api/login.php', 'POST', { email, password: pass });
    if (res.error) {
      msgEl.textContent = res.error;
      console.log("deu pau!");
    } else {
      // redireciona para a página principal de livros
      window.location = 'index.php';
    }
};