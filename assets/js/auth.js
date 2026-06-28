const bcrypt = dcodeIO.bcrypt;
const SESSION_KEY = 'mundial2026_session';

function getSession() {
  const raw = localStorage.getItem(SESSION_KEY);
  if (!raw) return null;
  try { return JSON.parse(raw); } catch { return null; }
}

function setSession(user) {
  localStorage.setItem(SESSION_KEY, JSON.stringify({
    user_id: user.idutilizadores,
    user_nome: user.nome_utilizador,
    user_tipo: user.administrador ? '1' : '0',
    user_username: user.nome_utilizador,
  }));
}

function destroySession() {
  localStorage.removeItem(SESSION_KEY);
}

function estaLogado() {
  return getSession() !== null;
}

function ehAdmin() {
  const s = getSession();
  return s !== null && s.user_tipo === '1';
}

function redirectLogin() {
  if (!estaLogado()) window.location.href = BASE_URL + 'login.html';
}

function redirectHome() {
  window.location.href = BASE_URL + 'index.html';
}

async function login(input, password) {
  let user = await supabaseSelectOne('utilizadores', '*', { nome_utilizador: input });
  if (!user) user = await supabaseSelectOne('utilizadores', '*', { email: input });
  if (!user) return 'Username ou password incorretos.';
  if (!bcrypt.compareSync(password, user.senha)) return 'Username ou password incorretos.';
  setSession(user);
  return null;
}

async function register(username, email, password) {
  const hash = bcrypt.hashSync(password, 10);
  const result = await supabaseInsert('utilizadores', {
    nome_utilizador: username,
    email: email,
    senha: hash,
    administrador: false,
  });
  if (!result) return 'Username ou email já existem.';
  return null;
}
