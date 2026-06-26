<?php
$page_title = 'Alterar Grupo - Mundial 2026';
require_once 'includes/header.php';
requer_admin();

$mensagem = "";
$grupos = db()->select('grupos', '*', [], 'grupos');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selecionar'])) {
    $id_grupo = (int)$_POST['id_grupo'];
    $grupo_sel = db()->selectOne('grupos', '*', ['id_grupo' => $id_grupo]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterar'])) {
    $id_grupo = (int)$_POST['id_grupo'];
    $novo_grupo = $_POST['grupo'];
    if (!empty($novo_grupo)) {
        $res = db()->update('grupos', ['grupos' => $novo_grupo], ['id_grupo' => $id_grupo]);
        $mensagem = $res ? "Grupo alterado para $novo_grupo!" : "Erro ao alterar (pode já existir).";
        $grupo_sel = ['id_grupo' => $id_grupo, 'grupos' => $novo_grupo];
    } else {
        $mensagem = "Insira uma letra.";
    }
}
?>
    <h1 class="cyberpunk glitched">Alterar Grupo</h1>
    <?php require_once 'includes/nav.php'; ?>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:500px;margin-bottom:20px">
        <label>Selecione Grupo:</label>
        <select class="cyberpunk" name="id_grupo" required>
            <option value="">-- Escolher --</option>
            <?php foreach ($grupos ?? [] as $g): ?>
                <option value="<?= $g['id_grupo'] ?>"><?= $g['grupos'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="selecionar" class="cyberpunk blue" style="--text:'S-1'">Selecionar</button>
    </form>

    <?php if (!empty($grupo_sel)): ?>
        <form method="post" style="max-width:500px">
            <input type="hidden" name="id_grupo" value="<?= $grupo_sel['id_grupo'] ?>">
            <label>Nova Letra:</label>
            <input class="cyberpunk" type="text" name="grupo" value="<?= $grupo_sel['grupos'] ?>" maxlength="1" required>
            <button type="submit" name="alterar" class="cyberpunk blue" style="--text:'A-2'">Alterar Grupo</button>
        </form>
    <?php endif; ?>
<?php require_once 'includes/footer.php'; ?>