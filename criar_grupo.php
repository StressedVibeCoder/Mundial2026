<?php
$page_title = 'Criar Grupo - Mundial 2026';
require_once 'includes/header.php';
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
    <h1 class="cyberpunk glitched">Criar Novo Grupo</h1>
    <?php require_once 'includes/nav.php'; ?>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:500px">
        <label>Letra do Grupo:</label>
        <input class="cyberpunk" type="text" name="grupo" maxlength="1" required>
        <button type="submit" class="cyberpunk green" style="--text:'C-1'">Criar Grupo</button>
    </form>
<?php require_once 'includes/footer.php'; ?>