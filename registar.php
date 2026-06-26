<?php
$page_title = 'Registar - Mundial 2026';
require_once 'includes/auth_header.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        if ($resultado !== null) {
            header("Location: login.php");
            exit;
        } else {
            $mensagem = "Username ou email já existem.";
        }
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>
    <h1 class="cyberpunk glitched">Registar</h1>
    <div>
        <a href="index.php" style="--text:'V-1';padding:10px 20px;font-size:0.9rem">Voltar ao Início</a>
        <a href="login.php" style="--text:'V-2';padding:10px 20px;font-size:0.9rem">Login</a>
    </div>

    <?php if ($mensagem): ?>
        <p style="background:var(--green-color);color:#fff;padding:12px;border-radius:4px;margin-bottom:15px"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" style="max-width:400px">
        <label>Username:</label>
        <input class="cyberpunk" type="text" name="username" required>

        <label>Email:</label>
        <input class="cyberpunk" type="email" name="email" required>

        <label>Password:</label>
        <input class="cyberpunk" type="password" name="password" required>

        <button type="submit" class="cyberpunk green" style="--text:'R-1'">Registar</button>
    </form>
<?php require_once 'includes/footer.php'; ?>