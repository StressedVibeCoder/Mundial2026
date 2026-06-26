<?php
$page_title = 'Gerir Utilizadores - Mundial 2026';
require_once 'includes/header.php';
requer_admin();

$mensagem = "";
$utilizadores = db()->select('utilizadores', '*', [], 'idutilizadores');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['criar'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $resultado = db()->insert('utilizadores', [
            'nome_utilizador' => $username,
            'email' => $email,
            'senha' => $hash,
            'administrador' => false,
        ]);
        $mensagem = $resultado !== null
            ? "Utilizador $username criado com sucesso!"
            : "Username ou email já existem.";
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['promover'])) {
    $id = (int)$_POST['idutilizador'];
    if ($id !== (int)$_SESSION['user_id']) {
        $res = db()->raw('POST', '/rpc/promover_admin', ['p_user_id' => $id]);
        $mensagem = $res ? "Utilizador promovido a admin!" : "Erro ao promover.";
    } else {
        $mensagem = "Não podes promover-te a ti próprio.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rebaixar'])) {
    $id = (int)$_POST['idutilizador'];
    if ($id !== (int)$_SESSION['user_id']) {
        $res = db()->update('utilizadores', ['administrador' => false], ['idutilizadores' => $id]);
        $mensagem = $res ? "Admin rebaixado a utilizador." : "Erro ao rebaixar.";
    } else {
        $mensagem = "Não podes rebaixar-te a ti próprio.";
    }
}

$utilizadores = db()->select('utilizadores', '*', [], 'idutilizadores');
?>
    <h1 class="cyberpunk glitched">Gerir Utilizadores</h1>
    <?php require_once 'includes/nav.php'; ?>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <h2 class="cyberpunk">Criar Novo Utilizador</h2>
    <form method="post" style="max-width:500px">
        <label>Username:</label>
        <input class="cyberpunk" type="text" name="username" required>

        <label>Email:</label>
        <input class="cyberpunk" type="email" name="email" required>

        <label>Password:</label>
        <input class="cyberpunk" type="password" name="password" required>

        <button type="submit" name="criar" class="cyberpunk green" style="--text:'C-3'">Criar Utilizador</button>
    </form>

    <h2 class="cyberpunk">Utilizadores Existentes</h2>
    <table style="width:100%;border-collapse:collapse;margin-bottom:20px;background:var(--black-color)">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($utilizadores ?? [] as $u): ?>
            <tr>
                <td><?= $u['idutilizadores'] ?></td>
                <td><?= $u['nome_utilizador'] ?></td>
                <td><?= $u['email'] ?></td>
                <td><?= $u['administrador'] ? 'Admin' : 'User' ?></td>
                <td>
                    <?php if ($u['administrador']): ?>
                        <?php if ((int)$u['idutilizadores'] !== (int)$_SESSION['user_id']): ?>
                            <form method="post" style="display:inline">
                                <input type="hidden" name="idutilizador" value="<?= $u['idutilizadores'] ?>">
                                <button type="submit" name="rebaixar" class="cyberpunk red" style="--text:'D-1'" onclick="return confirm('Rebaixar <?= $u['nome_utilizador'] ?> para user normal?')">Rebaixar</button>
                            </form>
                        <?php else: ?>
                            <em>(tu)</em>
                        <?php endif; ?>
                    <?php else: ?>
                        <form method="post" style="display:inline">
                            <input type="hidden" name="idutilizador" value="<?= $u['idutilizadores'] ?>">
                            <button type="submit" name="promover" class="cyberpunk blue" style="--text:'A-1'" onclick="return confirm('Promover <?= $u['nome_utilizador'] ?> a admin?')">Promover a Admin</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php require_once 'includes/footer.php'; ?>