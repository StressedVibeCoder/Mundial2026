<?php
// nav.php - menu de navegação (usa eh_admin() de config.php)
?>
<div style="margin-bottom:15px">
    <a href="index.php" class="cyberpunk purple" style="--text:'M-0';padding:10px 15px;font-size:0.8rem">Início</a>
    <?php if (eh_admin()): ?>
        <a href="criar_grupo.php" class="cyberpunk green" style="--text:'C-1';padding:10px 10px;font-size:0.8rem">Criar Grupo</a>
        <a href="criar_equipa.php" class="cyberpunk green" style="--text:'C-2';padding:10px 10px;font-size:0.8rem">Criar Equipa</a>
        <a href="criar_utilizador.php" class="cyberpunk green" style="--text:'C-3';padding:10px 10px;font-size:0.8rem">Gerir Users</a>
        <a href="registar_jogo.php" class="cyberpunk green" style="--text:'C-4';padding:10px 10px;font-size:0.8rem">Registar Jogo</a>
        <a href="alterar_grupo.php" class="cyberpunk blue" style="--text:'A-1';padding:10px 10px;font-size:0.8rem">Alterar Grupo</a>
        <a href="alterar_equipa.php" class="cyberpunk blue" style="--text:'A-2';padding:10px 10px;font-size:0.8rem">Alterar Equipa</a>
        <a href="alterar_jogo.php" class="cyberpunk blue" style="--text:'A-3';padding:10px 10px;font-size:0.8rem">Alterar Jogo</a>
        <a href="apagar_grupo.php" class="cyberpunk red" style="--text:'D-1';padding:10px 10px;font-size:0.8rem">Apagar Grupo</a>
        <a href="apagar_equipa.php" class="cyberpunk red" style="--text:'D-2';padding:10px 10px;font-size:0.8rem">Apagar Equipa</a>
        <a href="apagar_jogo.php" class="cyberpunk red" style="--text:'D-3';padding:10px 10px;font-size:0.8rem">Apagar Jogo</a>
    <?php endif; ?>
</div>