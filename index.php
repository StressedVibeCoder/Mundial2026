<?php
require_once 'config.php';

$grupos = db()->select('grupos', '*', [], 'grupos');
if (empty($grupos)) {
    $grupos = db()->raw('GET', '/grupos?select=*&order=grupos');
}
error_log("Grupos: " . print_r($grupos, true));
$jogos_raw = db()->select('jogo', '*', [], 'datahora');
$jogos = [];
foreach ($jogos_raw ?? [] as $j) {
    $e1 = db()->selectOne('equipas', 'pais', ['id_equipa' => $j['equipa1']]);
    $e2 = db()->selectOne('equipas', 'pais', ['id_equipa' => $j['equipa2']]);
    $j['equipa1_nome'] = $e1['pais'] ?? '?';
    $j['equipa2_nome'] = $e2['pais'] ?? '?';
    $jogos[] = $j;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Mundial 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <section class="cyberpunk black both">
    <h1 class="cyberpunk glitched">Mundial 2026</h1>

    <div style="text-align:right;margin-bottom:10px">
        <?php if (esta_logado()): ?>
            <span><?= $_SESSION['user_nome'] ?> (<?= $_SESSION['user_tipo'] === '1' ? 'Admin' : 'User' ?>)</span>
            <a href="logout.php" class="cyberpunk" style="--text:'S-1';padding:10px 20px;font-size:1rem">Logout</a>
        <?php else: ?>
            <a href="login.php" class="cyberpunk" style="--text:'S-1';padding:10px 20px;font-size:1rem">Login</a>
            <a href="registar.php" class="cyberpunk" style="--text:'S-2';padding:10px 20px;font-size:1rem">Registar</a>
        <?php endif; ?>
    </div>

    <div>
        <a href="index.php" class="cyberpunk purple" style="--text:'M-0';padding:10px 15px;font-size:0.8rem">Início</a>
        <?php if (eh_admin()): ?>
            <a href="criar_grupo.php" class="cyberpunk green" style="--text:'C-1';padding:10px 10px;font-size:0.8rem">Criar Grupo</a>
            <a href="criar_equipa.php" class="cyberpunk green" style="--text:'C-2';padding:10px 10px;font-size:0.8rem">Criar Equipa</a>
            <a href="criar_utilizador.php" class="cyberpunk green" style="--text:'C-3';padding:10px 10px;font-size:0.8rem">Gerir Users</a>
            <a href="registar_jogo.php" class="cyberpunk green" style="--text:'C-4';padding:10px 10px;font-size:0.8rem">Registar Jogo</a>
            <a href="alterar_grupo.php" class="cyberpunk blue" style="--text:'A-1';padding:10px 10px;font-size:0.8rem">Alterar Grupo</a>
            <a href="alterar_equipa.php" class="cyberpunk blue" style="--text:'A-2';padding:10px 10px;font-size:0.8rem">Alterar Equipa</a>
            <a href="alterar_jogo.php" class="cyberpunk blue" style="--text:'A-3';padding:10px 10px;font-size:0.8rem">Alterar Jogo</a>
            <a href="apagar_grupo.php" class="cyberpunk red" style="--text:'D-1';padding:10px 10px;font-size:0.8rem">Apagar Grupo</a>
            <a href="apagar_equipa.php" class="cyberpunk red" style="--text:'D-2';padding:10px 10px;font-size:0.8rem">Apagar Equipa</a>
            <a href="apagar_jogo.php" class="cyberpunk red" style="--text:'D-3';padding:10px 10px;font-size:0.8rem">Apagar Jogo</a>
        <?php endif; ?>
    </div>

    <h2 class="cyberpunk">Grupos e Equipas</h2>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:15px;margin-bottom:25px">
        <?php foreach ($grupos ?? [] as $grupo): ?>
            <div style="background:var(--black-color);border:2px solid var(--yellow-color);border-radius:0;overflow:hidden">
                <div style="background:#000;color:var(--yellow-color);padding:8px;font-weight:bold;text-align:center">Grupo <?= $grupo['grupos'] ?></div>
                <ul style="list-style:none;margin:0;padding:0">
                    <?php
                    $equipas = db()->select('equipas', 'id_equipa, pais', ['grupos_id_grupo' => $grupo['id_grupo']], 'pais');
if (empty($equipas)) {
    $equipas = db()->raw('GET', "/equipas?select=id_equipa,pais&grupos_id_grupo=eq.{$grupo['id_grupo']}&order=pais");
}
error_log("Equipas grupo {$grupo['id_grupo']}: " . print_r($equipas, true));
                    foreach ($equipas ?? [] as $equipa): ?>
                        <li style="padding:8px 12px;border-bottom:1px solid #333"><?= $equipa['pais'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

    <h2 class="cyberpunk">Jogos Realizados</h2>

    <table style="width:100%;border-collapse:collapse;margin-bottom:20px;background:var(--black-color)">
        <tr>
            <th>Data/Hora</th>
            <th>Local</th>
            <th>Equipa 1</th>
            <th>Resultado</th>
            <th>Equipa 2</th>
        </tr>
        <?php foreach ($jogos ?? [] as $jogo): ?>
            <tr>
                <td><?= date("d/m/Y H:i", strtotime($jogo['datahora'])) ?></td>
                <td><?= $jogo['local'] ?></td>
                <td><?= $jogo['equipa1_nome'] ?></td>
                <td style="font-weight:bold;text-align:center"><?= $jogo['golequipa1'] ?> - <?= $jogo['golequipa2'] ?></td>
                <td><?= $jogo['equipa2_nome'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </section>
</body>
</html>
