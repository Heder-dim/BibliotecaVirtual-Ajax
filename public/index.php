<?php
session_start();
if (empty($_SESSION['user_id'])) {
  header('Location: login.html');
  exit;
}
?>
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
  <meta charset='UTF-8'>
  <title>Biblioteca Virtual</title>
  <link rel='stylesheet' href='./css/index.css'>
</head>
<body>
<header>
  <div class="header-content">
    <h1>Biblioteca Virtual</h1>
    <!-- Botão de logout -->
    <a href="../api/logout.php" id="logout-btn" class="btn-logout">Logout</a>
  </div>
  <hr class='divider'>
</header>

<div class='container'>
  <form id='add-book-form'>
    <div class='form-group'>
      <label for='name'>Nome</label>
      <input type='text' id='name' placeholder='Nome' required>
    </div>
    <div class='form-group'>
      <label for='author'>Autor</label>
      <input type='text' id='author' placeholder='Autor' required>
    </div>
    <div class='form-group form-group-full'>
      <label for='description'>Descrição</label>
      <textarea id='description' rows='3' placeholder='Descrição' required></textarea>
    </div>
    <div class='form-group'>
      <label for='pages'>Número de páginas</label>
      <input type='number' id='pages' placeholder='Páginas' required>
    </div>
    <button type='submit' id='add-btn'>Adicionar livro</button>
  </form>

    <div class='filters'>
    <label>Filtros:</label>
    <input type='text' id='filter-name' placeholder='Nome'>
    <input type='number' id='filter-pages' placeholder='Max. de páginas'>
    <input type='text' id='filter-author' placeholder='Autor'>
    <button type="button" id="filter-btn">Filtrar</button>
  </div>


  <table>
    <thead>
      <tr>
        <th>Nome</th>
        <th>Autor</th>
        <th>Descrição</th>
        <th>Número de páginas</th>
        <th>Adicionado por</th>
      </tr>
      
    </thead>
    <tbody id='books-table'></tbody>
  </table>

  <div class='pagination' id='pagination'></div>
</div>

<footer>
  <hr class='divider'>
  <p>IF Goiano - Campus Iporá</p>
</footer>

<script src="./js/index.js"></script>
</body>
</html>
