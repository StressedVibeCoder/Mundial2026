<?php
require_once 'config.php';
requer_admin();

$mensagem = "";

$equipas_raw = db()->select('equipas', '*', [], 'pais');
$equipas = [];
foreach ($equipas_raw ?? [] as $e) {
    $g = db()->selectOne('grupos', 'grupos', ['id_grupo' => $e['grupos_id_grupo']]);
    $e['grupos'] = $g['grupos'] ?? '?';
    $equipas[] = $e;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_equipa = (int)$_POST['id_equipa'];

    if ($id_equipa > 0) {
        db()->delete('jogo', ['equipa1' => $id_equipa]);
        db()->delete('jogo', ['equipa2' => $id_equipa]);
        db()->delete('equipas', ['id_equipa' => $id_equipa]);
        $mensagem = "Equipa e seus jogos apagados com sucesso!";
    } else {
        $mensagem = "Selecione uma equipa.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Apagar Equipa - Mundial 2026</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
</head>
<body>
    <section class="cyberpunk black both">
    <h1 class="cyberpunk glitched">Apagar Equipa (e jogos associados)</h1>
    <div>
        <a href="index.php" style="--text:'V-9';padding:10px 20px;font-size:0.9rem">Voltar ao Início</a>
    </div>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" onsubmit="return confirm('Tem a certeza que pretende apagar esta equipa e todos os seus jogos?');" style="max-width:500px">
        <label>Equipa:</label>
        <select class="cyberpunk" name="id_equipa" required>
            <option value="">Selecione uma equipa</option>
            <?php foreach ($equipas ?? [] as $equipa): ?>
                <option value="<?= $equipa['id_equipa'] ?>">
                    <?= $equipa['pais'] ?> (Grupo <?= $equipa['grupos'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="cyberpunk red" style="--text:'D-3'">Apagar Equipa</button>
    </form>
    </section>
</body>
</html>
