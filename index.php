<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="processar.php">
        <div>
            <h1>Formulario</h1>
            <p>Digite suas informaçôes:</p>
        </div>
        <label for="nome">Nome: </label>
        <input type="text" name="nome">
        <label for="idade">Idade: </label>
        <input type="number" name="idade" id="idade">
        <label for="cpf">CPF: </label>
        <input type="number" name="cpf" id="cpf">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email">
        <label for="senha">Senha: </label>
        <input type="password" name="senha" id="senha">
        <label for="fotoPerfil">Inserir Imagem de perfil</label>
        <input type="file">
        <div>
        <button type="submit">Cadastrar</button>
        </div>

        

    </form>
</body>
</html>