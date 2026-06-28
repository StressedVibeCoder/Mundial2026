function formatDate(datahora) {
  const d = new Date(datahora);
  return d.toLocaleDateString('pt-PT', {
    day: '2-digit', month: '2-digit', year: 'numeric',
    hour: '2-digit', minute: '2-digit',
  });
}

function calcularPontos(palpite, jogo) {
  const g1 = palpite.golo_equipa1, g2 = palpite.golo_equipa2;
  const r1 = jogo.golequipa1, r2 = jogo.golequipa2;
  if (g1 === r1 && g2 === r2) return 5;
  if (Math.sign(g1 - g2) === Math.sign(r1 - r2)) return 2;
  return 0;
}

function esc(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}
