const pageSize = 8;
let currentPage = 1;

async function ajax(url, method = 'GET', data = null) {
  const opts = { method, headers: {} };
  if (data) {
    opts.headers['Content-Type'] = 'application/json';
    opts.body = JSON.stringify(data);
  }
  const res = await fetch(url, opts);
  return res.json();
}

async function loadBooks() {
  const name = document.getElementById('filter-name').value;
  const author = document.getElementById('filter-author').value;
  const maxPages = document.getElementById('filter-pages').value;
  const params = new URLSearchParams({
    page: currentPage,
    pageSize,
    name,
    author,
    maxPages
  });
  const data = await ajax('/api/list_books.php?' + params);
  renderTable(data.books);
  renderPagination(data.total);
}

function renderTable(books) {
  const tbody = document.getElementById('books-table');
  tbody.innerHTML = books.map(b => `
    <tr>
      <td>${b.name}</td>
      <td>${b.author}</td>
      <td>${b.description}</td>
      <td>${b.pages}</td>
      <td>${b.added_by}</td>
    </tr>
  `).join('');
}

function renderPagination(totalCount) {
  const totalPages = Math.ceil(totalCount / pageSize);
  const container = document.getElementById('pagination');
  container.innerHTML = '';
  const pages = getPageList(totalPages, currentPage);
  pages.forEach(p => {
    if (p === '...') {
      const span = document.createElement('span');
      span.textContent = p;
      span.classList.add('ellipsis');
      container.appendChild(span);
    } else {
      const btn = document.createElement('button');
      btn.textContent = p;
      if (p === currentPage) btn.classList.add('active');
      btn.onclick = () => {
        currentPage = p;
        loadBooks();
      };
      container.appendChild(btn);
    }
  });
}

function getPageList(total, page) {
  const delta = 2;
  const range = [];
  for (let i = 1; i <= total; i++) {
    if (
      i === 1 ||
      i === total ||
      (i >= page - delta && i <= page + delta)
    ) {
      range.push(i);
    } else if (range[range.length - 1] !== '...') {
      range.push('...');
    }
  }
  return range;
}

// dispara o loadBooks() ao clicar em “Filtrar”
document.getElementById('filter-btn').addEventListener('click', () => {
  currentPage = 1;
  loadBooks();
});

document.getElementById('add-book-form').onsubmit = async e => {
  e.preventDefault();
  const payload = {
    name: document.getElementById('name').value,
    author: document.getElementById('author').value,
    pages: document.getElementById('pages').value,
    description: document.getElementById('description').value
  };
  const res = await ajax('/api/add_book.php', 'POST', payload);
  if (res.success) {
    document.getElementById('add-book-form').reset();
    currentPage = 1;
    loadBooks();
  } else {
    alert(res.error || 'Erro ao adicionar livro');
  }
};

window.onload = loadBooks;
