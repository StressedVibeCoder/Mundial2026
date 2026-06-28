function renderNav() {
  const nav = document.getElementById('sidebar-nav');
  if (!nav) return;

  var b = BASE_URL;
  var links = '<a href="' + b + 'index.html">Início</a>';

  if (estaLogado() && !ehAdmin()) {
    links += '<div class="sidebar-section">Utilizador</div>';
    links += '<a href="' + b + 'palpites.html">Palpites</a>';
    links += '<a href="' + b + 'favoritos.html">Favoritos</a>';
  }
  if (estaLogado()) {
    links += '<div class="sidebar-section">Geral</div>';
    links += '<a href="' + b + 'ranking.html">Ranking</a>';
  }
  if (ehAdmin()) {
    links += '<div class="sidebar-section">Grupos</div>';
    links += '<a href="' + b + 'admin/grupos.html">Gerir Grupos</a>';
    links += '<div class="sidebar-section">Equipas</div>';
    links += '<a href="' + b + 'admin/equipas.html">Gerir Equipas</a>';
    links += '<div class="sidebar-section">Jogos</div>';
    links += '<a href="' + b + 'admin/jogos.html">Gerir Jogos</a>';
    links += '<div class="sidebar-section">Utilizadores</div>';
    links += '<a href="' + b + 'admin/utilizadores.html">Gerir Users</a>';
  }

  nav.innerHTML = links;
}

function renderTopbar() {
  const el = document.getElementById('topbar-user');
  if (!el) return;

  if (estaLogado()) {
    const s = getSession();
    el.innerHTML =
      '<span class="user-name">' + esc(s.user_nome) + '</span>' +
      '<span>(' + (ehAdmin() ? 'Admin' : 'User') + ')</span>' +
      '<a href="' + BASE_URL + 'logout.html" class="btn-sm btn-danger">Sair</a>';
  } else {
    el.innerHTML =
      '<a href="' + BASE_URL + 'login.html" class="btn-sm btn-primary">Login</a>' +
      '<a href="' + BASE_URL + 'registar.html" class="btn-sm btn-primary">Registar</a>';
  }
}

function renderLayout() {
  renderNav();
  renderTopbar();
}
