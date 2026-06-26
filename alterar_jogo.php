<?php
$page_title = 'Alterar Jogo - Mundial 2026';
require_once 'includes/header.php';
requer_admin();

$mensagem = "";
$jogo_selecionado = null;

$jogos_raw = db()->select('jogo', '*', [], 'datahora');
$jogos = [];
foreach ($jogos_raw ?? [] as $j) {
    $e1 = db()->selectOne('equipas', 'pais', ['id_equipa' => $j['equipa1']]);
    $e2 = db()->selectOne('equipas', 'pais', ['id_equipa' => $j['equipa2']]);
    $j['equipa1_nome'] = $e1['pais'] ?? '?';
    $j['equipa2_nome'] = $e2['pais'] ?? '?';
    $jogos[] = $j;
}
$equipas = db()->select('equipas', 'id_equipa, pais', [], 'pais');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['carregar'])) {
    $id_jogo = (int)$_POST['id_jogo'];
    $jogo_selecionado = db()->selectOne('jogo', '*', ['id_jogo' => $id_jogo]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterar'])) {
    $id_jogo = (int)$_POST['id_jogo'];
    $datahora = $_POST['datahora'];
    $local = $_POST['local'];
    $equipa1 = (int)$_POST['equipa1'];
    $equipa2 = (int)$_POST['equipa2'];
    $golequipa1 = (int)$_POST['golequipa1'];
    $golequipa2 = (int)$_POST['golequipa2'];

    if ($equipa1 == $equipa2) {
        $mensagem = "As equipas não podem ser iguais.";
    } elseif ($id_jogo > 0 && !empty($datahora) && !empty($local)) {
        $resultado = db()->update('jogo', [
            'datahora' => $datahora,
            'local' => $local,
            'equipa1' => $equipa1,
            'equipa2' => $equipa2,
            'golequipa1' => $golequipa1,
            'golequipa2' => $golequipa2,
        ], ['id_jogo' => $id_jogo]);
        $mensagem = $resultado !== null
            ? "Jogo alterado com sucesso!"
            : "Erro ao alterar o jogo.";
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>
    <h1 class="cyberpunk glitched">Alterar Dados do Jogo</h1>
    <?php require_once 'includes/nav.php'; ?>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:500px">
        <label>Jogo:</label>
        <select class="cyberpunk" name="id_jogo" required>
            <option value="">Selecione um jogo</option>
            <?php foreach ($jogos ?? [] as $jogo): ?>
                <option value="<?= $jogo['id_jogo'] ?>" <?= ($jogo_selecionado && $jogo['id_jogo'] == $jogo_selecionado['id_jogo']) ? 'selected' : '' ?>>
                    <?= $jogo['equipa1_nome'] ?> vs <?= $jogo['equipa2_nome'] ?> (<?= date("d/m/Y", strtotime($jogo['datahora'])) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="carregar" class="cyberpunk blue" style="--text:'A-5'">Carregar Dados</button>
    </form>

    <?php if ($jogo_selecionado): ?>
    <form method="post" style="max-width:500px">
        <input class="cyberpunk" type="hidden" name="id_jogo" value="<?= $jogo_selecionado['id_jogo'] ?>">

        <label>Data e Hora:</label>
        <input class="cyberpunk" type="datetime-local" name="datahora" value="<?= date('Y-m-d\TH:i', strtotime($jogo_selecionado['datahora'])) ?>" required>

        <label>Local:</label>
        <input class="cyberpunk" type="text" name="local" value="<?= $jogo_selecionado['local'] ?>" required>

        <label>Equipa 1:</label>
        <select class="cyberpunk" name="equipa1" required>
            <?php foreach ($equipas ?? [] as $equipa): ?>
                <option value="<?= $equipa['id_equipa'] ?>" <?= ($equipa['id_equipa'] == $jogo_selecionado['equipa1']) ? 'selected' : '' ?>>
                    <?= $equipa['pais'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Golos Equipa 1:</label>
        <input class="cyberpunk" type="number" name="golequipa1" min="0" value="<?= $jogo_selecionado['golequipa1'] ?>" required>

        <label>Equipa 2:</label>
        <select class="cyberpunk" name="equipa2" required>
            <?php foreach ($equipas ?? [] as $equipa): ?>
                <option value="<?= $equipa['id_equipa'] ?>" <?= ($equipa['id_equipa'] == $jogo_selecionado['equipa2']) ? 'selected' : '' ?>>
                    <?= $equipa['pais'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Golos Equipa 2:</label>
        <input class="cyberpunk" type="number" name="golequipa2" min="0" value="<?= $jogo_selecionado['golequipa2'] ?>" required>

        <button type="submit" name="alterar" class="cyberpunk blue" style="--text:'A-6'">Alterar</button>
    </form>
    <?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
