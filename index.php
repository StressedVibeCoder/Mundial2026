<?php
$page_title = 'Mundial 2026';
require_once 'includes/header.php';

$grupos = db()->select('grupos', '*', [], 'grupos');
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

    <?php require_once 'includes/nav.php'; ?>

    <h2 class="cyberpunk">Grupos e Equipas</h2>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:15px;margin-bottom:25px">
        <?php foreach ($grupos ?? [] as $grupo): ?>
            <div style="background:var(--black-color);border:2px solid var(--yellow-color);border-radius:0;overflow:hidden">
                <div style="background:#000;color:var(--yellow-color);padding:8px;font-weight:bold;text-align:center">Grupo <?= $grupo['grupos'] ?></div>
                <ul style="list-style:none;margin:0;padding:0">
                    <?php
                    $equipas = db()->select('equipas', 'id_equipa, pais', ['grupos_id_grupo' => $grupo['id_grupo']], 'pais');
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
<?php require_once 'includes/footer.php'; ?>