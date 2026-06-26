<?php
require_once 'config.php';
requer_admin();

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grupo = $_POST['grupo'];

    if (!empty($grupo)) {
        $resultado = db()->insert('grupos', ['grupos' => $grupo]);
        $mensagem = $resultado !== null
            ? "Grupo $grupo criado com sucesso!"
            : "Já existe o grupo $grupo.";
    } else {
        $mensagem = "Por favor, insira uma letra para o grupo.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Grupo - Mundial 2026</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
</head>
<body>
    <section class="cyberpunk black both">
    <h1 class="cyberpunk glitched">Criar Novo Grupo</h1>
    <div>
        <a href="index.php" style="--text:'V-1';padding:10px 20px;font-size:0.9rem">Voltar ao Início</a>
    </div>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:500px">
        <label>Letra do Grupo:</label>
        <input class="cyberpunk" type="text" name="grupo" maxlength="1" required>
        <button type="submit" class="cyberpunk green" style="--text:'C-1'">Criar Grupo</button>
    </form>
    </section>
</body>
</html>
