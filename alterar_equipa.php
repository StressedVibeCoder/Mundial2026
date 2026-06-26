<?php
$page_title = 'Alterar Equipa - Mundial 2026';
require_once 'includes/header.php';
requer_admin();

$mensagem = "";
$equipa_selecionada = null;

$equipas = db()->select('equipas', 'id_equipa, pais, grupos_id_grupo', [], 'pais');
$grupos = db()->select('grupos', '*', [], 'grupos');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['carregar'])) {
    $id_equipa = (int)$_POST['id_equipa'];
    $equipa_selecionada = db()->selectOne('equipas', '*', ['id_equipa' => $id_equipa]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterar'])) {
    $id_equipa = (int)$_POST['id_equipa'];
    $novo_pais = $_POST['novo_pais'];
    $novo_grupo = (int)$_POST['novo_grupo'];

    if ($id_equipa > 0 && !empty($novo_pais) && $novo_grupo > 0) {
        $resultado = db()->update('equipas', [
            'pais' => $novo_pais,
            'grupos_id_grupo' => $novo_grupo,
        ], ['id_equipa' => $id_equipa]);
        $mensagem = $resultado !== null
            ? "Equipa alterada com sucesso!"
            : "Já existe uma equipa com esse nome.";
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>
    <h1 class="cyberpunk glitched">Alterar Dados da Equipa</h1>
    <?php require_once 'includes/nav.php'; ?>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:500px">
        <label>Equipa:</label>
        <select class="cyberpunk" name="id_equipa" required>
            <option value="">Selecione uma equipa</option>
            <?php foreach ($equipas ?? [] as $equipa): ?>
                <option value="<?= $equipa['id_equipa'] ?>" <?= ($equipa_selecionada && $equipa['id_equipa'] == $equipa_selecionada['id_equipa']) ? 'selected' : '' ?>>
                    <?= $equipa['pais'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="carregar" class="cyberpunk blue" style="--text:'A-3'">Carregar Dados</button>
    </form>

    <?php if ($equipa_selecionada): ?>
    <form method="post" style="max-width:500px">
        <input class="cyberpunk" type="hidden" name="id_equipa" value="<?= $equipa_selecionada['id_equipa'] ?>">

        <label>País:</label>
        <input class="cyberpunk" type="text" name="novo_pais" value="<?= $equipa_selecionada['pais'] ?>" required>

        <label>Grupo:</label>
        <select class="cyberpunk" name="novo_grupo" required>
            <?php foreach ($grupos ?? [] as $grupo): ?>
                <option value="<?= $grupo['id_grupo'] ?>" <?= ($grupo['id_grupo'] == $equipa_selecionada['grupos_id_grupo']) ? 'selected' : '' ?>>
                    Grupo <?= $grupo['grupos'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="alterar" class="cyberpunk blue" style="--text:'A-4'">Alterar</button>
    </form>
    <?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
