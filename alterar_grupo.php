<?php
require_once 'config.php';
requer_admin();

$mensagem = "";
$grupos = db()->select('grupos', '*', [], 'grupos');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_grupo = (int)$_POST['id_grupo'];
    $novo_nome = $_POST['novo_nome'];

    if ($id_grupo > 0 && !empty($novo_nome)) {
        $resultado = db()->update('grupos', ['grupos' => $novo_nome], ['id_grupo' => $id_grupo]);
        $mensagem = $resultado !== null
            ? "Nome do grupo alterado com sucesso!"
            : "Já existe o grupo $novo_nome.";
    } else {
        $mensagem = "Selecione um grupo e insira um novo nome.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Alterar Grupo - Mundial 2026</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
</head>
<body>
    <section class="cyberpunk black both">
    <h1 class="cyberpunk glitched">Alterar Nome do Grupo</h1>
    <div>
        <a href="index.php" style="--text:'V-5';padding:10px 20px;font-size:0.9rem">Voltar ao Início</a>
    </div>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:500px">
        <label>Grupo:</label>
        <select class="cyberpunk" name="id_grupo" required>
            <option value="">Selecione um grupo</option>
            <?php foreach ($grupos ?? [] as $grupo): ?>
                <option value="<?= $grupo['id_grupo'] ?>">Grupo <?= $grupo['grupos'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Nova Letra:</label>
        <input class="cyberpunk" type="text" name="novo_nome" maxlength="1" required>

        <button type="submit" class="cyberpunk blue" style="--text:'A-2'">Alterar</button>
    </form>
    </section>
</body>
</html>
