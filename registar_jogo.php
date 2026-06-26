<?php
$page_title = 'Registar Jogo - Mundial 2026';
require_once 'includes/header.php';
requer_admin();

$mensagem = "";
$equipas = db()->select('equipas', 'id_equipa, pais', [], 'pais');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datahora = $_POST['datahora'];
    $local = $_POST['local'];
    $equipa1 = (int)$_POST['equipa1'];
    $equipa2 = (int)$_POST['equipa2'];
    $golequipa1 = (int)$_POST['golequipa1'];
    $golequipa2 = (int)$_POST['golequipa2'];

    if ($equipa1 == $equipa2) {
        $mensagem = "A equipa 1 e equipa 2 não podem ser iguais.";
    } elseif (!empty($datahora) && !empty($local) && $equipa1 > 0 && $equipa2 > 0) {
        $resultado = db()->insert('jogo', [
            'datahora' => $datahora,
            'local' => $local,
            'equipa1' => $equipa1,
            'equipa2' => $equipa2,
            'golequipa1' => $golequipa1,
            'golequipa2' => $golequipa2,
        ]);
        $mensagem = $resultado !== null
            ? "Jogo registado com sucesso!"
            : "Já existe um jogo marcado para esta data/hora.";
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>
    <h1 class="cyberpunk glitched">Registar Jogo</h1>
    <?php require_once 'includes/nav.php'; ?>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:500px">
        <label>Data e Hora:</label>
        <input class="cyberpunk" type="datetime-local" name="datahora" required>

        <label>Local:</label>
        <input class="cyberpunk" type="text" name="local" required>

        <label>Equipa 1:</label>
        <select class="cyberpunk" name="equipa1" required>
            <option value="">Selecione</option>
            <?php foreach ($equipas ?? [] as $equipa): ?>
                <option value="<?= $equipa['id_equipa'] ?>"><?= $equipa['pais'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Golos Equipa 1:</label>
        <input class="cyberpunk" type="number" name="golequipa1" min="0" value="0" required>

        <label>Equipa 2:</label>
        <select class="cyberpunk" name="equipa2" required>
            <option value="">Selecione</option>
            <?php foreach ($equipas ?? [] as $equipa): ?>
                <option value="<?= $equipa['id_equipa'] ?>"><?= $equipa['pais'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Golos Equipa 2:</label>
        <input class="cyberpunk" type="number" name="golequipa2" min="0" value="0" required>

        <button type="submit" class="cyberpunk green" style="--text:'C-4'">Registar Jogo</button>
    </form>
<?php require_once 'includes/footer.php'; ?>