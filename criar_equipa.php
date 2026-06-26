<?php
$page_title = 'Criar Equipa - Mundial 2026';
require_once 'includes/header.php';
requer_admin();

$mensagem = "";
$grupos = db()->select('grupos', '*', [], 'grupos');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pais = $_POST['pais'];
    $grupo_id = (int)$_POST['grupo_id'];

    if (!empty($pais) && $grupo_id > 0) {
        $resultado = db()->insert('equipas', [
            'pais' => $pais,
            'grupos_id_grupo' => $grupo_id,
        ]);
        $mensagem = $resultado !== null
            ? "Equipa $pais criada com sucesso!"
            : "Já existe a equipa $pais.";
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>
    <h1 class="cyberpunk glitched">Criar Nova Equipa</h1>
    <?php require_once 'includes/nav.php'; ?>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:500px">
        <label>País:</label>
        <input class="cyberpunk" type="text" name="pais" required>

        <label>Grupo:</label>
        <select class="cyberpunk" name="grupo_id" required>
            <option value="">Selecione um grupo</option>
            <?php foreach ($grupos ?? [] as $grupo): ?>
                <option value="<?= $grupo['id_grupo'] ?>">Grupo <?= $grupo['grupos'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="cyberpunk green" style="--text:'C-2'">Criar Equipa</button>
    </form>
<?php require_once 'includes/footer.php'; ?>