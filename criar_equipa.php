<?php
require_once 'config.php';
requer_admin();

$mensagem = "";
$grupos = db()->select('grupos', '*', [], 'grupos');
if (empty($grupos)) {
    $grupos = db()->raw('GET', '/grupos?select=*&order=grupos');
}
error_log("Grupos no criar_equipa: " . print_r($grupos, true));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pais = $_POST['pais'];
    $grupo_id = (int)$_POST['grupo_id'];

    if (!empty($pais) && $grupo_id > 0) {
        error_log("Inserindo equipa: pais=$pais, grupo_id=$grupo_id");
        $resultado = db()->insert('equipas', [
            'pais' => $pais,
            'grupos_id_grupo' => $grupo_id,
        ]);
        error_log("Resultado insert equipa: " . print_r($resultado, true));
        $mensagem = $resultado !== null
            ? "Equipa $pais criada com sucesso!"
            : "Já existe a equipa $pais.";
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Equipa - Mundial 2026</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
</head>
<body>
    <section class="cyberpunk black both">
    <h1 class="cyberpunk glitched">Criar Nova Equipa</h1>
    <div>
        <a href="index.php" style="--text:'V-2';padding:10px 20px;font-size:0.9rem">Voltar ao Início</a>
    </div>

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
    </section>
</body>
</html>
