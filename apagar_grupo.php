<?php
require_once 'config.php';
requer_admin();

$mensagem = "";
$grupos = db()->select('grupos', '*', [], 'grupos');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_grupo = (int)$_POST['id_grupo'];

    if ($id_grupo > 0) {
        $equipas = db()->select('equipas', 'id_equipa', ['grupos_id_grupo' => $id_grupo]);
        foreach ($equipas ?? [] as $equipa) {
            db()->delete('jogo', ['equipa1' => $equipa['id_equipa']]);
            db()->delete('jogo', ['equipa2' => $equipa['id_equipa']]);
        }
        db()->delete('equipas', ['grupos_id_grupo' => $id_grupo]);
        db()->delete('grupos', ['id_grupo' => $id_grupo]);
        $mensagem = "Grupo, equipas e jogos apagados com sucesso!";
    } else {
        $mensagem = "Selecione um grupo.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Apagar Grupo - Mundial 2026</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
</head>
<body>
    <section class="cyberpunk black both">
    <h1 class="cyberpunk glitched">Apagar Grupo (e respetivas equipas e jogos)</h1>
    <div>
        <a href="index.php" style="--text:'V-8';padding:10px 20px;font-size:0.9rem">Voltar ao Início</a>
    </div>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" onsubmit="return confirm('Tem a certeza que pretende apagar este grupo, todas as suas equipas e todos os jogos dessas equipas?');" style="max-width:500px">
        <label>Grupo:</label>
        <select class="cyberpunk" name="id_grupo" required>
            <option value="">Selecione um grupo</option>
            <?php foreach ($grupos ?? [] as $grupo): ?>
                <option value="<?= $grupo['id_grupo'] ?>">Grupo <?= $grupo['grupos'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="cyberpunk red" style="--text:'D-2'">Apagar Grupo</button>
    </form>
    </section>
</body>
</html>
