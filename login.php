<?php
$page_title = 'Login - Mundial 2026';
require_once 'includes/auth_header.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST['username'];
    $password = $_POST['password'];

    $user = db()->selectOne('utilizadores', '*', ['nome_utilizador' => $input]);

    if (!$user) {
        $user = db()->selectOne('utilizadores', '*', ['email' => $input]);
    }

    if ($user) {
        if (!password_verify($password, $user['senha'])) {
            $erro = "Username ou password incorretos.";
        } else {
            $_SESSION['user_id'] = $user['idutilizadores'];
            $_SESSION['user_nome'] = $user['nome_utilizador'];
            $_SESSION['user_tipo'] = $user['administrador'] ? '1' : '0';
            $_SESSION['user_username'] = $user['nome_utilizador'];
            header("Location: index.php");
            exit;
        }
    } else {
        $erro = "Username ou password incorretos.";
    }
}
?>
    <h1 class="cyberpunk glitched">Login</h1>
    <div>
        <a href="index.php" style="--text:'V-1';padding:10px 20px;font-size:0.9rem">Voltar ao Início</a>
        <a href="registar.php" style="--text:'V-2';padding:10px 20px;font-size:0.9rem">Registar</a>
    </div>

    <?php if ($erro): ?>
        <p style="background:var(--red-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $erro ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:400px">
        <label>Username ou Email:</label>
        <input class="cyberpunk" type="text" name="username" required>

        <label>Password:</label>
        <input class="cyberpunk" type="password" name="password" required>

        <button type="submit" class="cyberpunk blue" style="--text:'E-1'">Entrar</button>
    </form>
<?php require_once 'includes/footer.php'; ?>