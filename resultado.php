<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.html');
    exit;
}

$usuario = $_SESSION['usuario'];
unset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro Realizado</title>
  <link rel="stylesheet" href="style_resultado.css">
</head>
<body>
<div id="centralizar">
    <div class="success-box">
        <h2>Cadastro realizado com sucesso!</h2>
    </div>

    <div class="user-info">
        <h3>Dados do usuário:</h3>
        <p><strong>Nome:</strong> <?= $usuario['nome'] ?></p>
        <p><strong>E-mail:</strong> <?= $usuario['email'] ?></p>
    </div>

    <div class="profile-picture">
        <h3>Foto de perfil:</h3>
        <img src="<?= htmlspecialchars($usuario['foto'], ENT_QUOTES, 'UTF-8') ?>" alt="Foto de perfil" class="profile-pic" />
    </div>

    <p><a href="index.html">Voltar ao formulário</a></p>

</div>
</body>
</html>
