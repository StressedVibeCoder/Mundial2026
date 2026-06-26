<?php
require_once 'config.php';
requer_admin();

$mensagem = "";

$jogos_raw = db()->select('jogo', '*', [], 'datahora');
$jogos = [];
foreach ($jogos_raw ?? [] as $j) {
    $e1 = db()->selectOne('equipas', 'pais', ['id_equipa' => $j['equipa1']]);
    $e2 = db()->selectOne('equipas', 'pais', ['id_equipa' => $j['equipa2']]);
    $j['equipa1_nome'] = $e1['pais'] ?? '?';
    $j['equipa2_nome'] = $e2['pais'] ?? '?';
    $jogos[] = $j;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_jogo = (int)$_POST['id_jogo'];

    if ($id_jogo > 0) {
        db()->delete('jogo', ['id_jogo' => $id_jogo]);
        $mensagem = "Jogo apagado com sucesso!";
    } else {
        $mensagem = "Selecione um jogo.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Apagar Jogo - Mundial 2026</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
</head>
<body>
    <section class="cyberpunk black both">
    <h1 class="cyberpunk glitched">Apagar Jogo</h1>
    <div>
        <a href="index.php" style="--text:'V-10';padding:10px 20px;font-size:0.9rem">Voltar ao Início</a>
    </div>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" onsubmit="return confirm('Tem a certeza que pretende apagar este jogo?');" style="max-width:500px">
        <label>Jogo:</label>
        <select class="cyberpunk" name="id_jogo" required>
            <option value="">Selecione um jogo</option>
            <?php foreach ($jogos ?? [] as $jogo): ?>
                <option value="<?= $jogo['id_jogo'] ?>">
                    <?= $jogo['equipa1_nome'] ?> <?= $jogo['golequipa1'] ?>-<?= $jogo['golequipa2'] ?> <?= $jogo['equipa2_nome'] ?> (<?= date("d/m/Y H:i", strtotime($jogo['datahora'])) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="cyberpunk red" style="--text:'D-4'">Apagar Jogo</button>
    </form>
    </section>
</body>
</html>
